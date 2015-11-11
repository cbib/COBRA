#!/usr/bin/env python
# encoding: utf-8

import sys

import os
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
from helpers.path import data_dir
from pymongo.errors import DocumentTooLarge,OperationFailure


# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
  logger = Logger.init_logger('PROCESS_MAPPINGS_%s'%(cfg.language_code), load_config())


# Script supposed to be run in the background to populate the DB with available datasets 




logger.info("Running %s",sys.argv[0])


# Get available sequences and process them 
sequences_to_process=sequences_col.find({"mapping_file":{"$exists":False}})

logger.info("Found %d sequence tables to process",sequences_to_process.count())

for map_doc in sequences_to_process:
	# on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	
        # on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']

        # on parse le fichier
	sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])
	
	# save raw data 
	sequences_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})

	
        
        
#logger.info("Indexation on field \"mapping_file.Gene ID\" from collection \"sequences\"")
#sequences_col.create_index("mapping_file.Gene ID",sparse=True)
