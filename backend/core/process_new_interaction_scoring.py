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



#score all genes in interactions tables !!!
        
#score all genes in litterature interaction tables !!!
species_to_process=species_col.find({},{"full_name":1})
new_results=[]
for species in species_to_process:
    
    logger.info('parse'+species['full_name']+'annotation data');
    logger.info("parse literature interaction data")
    results=list(pv_interactions_col.find({'mapping_file.species':species['full_name']},{"mapping_file.Gene ID":1,"_id":0} ))
    for u in results:
        for r in u['mapping_file']:
            if 'Gene ID' in r:
                if r['Gene ID']!="":

                    if r['Gene ID'].find("-") != -1:
                        split_list=r['Gene ID'].split('-')
                        for gene_id in split_list:
                            #logger.info("gene id %s ",gene_id)
                            full_mappings_col.update({'mapping_file.Gene ID':gene_id,'mapping_file.species':species['full_name']},{'$inc': {'mapping_file.$.Score_int': 1 ,'mapping_file.$.Global_Score': 1 } })

                    else:
                        #logger.info("gene id %s ",r['Gene ID'])
                        full_mappings_col.update({'mapping_file.Gene ID':r['Gene ID'],'mapping_file.species':species['full_name']},{'$inc': {'mapping_file.$.Score_int': 1,'mapping_file.$.Global_Score': 1 } })
                        

    #score all genes in hpidb interaction tables !!!
    logger.info("parse hpidb data")
    results=list(pv_interactions_col.find({'mapping_file.species':species['full_name']},{"mapping_file.Uniprot ID":1,"_id":0} ))
    for u in results:
        for r in u['mapping_file']:
            if 'Uniprot ID' in r:
                if r['Uniprot ID']!="":
                    logger.info("uniprot id %s ",r['Uniprot ID'])
                    full_mappings_col.update({'mapping_file.Uniprot ID':r['Uniprot ID'],'mapping_file.species':species['full_name']},{'$inc': {'mapping_file.$.Score_int': 1,'mapping_file.$.Global_Score': 1  } })

                    