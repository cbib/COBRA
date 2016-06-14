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

##HORDEUM VULGARE

## Unspliced genes sequences

sequence_table={
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_1.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_2.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_3.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_4.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_5.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_6.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/GENE/gene_sequence_hordeum_vulgare_ensembl_7.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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


##CDNA sequence

sequence_table={
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_1.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_2.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_3.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_4.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_5.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_6.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_7.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_8.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_9.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_10.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_11.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_12.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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
	"data_file":"Hordeum/sequences/CDNA/cdna_sequence_hordeum_vulgare_ensembl_13.tsv",
	"species":"Hordeum vulgare",
	"src":"Gene ID",
	"src_version":"ENSEMBL/082214v1(IBSC_1.0)",
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

##Solanum lycopersicum


## Unspliced genes sequences

sequence_table={
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_1.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_2.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_3.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_4.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_5.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_6.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_7.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_8.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_9.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_10.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_11.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_12.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/GENE/gene_sequence_solanum_lycopersicum_Ensembl_13.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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

##CDNA sequence

sequence_table={
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_1.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_2.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_3.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_4.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_5.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_6.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_7.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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
	"data_file":"Solanum/sequences/CDNA/cdna_sequence_solanum_lycopersicum_Ensembl_8.tsv",
	"species":"Solanum lycopersicum",
	"src":"Gene ID",
	"src_version":"SL2.50 (2014-10-EnsemblPlants)",
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


##PRUNUS PERSICA

## Unspliced genes sequences

sequence_table={
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_1.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_2.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_3.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_4.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_5.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_6.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_7.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_8.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_9.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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
	"data_file":"Prunus/sequences/GENE/gene_sequence_prunus_persica_ensembl_10.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
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


##CDNA sequence

sequence_table={
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_1.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_2.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_3.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_4.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_5.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_6.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_7.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_8.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_9.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_10.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
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
	"data_file":"Prunus/sequences/CDNA/cdna_sequence_prunus_persica_ensembl_11.tsv",
	"species":"Prunus persica",
	"src":"Gene ID",
	"src_version":"(Prupe1_0 (2013-03))",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTIDSEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)

##Cucumis melo

## Unspliced genes sequences

sequence_table={
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_1.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_2.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_3.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_4.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_5.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_6.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_7.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_8.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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
	"data_file":"Cucumis/sequences/GENE/melon_v4_unigene_9.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"unigen v4 icugi",
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



##CDNA sequence

sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_1.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_2.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)

sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_3.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_4.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_5.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_6.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
        "tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)
sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_7.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)

sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_8.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)

sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_9.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)


sequence_table={
	"data_file":"Cucumis/sequences/CDNA/cdna_sequence_cucumis_melo_Plaza_10.tsv",
	"species":"Cucumis melo",
	"src":"Gene ID",
	"src_version":"Melon transcripts CM_3.5(3C)",
	"tgt":"CDNA_Sequence",
	"url":"",
	"doi":"none",
	"key":"GENEID/TRANSCRIPTID/PLAZAID/SEQUENCE",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Transcript ID','Plaza ID','Transcript Sequence'],
		"sheet_index":0,
	}
}
sequences_col.insert(sequence_table)















