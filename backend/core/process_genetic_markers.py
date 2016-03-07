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
  logger = Logger.init_logger('PROCESS_GENETIC_MARKERS_%s'%(cfg.language_code), load_config())


# Script supposed to be run in the background to populate the DB with available datasets 




logger.info("Running %s",sys.argv[0])


# Get available variations and process them 
genetic_markers_to_process=genetic_markers_col.find({"mapping_file":{"$exists":False}})

logger.info("Found %d genetic marker tables to process",genetic_markers_to_process.count())

for map_doc in genetic_markers_to_process:
	# on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	logger.info("src file: %s",src_file)
        # on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']
        fileName, fileExtension = os.path.splitext(src_file)

        if fileExtension!='.xls' and fileExtension!='.xlsx':
		sheet_values = parse_tsv_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

	else:
		sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

	
	try:
                genetic_markers_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})
		#break
	except DocumentTooLarge:
		print "Oops! Document too large to insert as bson object. Use grid fs to store file..."
		file=open(src_file, 'rb')
		with fs.new_file(data_file=src_file,content_type='text/plain',  metadata=dict(src=map_doc['src'],tgt=map_doc['tgt'],n_rows_to_skip=parser_config['n_rows_to_skip'])) as fp:
			fp.write(file)
		## adding fs file to the collection
		logger.info("Successfully add new file in grid fs mongo system %s",len(sheet_values))

		genetic_markers_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":{"species":species,"file":fp.data_file}}})
		# Close opened file
		file.close()


	

logger.info("Indexation on field \"mapping_file.Marker ID\" from collection \"genetic maps\"")
variations_col.create_index("mapping_file.Marker ID",sparse=True, background=True)