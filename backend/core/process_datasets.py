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
## Setup

from numbers import Number
import collections
from math import log
if "log" not in globals():
  logger = Logger.init_logger('DATA_PROCESSOR_%s'%(cfg.language_code), load_config())

logger.info("Running %s",sys.argv[0])

# Get available datasets and insert them in the DB 

# a_sample=samples_col.find_one({"experimental_results.values":{"$exists":False}})
samples_to_process=samples_col.find({"experimental_results":{"$elemMatch":{"values":{"$exists":False}}}})

logger.info("Found %d samples to process",samples_to_process.count())

for a_sample in samples_to_process:

        
	logger.info("Will process dataset for experiment %s",a_sample['name'])
	parser_config=a_sample['xls_parsing']
	for a_result_idx,a_result in [(i,x) for i,x in enumerate(a_sample['experimental_results']) if "values" not in x]:
		# specialize parser for the result 
		logger.info("Will process results from file %s sheet %d",a_result['data_file'],parser_config['sheet_index'])
		parser_config.update(a_result.get('xls_parsing',{}))
                #parsed_data=parse_excel_table(data_dir+a_result['data_file'],parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'],parser_config['id_type'])
                src_file= data_dir+a_result['data_file']
                fileName, fileExtension = os.path.splitext(src_file)
                if fileExtension!='.xls' and fileExtension!='.xlsx':
                    parsed_data = parse_tsv_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'],parser_config['id_type'])

                else:
                    parsed_data = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'],parser_config['id_type'])

		# perform the mapping 

		### TODO

		# update DB 
		diagnostic=samples_col.update({"_id":a_sample['_id'],"experimental_results.data_file":a_result['data_file']},{"$set":{"experimental_results.$.values":parsed_data}})
		logger.info("Performed insertion:%s",diagnostic)


