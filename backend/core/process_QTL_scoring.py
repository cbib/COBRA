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

   # markers_to_process=genetic_markers_col.find({"species":species['full_name']}{})
    markers_to_process=list(genetic_markers_col.find({'species':species['full_name']},{"mapping_file.Position":1,"_id":0} ))
    for markers in markers_to_process:
        for m in markers['mapping_file']:
            if 'Position' in m:
                if m['Position']!="":
                    logger.info("markers position %s ",m['Position'])
                    gene_to_process=list(full_mappings_col.find({"$and": [ { "mapping_file.Gene End": { "$gt": m['Position'] } }, { "mapping_file.Gene Start": { "$lt": m['Position'] } } ]},{"mapping_file.$":1}))
                    for gene in gene_to_process:
                        logger.info("gene %s ",gene)
                        
                        
   