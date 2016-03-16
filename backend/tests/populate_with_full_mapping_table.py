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
full_mappings_col.drop();
#mappings_col.remove({"type":{"$in":["full_table"]}});
#mappings_col.remove({"type":"full_table"});


#orthologs_col.drop()
#interactions_col.drop()
#for grid_out in fs.find({}, timeout=False):	
#	fs.delete(grid_out._id)



###################################################################################################################
############################################ PRUNUS ###############################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/FULL_MAPPING/prunus_full_table_1.tsv",
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
		"column_keys":['idx','Gene ID','Alias', 'Protein ID', 'Transcript ID', 'Uniprot ID','Description','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/FULL_MAPPING/prunus_full_table_2.tsv",
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
		"column_keys":['idx','Gene ID','Alias', 'Protein ID', 'Transcript ID', 'Uniprot ID','Description','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

###################################################################################################################
############################################ CUCUMIS MELO #########################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/FULL_MAPPING/cucumis_melo_full_1.tsv",
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
		"column_keys":['idx','Probe ID','Gene ID','Gene ID 2','Transcript ID','Transcript start','Transcript end','Uniprot ID','Description','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome','Strand'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/FULL_MAPPING/cucumis_melo_full_2.tsv",
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
		"column_keys":['idx','Probe ID','Gene ID','Gene ID 2','Transcript ID','Transcript start','Transcript end','Uniprot ID','Description','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome','Strand'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)



###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/FULL_MAPPING/hordeum_vulgare_full.tsv",
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
		"n_rows_to_skip":0,
		"column_keys":['idx','Probe ID','Gene ID','Transcript ID','Uniprot ID','Description','Gene Name','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################


# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/FULL_MAPPING/solanum_lycopersicum_full_1.tsv",
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
		"column_keys":['idx','Probe ID','Gene ID', 'Gene ID 2', 'Transcript ID','Uniprot ID','Alias','Description','Description 2','Domain','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Chromosome','Start','End'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/FULL_MAPPING/solanum_lycopersicum_full_2.tsv",
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
		"column_keys":['idx','Probe ID','Gene ID', 'Gene ID 2', 'Transcript ID','Uniprot ID','Alias','Description','Description 2','Domain','Plaza ID','Gene ontology ID','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Chromosome','Start','End'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)


###################################################################################################################
############################################ ARABIDOPSIS THALIANA #################################################
###################################################################################################################

# full mapping table - PROBEID/GENEID/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID
mapping_table={
	"data_file":"mappings/FULL_MAPPING/arabidopsis_thaliana_1.tsv",
	"species":"Arabidopsis thaliana",
	"type":"full_table",
	"src":"Gene ID",
	"src_version":"CATMA V2.1",
	"url":"ftp://urgv.evry.inra.fr/CATdb/array_design/CATMA_2.3_07122011.txt",
	"doi":"none",
	"key":"PROBEID/GENEID/GENEIDBIS/PROTEINID/DESCRIPTION/PLAZAID/ALIAS/GENEONTOLOGYID",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
                #Gene ID	Gene start (bp)	Gene end (bp)	Strand	Gene description	Gene name	WikiGene description	NA	Plaza ID	Probe ID	Transcript ID	GO term accession	GO term evidence code	exp	int	ort	QTL	SNP	score
                "column_keys":['idx','Gene ID','Start','End','Strand','Description', 'Gene Name','Description 2','Uniprot ID','Plaza ID','Probe ID','Transcript ID','Gene ontology ID','GO Evidence','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score'],

		#"column_keys":['idx','Probe ID','Gene ID','Transcript ID','Gene Name','Description', 'Uniprot ID','Description 2','Plaza ID','Alias','Gene ontology ID','Symbol','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)


mapping_table={
	"data_file":"mappings/FULL_MAPPING/arabidopsis_thaliana_2.tsv",
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
		"n_rows_to_skip":0,
		"column_keys":['idx','Probe ID','Gene ID','Transcript ID','Gene Name','Description', 'Uniprot ID','Description 2','Plaza ID','Alias','Gene ontology ID','Symbol','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/FULL_MAPPING/arabidopsis_thaliana_3.tsv",
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
		"n_rows_to_skip":0,
		"column_keys":['idx','Probe ID','Gene ID','Transcript ID','Gene Name','Description', 'Uniprot ID','Description 2','Plaza ID','Alias','Gene ontology ID','Symbol','Score_exp','Score_int','Score_orthologs','Score_QTL','Score_SNP','Global_Score','Start','End','Chromosome'],
		"sheet_index":0,
	}
}
full_mappings_col.insert(mapping_table)