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
interactions_to_process=interactions_col.find({"src_to_tgt":{"$exists":False}})

logger.info("Found %d interactions to process",interactions_to_process.count())
# map_doc=mappings_to_process[0]
for map_doc in interactions_to_process:
	 # on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	# on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']

	sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])
	
	#here we extract info about plant and virus
	
	
	# save raw data 
	interactions_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})

	# build dict mapper, save them as k,v docs 
	#a_to_b = collections.defaultdict(list)
	#b_to_a = collections.defaultdict(list)
	
	#src_col = map_doc['src']
	#tgt_col = map_doc['tgt']
	#for r in sheet_values:
	#	a_to_b[r[src_col]].append(r[tgt_col])
	#	b_to_a[r[tgt_col]].append(r[src_col])
	# check 1-to-1 mapping
	#a_to_b_tally=collections.Counter(map(len,a_to_b.values()))
	#b_to_a_tally=collections.Counter(map(len,b_to_a.values()))
	#if len(a_to_b_tally)>1:
	#	logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",tgt_col,src_col)
	#else:
	#	logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",tgt_col,src_col)
        #
	#if len(b_to_a_tally)>1:
	#	logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",src_col,tgt_col)
	#else:
	#	logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",src_col,tgt_col)

	# save raw data 
	#interactions_col.update({"_id":map_doc['_id']},{"$set":{"src_to_tgt":a_to_b.items()}})
	#interactions_col.update({"_id":map_doc['_id']},{"$set":{"tgt_to_src":b_to_a.items()}})
        
        logger.info("Indexation on field \"mapping_file.Host_symbol\" from collection \"interactions\")
        interactions_col.create_index("mapping_file.Host_symbol",sparse=True)

        logger.info("Indexation on field \"mapping_file.OFFICIAL_SYMBOL_A\" from collection \"interactions\")
        interactions_col.create_index("mapping_file.OFFICIAL_SYMBOL_A",sparse=True)
