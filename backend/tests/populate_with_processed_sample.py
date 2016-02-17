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
samples_col.remove({"state":{"$in":["processed"]}});


###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################



tomato_samples={
	"src_pub":"PMCID PMC3832472", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Solanum lycopersicum", # any abbrev name, key or full name, 
	"name":"Comparative Transcriptome Profiling of a Resistant vs. Susceptible Tomato (Solanum lycopersicum) Cultivar in Response to Infection by Tomato Yellow Leaf Curl Virus",
	"state":"processed",
        "comments":[
		{"content":"""Tomato yellow leaf curl virus (TYLCV) threatens tomato production worldwide by causing leaf yellowing, leaf curling, plant stunting and flower abscission. The current understanding of the host plant defense response to this virus is very limited. Using whole transcriptome sequencing, we analyzed the differential gene expression in response to TYLCV infection in the TYLCV-resistant tomato breeding line CLN2777A (R) and TYLCV-susceptible tomato breeding line TMXA48-4-0 (S). The mixed inoculated samples from 3, 5 and 7 day post inoculation (dpi) were compared to non-inoculated samples at 0 dpi. Of the total of 34831 mapped transcripts, 209 and 809 genes were differentially expressed in the R and S tomato line, respectively. The proportion of up-regulated differentially expressed genes (DEGs) in the R tomato line (58.37%) was higher than that in the S line (9.17%). Gene ontology (GO) analyses revealed that similar GO terms existed in both DEGs of R and S lines; however, some sets of defense related genes and their expression levels were not similar between the two tomato lines. Genes encoding for WRKY transcriptional factors, R genes, protein kinases and receptor (-like) kinases which were identified as down-regulated DEGs in the S line were up-regulated or not differentially expressed in the R line. The up-regulated DEGs in the R tomato line revealed the defense response of tomato to TYLCV infection was characterized by the induction and regulation of a series of genes involved in cell wall reorganization, transcriptional regulation, defense response, ubiquitination, metabolite synthesis and so on. The present study provides insights into various reactions underlining the successful establishment of resistance to TYLCV in the R tomato line, and helps in the identification of important defense-related genes in tomato for TYLCV disease management.""","author":"Tianzi Chen","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','ITAG_id','locus','Seq Description','FPKM b','FPKM a','logFC','P value','FDR','Significant'],
		"sheet_index":0,
		"id_type":"ITAG_id"
	},
	"experimental_results":[
		{
			"data_file":"Solanum/solanum_lycopersicum/transcriptomics/rna-seq/tomato_yellow_leaf_curl_virus/pone.0080816.s002_TMXA48.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tomato yellow leaf curl virus",
				"type":"inoculated",
				"label":"Infected with TYLCV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"TMXA48-4-0 (Susceptible)",
			"day_after_inoculation":"3, 5 and 7 dpi",
                        "material":"leaf"
			
		},
		{
			"data_file":"Solanum/solanum_lycopersicum/transcriptomics/rna-seq/tomato_yellow_leaf_curl_virus/pone.0080816.s002_CLN2777A.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tomato yellow leaf curl virus",
				"type":"inoculated",
				"label":"Infected with TYLCV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"CLN2777A (Resistant)",
			"day_after_inoculation":"3, 5 and 7 dpi",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(tomato_samples)


###################################################################################################################
############################################ PRUNUS ARMENIACA #################################################
###################################################################################################################

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus armeniaca", # any abbrev name, key or full name, 
	"name":"Gene Expression Analysis of Plum pox virus (Sharka) Susceptibility/Resistance in Apricot (Prunus armeniaca L.)",
	"state":"processed",
        "comments":[
		{"content":"""RNA-Seq has been applied to analyse the gene expression changes induced by PPV infection in leaves from two full-sib apricot genotypes, “Rojo Pasión” and “Z506-7”, resistant and susceptible to PPV, respectively. Transcriptomic analyses revealed the existence of more than 2,000 genes related to the pathogen response and resistance to PPV in apricot""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Exp_Gene_ID','Gene ID','Gene Name','A thaliana Gene ID','sample_1','sample_2','value_1','value_2','Value2_r1','Value2_r2','logFC','test_stat','p_value','q_value','Gene Description','Scaffold_position'],
		"sheet_index":0,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_armeniaca/transcriptomics/rna-seq/plum-pox-virus/journal.pone.0144670.s004.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"Rojo Pasion (Resistant)",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus armeniaca", # any abbrev name, key or full name, 
	"name":"Gene Expression Analysis of Plum pox virus (Sharka) Susceptibility/Resistance in Apricot (Prunus armeniaca L.)",
	"state":"processed",
        "comments":[
		{"content":"""RNA-Seq has been applied to analyse the gene expression changes induced by PPV infection in leaves from two full-sib apricot genotypes, “Rojo Pasión” and “Z506-7”, resistant and susceptible to PPV, respectively. Transcriptomic analyses revealed the existence of more than 2,000 genes related to the pathogen response and resistance to PPV in apricot""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Exp_Gene_ID','Gene ID','Gene Name','A thaliana Gene ID','sample_1','sample_2','value_1','Value1_r1','Value1_r2','value_2','Value2_r1','Value2_r2','logFC','test_stat','p_value','q_value','Gene Description','Scaffold_position'],
		"sheet_index":2,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_armeniaca/transcriptomics/rna-seq/plum-pox-virus/journal.pone.0144670.s004.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"Z506-7 (Susceptible)",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus armeniaca", # any abbrev name, key or full name, 
	"name":"Gene Expression Analysis of Plum pox virus (Sharka) Susceptibility/Resistance in Apricot (Prunus armeniaca L.)",
	"state":"processed",
        "comments":[
		{"content":"""RNA-Seq has been applied to analyse the gene expression changes induced by PPV infection in leaves from two full-sib apricot genotypes, “Rojo Pasión” and “Z506-7”, resistant and susceptible to PPV, respectively. Transcriptomic analyses revealed the existence of more than 2,000 genes related to the pathogen response and resistance to PPV in apricot""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Exp_Gene_ID','Gene ID','Gene Name','A thaliana Gene ID','sample_1','sample_2','value_1','value_2','Value2_r1','Value2_r2','logFC','test_stat','p_value','q_value','Gene Description','Scaffold_position'],
		"sheet_index":4,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_armeniaca/transcriptomics/rna-seq/plum-pox-virus/journal.pone.0144670.s004.xls",
			"conditions":["Resistant non infected","Susceptible non infected"],
			"contrast":"Resistant VS Susceptible",
			"type":"contrast",
			"variety":"Rojo Pasion Control (Resistant) vs Z506-7 Control (Susceptible)",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus armeniaca", # any abbrev name, key or full name, 
	"name":"Gene Expression Analysis of Plum pox virus (Sharka) Susceptibility/Resistance in Apricot (Prunus armeniaca L.)",
	"state":"processed",
        "comments":[
		{"content":"""RNA-Seq has been applied to analyse the gene expression changes induced by PPV infection in leaves from two full-sib apricot genotypes, “Rojo Pasión” and “Z506-7”, resistant and susceptible to PPV, respectively. Transcriptomic analyses revealed the existence of more than 2,000 genes related to the pathogen response and resistance to PPV in apricot""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Exp_Gene_ID','Gene ID','Gene Name','A thaliana Gene ID','sample_1','sample_2','value_1','Value1_r1','Value1_r2','value_2','Value2_r1','Value2_r2','logFC','test_stat','p_value','q_value','Gene Description','Scaffold_position'],
		"sheet_index":6,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_armeniaca/transcriptomics/rna-seq/plum-pox-virus/journal.pone.0144670.s004.xls",
			"conditions":[{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				},{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
			],
			"contrast":"resistant infected VS susceptible infected",
			"type":"contrast",
			"variety":"Rojo Pasion (Resistant) vs Z506-7 (Susceptible) ",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)



###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus Part Ryd2",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":2,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus Part Ryd3",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":3,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus Part Ryd4",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":4,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym7",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":5,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym16HB",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":6,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym17",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":7,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym1",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":8,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym18",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":9,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym8_rym9",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":10,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym13",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":11,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym3",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":12,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym14HB",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":13,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)

barley_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow/mild mosaic virus part rym15",
	"state":"processed",
        "xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"transcript_id","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Est","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":14,
		"id_type":"transcript_id" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)



###################################################################################################################
############################################ PRUNUS PERSICA #################################################
###################################################################################################################

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus persica", # any abbrev name, key or full name, 
	"name":"Analysis of gene expression changes in peach leaves in response to Plum pox virus infection using RNA-Seq",
	"state":"processed",
        "comments":[
		{"content":"""These results illustrate
the dynamic nature of the peach–PPV interaction at the
transcriptome level and confirm that sharka symptom expression
is a complex process that can be understood on the basis of
changes in plant gene expression.""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Gene ID','Gene name','Locus','FPKM INS','FPKM IWS','logFC','Test statistics','p value','q value','Description'],
		"sheet_index":0,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_persica/transcriptomics/rna-seq/plum-pox-virus/mpp12169-sup-0004-tables4.xls",
			"conditions":[{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV and without symptoms "
				},{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV and with symptoms "
				}
			],
			"contrast":"infected without symptoms VS infected with symptoms",
			"type":"contrast",
			"variety":"GF305",
			"day_after_inoculation":"NA",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus persica", # any abbrev name, key or full name, 
	"name":"Analysis of gene expression changes in peach leaves in response to Plum pox virus infection using RNA-Seq",
	"state":"processed",
        "comments":[
		{"content":"""These results illustrate
the dynamic nature of the peach–PPV interaction at the
transcriptome level and confirm that sharka symptom expression
is a complex process that can be understood on the basis of
changes in plant gene expression.""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Gene ID','Gene name','Locus','FPKM NI','FPKM INS','logFC','Test statistics','p value','q value','Description'],
		"sheet_index":1,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_persica/transcriptomics/rna-seq/plum-pox-virus/mpp12169-sup-0004-tables4.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
			],
			"contrast":"infected without symptoms VS healthy",
			"type":"contrast",
			"variety":"GF305",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)

Prunus_samples={
	"src_pub":"", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus persica", # any abbrev name, key or full name, 
	"name":"Analysis of gene expression changes in peach leaves in response to Plum pox virus infection using RNA-Seq",
	"state":"processed",
        "comments":[
		{"content":"""These results illustrate
the dynamic nature of the peach–PPV interaction at the
transcriptome level and confirm that sharka symptom expression
is a complex process that can be understood on the basis of
changes in plant gene expression.""","author":"Manuel Rubio","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"RNA-Seq"
	},
	"deposited":{
		"repository":"http://trace.ddbj.nig.ac.jp/DRASearch/study?acc=SRP028618",
		"sample_description_url":"http://sra.dnanexus.com/studies/SRP028618/samples",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Gene ID','Gene name','Locus','FPKM NI','FPKM IWS','logFC','Test statistics','p value','q value','Description'],
		"sheet_index":2,
		"id_type":"Gene ID"
	},
	"experimental_results":[
		{
			"data_file":"Prunus/prunus_persica/transcriptomics/rna-seq/plum-pox-virus/mpp12169-sup-0004-tables4.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
			],
			"contrast":"infected with symptoms VS healthy",
			"type":"contrast",
			"variety":"GF305",
			"day_after_inoculation":"",
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(Prunus_samples)