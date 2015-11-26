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
#mappings_col.drop({"type":{"$in":["full_table"]}});
mappings_col.remove({"type":{"$in":["full_table"]}});

#orthologs_col.drop()
#interactions_col.drop()
for grid_out in fs.find({}, timeout=False):
	
	fs.delete(grid_out._id)



###################################################################################################################
############################################ PRUNUS DOMESTICA #####################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/prunus_full_table.tsv",
	"species":"Prunus persica",
	"type":"full_table",
	"src":"PROBE_ID",
	"src_version":"NCBI",
	"url":"",
	"doi":"none",
	"key":"PROBEID/GENEID/GENEIDBIS/PROTEINIDALT1/PROTEINIDALT2/UNIPROTID/DESCRIPTION/PLAZAID/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Alias', 'Protein ID', 'Transcript ID', 'Uniprot ID','Description','Plaza ID','Gene ontology ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

###################################################################################################################
############################################ CUCUMIS MELO #########################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/cucumis_melo_full.tsv",
	"species":"Cucumis melo",
	"type":"full_table",
	"src":"PROBE_ID",
	"src_version":"est ICUGI v4",
        "tgt":"multiple",
        "tgt_version":"multiple",
	"url":"",
	"doi":"none",
	"key":"PROBEID/GENEID/GENEIDBIS/PROTEINID/DESCRIPTION/PLAZAID/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Probe ID','Gene ID','Gene ID 2','Uniprot ID','Description','Plaza ID','Gene ontology ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/hordeum_vulgare_full.tsv",
	"species":"Hordeum vulgare",
	"type":"full_table",
	"src":"PROBE_ID",
	"src_version":"Morex contig",
        "tgt":"Multiple",
        "tgt_version":"Multiple target",
	"url":"",
	"doi":"none",
	"key":"PROBEID/GENEID/GENEIDBIS/PROTEINID/DESCRIPTION/PLAZAID/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Probe ID','Gene ID','Transcript ID','Uniprot ID','Description','Gene name','Plaza ID','Gene ontology ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################


# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/solanum_lycopersicum_full_1.tsv",
	"species":"Solanum lycopersicum",
	"type":"full_table",
	"src":"PROBE_ID",
	"src_version":"SolGenomics first part",
        "tgt":"Multiple",
        "tgt_version":"Multiple target",
	"url":"",
	"doi":"none",
	"key":"PROBEID/GENEID/TRANSCRIPTID/PROTEINID/ALIAS/DESCRIPTION/PLAZAID/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Probe ID','Gene ID', 'Gene ID 2', 'Transcript ID','Uniprot ID','Alias','Description','Plaza ID','Gene ontology ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/solanum_lycopersicum_full_2.tsv",
	"species":"Solanum lycopersicum",
	"type":"full_table",
	"src":"PROBE_ID",
	"src_version":"SolGenomics second part",
        "tgt":"Multiple",
        "tgt_version":"Multiple target",
	"url":"",
	"doi":"none",
	"key":"PROBEID/GENEID/TRANSCRIPTID/PROTEINID/ALIAS/DESCRIPTION/PLAZAID/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Probe ID','Gene ID', 'Gene ID 2', 'Transcript ID','Uniprot ID','Alias','Description','Plaza ID','Gene ontology ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


###################################################################################################################
############################################ ARABIDOPSIS THALIANA #################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/arabidopsis_thaliana_full.tsv",
	"species":"Arabidopsis thaliana",
	"type":"full_table",
	"src":"CATMA_ID",
	"src_version":"CATMA V2.1",
	"url":"ftp://urgv.evry.inra.fr/CATdb/array_design/CATMA_2.3_07122011.txt",
	"doi":"none",
	"key":"PROBEID/GENEID/GENEIDBIS/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Probe ID','Gene ID','Gene ID 2','Uniprot ID','Description','Plaza ID','Alias','Gene ontology ID','Symbol'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)