#! /usr/bin/python
# encoding: utf-8

import sys
import os
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
#logger.info("Performing GO enrichment for all samples")


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
    

#    logger.info(len(genelist))

    #get unique GO terms associated with these terms.
    go_to_process=db.full_mappings.aggregate([
        {'$match': {"species" : species}},
        {'$project': {"mapping_file" : 1,'_id':0}},
        {'$unwind': "$mapping_file"},
        {'$match': {"$or" : [
                {'mapping_file.Gene ID': { '$in': genelist}},
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



    #search for each unique GO term which genes has this GO ID
#    logger.info(len(go_id_list.items()))
    result_file = "/data/hypergeom_R_results/result_"+str(doc_id)+".txt"
    for key, value in go_id_list.items():
        if (key!="NA"):
#                print key
#                print value

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
            #logger.info(value+'/'+total_de_genes+' genes shows GO term with id: '+key+'</br>')
            #logger.info(total_gene_size+'/'+total_genes_for_species+' genes shows GO term with id: '+key+'</br>')        
    #        if value> 10:
    #            logger.info(value+'/'+total_de_genes+' genes shows GO term with id: '+key+'</br>')
    #            logger.info(total_gene_size+'/'+total_genes_for_species+' genes shows GO term with id: '+key+'</br>')


            total_go_to_process=db.gene_ontology.aggregate([

                {'$project': {"GO_collections" : 1,'_id':0}},
                {'$unwind': "$GO_collections"},
                {'$match': {'GO_collections.id':key }},
                {'$project': {"GO_collections.name" : 1,'_id':0}}
            ]);
            GO_name=""
            for total_go in  total_go_to_process:
                GO_name=total_go['GO_collections']['name']
            GO_name.replace(" |(|)", "_")


            #result_file = "/data/hypergeom_R_results/result.txt"

            #rscript="/data/hypergeom_R_results/my_rscript.R"


            #sys.argv=[rscript,value,total_gene_size,total_de_genes,total_genes_for_species]

            #execfile(rscript)


            #commande="/data/hypergeom_R_results/my_rscript.R 12 344 3456 4444"

            # Define command and arguments
            #command = 'Rscript'
            #path2script = '/data/hypergeom_R_results/my_rscript.R'
            #args = shlex.split(commande)

            # Variable number of args in a list
            #args = ["12","344","3456","4444"]

            # Build subprocess command
            #cmd = [command, path2script] + args

            # check_output will run the command and store to result
            #x = subprocess.check_output(cmd, universal_newlines=True)
            #with open('/data/hypergeom_R_results/result.txt','a') as fileobj:
            #    subprocess.call(cmd, stdout=fileobj,stderr=subprocess.STDOUT)


            #output = subprocess.Popen(['/usr/bin/Rscript',"/data/hypergeom_R_results/my_rscript.R","12","344","3456","4444","GO2","testname"],shell=True)
            #cmd = "/usr/bin/Rscript /data/hypergeom_R_results/my_rscript.R  %s %s" % (argument1 argument2)
#            logger.info(key)

           #os.system("/usr/bin/Rscript /data/hypergeom_R_results/my_rscript.R "+str(value)+" "+str(total_gene_size)+" "+str(len(total_genes_for_species))+" "+str(total_de_genes)+" "+key+" "+GO_name+" >> /data/hypergeom_R_results/result.txt &")

            
            with open(result_file,'a') as fileobj:

            #with open('/data/hypergeom_R_results/result.txt','a') as fileobj:
                subprocess.Popen(["/usr/bin/Rscript","/data/hypergeom_R_results/my_rscript.R",str(value), str(total_gene_size), str(len(total_genes_for_species)), str(total_de_genes),key,GO_name], stdout=fileobj, stderr=subprocess.PIPE)

    #logger.info(doc_id)
    #retrive all results form result.txt
    #sheet_values=parse_result_file('/data/hypergeom_R_results/result.txt')
    sheet_values=parse_GO_enriched_tsv_table(result_file,['idx','P value','GO ID','GO NAME'],0)

    # create the table created in GO_enrichement.php with result 
    db.go_enrichments.update({"_id":ObjectId(doc_id)},{"$set":{"result_file":sheet_values}})
    #os.remove('/data/hypergeom_R_results/result.txt')
    os.remove(result_file)


            #process.wait()
            #logger.info("R script terminated")
            #stdout, stderr = process.communicate()
            #logger.info(stdout)
            #logger.info(stderr)
        #final = output.stdout.read()
        #print final
#                with open('/data/hypergeom_R_results/result.txt','a') as fileobj:
#                    subprocess.call(["/usr/bin/Rscript",  "--no-save", "--no-restore",
#                    "--verbose", "/data/hypergeom_R_results/my_rscript.R", 
#                    str(value), str(total_gene_size),  str(total_de_genes), str(total_genes_for_species)], 
#                    stdout=fileobj, stderr=subprocess.STDOUT)





    #output = shell_exec("Rscript $rscript $value $global_value $total_species_genes $total_diff_exp_genes $key $GO_name>> $result_file")

#            //$GO_name=$GOCollection->find(array('GO_collections.id'=>$key),array('GO_collections.$'=>1,'_id'=>0));
#            $GO_cursor=$GOCollection->aggregate(array(
#            array('$project' => array('GO_collections'=>1,'_id'=>0)),
#            array('$unwind'=>'$GO_collections'),
#            array('$match' => array('GO_collections.id'=>$key)),
#            array('$project' => array('GO_collections.name'=>1,'_id'=>0))
#            ));













#            gene_to_process=db.measurements.aggregate([
#                {'$match': {"xp" : xp_id}},
#                {'$group' : {'_id' : '$xp', 'xp_metadata':{'$addToSet':{'gene':"$gene","logFC":"$logFC"}}}},
#                {'$match' : {"$or": [ { "logFC": { "$gt": 2 } }, { "logFC": { "$lt": -2 } } ]}}
#            ]);

    #group gene/logFC by xp and keep those with logFC > 2 or <-2
#            gene_to_process=db.measurements.aggregate([
#                {'$match': {"xp" : xp_id,"$or": [ { "logFC": { "$gt": 2 } }, { "logFC": { "$lt": -2 } } ]}},
#                {'$group' : {'_id' : '$xp', 'xp_metadata':{'$addToSet':{'gene':"$gene","logFC":"$logFC"}}}}
#            ]);

#            gene_to_process=db.measurements.aggregate([
#                {'$match': {"xp" : xp_id,"$or": [ { "logFC": { "$gt": 2 } }, { "logFC": { "$lt": -2 } } ]}},
#                {'$group' : {'_id' : '$xp', 'xp_metadata':{'$addToSet':{'gene':"$gene","logFC":"$logFC"}}}}
#            ]);
    ##

#            for gene in gene_to_process:
#                print gene['_id']
#                print gene['xp_metadata']
#                for gene_id in gene['xp_metadata']:
#                    GO_to_process=db.full_mappings.aggregate([
#                        {'$match': {"species" : species}},
#                        {'$project': {"mapping_file" : 1,'_id':0}},
#                        {'$unwind': "$mapping_file"},
#                        {'$match': {"$or" : [
#                                {'mapping_file.Gene ID': gene_id['gene']},
#                                {'mapping_file.Gene ID 2': gene_id['gene']}
#                        ]}},
#                        {'$project': {"mapping_file.Gene ontology ID" : 1,'mapping_file.Gene ID':1,'_id':0}}
#
#
#
#                    ]);






#2.get list of genes with logFC higher than x and lower than y
#3.get list of unique GO id related to previous gene list.
#4.find all genes in this species associated with this list of GO terms
#5.get GO term definition
#6.perform hypergeom test and produce a file with this format:
#7.Pvalue\tGO id\tGO name
#8.sort the file
#9.select the n top over represented GO ID

