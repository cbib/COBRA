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
#mappings_to_process=mappings_col.find({"mapping_file":{"$exists":False}})
mappings_to_process=mappings_col.find({"mapping_file":{"$exists":False},"type":{"$in":["full_table"]}})

logger.info("Found %d mappings to process",mappings_to_process.count())
# map_doc=mappings_to_process[0]
for map_doc in mappings_to_process:
	 # on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	# on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']
	species=map_doc['species']
	logger.info("species %s",species)
	size=os.path.getsize(src_file) >> 20
	frac=size/(1024*1024.0)
	final=frac+size
	logger.info("size of %s : %s",src_file,final)
	
	fileName, fileExtension = os.path.splitext(src_file)
	if fileExtension!='.xls' and fileExtension!='.xlsx':
		sheet_values = parse_tsv_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

	else:
		sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

		
	
	try:
		mappings_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})
		#break
	except DocumentTooLarge:
		print "Oops! Document too large to insert as bson object. Use grid fs to store file..."
		file=open(src_file, 'rb')
		with fs.new_file(data_file=src_file,content_type='text/plain',  metadata=dict(src=map_doc['src'],tgt=map_doc['tgt'],n_rows_to_skip=parser_config['n_rows_to_skip'])) as fp:
			fp.write(file)
		## adding fs file to the collection
		logger.info("Successfully add new file in grid fs mongo system %s",len(sheet_values))

		mappings_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":{"species":species,"file":fp.data_file}}})
		             #update({"_id":map_doc['_id']},{"$push":{"mapping_file":{"species":species['species'],"file":fp.data_file}}})
		# Close opened file
		file.close()	




logger.info("Indexation on field \"mapping_file.Plaza ID\", \"mapping_file.Gene ID\", \"mapping_file.Transcript ID\" from collection \"mappings\"")
mappings_col.create_index("mapping_file.Plaza ID",sparse=True,background=True)
mappings_col.create_index("mapping_file.Gene ID",sparse=True,background=True)
mappings_col.create_index("mapping_file.Transcript ID",sparse=True,background=True)