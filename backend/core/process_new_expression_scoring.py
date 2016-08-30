#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
from helpers.path import data_dir
from bson.son import SON

# Script supposed to be run in the background to populate the DB with available datasets 
## Setup

from numbers import Number
import collections
from math import log
if "log" not in globals():
  logger = Logger.init_logger('DATA_PROCESSOR_%s'%(cfg.language_code), load_config())

logger.info("Running %s",sys.argv[0])
species_to_process=species_col.find({},{"full_name":1})


for species in species_to_process:
    tgt_samples=samples_col.find({"species":species['full_name'],"experimental_results.conditions.infected":True})

    logger.info("species %s",species['full_name'])
    tgt_path=[]
    tgt_description={}
    for a_sample in tgt_samples:
            for i,xp in enumerate(a_sample['experimental_results']):
                    for j,condition in enumerate(xp['conditions']):
                            if "infection_agent" in condition :

                                    if 'contrast' in xp:
                                            this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)
                                            #logger.info("Path %s",this_path)
                                            tgt_path.append(this_path)
                                            tgt_description[this_path]=xp['contrast']+":"+condition.get('label',"")
                                            break
                                    else:
                                            this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)                                                    
                                            #logger.info("Path %s",this_path)
                                            tgt_path.append(this_path)
                                            tgt_description[this_path]=condition.get('label',"")
                                            break

    if len(tgt_path)<1:
            print "nothing found"

    #results=list(measurements_col.find({"xp":{"$in":tgt_path},"logFC":{"$gt":2}},{"_id":0}))
    results=list(measurements_col.find({ "xp":{"$in":tgt_path},"$or": [ { "logFC": { "$gt": 2 } }, { "logFC": { "$lt": -2 } } ] },{"_id":0} ))
    logger.info("preparing new scoring step for species %s",species["full_name"])
    counter=0
    for r in results:
        logger.info("scoring step for gene number: %d",counter)
        
        if species['full_name']== "Hordeum vulgare":
            if 'gene_original_id' in r:
                full_mappings_col.update({'species':"Hordeum vulgare",'mapping_file.Transcript ID':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{"$inc": {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })
            else:
                full_mappings_col.update({'species':"Hordeum vulgare","mapping_file.Transcript ID":r['gene']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })
                

        elif species['full_name']== "Prunus domestica":
            full_mappings_col.update({'species':"Prunus persica","mapping_file.Protein ID":r['gene']},{'$inc': {"mapping_file.$.Score_exp": 1,"mapping_file.$.Global_Score": 1 } })


        elif species['full_name']== "Prunus armeniaca":
            full_mappings_col.update({'species':"Prunus persica","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score_exp": 1,"mapping_file.$.Global_Score": 1 } })


        elif species['full_name']== "Prunus persica":
            full_mappings_col.update({'species':"Prunus persica","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score_exp": 1,"mapping_file.$.Global_Score": 1 } })


        elif species['full_name']== "Cucumis melo":
            #logger.info("gene id %s",r['gene'])
            full_mappings_col.update({'species':"Cucumis melo","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score_exp": 1,"mapping_file.$.Global_Score": 1 } })




        elif species['full_name']== "Arabidopsis thaliana":
            #logger.info("gene id %s for probe id %s",r['gene'],r['gene_original_id'])
            if 'gene_original_id' in r:

                full_mappings_col.update({'species':"Arabidopsis thaliana",'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })
            else:
                full_mappings_col.update({'species':"Arabidopsis thaliana",'mapping_file.Gene ID':r['gene']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })


        elif species['full_name']== "Oriza sativa ssp japonica":
            #logger.info("gene id %s for probe id %s",r['gene'],r['gene_original_id'])
            if 'gene_original_id' in r:

                full_mappings_col.update({'species':species["full_name"],'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })
            else:
                full_mappings_col.update({'species':species["full_name"],'mapping_file.Gene ID':r['gene']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })


        else:
            if 'gene_original_id' in r:

                full_mappings_col.update({'species':species["full_name"],'mapping_file.Gene ID 2':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })

            else:

                full_mappings_col.update({'species':species["full_name"],"mapping_file.Gene ID":r['gene']},{'$inc': {'mapping_file.$.Score_exp': 1,'mapping_file.$.Global_Score': 1 } })
        counter+=1
        
        
        
    results=list(pv_interactions_col.find({'mapping_file.species':species['full_name']},{"mapping_file.Gene ID":1,"_id":0} ))
    for u in results:
        for r in u['mapping_file']:
            if 'Gene ID' in r:
                if r['Gene ID']!="":

                    if r['Gene ID'].find("-") != -1:
                        split_list=r['Gene ID'].split('-')
                        for gene_id in split_list:
                            #logger.info("gene id %s ",gene_id)
                            full_mappings_col.update({'mapping_file.Gene ID':gene_id},{'$inc': {'mapping_file.$.Score_int': 1 ,'mapping_file.$.Global_Score': 1 } })
#                            plaza_results=full_mappings_col.find({'mapping_file.Gene ID':gene_id},{'mapping_file.$': 1 } )
#                            for p in plaza_results:
#                                for values in p['mapping_file']:
#
#                                    #logger.info("plaza id %s",values['Plaza ID'])
#                                    plaza_id=values['Plaza ID']
#
#                                    #orthologs_list_identifier
#                                    ortholog_result=orthologs_col.find({'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
#                                    for ortholog in ortholog_result:
#                                        #logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
#                                        ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
#                                        if ortholog_list.find(",") != -1:
#                                            ortholog_split_list=ortholog_list.split(',')
#                                            for ortholog_id in ortholog_split_list:
#                                                if ortholog_id!=plaza_id:
#                                                    #logger.info("ortholog id %s ",ortholog_id)
#
#                                                    full_mappings_col.update({"mapping_file.Plaza ID":ortholog_id},{"$inc": {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5  } })
#                                        else:
#                                            if ortholog_list!=plaza_id:
#                                                #logger.info("ortholog id %s ",ortholog_list)
#
#                                                full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5  } })

                    else:
                        #logger.info("gene id %s ",r['Gene ID'])
                        full_mappings_col.update({'mapping_file.Gene ID':r['Gene ID']},{'$inc': {'mapping_file.$.Score_int': 1,'mapping_file.$.Global_Score': 1 } })
#                        plaza_results=full_mappings_col.find({'mapping_file.Gene ID':r['Gene ID']},{'mapping_file.$': 1 } )
#                        for p in plaza_results:
#                            for values in p['mapping_file']:
#
#                                #logger.info("plaza id %s",values['Plaza ID'])
#                                plaza_id=values['Plaza ID']
#                                #orthologs_list_identifier
#                                ortholog_result=orthologs_col.find({'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
#                                for ortholog in ortholog_result:
#                                    #logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
#                                    ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
#                                    if ortholog_list.find(",") != -1:
#                                        ortholog_split_list=ortholog_list.split(',')
#                                        for ortholog_id in ortholog_split_list:
#                                            if ortholog_id!=plaza_id:
#                                                #logger.info("ortholog id %s ",ortholog_id)
#
#                                                full_mappings_col.update({'mapping_file.Plaza ID':ortholog_id},{'$inc': {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5  } })
#                                    else:
#                                        if ortholog_list!=plaza_id:
#                                            #logger.info("ortholog id %s ",ortholog_list)
#
#                                            full_mappings_col.update({'mapping_file.Plaza ID':ortholog_list},{'$inc': {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5  } })


    #score all genes in hpidb interaction tables !!!
    logger.info("parse hpidb data")
    results=list(pv_interactions_col.find({'mapping_file.species':species['full_name']},{"mapping_file.Uniprot ID":1,"_id":0} ))
    for u in results:
        for r in u['mapping_file']:
            if 'Uniprot ID' in r:
                if r['Uniprot ID']!="":
                    #logger.info("uniprot id %s ",r['Uniprot ID'])
                    full_mappings_col.update({'mapping_file.Uniprot ID':r['Uniprot ID']},{'$inc': {'mapping_file.$.Score_int': 1,'mapping_file.$.Global_Score': 1  } })

#                    plaza_results=full_mappings_col.find({'mapping_file.Uniprot ID':r['Uniprot ID']},{'mapping_file.$.Plaza ID': 1 } )
#                    for p in plaza_results:
#                            for values in p['mapping_file']:
#
#                                #logger.info("plaza id %s",values['Plaza ID'])
#
#
#                                plaza_id=values['Plaza ID']
#                                ortholog_result=orthologs_col.find({'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
#                                for ortholog in ortholog_result:
#                                    #logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
#                                    ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
#                                    if ortholog_list.find(",") != -1:
#                                        ortholog_split_list=ortholog_list.split(',')
#                                        for ortholog_id in ortholog_split_list:
#                                            if ortholog_id!=plaza_id:
#                                                #logger.info("ortholog id %s ",ortholog_id)
#                                                full_mappings_col.update({'mapping_file.Plaza ID':ortholog_id},{'$inc': {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5 } })
#                                    else:
#                                        if ortholog_list!=plaza_id:
#                                            #logger.info("ortholog id %s ",ortholog_list)
#                                            full_mappings_col.update({'mapping_file.Plaza ID':ortholog_list},{'$inc': {'mapping_file.$.Score_orthologs': 0.5,'mapping_file.$.Global_Score': 0.5 } })
