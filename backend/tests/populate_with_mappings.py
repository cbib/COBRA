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
#mappings_col.drop({"type":{"$nin":["full_table"]}});
#mappings_col.remove({"type":{"$nin":["full_table"]}});
mappings_col.drop()
#orthologs_col.drop()
#interactions_col.drop()
for grid_out in fs.find({}, timeout=False):
	
	fs.delete(grid_out._id)



###################################################################################################################
############################################ PRUNUS DOMESTICA #####################################################
###################################################################################################################


# Gene_to_prot - unigene to NCBI_Protein_code
mapping_table={
	"data_file":"mappings/journal.pone.0100477.s004.tsv",
	"species":"Prunus domestica",
	"type":"gene_to_prot",
	"src":"unigene",
	"src_version":"",
	"tgt":"NCBI Protein code",
	"tgt_version":"NCBI",
	"description":"Sequence",
	"url":"",
	"doi":"",
	"key":"unigene_2_ncbi_protein",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":2,
		"column_keys":['idx','unigene', 'Sequence', 'Jojo-W1', 'Jojo-W2', 'Jojo-W+PPV', 'Jojo-M+PPV', 'fold_change', 'logFC', 'logCPM', 'PValue', 'FDR', 'Description', 'AccPrunus', 'DescPrunus', 'AccNCBI', 'DescNCBI', 'AccPlants', 'DescPlants', 'AccPRG', 'DescPRG','NCBI Protein code'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



# Gene_to_prot - plaza to melonomics
mapping_table={
	"data_file":"mappings/plaza_id_conversion.ppe.xls",
	"species":"Prunus persica",
	"type":"gene_to_gene",
	"src":"Plaza gene id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"GDR_gene_id",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.ppe.csv.gz",
	"doi":"not published",
	"key":"PLAZA_conversion",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Plaza gene id','GDR_gene_id','GDR_transcript_id','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

###################################################################################################################
############################################ CUCUMIS MELO #########################################################
###################################################################################################################




# Est_to_gene est_unigen to icugi_unigene
mapping_table={
	"data_file":"mappings/1471-2164-13-601-s7.xls",
	"species":"Cucumis melo",
	"type":"est_to_gene",
	"src":"est_unigen",
	"src_version":"Melogen melo_v1 Array express",
	"tgt":"icugi_unigene",
	"tgt_version":"Icugi unigen v4",
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


# Gene_to_prot - plaza to melonomics
mapping_table={
	"data_file":"mappings/plaza_id_conversion.cme.xls",
	"species":"Cucumis melo",
	"type":"gene_to_gene",
	"src":"Plaza gene id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"Melonomics_gene_id",
	"tgt_version":"Melonomics genes v3.5",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.cme.csv.gz",
	"doi":"not published",
	"key":"PLAZA_conversion",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Plaza gene id','Melonomics_gene_id','Melonomics_transcript_id','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################



# Gene_to_gene - Plaza to barlex
mapping_table={
	"data_file":"mappings/plaza_id_conversion.hvu.xls",
	"species":"Hordeum vulgare",
	"type":"gene_to_prot",
	"src":"Plaza gene id",
	"src_version":"PLAZA 3.0 Monocots",
	"tgt":"transcript id",
	"tgt_version":"Barlex transcript",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_monocots_03/IdConversion/id_conversion.hvu.csv.gz",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"PLAZA_conversion",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Plaza gene id','gene_id','protein_id', 'id', 'transcript id','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



# Est_to_gene - Morex_Contig to protein_id
mapping_table={
	"data_file":"mappings/Barlex_HC_LC_gene1.tsv",
	"species":"Hordeum vulgare",
	"type":"est_to_gene",
	"src":"Morex_Contig",
	"src_version":"",
	"tgt":"transcript id",
	"tgt_version":"Barlex",
	"description":"Barlex HC/LCgenes part 1",
	"url":"http://apex.ipk-gatersleben.de/apex/f?p=284:27:8729907556936:CSV::::",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"morex_contig_id_to_barleyHC_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','transcript id','Morex_Contig','FPC','BAC','Cluster ID','MorexChromosome','Morex Contig cM','BAC Contig','Confidence','FunctionalAnnotation'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Est_to_gene - Morex_Contig to transcript_id
mapping_table={
	"data_file":"mappings/Barlex_HC_LC_gene2.tsv",
	"species":"Hordeum vulgare",
	"type":"est_to_gene",
	"src":"Morex_Contig",
	"src_version":"",
	"tgt":"transcript id",
	"tgt_version":"",
	"description":"Barlex HC/LC genes part 2",
	"url":"http://apex.ipk-gatersleben.de/apex/f?p=284:27:8729907556936:CSV::::",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"morex_contig_id_to_barleyHC_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','transcript id','Morex_Contig','FPC','BAC','Cluster ID','MorexChromosome','Morex Contig cM','BAC Contig','Confidence','FunctionalAnnotation'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)








###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################

#to add "url":”ftp://ftp.sgn.cornell.edu/genomes/Solanum_lycopersicum/id_conversion/tomato_unigenes_solyc_conversion_annotated.txt",




# Est_to_gene - SGN_S to SGN_U
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










# Gene_to_prot - Plaza to ITAG protein
mapping_table={
	"data_file":"mappings/plaza_id_conversion.sly.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_prot",
	"src":"Plaza gene id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"ITAG_pid",
	"tgt_version":"2_3",
	"description":"uniprot_id",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.sly.csv.gz",
	"doi":"none",
	"key":"PLAZA_conversion",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Plaza gene id','ITAG_pid','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)












###################################################################################################################
############################################ ARABIDOPSIS THALIANA #################################################
###################################################################################################################





# Est_to_gene - CATMA_ID to TAIR AGI gene id
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



# Gene_to_prot - Plaza to uniprot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.ath.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_prot",
	"src":"Plaza gene id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"uniprot_id",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/IdConversion/id_conversion.ath.csv",
	"doi":"none",
	"key":"PLAZA_conversion",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Plaza gene id','alias','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


