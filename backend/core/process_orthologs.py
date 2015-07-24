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
from pymongo.errors import DocumentTooLarge,OperationFailure


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
			logger.info("species initials : %s \n",species_initials)
			for row in sheet_values:
				cpt=0
				species_found=False;
				for x in row:
					if cpt==0:
						#logger.info("plaza id first letter : %s,\n",row[x][0]+row[x][1])
						if (species_initials==row[x][0]+row[x][1]) and (row[x][2]!="R"):
							#logger.info("species initials found : %s \n",species_initials)
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
			sheet_value = parse_tsv_table(tgt_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],parser_config['sheet_index'])

			try:
				orthologs_col.update({"_id":map_doc['_id']},{"$push":{"mapping_file":sheet_value}})
				#break
			except DocumentTooLarge:
				print "Oops! Document too large to insert as bson object. Use grid fs to store file..."

			file.close()

		

