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

variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis1_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis1_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis1_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis1_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis1_5.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis2_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis2_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis2_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis3_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis3_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis3_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis3_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis4_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis4_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis4_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis4_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)

variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)

variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_5.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)
variation_table={
	"data_file":"Arabidopsis/SNP/ensembl_variant_arabidopsis5_6.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"2010-09-TAIR10",
        "tgt":"Variant ID",
        "chrom":1,
	"url":"",
	"doi":"none",
	"key":"VARIANTID/POSITION/DESCRIPTION/GENEID/ALLELES",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Variant ID','Position','Description','Gene ID','Alleles'],
		"sheet_index":0,
	}
}
variations_col.insert(variation_table)