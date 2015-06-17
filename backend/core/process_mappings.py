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
  logger = Logger.init_logger('PROCESS_MAPPINGS_%s'%(cfg.language_code), load_config())


# Script supposed to be run in the background to populate the DB with available datasets 




logger.info("Running %s",sys.argv[0])



# Get available mappings and process them 
mappings_to_process=mappings_col.find({"src_to_tgt":{"$exists":False}})

logger.info("Found %d mappings to process",mappings_to_process.count())
# map_doc=mappings_to_process[0]
for map_doc in mappings_to_process:
	 # on recup le chemin du fichier
	src_file= data_dir+map_doc['data_file']
	# on recup la config du parser xls 
	parser_config=map_doc['xls_parsing']

	sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])
	
	
	
	# Save raw data > 65536 lines.
	if len(sheet_values)> 65000:
		# tgt_file=map_doc['data_file'].split('.')
# 		tgt_file=data_dir+tgt_file[0]+".tsv"
# 		logger.info("tgt file %s",tgt_file)
# 		file=open(tgt_file, 'wb')
# 		for row in sheet_values:
# 			cpt=0
# 			for x in row:
# 				if cpt==0:
# 					logger.info("row value %s",row[x])
# 
# 					file.write(row[x])
# 					file.write("\t")
# 				else:
# 					logger.info("row value %s",row[x])
# 
# 					file.write(row[x])
# 					file.write("\n")	
# 			cpt+=1
# 		file.closed
		file=open(src_file, 'rb')
		with fs.new_file(data_file=src_file,content_type='text/plain',  metadata=dict(src=map_doc['src'],tgt=map_doc['tgt'],n_rows_to_skip=parser_config['n_rows_to_skip'])) as fp:
			fp.write(file)
		## adding fs file to the collection
		logger.info("Successfully add new file in grid fs mongo system %s",len(sheet_values))

		mappings_col.update({"_id":map_doc['_id']},{"$push":{"mapping_file":fp.data_file}})
		# Close opened file
		file.close()
	
	else:
	
		# save raw data 
		mappings_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})

	# build dict mapper, save them as k,v docs 
	a_to_b = collections.defaultdict(list)
	b_to_a = collections.defaultdict(list)
	src_col = map_doc['src']
	tgt_col = map_doc['tgt']	
	for r in sheet_values:
		#a_to_b[str(r[src_col])].append(str(r[tgt_col]))
		#b_to_a[str(r[tgt_col])].append(str(r[src_col]))
		a_to_b[r[src_col]].append(r[tgt_col])
		b_to_a[r[tgt_col]].append(r[src_col])
	# check 1-to-1 mapping
	a_to_b_tally=collections.Counter(map(len,a_to_b.values()))
	b_to_a_tally=collections.Counter(map(len,b_to_a.values()))
	if len(a_to_b_tally)>1:
		logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",tgt_col,src_col)
	else:
		logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",tgt_col,src_col)

	if len(b_to_a_tally)>1:
		logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",src_col,tgt_col)
	else:
		logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",src_col,tgt_col)

	# save raw data 
	#for key, value in a_to_b.items():
	#	mappings_col.update({"_id":map_doc['_id']},{"$set":{"src_to_tgt":{"src":str(key),"tgt":str(value)}}})
	#for key, value in b_to_a:	
	#	mappings_col.update({"_id":map_doc['_id']},{"$set":{"tgt_to_src":{"tgt":str(key),"src":str(value)}}})
	mappings_col.update({"_id":map_doc['_id']},{"$set":{"src_to_tgt":a_to_b.items()}})
	mappings_col.update({"_id":map_doc['_id']},{"$set":{"tgt_to_src":b_to_a.items()}})

