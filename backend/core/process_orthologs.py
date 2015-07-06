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
  logger = Logger.init_logger('PROCESS_ORTHOLOGS_%s'%(cfg.language_code), load_config())


# Script supposed to be run in the background to populate the DB with available datasets 




logger.info("Running %s",sys.argv[0])



# Get available interactions and process them 
orthologs_to_process=orthologs_col.find({"src_to_tgt":{"$exists":False}})
logger.info("Found %d orthologs to process",orthologs_to_process.count())


# map_doc=mappings_to_process[0]
for map_doc in orthologs_to_process:
	# get file path
	src_file= data_dir+map_doc['data_file']
	# get xls parser config 
	parser_config=map_doc['xls_parsing']
	if map_doc['src']=="plaza_gene_identifier" :
		species_initials=[]
		# Get species keys identifier by searching available mapping file for plaza
		species_to_process=mappings_col.find({"src":"plaza_gene_id",'type':{"$nin":['gene_to_go']}},{"species":1})
		for species in species_to_process:
			species_initials.append(species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize())
			logger.info("species first letter : %s, species second letter: %s",species['species'].split( )[0][0],species['species'].split( )[1][0].capitalize())


		sheet_values = parse_ortholog_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],species_initials)
		# save raw data 
		logger.info("sheet_value %d",len(sheet_values))
		species_initials=[]
		species_to_process=mappings_col.find({"src":"plaza_gene_id",'type':{"$nin":['gene_to_go']}},{"species":1})
		for species in species_to_process:
			species_initials=species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize()
			tgt_file=data_dir+"orthologs/integrative_orthology."+map_doc['version']+"ORTHO_COBRA"+species_initials+".tsv"
			logger.info("tgt file %s",tgt_file)
			file=open(tgt_file, 'wb')
			logger.info("species initials : %s,\n",species_initials)
			for row in sheet_values:
				cpt=0
				species_found=False;
				for x in row:
					if cpt==0:
						
						#logger.info("plaza id first letter : %s,\n",row[x][0]+row[x][1])
						if (species_initials==row[x][0]+row[x][1]) and (row[x][2]!="R"):
							species_found=True;
					if species_found :
						if cpt==0:
							file.write(row[x])
							file.write("\t")
						else:
							file.write(row[x])
							file.write("\n")	
					
					cpt+=1
				species_found=False;
			file.closed
			file=open(tgt_file, 'rb')
			with fs.new_file(data_file=tgt_file,content_type='text/plain',  metadata=dict(src='plaza_gene_identifier',tgt='orthologs_list_identifier',n_rows_to_skip='0')) as fp:
				fp.write(file)
			## adding fs file to the collection
			orthologs_col.update({"_id":map_doc['_id']},{"$push":{"mapping_file":{"species":species['species'],"file":fp.data_file}}})
			# Close opened file
			file.close()
		#orthologs_col.put("mapping_file":"sheet_values")
		
		##Create our own file with only orthology relationship between described species in COBRA
		#when adding new species, this file will be automatically rebuilt.
		
		
		
		#file=open(tgt_file, 'rb')
		
		#with fs.new_file(data_file='orthologs/integrative_orthology.ORTHO_COBRA.tsv',content_type='text/plain',  metadata=dict(src='plaza_gene_identifier',tgt='orthologs_list_identifier',n_rows_to_skip='0')) as fp:
		#	fp.write(file)
		#logger.info("filename %s",fs.list())
		
		
		##A way to access the file store file
		
		#for grid_out in fs.find({"data_file":"orthologs/integrative_orthology.ORTHO_COBRA.tsv"}, timeout=False):
		#	data = grid_out.read()
		#logger.info("sheet_value %s",data)
		
		## adding fs file to the collection
		#orthologs_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":fp.data_file}})

		# build dict mapper, save them as k,v docs 
		
		
		
		# a_to_b = collections.defaultdict(list)
# 		b_to_a = collections.defaultdict(list)
# 	
# 		src_col = map_doc['src']
# 		tgt_col = map_doc['tgt']
# 		for r in sheet_values:
# 			a_to_b[r[src_col]].append(r[tgt_col])
# 			b_to_a[r[tgt_col]].append(r[src_col])
# 		# check 1-to-1 mapping
# 		a_to_b_tally=collections.Counter(map(len,a_to_b.values()))
# 		b_to_a_tally=collections.Counter(map(len,b_to_a.values()))
# 		if len(a_to_b_tally)>1:
# 			logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",tgt_col,src_col)
# 		else:
# 			logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",tgt_col,src_col)
# 
# 		if len(b_to_a_tally)>1:
# 			logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",src_col,tgt_col)
# 		else:
# 			logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",src_col,tgt_col)
# 
# 		#write i separate files the src to tgt and 
# 		
# 		
# 		
# 		# save raw data 
# 		orthologs_col.update({"_id":map_doc['_id']},{"$set":{"src_to_tgt":a_to_b.items()}})
# 		orthologs_col.update({"_id":map_doc['_id']},{"$set":{"tgt_to_src":b_to_a.items()}})


	
	
	# sheet_values = parse_excel_table(src_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])
# 	
# 	#here we extract info about plant and virus
# 	
# 	
# 	# save raw data 
# 	orthologs_col.update({"_id":map_doc['_id']},{"$set":{"mapping_file":sheet_values}})
# 
# 	# build dict mapper, save them as k,v docs 
# 	a_to_b = collections.defaultdict(list)
# 	b_to_a = collections.defaultdict(list)
# 	
# 	src_col = map_doc['src']
# 	tgt_col = map_doc['tgt']
# 	for r in sheet_values:
# 		a_to_b[r[src_col]].append(r[tgt_col])
# 		b_to_a[r[tgt_col]].append(r[src_col])
# 	# check 1-to-1 mapping
# 	a_to_b_tally=collections.Counter(map(len,a_to_b.values()))
# 	b_to_a_tally=collections.Counter(map(len,b_to_a.values()))
# 	if len(a_to_b_tally)>1:
# 		logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",tgt_col,src_col)
# 	else:
# 		logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",tgt_col,src_col)
# 
# 	if len(b_to_a_tally)>1:
# 		logger.info("Multiple %s mapping to a single %s, building a 1-n mapping table",src_col,tgt_col)
# 	else:
# 		logger.info("Single %s mapping to a single %s, building a 1-1 mapping table",src_col,tgt_col)
# 
# 	# save raw data 
# 	orthologs_col.update({"_id":map_doc['_id']},{"$set":{"src_to_tgt":a_to_b.items()}})
# 	orthologs_col.update({"_id":map_doc['_id']},{"$set":{"tgt_to_src":b_to_a.items()}})
# 
