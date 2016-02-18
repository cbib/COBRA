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

pv_interactions_col.drop()
# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)






###################################################################################################################
############################################ INTERACTION TABLES ###################################################
###################################################################################################################




# Literature and partner - Interaction potyvirus

interactions_table={
	"data_file":"interactomics/potyvirus/Potyvirus.Interactors.xls",
	"src":"Virus_symbol",
	"tgt":"Host_symbol",
	"type":"symbol_to_symbol",
	"virus_class":"potyvirus",
	"xls_parsing":{
		"n_rows_to_skip":3,
		"column_keys":['idx','Virus_symbol','Host_symbol','method','virus','host','Putative_function','Reference','Accession_number'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/potyvirus/VPg_Interactor.xls",
	"species":"Arabidopsis thaliana",
        "src":"Host_gene",
	"tgt":"Virus_symbol",
	"type":"gene_to_symbol",
	"virus_class":"potyvirus",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Host_gene','Virus_symbol'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/potyvirus/Nla_Interactor.xls",
        "species":"Arabidopsis thaliana",
	"src":"Host_gene",
	"tgt":"Virus_symbol",
	"type":"gene_to_symbol",
	"virus_class":"potyvirus",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Host_gene','Virus_symbol'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/potexvirus/Potexvirus.Interactors.xls",
	"src":"Virus_symbol",
	"tgt":"Host_symbol",
	"type":"symbol_to_symbol",
	"virus_class":"potexvirus",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Virus_symbol','Virus_name','Host_symbol','Host_name','method','virus','host','Putative_function','Reference','Accession_number'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/Tobamovirus/Tobamovirus.Interactors.28.07.15.xlsx",
	"src":"Virus_symbol",
	"tgt":"Host_symbol",
	"type":"symbol_to_symbol",
	"virus_class":"tobamovirus",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Virus_symbol','Virus_name','Host_symbol','Host_name','method','virus','host','Putative_function','Reference','Accession_number'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)








# Host pathogen interaction db
interactions_table={
	"data_file":"interactomics/Intact/hpidb2_plant_only.xls",
	"type":"prot_to_prot_hpidb",
	"src":"protein_xref_1",
	"src_version":"uniprot",
	"tgt":"protein_xref_2",
	"tgt_version":"uniprot",
	"src_name":"protein_taxid_1_name",
	"tgt_name":"protein_taxid_2_name",
	"method":"detection_method",
	"pub":"pmid",
	"host_taxon":"protein_taxid_1_cat",
	"virus_taxon":"protein_taxid_2_cat",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','protein_xref_1','alternative_identifiers_1','protein_alias_1','protein_xref_2','alternative_identifiers_2','protein_alias_2','detection_method','author_name','pmid','protein_taxid_1','protein_taxid_2','interaction_type','source_database_id','database_identifier','confidence','protein_xref_1_unique','protein_xref_2_unique','protein_taxid_1_cat','protein_taxid_2_cat','protein_taxid_1_name','protein_taxid_2_name','protein_seq1','protein_seq2','source_database','comment'],
		"sheet_index":0,
		
	}

}
pv_interactions_col.insert(interactions_table)






