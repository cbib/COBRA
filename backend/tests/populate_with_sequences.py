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

# clear db 

sequences_col.drop()

##Mapping Prunus Domestica


sequence_table={
	"data_file":"Arabidopsis/arabidopsis_thaliana/sequences/Arabidopsis_TAIR10_all_sequences.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(mapping_table)