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


# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
  logger = Logger.init_logger('PROCESS_INTERACTIONS_%s'%(cfg.language_code), load_config())


# Script supposed to be run in the background to populate the DB with available datasets 




logger.info("Running %s",sys.argv[0])



# Get available interactions and process them 
#interactions_to_process=pp_interactions_col.find({"src_to_tgt":{"$exists":False}})
interactions_to_process=pp_interactions_col.find({"mapping_file":{"$exists":False},"$or": [{"origin":"BIOGRID"},{"origin":"INTACT"}]})


logger.info("Found %d interactions to process",interactions_to_process.count())
# map_doc=mappings_to_process[0]
for map_doc in interactions_to_process:
	 # on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	# on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']
        fileName, fileExtension = os.path.splitext(src_file)
        if fileExtension!='.xls' and fileExtension!='.xlsx':
		sheet_values = parse_tsv_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

	else:
		sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

		
	#here we extract info about plant and virus
	# save raw data 
	pp_interactions_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})
   

logger.info("Indexation on field \"mapping_file.Uniprot ID\" from document \"Intact database\" in collection \"plant-plant interactions\"")
pp_interactions_col.create_index("mapping_file.Uniprot ID",sparse=True,background=True)
logger.info("Indexation on field \"mapping_file.Gene ID\" from document \"Biogrid database\" in collection \"plant-plant interactions\"")
pp_interactions_col.create_index("mapping_file.Gene ID",sparse=True,background=True)
