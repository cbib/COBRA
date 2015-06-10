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

mappings_col.remove()
orthologs_col.remove()
for grid_out in fs.find({}, timeout=False):
	
	fs.delete(grid_out._id)


##Mapping PRunus Domestica


mapping_table={
	"data_file":"mappings/Table_S1.xls",
	"species":"Prunus Domestica",
	"type":"gene_to_prot",
	"src":"unigene",
	"src_version":"",
	"tgt":"NCBI_Protein_code",
	"tgt_version":"",
	"description":"Sequence",
	"url":"",
	"doi":"",
	"key":"unigene_2_ncbi_protein",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":2,
		"column_keys":['idx','unigene', 'Sequence', 'Jojo-W1', 'Jojo-W2', 'Jojo-W+PPV', 'Jojo-M+PPV', 'fold_change', 'logFC', 'logCPM', 'PValue', 'FDR', 'Description', 'AccPrunus', 'DescPrunus', 'AccNCBI', 'DescNCBI', 'AccPlants', 'DescPlants', 'AccPRG', 'DescPRG','NCBI_Protein_code'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

## mapping Table melon
#est_to_gene

mapping_table={
	"data_file":"mappings/1471-2164-13-601-s7.xls",
	"species":"Cucumis melo",
	"type":"est_to_gene",
	"src":"est_unigen",
	"src_version":"Melogen_melo_v1",
	"tgt":"icugi_unigene",
	"tgt_version":"v4",
	"description":"sequence",
	"url":"http://www.biomedcentral.com/content/supplementary/1471-2164-13-601-s7.xls",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"est_2_unigene",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":3,
		"column_keys":['idx','est_unigen','sequence','icugi_unigene'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)
#gene_to_gene
mapping_table={
	"data_file":"mappings/Melon_Icugi_to_Melonomics.xls",
	"species":"Cucumis melo",
	"type":"gene_to_gene",
	"src":"icugi_unigene",
	"src_version":"v4",
	"tgt":"Melonomics_gene_id",
	"tgt_version":"v3.5",
	"description":"none",
	"url":"not published",
	"doi":"not published",
	"key":"est_2_unigene",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','icugi_unigene','Melonomics_gene_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_prot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.cme.xls",
	"species":"Cucumis melo",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"Melonomics_gene_id",
	"tgt_version":"v3.5",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.cme.csv.gz",
	"doi":"not published",
	"key":"plaza_gene_id_to_melonomics_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','Melonomics_gene_id','Tid','uniprot'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#Mapping Table Barley
#gene_to_prot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.hvu.xls",
	"species":"Hordeum vulgare",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Monocots",
	"tgt":"barley_protein_id",
	"tgt_version":"test",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_monocots_03/IdConversion/id_conversion.hvu.csv.gz",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"plaza_gene_id_to_barley_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','barley_gene_id','barley_protein_id', 'id', 'Tid','uniprot'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


mapping_table={
	"data_file":"mappings/Barlex_list_genes.xls",
	"species":"Hordeum vulgare",
	"type":"est_to_gene",
	"src":"Morex_Contig",
	"src_version":"",
	"tgt":"Locus_Gene_Name",
	"tgt_version":"",
	"description":"none",
	"url":"http://apex.ipk-gatersleben.de/apex/f?p=284:27:8729907556936:CSV::::",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"morex_contig_id_to_barley_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','FPC','BAC','Cluster ID','Morex_Contig','MorexChromosome','Morex Contig cM','BAC Contig','Locus_Gene_Name','Confidence','FunctionalAnnotation'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



#Mapping Table Tomato

#gene_to_prot
mapping_table={
	"data_file":"mappings/tomato_species_unigene_2009_01_14.v1.blastx.swissprot.m8.filtered.annotated.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_prot",
	"src":"SGN_U",
	"src_version":"tomato200607#2",
	"tgt":"UniProt",
	"tgt_version":"",
	"description":"description",
	"url":"ftp://ftp.solgenomics.net/unigene_builds/combined_species_assemblies/tomato_species/unigene_annotations/tomato_species_unigene_2009_01_14.v1.blastx.swissprot.m8.filtered.annotated.tab",
	"doi":"none",
	"key":"SGN_U_2_Uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','SGN_U', 'Swissprot_name', 'Species_code','UniProt','SwissProt_ID', 'full_ID', 'identity', 'aligment_length', 'mismatches', 'gap_openings', 'query_start_position', 'query_end_position', 'subject_start_position', 'subject_end_position', 'e-value', 'hit_score','description'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_gene
mapping_table={
	"data_file":"mappings/tomato_species_unigenes.v2.Solyc_ITAG2.3.genemodels.map.annot.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_gene",
	"src":"SGN_U",
	"src_version":"tomato200607#2",
	"tgt":"ITAG",
	"tgt_version":"2_3",
	"description":"InterproDescription",
	"GO":"GOAccession",
	"url":"ftp://ftp.solgenomics.net/unigene_builds/combined_species_assemblies/tomato_species/unigene_annotations/tomato_species_unigenes.v2.Solyc_ITAG2.3.genemodels.map.txt",
	"doi":"none",
	"key":"SGN_U_2_ITAG",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','SGN_U','ITAG','InterproDescription','GOAccession'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_prot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.sly.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"ITAG_pid",
	"tgt_version":"2_3",
	"description":"none",
	"GO":"GOAccession",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.sly.csv.gz",
	"doi":"none",
	"key":"Plaza_gene_id_to_ITAG",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','ITAG_pid','uniprot'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#est_to_gene
mapping_table={
	"data_file":"mappings/TOM1_id_to_tomato200607#2_id.xls",
	"species":"Solanum lycopersicum",
	"type":"est_to_gene",
	"src":"SGN_S",
	"src_version":"tom1",
	"tgt":"SGN_U",
	"tgt_version":"tomato200607#2",
	"description":"NA",
	"url":"",
	"doi":"none",
	"key":"SGN_S_2_SGN_U",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','SGN_S','SGN_U'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



#Mapping Table Arabidopsis

#est_to_gene
mapping_table={
	"data_file":"mappings/CATMA_2.3_07122011.xls",
	"species":"Arabidopsis thaliana",
	"type":"est_to_gene",
	"src":"CATMA_ID",
	"src_version":"CATMA V2.1",
	"tgt":"AGI_TAIR",
	"tgt_version":"2_3",
	"description":"Description",
	"url":"ftp://urgv.evry.inra.fr/CATdb/array_design/CATMA_2.3_07122011.txt",
	"doi":"none",
	"key":"CATMA_2_AGI",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":4,
		"column_keys":['idx','CATMA_ID','Probe_type','AGI_TAIR','Gene_type','Description'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_prot
mapping_table={
	"data_file":"mappings/Uniprot_TAIR10_may2012.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_prot",
	"src":"AGI_TAIR",
	"src_version":"TAIR10",
	"tgt":"Uniprot",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.arabidopsis.org/home/tair/Proteins/Id_conversions/Uniprot_TAIR10_May2012.txt",
	"doi":"none",
	"key":"AGI_2_Uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','AGI_TAIR','Uniprot'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_prot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.ath.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"uniprot",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.ath.csv",
	"doi":"none",
	"key":"PLAZA_2_Uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','alias','uniprot'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

#gene_to_gene_symbol
mapping_table={
	"data_file":"mappings/gene_aliases_20131231.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_symbol",
	"src":"AGI_TAIR",
	"src_version":"TAIR10",
	"tgt":"symbol",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.arabidopsis.org/home/tair/TAIR_Data_20131231/gene_aliases_20131231.gz",
	"doi":"none",
	"key":"AGI_2_Name",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','AGI_TAIR','symbol','full_name'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



#### Ortholog Tables


###PGJDB
# orthologs_table={
# 	"data_file":"orthologs/33090_clusters_1_57_0.xls",
# 	"src":"NCBI_locus_identifier",
# 	"tgt":"cluster_number",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','NCBI_gene_identifier','NCBI_locus_identifier','clusters_ref','function','organism','cluster_number'],
# 		"sheet_index":0		
# 	}
# }
# orthologs_col.insert(orthologs_table)

###PLAZA


orthologs_table={

	'data_file':'orthologs/integrative_orthology.ORTHO.tsv',
	'src':'plaza_gene_identifier',
	'tgt':'orthologs_list_identifier',
	'version':"dicots_3.0",
	'xls_parsing':{
		'n_rows_to_skip':0,
		'column_keys':['plaza_gene_identifier','orthologs_list_identifier'],
		'sheet_index':0
		
	}
}

orthologs_col.insert(orthologs_table)


# orthologs_table={
# 
# 	'data_file':'orthologs/integrative_orthology.ORTHO_monocots.tsv',
# 	'src':'plaza_gene_identifier',
# 	'tgt':'orthologs_list_identifier',
# 	'version':"monocots_3.0",
# 	'xls_parsing':{
# 		'n_rows_to_skip':0,
# 		'column_keys':['plaza_gene_identifier','orthologs_list_identifier'],
# 		'sheet_index':0
# 		
# 	}
# }
# 
# orthologs_col.insert(orthologs_table)

