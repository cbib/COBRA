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
#genes_to_process=full_mappings_col.find({},{'mapping_file.Gene ID':1,'mapping_file.Plaza ID':1})


coefficient=0.5
genes_to_process=list(full_mappings_col.aggregate([
                            {'$unwind':'$mapping_file'},
                            {
                              '$project':
                                 {
                                   'mapping_file.Plaza ID':1,
                                   'mapping_file.Global_Score':1,
                                   '_id': 0
                                 }
                            }
                        ]
                        , useCursor=False))




for gene in genes_to_process:
    #logger.info("Gene ID: %s",gene['mapping_file']['Gene ID'])
    logger.info("Plaza ID: %s",gene['mapping_file']['Plaza ID'])
    plaza_id=gene['mapping_file']['Plaza ID']
    ortholog_global_scores=0.0
    total_ortholog=0
    if  plaza_id!='NA':
        ortholog_result=orthologs_col.find({'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
        for ortholog in ortholog_result:
            ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
            ###Here we got a list of orthologs
            ortholog_global_scores=0.0 
            #ortholog_split_list=ortholog_list.split(',')
            
            
            
            
            
            for ortholog_id in ortholog_list.split(','):
                
                for id in genes_to_process:
                    if id['mapping_file']['Plaza ID']==ortholog_id:
                        print gene['mapping_file']['Global_Score']
                
                if ortholog_id!=plaza_id:
                    #logger.info(" Ortholog ID: %s -- Plaza ID: %s",ortholog_id,plaza_id)
                    
                    
                    
                    scores_to_process=full_mappings_col.find({"mapping_file.Plaza ID":ortholog_id},{'mapping_file.$.Global_Score': 1  })
                    for score in scores_to_process:
                        #logger.info("Score: %.4f",score['mapping_file'][0]['Global_Score'])
                        ortholog_global_scores=ortholog_global_scores+float(score['mapping_file'][0]['Global_Score'])
                    #full_mappings_col.update({"mapping_file.Plaza ID":ortholog_id},{"$inc": {'mapping_file.$.Global_Score': 0.5 } })
                    total_ortholog=total_ortholog+1
#            else:
#                if ortholog_list!=plaza_id:
#                    #logger.info("Plaza ID: %s",ortholog_id)
#                    #full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Score_orthologs': 0.5 } })
#                    scores_to_process=full_mappings_col.find({"mapping_file.Plaza ID":ortholog_id},{'mapping_file.$.Global_Score': 1  })
#                    for score in scores_to_process:
#                        #logger.info("Score: %.4f",score['mapping_file']['Global_Score'])
#                        ortholog_global_scores=ortholog_global_scores+float(score['mapping_file'][0]['Global_Score'])
#                    total_ortholog=total_ortholog+1
                    #full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Global_Score': 0.5 } })
        #logger.info("%s orthologs scores summed: %.4f",total_ortholog,ortholog_global_scores)
        if ortholog_global_scores > 0.0:
            score_plus=(ortholog_global_scores*coefficient)/total_ortholog
            #logger.info("score to add: %s",score_plus)
            full_mappings_col.update({"mapping_file.Plaza ID":plaza_id},{"$inc": {'mapping_file.$.Score_orthologs': float(score_plus)} })
            full_mappings_col.update({"mapping_file.Plaza ID":plaza_id},{"$inc": {'mapping_file.$.Global_Score': float(score_plus)} })

    
    
#    for p in plaza_results:
#        for values in p['mapping_file']: 
#
#            plaza_id=values['Plaza ID']
#
#            #orthologs_list_identifier
#            ortholog_result=orthologs_col.find({'species':species,'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
#            for ortholog in ortholog_result:
#
#                #logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
#                ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
#                if ortholog_list.find(",") != -1:
#                    ortholog_split_list=ortholog_list.split(',')
#                    for ortholog_id in ortholog_split_list:
#                        if ortholog_id!=plaza_id:
#                            full_mappings_col.update({"mapping_file.Plaza ID":ortholog_id},{"$inc": {'mapping_file.$.Score_orthologs': 0.5 , 'mapping_file.$.Global_Score': 0.5 } })
#                else:
#                    if ortholog_list!=plaza_id:
#                        full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Score_orthologs': 0.5 , 'mapping_file.$.Global_Score': 0.5 } })

    

