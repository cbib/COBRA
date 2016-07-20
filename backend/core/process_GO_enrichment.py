#! /usr/bin/python
# encoding: utf-8

import sys
import os
import stat
import subprocess

sys.path.append("../../backend")
sys.path.append(".")




#from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__ = "benjamindartigues"
__date__ = "$Jun 25, 2016 2:18:36 PM$"



#chmod("/data/hypergeom_R_results", octdec(0777))
#logger.info(sys.argv[1])
#for arg in sys.argv:
#    logger.info(arg)
xp=sys.argv[1]
doc_id=sys.argv[2]
min=sys.argv[3]
max=sys.argv[4]
xp=xp.replace("__", ".")
# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
    logger = Logger.init_logger('FLATTEN_%s'%(cfg.language_code), load_config())
#logger.info("Running %s",sys.argv[0])
logger.info("Performing GO enrichment for all samples")
#os.chmod("/data/hypergeom_R_results", 0755)

#1.group measurement dataset by xp and project gene ID 

#xps=db.measurements.distinct('xp')

#for xp in xps:


#logger.info(xp)
array_to_process=db.measurements.aggregate([
    {'$match': {"xp" : xp}},
    {'$group' : {'_id' : '$species', 'xp_data':{'$addToSet':{'gene':"$gene","logFC":"$logFC"}}}}
]);
#    array_to_process=db.measurements.aggregate([
#        {'$match': {"type" : "contrast"}},
#        {'$group' : {'_id' : '$xp', 'xp_id':{'$addToSet':{'type':"$type","assay_type":"$assay_type","species":"$species"}}}}
#    ]);
for array in array_to_process:

    xp_id=xp 
    species=array['_id']
    if species=="Prunus armeniaca" or species=="Prunus domestica":
        species="Prunus persica"
    
    total_genes_for_species=db.full_mappings.distinct("mapping_file.Gene ID",{'species':species});

