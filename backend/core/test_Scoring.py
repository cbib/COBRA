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




#score all genes in hpidb interaction tables !!!
logger.info("parse hpidb data")
results=list(pv_interactions_col.find({"type":"hpidb"},{"mapping_file.Uniprot ID":1,"_id":0} ))
for u in results:
    for r in u['mapping_file']:
        if 'Uniprot ID' in r:
            if r['Uniprot ID']!="":
                logger.info("uniprot id %s ",r['Uniprot ID'])
                #full_mappings_col.update({'mapping_file.Uniprot ID':r['Uniprot ID']},{'$inc': {'mapping_file.$.Score': 1 } })
                
                plaza_results=full_mappings_col.find({'mapping_file.Uniprot ID':r['Uniprot ID']},{'mapping_file.$.Plaza ID': 1 } )
                for p in plaza_results:
                        for values in p['mapping_file']:
                            
                            logger.info("plaza id %s",values['Plaza ID'])
                            

                            plaza_id=values['Plaza ID']
                            ortholog_result=orthologs_col.find({'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
                            for ortholog in ortholog_result:
                                #logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
                                ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
                                if ortholog_list.find(",") != -1:
                                    ortholog_split_list=ortholog_list.split(',')
                                    for ortholog_id in ortholog_split_list:
                                        if ortholog_id!=plaza_id:
                                            logger.info("ortholog id %s ",ortholog_id)
                                            #full_mappings_col.update({'mapping_file.Plaza ID':ortholog_id},{'$inc': {'mapping_file.$.Score': 1 } })
                                else:
                                    if ortholog_list!=plaza_id:
                                        logger.info("ortholog id %s ",ortholog_list)
                                        #full_mappings_col.update({'mapping_file.Plaza ID':ortholog_list},{'$inc': {'mapping_file.$.Score': 1 } })
