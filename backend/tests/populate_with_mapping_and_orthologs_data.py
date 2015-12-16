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
mappings_col.remove({"type":{"$nin":["full_table"]}});
#mappings_col.drop()
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



# Gene_to_prot - plaza to melonomics
mapping_table={
	"data_file":"mappings/plaza_id_conversion.ppe.xls",
	"species":"Prunus persica",
	"type":"gene_to_gene",
	"src":"plaza_gene_id",
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
		"column_keys":['idx','plaza_gene_id','GDR_gene_id','GDR_transcript_id','uniprot_id'],
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

# Gene_to_gene icugi_unigene to melonomics 
mapping_table={
	"data_file":"mappings/Melon_Icugi_to_Melonomics.xls",
	"species":"Cucumis melo",
	"type":"gene_to_gene",
	"src":"icugi_unigene",
	"src_version":"Icugi unigen v4",
	"tgt":"Melonomics_gene_id",
	"tgt_version":"Melonomics genes v3.5",
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

# Gene_to_prot - icugi_unigene to  swissprot
mapping_table={
	"data_file":"mappings/icugi_unigen--melonomics--uniprot--annotation.xls",
	"species":"Cucumis melo",
	"type":"gene_to_prot",
	"src":"icugi_unigene",
	"src_version":"Icugi unigen v4",
	"tgt":"uniprot_id",
	"tgt_version":"swissprot",
	"description":"none",
	"url":"not published",
	"doi":"not published",
	"key":"unigen_2_uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','icugi_unigene','Melonomics_gene_id','uniprot_id','annotation'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_prot - melonomics to uniprot
mapping_table={
	"data_file":"mappings/icugi_unigen--melonomics--uniprot--annotation.xls",
	"species":"Cucumis melo",
	"type":"gene_to_prot",
	"src":"Melonomics_gene_id",
	"src_version":"Icugi unigen v4",
	"tgt":"uniprot_id",
	"tgt_version":"swissprot",
	"description":"none",
	"url":"not published",
	"doi":"not published",
	"key":"melonomics_gene_id_2_uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','icugi_unigene','Melonomics_gene_id','uniprot_id','annotation'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_prot - plaza to melonomics
mapping_table={
	"data_file":"mappings/plaza_id_conversion.cme.xls",
	"species":"Cucumis melo",
	"type":"gene_to_gene",
	"src":"plaza_gene_id",
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
		"column_keys":['idx','plaza_gene_id','Melonomics_gene_id','Melonomics_transcript_id','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_go - plaza to gene ontology
# mapping_table={
# 	"data_file":"mappings/gene_ontology/go.cme.tsv",
# 	"species":"Cucumis melo",
# 	"type":"gene_to_go",
# 	"src":"plaza_gene_id",
# 	"src_version":"PLAZA 3.0 Dicots",
# 	"tgt":"GO_ID",
# 	"tgt_version":"PLAZA 3.0 Dicots",
# 	"description":"none",
# 	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.cme.csv.gz",
# 	"doi":"not published",
# 	"key":"plaza gene id to go id",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','id','species','plaza_gene_id','GO_ID','evidence','go_source','provider','comment','is_shown'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)

# Gene_to_go - plaza to gene ontology
mapping_table={
	"data_file":"mappings/gene_ontology/go.cme.converted.tsv",
	"species":"Cucumis melo",
	"type":"gene_to_go",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"GO_ID-evidence",
	"tgt_version":"PLAZA 3.0 Dicots",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.cme.csv.gz",
	"doi":"not published",
	"key":"plaza gene id to go id list",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','GO_ID-evidence'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)





###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################

# #to add barley_HighConf_genes_MIPS_23Mar12_HumReadDesc.txt
# ## AHRD-Version 2.0
# # Human Readable Descriptions (AHRD)

# Gene_to_go - Plaza to gene ontology
# mapping_table={
# 	"data_file":"mappings/gene_ontology/go.hvu.tsv",
# 	"species":"Hordeum vulgare",
# 	"type":"gene_to_go",
# 	"src":"plaza_gene_id",
# 	"src_version":"PLAZA 3.0 Monocots",
# 	"tgt":"GO_ID",
# 	"tgt_version":"PLAZA 3.0 Monocots",
# 	"description":"none",
# 	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_monocots_03/GO/go.hvu.csv.gz",
# 	"doi":"",
# 	"key":"plaza gene_id to go id",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','id','species','plaza_gene_id','GO_ID','evidence','go_source','provider','comment','is_shown'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)






mapping_table={
	"data_file":"mappings/gene_ontology/go.hvu.converted.tsv",
	"species":"Hordeum vulgare",
	"type":"gene_to_go",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Monocots",
	"tgt":"GO_ID-evidence",
	"tgt_version":"PLAZA 3.0 Monocots",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_monocots_03/GO/go.hvu.csv.gz",
	"doi":"",
	"key":"plaza gene id to go id list",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','GO_ID-evidence'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Prot_to_desc - Protein_id to Human Readable Descriptions (AHRD)
mapping_table={
	"data_file":"mappings/barley_HighConf_genes_MIPS_23Mar12_HumReadDesc.xls",
	"species":"Hordeum vulgare",
	"type":"gene_to_symbol",
	"src":"transcript id",
	"src_version":"mips.helmholtz",
	"tgt":"description",
	"tgt_version":"Assignment of Human Readable Descriptions (AHRD)",
	"description":"none",
	"url":"ftp://ftpmips.helmholtz-muenchen.de/plants/barley/public_data/genes/barley_HighConf_genes_MIPS_23Mar12_HumReadDesc.txt",
	"doi":"10.1186/1471-2164-13-601-s7",
	"key":"plaza_gene_id_to_barley_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','transcript id','Blast-Hit-Accession','AHRD-Quality-Code','description','Interpro-ID (Description)'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_gene - Plaza to barlex
mapping_table={
	"data_file":"mappings/plaza_id_conversion.hvu.xls",
	"species":"Hordeum vulgare",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
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
		"column_keys":['idx','plaza_gene_id','gene_id','protein_id', 'id', 'transcript id','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Est_to_gene - Morex_Contig to protein_id
# mapping_table={
# 	"data_file":"mappings/Barlex_list_genes.xls",
# 	"species":"Hordeum vulgare",
# 	"type":"est_to_gene",
# 	"src":"Morex_Contig",
# 	"src_version":"Morex contig Barlex",
# 	"tgt":"protein_id",
# 	"tgt_version":"",
# 	"description":"none",
# 	"url":"http://apex.ipk-gatersleben.de/apex/f?p=284:27:8729907556936:CSV::::",
# 	"doi":"10.1186/1471-2164-13-601-s7",
# 	"key":"morex_contig_id_to_barley_id",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','FPC','BAC','Cluster ID','Morex_Contig','MorexChromosome','Morex Contig cM','BAC Contig','protein_id','Confidence','FunctionalAnnotation'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)

# Est_to_gene - Morex_Contig to protein_id
mapping_table={
	"data_file":"mappings/Barlex_HC_LC_gene.tsv",
	"species":"Hordeum vulgare",
	"type":"est_to_gene",
	"src":"Morex_Contig",
	"src_version":"",
	"tgt":"transcript id",
	"tgt_version":"",
	"description":"none",
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
	"data_file":"mappings/Barlex_HC_LC_gene1.tsv",
	"species":"Hordeum vulgare",
	"type":"est_to_gene",
	"src":"Morex_Contig",
	"src_version":"",
	"tgt":"transcript id",
	"tgt_version":"",
	"description":"none",
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
#mapping_table={
#	"data_file":"mappings/barlex_LC_gene2.tsv",
#	"species":"Hordeum vulgare",
#	"type":"est_to_gene",
#	"confidence level":"LC",
#	"src":"Morex_Contig",
#	"src_version":"",
#	"tgt":"transcript id",
#	"tgt_version":"",
#	"description":"none",
#	"url":"http://apex.ipk-gatersleben.de/apex/f?p=284:27:8729907556936:CSV::::",
#	"doi":"10.1186/1471-2164-13-601-s7",
#	"key":"morex_contig_id_to_barleyHC_id",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','FPC','BAC','Cluster ID','Morex_Contig','MorexChromosome','Morex Contig cM','BAC Contig','transcript id','Confidence','FunctionalAnnotation'],
#		"sheet_index":0,
#	}
#}
#mappings_col.insert(mapping_table)






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

# Gene_to_gene - SGN_U to ITAG gene
mapping_table={
	"data_file":"mappings/tomato_unigenes_solyc_conversion_annotated.tsv",
	"species":"Solanum lycopersicum",
	"type":"gene_to_gene",
	"src":"SGN_U",
	"src_version":"tomato200607#2",
	"tgt":"ITAG_pid",
	"tgt_version":"2_3",
	"description":"Description",
	"GO":"GO_ID",
	"url":"ftp://ftp.solgenomics.net/unigene_builds/combined_species_assemblies/tomato_species/unigene_annotations/tomato_species_unigenes.v2.Solyc_ITAG2.3.genemodels.map.txt",
	"doi":"none",
	"key":"SGN_U_2_ITAG",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','SGN_U','ITAG_pid','Description','interpro','GO_ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


# Gene_to_prot - SGN_U to uniprot
mapping_table={
	"data_file":"mappings/tomato_species_unigene_2009_01_14.v1.blastx.swissprot.m8.filtered.annotated.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_prot",
	"src":"SGN_U",
	"src_version":"tomato200607#2",
	"tgt":"uniprot_id",
	"tgt_version":"",
	"description":"description",
	"url":"ftp://ftp.solgenomics.net/unigene_builds/combined_species_assemblies/tomato_species/unigene_annotations/tomato_species_unigene_2009_01_14.v1.blastx.swissprot.m8.filtered.annotated.tab",
	"doi":"none",
	"key":"SGN_U_2_Uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','SGN_U', 'Swissprot_name', 'Species_code','uniprot_id','SwissProt_ID', 'full_ID', 'identity', 'aligment_length', 'mismatches', 'gap_openings', 'query_start_position', 'query_end_position', 'subject_start_position', 'subject_end_position', 'e-value', 'hit_score','description'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)



# Gene_to_symbol - SGN_U to symbol
mapping_table={
	"data_file":"mappings/tomato_unigenes_solyc_conversion_annotated.tsv",
	"species":"Solanum lycopersicum",
	"type":"gene_to_symbol",
	"src":"SGN_U",
	"src_version":"tomato200607#2",
	"tgt":"Description",
	"tgt_version":"2_3",
	"description":"Description",
	"GO":"GO_ID",
	"url":"ftp://ftp.solgenomics.net/unigene_builds/combined_species_assemblies/tomato_species/unigene_annotations/tomato_species_unigenes.v2.Solyc_ITAG2.3.genemodels.map.txt",
	"doi":"none",
	"key":"SGN_U_2_SYMBOL",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','SGN_U','ITAG_pid','Description','interpro','GO_ID'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_prot - Plaza to ITAG protein
mapping_table={
	"data_file":"mappings/plaza_id_conversion.sly.xls",
	"species":"Solanum lycopersicum",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
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
		"column_keys":['idx','plaza_gene_id','ITAG_pid','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


#Gene_to_go - Plaza to gene ontology
# mapping_table={
# 	"data_file":"mappings/gene_ontology/go.sly.tsv",
# 	"species":"Solanum lycopersicum",
# 	"type":"gene_to_go",
# 	"src":"plaza_gene_id",
# 	"src_version":"PLAZA 3.0 Dicots",
# 	"tgt":"GO_ID",
# 	"tgt_version":"",
# 	"description":"none",
# 	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.sly.csv.gz",
# 	"doi":"not published",
# 	"key":"plaza gene id to go id",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','id','species','plaza_gene_id','GO_ID','evidence','go_source','provider','comment','is_shown'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)

mapping_table={
	"data_file":"mappings/gene_ontology/go.sly.converted.tsv",
	"species":"Solanum lycopersicum",
	"type":"gene_to_go",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"GO_ID-evidence",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.sly.csv.gz",
	"doi":"not published",
	"key":"plaza gene id to go id list",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','GO_ID-evidence'],
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

# Gene_to_prot - TAIR AGI gene id to uniprot id
mapping_table={
	"data_file":"mappings/Uniprot_TAIR10_may2012_sorted.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_prot",
	"src":"AGI_TAIR",
	"src_version":"TAIR10",
	"tgt":"uniprot_id",
	"tgt_version":"",
	"description":"none",
	"url":"ftp://ftp.arabidopsis.org/home/tair/Proteins/Id_conversions/Uniprot_TAIR10_May2012.txt",
	"doi":"none",
	"key":"AGI_2_Uniprot",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','AGI_TAIR','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to_prot - Plaza to uniprot
mapping_table={
	"data_file":"mappings/plaza_id_conversion.ath.xls",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_prot",
	"src":"plaza_gene_id",
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
		"column_keys":['idx','plaza_gene_id','alias','uniprot_id'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)

# Gene_to__symbol - TAIR AGI gene id to gene symbol
mapping_table={
	"data_file":"mappings/arabidopsis_thaliana_gene_aliases_20131231.xls",
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

# Gene_to_go - TAIR AGI gene id to gene ontology
# mapping_table={
# 	"data_file":"mappings/gene_ontology/ATH_GO_GOSLIM.tsv",
# 	"species":"Arabidopsis thaliana",
# 	"type":"gene_to_go",
# 	"src":"AGI_TAIR",
# 	"src_version":"Tair",
# 	"tgt":"GO_ID",
# 	"tgt_version":"",
# 	"url":"https://www.arabidopsis.org/download_files/GO_and_PO_Annotations/Gene_Ontology_Annotations/ATH_GO_GOSLIM.txt",
# 	"doi":"",
# 	"src_pub":"Berardini, TZ, Mundodi, S, Reiser, R, Huala, E, Garcia-Hernandez, M,Zhang, P, Mueller, LM, Yoon, J, Doyle, A, Lander, G, Moseyko, N, Yoo,D, Xu, I, Zoeckler, B, Montoya, M, Miller, N, Weems, D, and Rhee, SY(2004) Functional annotation of the Arabidopsis genome usingcontrolled vocabularies. Plant Physiol. 135(2):1-11.",
# 	"key":"Tair_2_GO",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":0,
# 		"column_keys":['idx','AGI_TAIR','TAIR_accession','object_name','relationship_type','GO_term','GO_ID','TAIR_Keyword_ID','Aspect','GOslim_term','Evidence_code','Evidence_description','Evidence_with','Reference','Annotator','Date'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)

# Gene_to_go - TAIR AGI gene id to gene ontology
# mapping_table={
# 	"data_file":"mappings/gene_ontology/go.ath.tsv",
# 	"species":"Arabidopsis thaliana",
# 	"type":"gene_to_go",
# 	"src":"plaza_gene_id",
# 	"src_version":"PLAZA 3.0 Dicots",
# 	"tgt":"GO_ID",
# 	"tgt_version":"",
# 	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.ath.csv.gz",
# 	"doi":"",
# 	"src_pub":"Berardini, TZ, Mundodi, S, Reiser, R, Huala, E, Garcia-Hernandez, M,Zhang, P, Mueller, LM, Yoon, J, Doyle, A, Lander, G, Moseyko, N, Yoo,D, Xu, I, Zoeckler, B, Montoya, M, Miller, N, Weems, D, and Rhee, SY(2004) Functional annotation of the Arabidopsis genome usingcontrolled vocabularies. Plant Physiol. 135(2):1-11.",
# 	"key":"plaza gene id to go grid id",
# 	# parser config 
# 		# xls parser configuration, are propagated to all entries in  "experimental_results",
# 	"xls_parsing":{
# 		"n_rows_to_skip":1,
# 		"column_keys":['idx','id','species','plaza_gene_id','GO_ID','evidence','go_source','provider','comment','is_shown'],
# 		"sheet_index":0,
# 	}
# }
# mappings_col.insert(mapping_table)

# Gene_to_go - TAIR AGI gene id to gene ontology
mapping_table={
	"data_file":"mappings/gene_ontology/go.ath.converted.tsv",
	"species":"Arabidopsis thaliana",
	"type":"gene_to_go",
	"src":"plaza_gene_id",
	"src_version":"PLAZA 3.0 Dicots",
	"tgt":"GO_ID-evidence",
	"tgt_version":"",
	"url":"ftp://ftp.psb.ugent.be/pub/plaza/plaza_public_dicots_03/GO/go.ath.csv.gz",
	"doi":"",
	"src_pub":"Berardini, TZ, Mundodi, S, Reiser, R, Huala, E, Garcia-Hernandez, M,Zhang, P, Mueller, LM, Yoon, J, Doyle, A, Lander, G, Moseyko, N, Yoo,D, Xu, I, Zoeckler, B, Montoya, M, Miller, N, Weems, D, and Rhee, SY(2004) Functional annotation of the Arabidopsis genome usingcontrolled vocabularies. Plant Physiol. 135(2):1-11.",
	"key":"plaza gene id to go id list",
	# parser config 
		# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','plaza_gene_id','GO_ID-evidence'],
		"sheet_index":0,
	}
}
mappings_col.insert(mapping_table)


###################################################################################################################
############################################ ORTHOLOG TABLES #####################################################
###################################################################################################################

# Plaza Orthologs - Dicots
# orthologs_table={
# 
# 	'data_file':'orthologs/integrative_orthology.ORTHO.tsv',
# 	'src':'plaza_gene_identifier',
# 	'tgt':'orthologs_list_identifier',
# 	'version':"dicots_3.0",
# 	'xls_parsing':{
# 		'n_rows_to_skip':0,
# 		'column_keys':['plaza_gene_identifier','orthologs_list_identifier'],
# 		'sheet_index':0
# 		
# 	}
# }
# orthologs_col.insert(orthologs_table)


# PGJDB Orthologs
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


# Plaza Orthologs - Monocots
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




###################################################################################################################
############################################ INTERACTION TABLES ###################################################
###################################################################################################################




# Literature and partner - Interaction potyvirus
#interactions_table={
#	"data_file":"interactomics/potyvirus/Potyvirus.Interactors.xls",
#	"src":"Virus_symbol",
#	"tgt":"Host_symbol",
#	"type":"symbol_to_symbol",
#	"virus_class":"potyvirus",
#	"xls_parsing":{
#		"n_rows_to_skip":3,
#		"column_keys":['idx','Virus_symbol','Host_symbol','method','virus','host','Putative_function','Reference','Accession_number'],
#		"sheet_index":0,
#		
#	}
#
#}
#interactions_col.insert(interactions_table)


# Host pathogen interaction db
#interactions_table={
#	"data_file":"interactomics/Intact/hpidb2_plant_only.xls",
#	"type":"prot_to_prot",
#	"src":"protein_xref_1",
#	"src_version":"uniprot",
#	"tgt":"protein_xref_2",
#	"tgt_version":"uniprot",
#	"host_name":"protein_taxid_1_name",
#	"virus_name":"protein_taxid_2_name",
#	"method":"detection_method",
#	"pub":"pmid",
#	"host_taxon":"protein_taxid_1_cat",
#	"virus_taxon":"protein_taxid_2_cat",
#	"xls_parsing":{
#		"n_rows_to_skip":1,
#		"column_keys":['idx','protein_xref_1','alternative_identifiers_1','protein_alias_1','protein_xref_2','alternative_identifiers_2','protein_alias_2','detection_method','author_name','pmid','protein_taxid_1','protein_taxid_2','interaction_type','source_database_id','database_identifier','confidence','protein_xref_1_unique','protein_xref_2_unique','protein_taxid_1_cat','protein_taxid_2_cat','protein_taxid_1_name','protein_taxid_2_name','protein_seq1','protein_seq2','source_database','comment'],
#		"sheet_index":0,
#		
#	}
#
#}
#interactions_col.insert(interactions_table)


