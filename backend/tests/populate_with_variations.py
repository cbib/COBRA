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


variations_col.drop()

##CDNA sequence



###################################################################################################################
############################################ ARABIDOPSIS THALIANA ###############################################################
###################################################################################################################





###################################################################################################################
############################################ PRUNUS ###############################################################
###################################################################################################################

variation_table={
	"data_file":"Prunus/prunus_persica/SNP/IRSC_9K_peach_SNP_array_work_version.xls",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"International Rosaceae SNP Consortium (IRSC)",
        "tgt":"Variant ID",
        "description":"""This file contains the SNPs selected for inclusion on the International Rosaceae SNP Consortium (IRSC) Peach  SNP Infinium Array that is currently in production. For more information on array design  contact Dorrie Main (dorrie@wsu.edu)""",
        "chrom":"all",
	"url":"",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":3,
		"column_keys":['idx','Variant ID','Alleles','Scaffold','Position',],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)