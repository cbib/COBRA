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

pp_interactions_col.remove({"origin":"STRING"})


# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


#String database

interactions_table={
	"data_file":"interactomics/STRING/tomato/tomato_aa.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID list",
	"src_symbol":"String",
	"tgt_symbol":"String",
        "origin":"STRING",
        "type":"prot_to_prot",
	"species":"Solanum lycopersicum",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID 2'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)

