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




pipeline=[
            {'$match' : {'type':'full_table'}},           
            {'$project' : {'mapping_file':1,'species':1,'_id':0}},         
            {'$unwind':'$mapping_file'},         
            {'$match' : {'$or': [ 
                {'mapping_file.Gene ID':{'$regex':'^AT4G23810', '$options': 'xi' }}, 
                {'mapping_file.Gene ID':{'$regex':'AT4G23810$', '$options': 'xi' }}, 
                {'mapping_file.Gene ID 2':{'$regex':'^AT4G23810', '$options': 'xi' }}, 
                {'mapping_file.Gene ID 2':{'$regex':'AT4G23810$', '$options': 'xi' }}, 
            ]}},         
            {'$project' : {'mapping_file':1,'_id':0}}     

        ]


results=full_mappings_col.aggregate(pipeline, useCursor=False)
for result in results:
    id = result["mapping_file"]["Gene ID"]
    logger.info("Gene ID %s",id)
    


    full_mappings_col.update(
    {"mapping_file.Gene ID": id},
    {"$inc": {"mapping_file.$.Score": 1}},multi=True
    )


#cursor_to_table(results)


    