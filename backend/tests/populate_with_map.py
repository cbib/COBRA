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

genetic_maps_col.drop()





###################################################################################################################
############################################ PRUNUS PERSICA ###############################################################
###################################################################################################################

map_table={
	"data_file":"Prunus/prunus_persica/genetic_maps/GDR_map_set.tsv",
	"species":"Prunus persica",
	"src":"Map ID",
	"src_version":"",
        "tgt":"Feature ID",
	"url":"",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Map ID','map_acc','map_name','map_start','map_stop','feature_acc','Feature ID','feature_aliases','feature_start','feature_stop','feature_type_acc','is_landmark'],
		"sheet_index":0,
	}
}
genetic_maps_col.insert(map_table)

###################################################################################################################
############################################ PRUNUS ARMENIACA ###############################################################
###################################################################################################################

map_table={
	"data_file":"Prunus/prunus_armeniaca/genetic_maps/GDR_map_set.tsv",
	"species":"Prunus armeniaca",
	"src":"Map ID",
	"src_version":"",
        "tgt":"Feature ID",
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Map ID','map_acc','map_name','map_start','map_stop','feature_acc','Feature ID','feature_aliases','feature_start','feature_stop','feature_type_acc','is_landmark'],
		"sheet_index":0,
	}
}
genetic_maps_col.insert(map_table)