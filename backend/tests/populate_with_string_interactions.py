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

pp_interactions_col.remove({"origin":"STRING","species":"Solanum lycopersicum"})
pp_interactions_col.remove({"origin":"STRING","species":"Hordeum vulgare"})
pp_interactions_col.remove({"origin":"STRING","species":"Arabidopsis thaliana"})


# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


#String database

interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_1.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_2.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_3.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_4.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_5.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_6.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_7.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_8.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_9.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_10.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_11.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_12.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_13.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_14.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_15.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_16.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_17.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Tomato/tomato_protein_links_v10_18.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

#HORDEUM VULGARE

interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_1.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_2.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_3.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_4.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_5.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_6.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_7.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_8.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_9.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_10.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_11.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_12.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_13.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_14.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Barley/barley_protein_links_v10_15.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Hordeum vulgare",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_1.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_2.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_3.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_4.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_5.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_6.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_7.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_8.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_9.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_10.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_11.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_12.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_13.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_14.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_15.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_16.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_17.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_18.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_19.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_20.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
interactions_table={
	"data_file":"interactomics/STRING/Arabidopsis/arabidopsis_protein_links_v10_21.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID list'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)
