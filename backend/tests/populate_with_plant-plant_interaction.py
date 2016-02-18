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



#BIOGRID Plant-plant interactions

interactions_table={
	"data_file":"interactomics/biogrid/BIOGRID-ORGANISM-Solanum_lycopersicum-3.4.128.tab.xls",
	"src":"INTERACTOR_A",
	"tgt":"INTERACTOR_B",
	"src_symbol":"OFFICIAL_SYMBOL_A",
	"tgt_symbol":"OFFICIAL_SYMBOL_B",
	"type":"symbol_to_symbol",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','INTERACTOR_A','INTERACTOR_B','OFFICIAL_SYMBOL_A','OFFICIAL_SYMBOL_B','ALIASES_FOR_A','ALIASES_FOR_B','EXPERIMENTAL_SYSTEM','SOURCE','PUBMED_ID','ORGANISM_A_ID','ORGANISM_B_ID'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)


interactions_table={
	"data_file":"interactomics/biogrid/BIOGRID-ORGANISM-Arabidopsis_thaliana_Columbia-3.4.128.tab.xls",
	"src":"INTERACTOR_A",
	"tgt":"INTERACTOR_B",
	"src_symbol":"OFFICIAL_SYMBOL_A",
	"tgt_symbol":"OFFICIAL_SYMBOL_B",
	"type":"symbol_to_symbol",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','INTERACTOR_A','INTERACTOR_B','OFFICIAL_SYMBOL_A','OFFICIAL_SYMBOL_B','ALIASES_FOR_A','ALIASES_FOR_B','EXPERIMENTAL_SYSTEM','SOURCE','PUBMED_ID','ORGANISM_A_ID','ORGANISM_B_ID'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)


#IntAct db
interactions_table={
	"data_file":"interactomics/Intact/intact_full.xls",
	"type":"prot_to_prot_intact",
	"src":"protein_xref_1",
	"src_version":"uniprot",
	"tgt":"protein_xref_2",
	"tgt_version":"uniprot",
	"src_name":"Taxid interactor A",
	"tgt_name":"Taxid interactor B",
	"method":"detection_method",
	"pub":"pmid",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','protein_EBI_ref_1','protein_EBI_ref_2','protein_xref_1','protein_xref_2','alternative_identifiers_1','alternative_identifiers_2','detection_method','author_name','pmid','Taxid interactor A','Taxid interactor B','interaction_type','source_database_id','interaction_identifier','confidence'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)