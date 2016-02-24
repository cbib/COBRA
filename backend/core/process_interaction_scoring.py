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
        

results=list(pv_interactions_col.find({},{"mapping_file.Gene ID":1,"_id":0} ))
for u in results:
    for r in u['mapping_file']:
        if 'Gene ID' in r:
            if r['Gene ID']!="":

                if r['Gene ID'].find("-") != -1:
                    split_list=r['Gene ID'].split('-')
                    for gene_id in split_list:
                        logger.info("gene id %s ",gene_id)
                        full_mappings_col.update({'mapping_file.Gene ID':gene_id},{'$inc': {'mapping_file.$.Score': 1 } })
                        plaza_results=full_mappings_col.find({'mapping_file.Gene ID':gene_id},{'mapping_file.Plaza ID': 1 } )
                        for p in plaza_results:
                            logger.info("plaza id %s",p['mapping_file'][0]['Plaza ID'])
                else:
                    logger.info("gene id %s ",r['Gene ID'])
                    full_mappings_col.update({'mapping_file.Gene ID':r['Gene ID']},{'$inc': {'mapping_file.$.Score': 1 } })
                    plaza_results=full_mappings_col.find({'mapping_file.Gene ID':r['Gene ID']},{'mapping_file.Plaza ID': 1 } )
                    for p in plaza_results:
                        logger.info("plaza id %s",p['mapping_file'][0]['Plaza ID'])


results=list(pv_interactions_col.find({},{"mapping_file.Uniprot ID":1,"_id":0} ))
for u in results:
    for r in u['mapping_file']:
        if 'Uniprot ID' in r:
            if r['Uniprot ID']!="":
                logger.info("uniprot id %s ",r['Uniprot ID'])
                full_mappings_col.update({'mapping_file.Uniprot ID':r['Uniprot ID']},{'$inc': {'mapping_file.$.Score': 1 } })
                plaza_results=full_mappings_col.find({'mapping_file.Uniprot ID':r['Uniprot ID']},{'mapping_file.Plaza ID': 1 } )
                for p in plaza_results:
                    logger.info("plaza id %s",p['mapping_file'][0]['Plaza ID'])
