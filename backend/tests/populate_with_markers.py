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


genetic_markers_col=db.genetic_markers






###################################################################################################################
############################################ PRUNUS PERSICA #######################################################
###################################################################################################################

marker_table={
	"data_file":"Prunus/prunus_persica/genetic_markers/persica_markers_final.tsv",
	"species":"Prunus persica",
	"src":"Marker ID",
	"src_version":"",
        "tgt":"Map ID",
	"url":"",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','HREF_markers','Marker ID','Alias','Type','Species','Map ID','Linkage Group','Start','Stop','Location','Citation','Primer1 name','Primer1 sequence','Primer2 name','Primer2 sequence'],
		"sheet_index":0,
	}
}
genetic_markers_col.insert(marker_table)

###################################################################################################################
############################################ PRUNUS ARMENIACA #####################################################
###################################################################################################################

marker_table={
	"data_file":"Prunus/prunus_armeniaca/genetic_markers/armeniaca_markers_final.tsv",
	"species":"Prunus armeniaca",
	"src":"Marker ID",
	"src_version":"",
        "tgt":"Map ID",
	"url":"",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','HREF_markers','Marker ID','Alias','Type','Species','Map ID','Linkage Group','Start','Stop','Location','Citation','Primer1 name','Primer1 sequence','Primer2 name','Primer2 sequence'],
		"sheet_index":0,
	}
}
genetic_markers_col.insert(marker_table)