#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
import string
from random import *

# Script 
import datetime
if "log" not in globals():
  log = Logger.init_logger('SAMPLE_DATA_%s'%(cfg.language_code), load_config())

# Clear collections to fill

pp_interactions_col.drop()
# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


#String database

interactions_table={
	"data_file":"interactomics/STRING/3702.protein.links.v10_aa",
	"src":"Transcript ID",
	"tgt":"Transcript ID 2",
	"src_symbol":"String",
	"tgt_symbol":"String",
	"type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID 2'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)


#BIOGRID Plant-plant interactions

interactions_table={
	"data_file":"interactomics/biogrid/BIOGRID-ORGANISM-Solanum_lycopersicum-3.4.128.tab.xls",
	"src":"Gene ID",
	"tgt":"Gene ID 2",
	"src_symbol":"OFFICIAL_SYMBOL_A",
	"tgt_symbol":"OFFICIAL_SYMBOL_B",
	"type":"symbol_to_symbol",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene ID 2','OFFICIAL_SYMBOL_A','OFFICIAL_SYMBOL_B','ALIASES_FOR_A','ALIASES_FOR_B','EXPERIMENTAL_SYSTEM','SOURCE','PUBMED_ID','ORGANISM_A_ID','ORGANISM_B_ID'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)


interactions_table={
	"data_file":"interactomics/biogrid/BIOGRID-ORGANISM-Arabidopsis_thaliana_Columbia-3.4.128.tab.xls",
	"src":"Gene ID",
	"tgt":"Gene ID 2",
	"src_symbol":"OFFICIAL_SYMBOL_A",
	"tgt_symbol":"OFFICIAL_SYMBOL_B",
	"type":"symbol_to_symbol",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene ID 2','OFFICIAL_SYMBOL_A','OFFICIAL_SYMBOL_B','ALIASES_FOR_A','ALIASES_FOR_B','EXPERIMENTAL_SYSTEM','SOURCE','PUBMED_ID','ORGANISM_A_ID','ORGANISM_B_ID'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)


#IntAct db
interactions_table={
	"data_file":"interactomics/Intact/intact_full.xls",
	"type":"intact",
	"src":"Uniprot ID",
	"src_version":"uniprot",
	"tgt":"Uniprot ID 2",
	"tgt_version":"uniprot",
	"src_name":"Taxid interactor A",
	"tgt_name":"Taxid interactor B",
	"method":"detection_method",
	"pub":"pmid",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','protein_EBI_ref_1','protein_EBI_ref_2','Uniprot ID','Uniprot ID 2','alternative_identifiers_1','alternative_identifiers_2','detection_method','author_name','pmid','Taxid interactor A','Taxid interactor B','interaction_type','source_database_id','interaction_identifier','confidence'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)