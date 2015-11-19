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
for grid_out in fs.find({}, timeout=False):
	
	fs.delete(grid_out._id)

##Sequences Arabidopsis thaliana


sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_5.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_6.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_7.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_8.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/CDNA/Arabidopsis_TAIR10_sequences_set_9.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"TAIR",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)


sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_1.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
        "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_2.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
   "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_3.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
   "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_4.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
   "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_5.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
   "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_6.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
   "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Arabidopsis/sequences/GENE/gene_sequence_arabidopsis_thaliana_Ensembl_7.tsv",
	"species":"Arabidopsis thaliana",
	"src":"Gene ID",
	"src_version":"ENSEMBL/TAIR",
        "tgt":"Gene_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Gene Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)