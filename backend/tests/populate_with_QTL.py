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

#qtl_table={
#	"data_file":"Prunus/prunus_persica/QTL/QTL_prunus_final.tsv",
#       "species":"Prunus persica",
#	"src":"QTL ID",
#	"src_version":"",
#        "tgt":"Marker ID",
#	"url":"http://www.rosaceae.org/node/",
#	"doi":"none",
#	"key":"",
#	# parser config 
#		# xls parser configuration, are propagated to all entries in  "experimental_results",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','Type','HREF_QTL','QTL ID','Published Symbol','Trait Name','Trait Alias','Study','Population','HREF_col_markers','Colocalizing marker','HREF_markers','Marker ID','Map','AD ratio','R2','Species','Citation'],
#		"sheet_index":0,
#	}
#}
#qtls_col.insert(qtl_table)
###################################################################################################################
############################################ PRUNUS ARMENIACA #######################################################
###################################################################################################################

#qtl_table={
#	"data_file":"Prunus/prunus_armeniaca/QTL/QTL_armeniaca_final.tsv",
#	"species":"Prunus armeniaca",
#	"src":"QTL ID",
#	"src_version":"",
#       "tgt":"Marker ID",
#	"url":"http://www.rosaceae.org/node/1534497/",
#	"doi":"none",
#	"key":"",
#	# parser config 
#		# xls parser configuration, are propagated to all entries in  "experimental_results",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','Type','HREF_QTL','QTL ID','Published Symbol','Trait Name','Trait Alias','Study','Population','HREF_col_markers','Colocalizing marker','HREF_markers','Marker ID','Map','AD ratio','R2','Species','Citation'],
#		"sheet_index":0,
#	}
#}
#qtls_col.insert(qtl_table)


qtl_table={
	"data_file":"Prunus/QTL/prunus_species_qtl.tsv",
	"src":"QTL ID",
	"src_version":"",
        "tgt":"Marker ID",
	"url":"http://www.rosaceae.org/node/1534497/",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','HREF_QTL','QTL ID','Published Symbol','Trait Name','Trait Alias','Study','Population','HREF_col_markers','Colocalizing marker','HREF_markers','Marker ID','Map ID','AD ratio','R2','Species','Citation'],
		"sheet_index":0,
	}
}
qtls_col.insert(qtl_table)


#qtl_table={
#	"data_file":"Solanum/QTL/QTL_sol_pgdbj.tsv",
#	"src":"QTL ID",
#	"src_version":"",
#       "tgt":"Marker ID",
#	"url":"http://pgdbj.jp/markerdb2/",
#	"doi":"none",
#	"key":"",
#	# parser config 
#		# xls parser configuration, are propagated to all entries in  "experimental_results",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','Species','Family','QTL','Trait Name','Chr or LG','Significant Marker','Lod','Lod peak (cm)','Location','Trait Type','DOI or PMID'],
#		"sheet_index":0,
#	}
#}
#qtls_col.insert(qtl_table)

#qtl_table={
#	"data_file":"Cucumis/QTL/QTL_cuc_pgdbj.tsv",
#	"src":"QTL ID",
#	"src_version":"PGDBJ",
#       "tgt":"Marker ID",
#	"url":"",
#	"doi":"none",
#	"key":"",
#	# parser config 
#		# xls parser configuration, are propagated to all entries in  "experimental_results",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','Species','Family','QTL','Trait Name','Chr or LG','Marker ID','Lod','Lod peak (cm)','Location','Trait Type','DOI or PMID'],
#		"sheet_index":0,
#	}
#}
#qtls_col.insert(qtl_table)


qtl_table={
	"data_file":"Cucumis/QTL/QTL_physical_positions.tsv",
	"src":"QTL ID",
	"src_version":"Melonomics",
        "tgt":"Marker ID",
	"url":"",
	"doi":"none",
	"key":"",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Alias','QTL Name','letter_exp','QTL ID','Chromosome','Map ID','Marker ID','Marker ID 2','Start','End'],
		"sheet_index":0,
	}
}
qtls_col.insert(qtl_table)