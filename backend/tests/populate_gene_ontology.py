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

gene_ontology_col.remove()

# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


##Mapping PRunus Domestica


mapping_table={
	"data_file":"gene_ontology/ATH_GO_GOSLIM.xls",
	"species":"Arabidopsis thaliana",
	"type":"",
	"src":"AGI_TAIR",
	"src_version":"Tair",
	"tgt":"GO term",
	"tgt_version":"",
	"relation":"relationship type",
	"url":"",
	"doi":"",
	"key":"unigene_2_ncbi_protein",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','locus_name','TAIR accession','object name','relationship type','GO term','GO ID','TAIR Keyword ID','Aspect','GOslim term','Evidence code','Evidence description','Evidence with','Reference','Annotator','Date annotated'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)