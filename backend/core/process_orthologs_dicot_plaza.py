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

orthologs_col.drop()

logger.info("Running %s",sys.argv[0])


###DICOTS PART####


# get file path
src_file= data_dir+'orthologs/integrative_orthology.ORTHO.tsv'


species_initial=[]
# Get species keys identifier by searching available mapping file for plaza
species_to_process=mappings_col.find({"src":"Plaza gene id",'type':"PLAZA"},{"species":1})

for species in species_to_process:
	species_initial.append(species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize())
	logger.info("species first letter : %s, species second letter: %s",species['species'].split( )[0][0],species['species'].split( )[1][0].capitalize())

sheet_values = parse_ortholog_table(src_file,['Plaza gene id','orthologs_list_identifier'],0,species_initial)

# save raw data 
logger.info("sheet_value %d",len(sheet_values))

species_initials=[]
species_to_process=mappings_col.find({"src":"Plaza gene id",'type':"PLAZA"},{"species":1})
for species in species_to_process:
	logger.info("species first letter : %s, species second letter: %s",species['species'].split( )[0][0],species['species'].split( )[1][0].capitalize())

	species_initials=species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize()
	tgt_file=data_dir+"orthologs/integrative_orthology.dicots_3.0ORTHO_COBRA"+species_initials+".tsv"
	
	orthologs_table={

		'data_file':tgt_file,
		'species':species['species'],
		'src':'Plaza gene id',
		'tgt':'orthologs_list_identifier',
		'version':"dicots_3.0",
		'xls_parsing':{
			'n_rows_to_skip':0,
			'column_keys':['idx','Plaza gene id','orthologs_list_identifier'],
			'sheet_index':0
		
		}
	}
	orthologs_col.insert(orthologs_table)

	
	
	parser_config=orthologs_table['xls_parsing']
	logger.info("tgt file %s",tgt_file)
	file=open(tgt_file, 'wb')
	for row in sheet_values:
		cpt=0
		species_found=False;
		for x in row:
			if cpt==0:
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
	sheet_value = parse_tsv_ortholog_plaza_table(tgt_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],species_initial,parser_config['sheet_index'])
	try:
		logger.info("map_doc _id : %s \n",orthologs_table['_id'])
		orthologs_col.update({"_id":orthologs_table['_id']},{"$set":{"mapping_file":sheet_value}})
		#break
	except DocumentTooLarge:
		print "Oops! Document too large to insert as bson object. Use grid fs to store file..."

	file.close()


###MONOCOTS PART####

src_file= data_dir+'orthologs/integrative_orthology.ORTHO_monocots.tsv'


species_initial=[]
# Get species keys identifier by searching available mapping file for plaza
species_to_process=mappings_col.find({"src":"Plaza gene id",'type':"PLAZA"},{"species":1})
for species in species_to_process:
	species_initial.append(species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize())
	logger.info("species first letter : %s, species second letter: %s",species['species'].split( )[0][0],species['species'].split( )[1][0].capitalize())

sheet_values = parse_ortholog_table(src_file,['Plaza gene id','orthologs_list_identifier'],0,species_initial)
# save raw data 
logger.info("sheet_value %d",len(sheet_values))
species_initials=[]
species_to_process=mappings_col.find({"src":"Plaza gene id",'type':"PLAZA"},{"species":1})
for species in species_to_process:
	logger.info("species first letter : %s, species second letter: %s",species['species'].split( )[0][0],species['species'].split( )[1][0].capitalize())

	species_initials=species['species'].split( )[0][0]+species['species'].split( )[1][0].capitalize()
	tgt_file=data_dir+"orthologs/integrative_orthology.monocots_3.0ORTHO_COBRA"+species_initials+".tsv"

	orthologs_table={

		'data_file':tgt_file,
		'species':species['species'],
		'src':'Plaza gene id',
		'tgt':'orthologs_list_identifier',
		'version':"monocots_3.0",
		'xls_parsing':{
			'n_rows_to_skip':0,
			'column_keys':['idx','Plaza gene id','orthologs_list_identifier'],
			'sheet_index':0
		
		}
	}
	orthologs_col.insert(orthologs_table)
	#orthologs_to_process=orthologs_col.find({"mapping_file":{"$exists":False},"data_file":tgt_file,'version':"monocots_3.0"})

	
	
	parser_config=orthologs_table['xls_parsing']
	logger.info("tgt file %s",tgt_file)
	file=open(tgt_file, 'wb')

	for row in sheet_values:
		cpt=0
		species_found=False;
		for x in row:
			if cpt==0:
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
	sheet_value = parse_tsv_ortholog_plaza_table(tgt_file,parser_config['column_keys'],parser_config['n_rows_to_skip'],species_initial,parser_config['sheet_index'])
	
	try:
		logger.info("map_doc _id : %s \n",orthologs_table['_id'])
		orthologs_col.update({"_id":orthologs_table['_id']},{"$set":{"mapping_file":sheet_value}})
		#break
	except DocumentTooLarge:
		print "Oops! Document too large to insert as bson object. Use grid fs to store file..."

	file.close()

		