#    logger.info(species)
    data_array=array['xp_data']
    #print "xp id: "+xp_id
    genelist=[]
    for data in data_array:
        #type=data['type']
        #assay_type=data['assay_type']

        gene=data['gene']
        logFC=data['logFC']
        if logFC > float(max) or logFC < float(min):
            genelist.append(gene)

    #get size of differentially expressed genes list 
    total_de_genes=len(genelist)
    
    logger.info(species)

    #get unique GO terms associated with these terms.
    go_to_process=db.full_mappings.aggregate([
        {'$match': {"species" : species}},
        {'$project': {"mapping_file" : 1,'_id':0}},
        {'$unwind': "$mapping_file"},
        {'$match': {"$or" : [
                {'mapping_file.Gene ID': { '$in': genelist}},
                {'mapping_file.Transcript ID': { '$in': genelist}},
                
                {'mapping_file.Gene ID 2': { '$in': genelist}}
        ]}},
        {'$project': {"mapping_file.Gene ontology ID" : 1,'mapping_file.Gene ID':1,'_id':0}}



    ]);

    go_id_list={}
    # parse GO list to score GO terms as number of times a GO ID is found in this set fo genes
    for go in go_to_process:
        #print go['mapping_file']['Gene ontology ID']
        #go_ids=split("_", go['mapping_file']['Gene ontology ID'])
        go_ids= go['mapping_file']['Gene ontology ID'].split('_')
        gene_id=go['mapping_file']['Gene ID']
        for go_id in go_ids:
            go_ids= go_id.split('-')
            if not go_ids[0] in go_id_list:
                go_id_list[go_ids[0]]=0
            else:
                tmp=go_id_list[go_ids[0]]
                go_id_list[go_ids[0]]=tmp+1


    if len(go_id_list.items())!=0:
        
        #search for each unique GO term which genes has this GO ID
        logger.info(len(go_id_list.items()))
        
        
        # here we need to create R script on flight 
        r_script= "/data/hypergeom_R_results/script_"+str(doc_id)+".R" 
        f = open(r_script, 'w')
        text_script='args <- commandArgs(TRUE)\nx <- as.numeric(args[1])\nm <- as.numeric(args[2])\nn <- as.numeric(args[3])\nk <- as.numeric(args[4])\nGO <- args[5]\nname <- args[6]\nnamespace <- args[7]\nout <- phyper(x-1,m,n-m,k,lower.tail=FALSE)\nif (GO!=\"NA\" & GO!=\"\"){\n\tif(format(out,digits=12,format=\"g\")<1){\n\t\tcat(format(out,digits=12,format=\"g\"))\n\t\tcat(\"\\t\")\n\t\tcat(GO)\n\t\tcat(\"\\t\")\n\t\tcat(name)\n\t\tcat(\"\\t\")\n\t\tcat(namespace)\n\t\tcat(\"\\n\")\n\t}\n}'
        f.write(text_script)
        f.close()
        
        os.chmod(r_script, 0755)

        result_file = "/data/hypergeom_R_results/result_"+str(doc_id)+".txt"

        for key, value in go_id_list.items():
            if ((key!="NA") and (key!="")):

                totalgenelist=[]
                #retrieve all gene ID associated with this GO ID
                total_gene_to_process=db.full_mappings.aggregate([
                    {'$match': {"species" : species}},
                    {'$project': {"mapping_file" : 1,'_id':0}},
                    {'$unwind': "$mapping_file"},
                    {'$match': {'mapping_file.Gene ontology ID':{'$regex':key, '$options': 'xi' } }},
                    {'$project': {"mapping_file.Gene ID" : 1,'_id':0}}



                ]);

                for total_gene in total_gene_to_process:
                    #print total_gene['mapping_file']['Gene ID']
                    totalgenelist.append(total_gene['mapping_file']['Gene ID'])
                total_gene_size= len(totalgenelist)
                total_go_to_process=db.gene_ontology.aggregate([

                    {'$project': {"GO_collections" : 1,'_id':0}},
                    {'$unwind': "$GO_collections"},
                    {'$match': {'$and':[ {'GO_collections.id':key },{'GO_collections.name': {'$ne':""}}]}},
                    {'$project': {"GO_collections.name" : 1,"GO_collections.namespace":1,'_id':0}}
                ]);
                GO_name=""
                for total_go in  total_go_to_process:
                    GO_name=total_go['GO_collections']['name']
                    GO_namespace=total_go['GO_collections']['namespace']
                    logger.info(GO_name)
                    logger.info(GO_namespace)
                    
                GO_name.replace(" |(|)", "_")


                logger.info(key)


                if GO_name!="":
                    with open(result_file,'a') as fileobj:

                        subprocess.Popen(["/usr/bin/Rscript",r_script,str(value), str(total_gene_size), str(len(total_genes_for_species)), str(total_de_genes),key,GO_name,GO_namespace], stdout=fileobj, stderr=subprocess.PIPE)
                        

        p = subprocess.Popen("ps aux | grep "+r_script, stdout=subprocess.PIPE, shell=True)
        (output, err) = p.communicate()
        logger.info(output)
        
        while output.count(r_script)>2  :
            p = subprocess.Popen("ps aux | grep "+r_script, stdout=subprocess.PIPE, shell=True)
            (output, err) = p.communicate()
            logger.info(output.count(r_script))
        sheet_values=parse_GO_enriched_tsv_table(result_file,r_script,['idx','P value','GO ID','GO NAME','GO NAMESPACE','adjusted_pvalue'],0)

        # create the table created in GO_enrichement.php with result 
        db.go_enrichments.update({"_id":ObjectId(doc_id)},{"$set":{"result_file":sheet_values}})

        os.remove(result_file)
        os.remove(r_script)

        
    else:
        logger.info("these genes have no GO associated")
        db.go_enrichments.remove({"_id":ObjectId(doc_id)})