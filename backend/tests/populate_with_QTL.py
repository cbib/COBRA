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


qtls_col.drop()






###################################################################################################################
############################################ PRUNUS PERSICA #######################################################
###################################################################################################################

qtl_table={
	"data_file":"Prunus/prunus_persica/QTL/QTL_prunus_final.tsv",
	"species":"Prunus persica",
	"src":"QTL ID",
	"src_version":"",
        "tgt":"Marker ID",
	"url":"http://www.rosaceae.org/node/",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Type','HREF_QTL','QTL ID','Published Symbol','Trait Name','Trait Alias','Study','Population','Colocalizing marker','HREF_markers','Marker ID','Map','AD ratio','R2','Species','Citation'],
		"sheet_index":0,
	}
}
qtls_col.insert(qtl_table)
###################################################################################################################
############################################ PRUNUS ARMENIACA #######################################################
###################################################################################################################

qtl_table={
	"data_file":"Prunus/prunus_armeniaca/QTL/QTL_armeniaca_final.tsv",
	"species":"Prunus armeniaca",
	"src":"QTL ID",
	"src_version":"",
        "tgt":"Marker ID",
	"url":"http://www.rosaceae.org/node/",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Type','HREF_QTL','QTL ID','Published Symbol','Trait Name','Trait Alias','Study','Population','Colocalizing marker','HREF_markers','Marker ID','Map','AD ratio','R2','Species','Citation'],
		"sheet_index":0,
	}
}
qtls_col.insert(qtl_table)