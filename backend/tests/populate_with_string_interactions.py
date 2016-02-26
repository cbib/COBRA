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

pp_interactions_col.remove({"type":"String Database"})

pp_interactions_col.drop()
# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


#String database

interactions_table={
	"data_file":"interactomics/STRING/3702.protein.links.v10_aa.tsv",
	"src":"Transcript ID",
	"tgt":"Transcript ID 2",
	"src_symbol":"String",
	"tgt_symbol":"String",
	"type":"String Database",
	"species":"Arabidopsis thaliana",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Transcript ID','Transcript ID 2',combined Score'],
		"sheet_index":0,
		
	}

}
pp_interactions_col.insert(interactions_table)