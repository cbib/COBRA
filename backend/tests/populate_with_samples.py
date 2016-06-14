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



publications_col.drop()
samples_col.drop()
measurements_col.drop()

#orthologs_col.remove()
#users_col.remove()
#orthologs_col.gridfs.drop()
#db.drop_collection("orthologs_col.files")
#db.drop_collection("orthologs_col.chunks")
#orthologs_col.files.drop()
#orthologs_col.chunks.drop()











#### Barley


## publication 
## mapping 
## samples 

##### Orthologs

#orthologs={
#	"data_file":"orthologs/33090_clusters_1_57_0.xls",
#	"from":"OrthoDB",
#	"version":"Version 1.57.0",
#	"xls_parsing":{
#		"n_rows_to_skip":0,
#		"column_keys":['idx','number','NCBI_Reference','cluster_info','protein_name','species' ],
#		"sheet_index":0,
#	}
	


#}
#orthologs_col.insert(orthologs)





## publications 

melon_pub={
	"doi":"10.1186/1471-2164-10-467",
	"url":"http://www.biomedcentral.com/1471-2164/10/467",
	"first_author":"Albert Mascarell-Creus",
	"pmid":19821986, # http://www.ncbi.nlm.nih.gov/pubmed/19821986
	# rest can be populated automatically 
}
publications_col.insert(melon_pub)

melon_pub={
    "doi":"10.1094/MPMI-07-11-0193",
    "url":"http://dx.doi.org/10.1094/MPMI-07-11-0193",
    "first_author":"Daniel Gonzalez-Ibeas",
    "pmid":21970693, # http://www.ncbi.nlm.nih.gov/pubmed/19821986
    # rest can be populated automatically 
}
publications_col.insert(melon_pub)

prunus_pub={
	"doi":"10.1371/journal.pone.0100477",
	"url":"http://journals.plos.org/plosone/article?id=10.1371/journal.pone.0100477",
	"first_author":"Bernardo Rodamilans",
	"title":"Transcriptomic Analysis of Prunus domestica Undergoing Hypersensitive Response to Plum Pox Virus Infection",
	"pmid":24959894, # http://www.ncbi.nlm.nih.gov/pubmed/24959894
	# rest can be populated automatically 
}
publications_col.insert(prunus_pub)




## samples 

###################################################################################################################
############################################ CUCUMIS MELO #########################################################
###################################################################################################################


melo_samples={
    "src_pub":23134692, # Any field from the pub, doi, pmid, first author etc. 
    "species":"Cucumis melo", # any abbrev name, key or full name, 
    "name":"Root transcriptional responses of two melon genotypes with contrasting resistance to Monosporascus cannonballus (Pollack et Uecker) infection",
    "comments":[
        {"content":"""Monosporascus cannonballus is the main causal agent of melon vine 
        decline disease. Several studies have been carried out mainly focused on the study 
        of the penetration of this pathogen into melon roots, the evaluation of symptoms 
        severity on infected roots, and screening assays for breeding programs. However, 
        a detailed molecular view on the early interaction between M. cannonballus and melon 
        roots in either susceptible or resistant genotypes is lacking. In the present study, 
        we used a melon oligo-based microarray to investigate the gene expression responses 
        of two melon genotypes, Cucumis melo ‘Piel de sapo’ (‘PS’) and C. melo ‘Pat 81’, with 
        contrasting resistance to the disease. This study was carried out at 1 and 3 days after 
        infection (DPI) by M. cannonballus. """}
    ],
    "assay":{
        "type":"micro-array",
        "design":"http://www.ebi.ac.uk/arrayexpress/files/A-MEXP-2252/A-MEXP-2252.adf.txt"
    },
    "deposited":{
        "repository":"http://www.ebi.ac.uk/arrayexpress/experiments/E-MEXP-3732/",
        "sample_description_url":"http://www.ebi.ac.uk/arrayexpress/experiments/E-MEXP-3732/samples/",
        "experimental_meta_data":"http://www.ebi.ac.uk/arrayexpress/xml/v2/experiments?query=melogen_melo_v1"

    },
    # xls parser configuration, are propagated to all entries in  "experimental_results",
    "xls_parsing":{
		"n_rows_to_skip":4,
		"column_keys":['idx','Est','description','fold_change','function'],
		"sheet_index":0,
		"id_type":"Est"
	},
    "experimental_results":[
        {
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/monosporascus_cannonballus/condition1/1471-2164-13-601-s1.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"monosporascus_cannonballus",
				"type":"inoculated",
				"label":"Infected with M. canonballus"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"PS",
			"day_after_inoculation":1,
                        "material":"undefined"
		},
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/monosporascus_cannonballus/condition1/1471-2164-13-601-s2.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"monosporascus_cannonballus",
				"type":"inoculated",
				"label":"Infected with M. canonballus"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"pat81",
			"day_after_inoculation":1,
            "material":"undefined"
		},
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/monosporascus_cannonballus/condition1/1471-2164-13-601-s3.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"monosporascus_cannonballus",
				"type":"inoculated",
				"label":"Infected with M. canonballus"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"PS",
			"day_after_inoculation":3,
            "material":"undefined"
		},
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/monosporascus_cannonballus/condition1/1471-2164-13-601-s4.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"monosporascus_cannonballus",
				"type":"inoculated",
				"label":"Infected with M. canonballus"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"pat81",
			"day_after_inoculation":3,
            "material":"undefined"
        }
    ]

}
samples_col.insert(melo_samples)


melo_samples={
    "src_pub":21970693, # Any field from the pub, doi, pmid, first author etc. 
    "species":"Cucumis melo", # any abbrev name, key or full name, 
    "name":"Recessive resistance to Watermelon mosaic virus in melon is associated with a defense response as revealed by microarray analysis",
    "comments":[
        {"content":"""Two melon genotypes have been used to analyse transcriptomic 
        responses to infection by Watermelon mosaic 
        virus: Tendral (susceptibel to WMV) and TGR-1551 (resistant to WMV). 
        For each genotype, 60 melon seedlings were inoculated with WMV-M116 
        and another 60 were mock-inoculated. Cotyledons of 10 plants were 
        harvested at 1, 3, 5, 7, 9 and 15 dpi. At 15 dpi, 
        the systemically infected second true leaf was also harvested. 
        To reduce variability, each biological replicate used in this study 
        was prepared by mixing the RNA extracts from 2 or 4 mock or WMV-inoculated 
        cotyledons, respectively, or from 3 melon leaves. Samples (WMV infected and 
        mock inoculated) corresponding to cotyledons at 1, 3 and 7 dpi, and leaves at 
        15 dpi were used for microarray hybridisations, three biological replicates 
        for each one, leading to a total of 48 samples."""}
    ],
    "assay":{
        "type":"micro-array",
        "design":"https://www.ebi.ac.uk/arrayexpress/files/A-GEOD-13748/A-GEOD-13748.adf.txt"
    },
    "deposited":{
        "repository":"https://www.ebi.ac.uk/arrayexpress/experiments/E-GEOD-30111/",
        "sample_description_url":"https://www.ebi.ac.uk/arrayexpress/experiments/E-GEOD-30111/samples/",
        "experimental_meta_data":"http://www.ebi.ac.uk/arrayexpress/xml/v2/experiments?query=melogen_melo_v1"

    },
    # xls parser configuration, are propagated to all entries in  "experimental_results",
    "xls_parsing":{
        "n_rows_to_skip":1,
        "column_keys":['idx','Est','adjP_Val','P_Value','t','B','logFC','SPOT_ID'],
        "sheet_index":0,
        "id_type":"Est"
    },
    "experimental_results":[
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_Tendral-Mock_1dpi_VS_cotyledon_Tendral-WMVinfected_1dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"Tendral",
            "day_after_inoculation":1,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_Tendral-Mock_3dpi_VS_cotyledon_Tendral-WMVinfected_3dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"Tendral",
            "day_after_inoculation":3,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_Tendral-Mock_7dpi_VS_cotyledon_Tendral-WMVinfected_7dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"Tendral",
            "day_after_inoculation":7,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_TGR-1551-Mock_1dpi_VS_cotyledon_TGR1551-WMVinfected_1dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"TGR1551",
            "day_after_inoculation":1,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_TGR-1551-Mock_3dpi_VS_cotyledon_TGR1551-WMVinfected_3dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"TGR1551",
            "day_after_inoculation":3,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/cotyledon_TGR-1551-Mock_7dpi_VS_cotyledon_TGR1551-WMVinfected_7dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"TGR1551",
            "day_after_inoculation":7,
            "material":"cotyledon"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/leaf_Tendral-Mock_15dpi_VS_leaf_Tendral-WMVinfected_15dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"Tendral",
            "day_after_inoculation":15,
            "material":"leaf"
        },
        {
            "data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/watermelon_mosaic_virus/leaf_TGR-1551-Mock_15dpi_VS_leaf_TGR1551-WMVinfected_15dpi.xls",
            "conditions":["non infected",{
                "infected":True,
                "infection_agent":"Watermelon mosaic virus",
                "type":"inoculated",
                "label":"Infected with WMV"
                
                }
            ],
            "contrast":"infected VS healthy",
            "type":"contrast",
            "variety":"TGR1551",
            "day_after_inoculation":15,
            "material":"leaf"
        }
    ]

}
samples_col.insert(melo_samples)

melo_samples={
	"src_pub":19821986, # Any field from the pub, doi, pmid, first author etc. 
	"species":"Cucumis melo", # any abbrev name, key or full name, 
	"name":"Transcriptomics of infection of C. melo",
	"comments":[
		{"content":"""
Excerpt from the article related to strains : 

The material used for the transcriptomic profile analyses came from three different C. melo accessions: the line T-111, which corresponds to a Piel de Sapo breeding line, the Tendral variety (Semillas Fitó, Barcelona, Spain), and the pat81 accession of C. melo L. ssp. agrestis (Naud.) Pangalo maintained at the germplasm bank of COMAV (COMAV-UPV, Valencia, Spain). Seeds of T-111 were germinated at 30°C for two days and plants were grown in a greenhouse in peat bags, drip irrigated, with 0.25-m spacing between plants. Fruits were collected 15 and 46 days after pollination and mesocarp tissues were used for RNA extractions. Roots from pat81 plants were mock treated or inoculated with 50 colony-forming units (CFU) of M.c. per gram of sterile soil and harvested 14 days after inoculation. Cotyledons from var. Tendral, mock treated or mechanically inoculated with CMV, were harvested 3 days post inoculation. Plant growth and infections were done as described in González-Ibeas et al. [1].
		""","author":"hayssam","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"http://www.ebi.ac.uk/arrayexpress/files/A-MEXP-1675/A-MEXP-1675.adf.txt"
	},
	"deposited":{
		"repository":"http://www.ebi.ac.uk/arrayexpress/experiments/E-MEXP-2334/",
		"sample_description_url":"http://www.ebi.ac.uk/arrayexpress/experiments/E-MEXP-2334/samples/",
		"experimental_meta_data":"http://www.ebi.ac.uk/arrayexpress/xml/v2/experiments?query=melogen_melo_v1"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":3,
		"column_keys":['idx','Est','length','description','fold_change'],
		"sheet_index":0,
		"id_type":"Est"
	},
	"experimental_results":[
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/no_infection/condition_15d_VS_46d/1471-2164-10-467-S1.XLS",
			"conditions":["15d","46d"],
			"contrast":"46d VS 15d",
			"type":"contrast",
                        "day_after_inoculation":"NA",
			"variety":"T-111",
                        "material":"Fruit mesocarp"
		},
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/monosporascus_cannonballus/1471-2164-10-467-S2.XLS",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"monosporascus_cannonballus",
				"type":"inoculated",
				"label":"Infected with M. canonballus"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
                        "day_after_inoculation":"NA",
			"variety":"pat81",
			"day_after_inoculation":"NA",
                        "material":"root"
		},
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/cucumber_mosaic_virus/1471-2164-10-467-S3.XLS",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Cucumber mosaic virus",
				"type":"inoculated",
				"label":"Infected with CMV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
                        "day_after_inoculation":"NA",
			"variety":"Tendral",
			"day_after_inoculation":"NA",
                        "material":"cotyledon"
			
		}
	]

}
samples_col.insert(melo_samples)

###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################


tomato_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Solanum lycopersicum", # any abbrev name, key or full name, 
	"name":"Transcriptomics of infection of S.lycopersicum",
	"comments":[
		{"content":""" not published yet""","author":"ben","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"tom1"
	},
	"deposited":{
		"repository":"not deposited yet",
		"sample_description_url":"not deposited yet",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Est','Block','Column','Row','ID','logFC','A','t','P_Value','B','5_unigen_build_1_2','5_GO_annotation','3_unigen_build_1_2','3_GO_annotation'],
		"sheet_index":0,
		"id_type":"Est"
	},
	"experimental_results":[
		
		{
			"data_file":"Solanum/solanum_lycopersicum/transcriptomics/micro_array/tobacco_etch_virus/toptable_ino7dpi.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"NA",
			"day_after_inoculation":"NA",
                        "material":"NA"
			
		}
	]

}
samples_col.insert(tomato_samples)


###################################################################################################################
############################################ ARABIDOPSIS THALIANA #################################################
###################################################################################################################


AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptional analysis of Arabidopsis thaliana infected by a potyvirus. dye-swap 1-2(thale cress)",
	"comments":[
		{"content":"""In this experiment, Arabidopsis plants infected by a virus, Tobacco etch virus (TEV), a potyvirus, were compared with healthy plants to identify genes for which the expression is modified by the viral infection. Analysis of both inoculated leaves and upper young leaves were performed 7 days after the inoculation with the virus (or with only buffer for the healthy plants).""","author":"Frederic Revers","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA V2.1"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE8875",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=37",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Est','Gene','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','logFC','P-VAL','logFCR'],
		"sheet_index":0,
		"id_type":"Est"
	},
	"experimental_results":[
		
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap1_1_iAino_iAsys.xls",
			"conditions":[
				{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				},
				{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"systemic",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"leaf"
			
		},
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap1_2_iAino_iAsys.xls",
			"conditions":[
				{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				},
				{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"systemic",
				"label":"Infected with TEV"
				}
		],
			"contrast":"infected VS infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(AT_samples)

AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptional analysis of Arabidopsis thaliana infected by a potyvirus. dye-swap 3-4(thale cress)",
	"comments":[
		{"content":""" not published yet""","author":"Frederic Revers","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA V2.1"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE8875",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=37",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Est','Gene','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','logFC','P-VAL','logFCR'],
		"sheet_index":0,
		"id_type":"Est"
	},
	"experimental_results":[
		
		
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap2_1_iAino_mAino.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"leaf"
			
		},
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap2_2_iAino_mAino.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"landsberg erecta",
            		"day_after_inoculation":7,
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(AT_samples)

AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptional analysis of Arabidopsis thaliana infected by a potyvirus. dye-swap 5-6(thale cress)",
	"comments":[
		{"content":""" not published yet""","author":"Frederic Revers","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA V2.1"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/geo/query/acc.cgi?acc=GSE8875",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=37",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','Est','Gene','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','logFC','P-VAL','logFCR'],
		"sheet_index":0,
		"id_type":"Est"
	},
	"experimental_results":[
		
		
		
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap3_1_iAsys_mAsys.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"systemic",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"leaf"
			
		},
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/2/RA03-02_Potyvirus_exp37_dyeswap3_2_iAsys_mAsys.xls",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"systemic",
				"label":"Infected with TEV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"leaf"
			
		}
	]

}
samples_col.insert(AT_samples)

###################################################################################################################
############################################ PRUNUS DOMESTICA #####################################################
###################################################################################################################


prunus_samples={
	"src_pub":24959894, # Any field from the pub, doi, pmid, first author etc. 
	"species":"Prunus domestica", # any abbrev name, key or full name,P. domestica 
	"strain":"JoJo",
	"name":"Transcriptomics of infection of P. domestica Jojo by PPV",
	"xp_page":{
	"content":"""
RNAseq from P.domestica cv Jojo infected and non-infected with PPV; 
====

3020 differentially expressed unigenes (2234 up- and 786 down-regulated); 154 potential resistance genes; 75 additional genes that might be good candidates based on literature findings.

paper:

[Transcriptomic Analysis of Prunus domestica Undergoing Hypersensitive Response to Plum Pox Virus Infection](#24959894)
url:
http://www.plosone.org/article/info%3Adoi%2F10.1371%2Fjournal.pone.0100477

data linked with articles :

[journal.pone.0100477.s004.xls](#journal.pone.0100477.s004.xls)
Differentially expressed unigenes. The raw number of reads found on each sample is given in columns Jojo-W1, Jojo-W2, Jojo-W+PPV and Jojo-M+PPV. Fold changes between infected and non-infected samples and FDR values are detailed in columns FC and FDR, respectively. Column labeled Description expands on the details of each unigene, including length in nucleotides.
doi:10.1371/journal.pone.0100477.s004 (XLS)

[journal.pone.0100477.s005.xls](#journal.pone.0100477.s005.xls)
Differentially expressed unigenes found in PRGdb. The raw number of reads found on each sample is given in columns Jojo-W1, Jojo-W2, Jojo-W+PPV and Jojo-M+PPV. Fold changes between infected and non-infected samples and FDR values are detailed in columns FC and FDR, respectively. Column labeled Description expands on the details of each unigene, including length in nucleotides.
doi:10.1371/journal.pone.0100477.s005. Content of this table is the same as the content from table s004, but only genes found in PRGdb are included (156 genes)

[journal.pone.0100477.s006.xls](#journal.pone.0100477.s006.xls)
Genes possibly involved in plant defense not included in the PRGdb. Similarity to a known protein is given in the Homology column. The raw number of reads found on each sample is given in columns Jojo-W1, Jojo-W2, Jojo-W+PPV and Jojo-M+PPV. Fold changes between infected and non-infected samples and FDR values are detailed in columns FC and FDR, respectively. Column labeled Description expands on the details of each unigene, including length in nucleotides.
doi:10.1371/journal.pone.0100477.s006

[journal.pone.0100477.s007.xls](#journal.pone.0100477.s007.xls)
List of genes from PRGdb matched by more than one ‘Jojo’ unigene. Reference numbers of the matched genes are shown in the NCBI Match column. The raw number of reads found on each sample is shown in columns Jojo-W1, Jojo-W2, Jojo-W+PPV and Jojo-M+PPV. Fold changes between infected and non-infected samples is given in column FC. Column labeled Description expands on the details of each gene.
doi:10.1371/journal.pone.0100477.s007. Not included.
	"""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":2,
		"column_keys":['idx',"Est", "Sequence", "Jojo-W1", "Jojo-W2", "Jojo-W+PPV", "Jojo-M+PPV", "fold_change", "logFC", "logCPM", "PValue", "FDR", "Description", "AccPrunus", "DescPrunus", "AccNCBI", "DescNCBI", "AccPlants", "DescPlants", "AccPRG", "DescPRG"],
		"sheet_index":0,
		"id_type":"Est" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":"journal.pone.0100477.s004.xls",
		"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s004.xls",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"Prunus jojo",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"type":"undefined","infection_agent":"ppv","label":"infected with PPV"}
		]
	}, {
		"name":"journal.pone.0100477.s005.xls",
		"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s005.xls",
		"description":"Differentially expressed unigenes found in PRGdb",
		"type":"contrast",
                "variety":"Prunus jojo",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"type":"undefined","infection_agent":"ppv","label":"infected with PPV"}
		]
	}
	# , {
	# 	"name":"journal.pone.0100477.s006.xls",
	# 	"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s006.xls",
	# 	"description":"Genes that might be involved in plant defense and are not included in the PRGdb",
	# 	"type":"contrast",
	# 	"conditions":[
	# 		"non-infected",
	# 		{"infected":True,"infection_agent":"ppv","label":"infected with PPV"}
	# 	],
	# 	"xls_parsing":{'column_keys':['idx',"Homology", "Jojo-W1", "Jojo-W2", "Jojo-W+PPV", "Jojo-M+PPV", "fold_change", "logFC", "logCPM", "PValue", "FDR", "Description"]}
	# }
	# Table S7 is weird in content
	# , {
	# 	"name":"journal.pone.0100477.s007.xls",
	# 	"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s007.xls",
	# 	"description":"",
	# 	"conditions":[
	# 		"non-infected",
	# 		{"infected":True,"infection_agent":"ppv","label":"infected with PPV"}
	# 	]
	# }
	]
}
samples_col.insert(prunus_samples)



###################################################################################################################
############################################ HORDEUM VULGARE ######################################################
###################################################################################################################

# Barley
barley_samples={
	"src_pub":"not published", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Hordeum vulgare", # any abbrev name, key or full name, 
	"strain":"",
	"name":"barley-BYDV virus RNAseq results",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"Est","start","end","value_1","value_2","log2(fold_change)","significant","value_1","value_2","logFC","significant","value_1","value_2","log2(fold_change)","significant","#Polymorphism(55vs56)","assembly info","#significant"],
		"sheet_index":0,
		"id_type":"Est" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":"RNASeq_summary_short.xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/RNASeq_summary_short.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
                "variety":"NA",
		"day_after_inoculation":"NA",
                "material":"NA",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","type":"undefined","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


######PROCESSED SAMPLES PART
###################################################################################################################
############################################ ORIZA Sativa Japonica #################################################
###################################################################################################################
rice_japonica_samples={
    "src_pub":"PMC3798811", # Any field from the pub, doi, pmid, first author etc. 
    "species":"Oriza sativa ssp japonica", # any abbrev name, key or full name, 
    "name":"Relationship between gene responses and symptoms induced by Rice grassy stunt virus",
    "state":"processed",
    "comments":[
        {"content":"""Rice grassy stunt virus (RGSV) is a serious threat to rice production in Southeast Asia. 
            RGSV is a member of the genus Tenuivirus, and it induces leaf yellowing, stunting, 
            and excess tillering on rice plants. Here we examined gene responses of rice to RGSV 
            infection to gain insight into the gene responses which might be associated with the disease symptoms. 
            The results indicated that (1) many genes related to cell wall synthesis and chlorophyll synthesis were predominantly suppressed by RGSV infection; 
            (2) RGSV infection induced genes associated with tillering process; (3) RGSV activated genes involved in inactivation of gibberellic acid and 
            indole-3-acetic acid; and (4) the genes for strigolactone signaling were suppressed by RGSV. 
            These results suggest that these gene responses to RGSV infection account for the excess tillering specific 
            to RGSV infection as well as other symptoms by RGSV, such as stunting and leaf chlorosis."""}
    ],
    "assay":{
        "type":"micro-array",
        "design":"http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3798811/bin/DataSheet1.ZIP"
    },
    "deposited":{
        "repository":"",
        "sample_description_url":"",
        "experimental_meta_data":""

    },
    # xls parser configuration, are propagated to all entries in  "experimental_results",
    "xls_parsing":{
		"n_rows_to_skip":0,
		"column_keys":['idx','Gene ID','Locus','Annotation','expressed/not expressed','Average Log2 RGSV-inoculated plants','Average Log2 in mock-inoculated plants','LogFC','Expression of genes significantly induced (""u"") or suppressed (""d"")'],
		"sheet_index":0,
		"id_type":"Gene ID"
	},
    "experimental_results":[
        {
			"data_file":"Oriza/transcriptomics/micro-array/RGSV/DEG_riceRGSV.tsv",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Rice grassy stunt virus",
				"type":"inoculated",
				"label":"Infected with RGSV"
				}
			],
			"contrast":"infected VS healthy",
			"type":"contrast",
			"variety":"Oryza sativa cv. Nipponbare",
			"day_after_inoculation":28,
                        "material":"leaf"
		
                
        }
    ]

}
samples_col.insert(rice_japonica_samples)



###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #################################################
###################################################################################################################



tomato_samples={
	"src_pub":"PMC3832472", # Any field from the pub, doi, pmid, first author etc. 
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
		"column_keys":['idx','Gene ID','locus','Seq Description','FPKM b','FPKM a','logFC','P value','FDR','Significant'],
		"sheet_index":0,
		"id_type":"Gene ID"
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus ","label":"infected with BYMV"}
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
		"id_type":"transcript_id" 

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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
			{"infected":True,"type":"undefined","infection_agent":"Barley yellow/mild mosaic virus","label":"infected with BYMV"}
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
		"column_keys":['idx','Exp Gene ID','Gene ID','Locus','FPKM INS','FPKM IWS','logFC','Test statistics','p value','q value','Description'],
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
		"column_keys":['idx','Exp Gene ID','Gene ID','Locus','FPKM NI','FPKM INS','logFC','Test statistics','p value','q value','Description'],
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
		"column_keys":['idx','Exp Gene ID','Gene ID','Locus','FPKM NI','FPKM IWS','logFC','Test statistics','p value','q value','Description'],
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


AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptionnal response to potyviruses infection in Arabidopsis Part 1",
        "state":"processed",
	"comments":[
		{"content":"""Arabidopsis thaliana ecotype Ler was inoculated with three different Potyviruses. About 4 weeks after sowing, the 6 expanded leaves plants were inoculated with the different viruses or were mock-inoculated. Seven days after inoculation, inoculated leaves were collected, RNA was extracted and virus infection controlled. Three biological repeats have been done and two dye-swaps.""","author":"Valerie Schurdi-Levraud,Jean-Pierre Renou,Veronique Brunaud,Marie-Laure Martin-Magniette","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA v2.2"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/projects/geo/query/acc.cgi?acc=GSE10707",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=206",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":8,
		"column_keys":['idx','Est','Gene','I_S1','I_S2','logFC','P-VAL'],
		"sheet_index":0,
		"id_type":"Gene"
	},
	"experimental_results":[
		
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerTEV1-LerMock1_exp206.xlsx",
			"conditions":[
                                "non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				}
			
			],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerTEV2-LerMock2_exp206.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Tobacco etch virus",
				"type":"inoculated",
				"label":"Infected with TEV"
				}
                        ],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerPPV1-LerPPVMock1_exp206.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
                        ],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		}
                
	]

}
samples_col.insert(AT_samples)




AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptionnal response to potyviruses infection in Arabidopsis Part 1",
        "state":"processed",
	"comments":[
		{"content":"""Arabidopsis thaliana ecotype Ler was inoculated with three different Potyviruses. About 4 weeks after sowing, the 6 expanded leaves plants were inoculated with the different viruses or were mock-inoculated. Seven days after inoculation, inoculated leaves were collected, RNA was extracted and virus infection controlled. Three biological repeats have been done and two dye-swaps.""","author":"Valerie Schurdi-Levraud,Jean-Pierre Renou,Veronique Brunaud,Marie-Laure Martin-Magniette","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA v2.2"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/projects/geo/query/acc.cgi?acc=GSE10707",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=206",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":8,
		"column_keys":['idx','Est','Gene','I_S1','I_S2','logFC','P-VAL'],
		"sheet_index":0,
		"id_type":"Gene"
	},
	"experimental_results":[
		
		
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerPPV2-LerPPVMock2_exp206.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Plum pox virus",
				"type":"inoculated",
				"label":"Infected with PPV"
				}
                        ],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerLMV1-LerMock1_exp206.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
                        ],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-LerLMV2-LerMock2_exp206.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
                        ],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"landsberg erecta",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		}
	]

}
samples_col.insert(AT_samples)







AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptionnal response to potyviruses infection in Arabidopsis Part 3",
        "state":"processed",
	"comments":[
		{"content":"""Four different Arabidopsis ecotypes were inoculated with one Potyviruse. About 4 weeks after sowing, the 6 expanded leaves plants were inoculated with the different viruses or were mock-inoculated. Seven days after inoculation, inoculated leaves were collected, RNA was extracted and virus infection controlled. RNA fron infected plants was then used for microarrays hybridization. Three biological repeat have been done and two dye-swap.""","author":"Valerie Schurdi-Levraud,Jean-Pierre Renou,Frederique Bitton,Marie-Laure Martin-Magniette","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA v2.2"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/projects/geo/query/acc.cgi?acc=GSE10711",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=207",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":8,
		"column_keys":['idx','Est','Gene','I_S1','I_S2','logFC','P-VAL'],
		"sheet_index":0,
		"id_type":"Gene"
	},
	"experimental_results":[
		
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-ColLMV1-ColMock1_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
			
			],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"col-0",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
		{
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-ColLMV2-ColMock2_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
		],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"col-0",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-Bl1LMV1-Bl1Mock1_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
		],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"bologna-1",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		}
	]

}
samples_col.insert(AT_samples)

AT_samples={
	"src_pub":"not published yet", # Any field from the pub, doi, pmid, first author etc. 
	"species":"Arabidopsis thaliana", # any abbrev name, key or full name, 
	"name":"Transcriptionnal response to potyviruses infection in Arabidopsis Part 4",
        "state":"processed",
	"comments":[
		{"content":"""Four different Arabidopsis ecotypes were inoculated with one Potyviruse. About 4 weeks after sowing, the 6 expanded leaves plants were inoculated with the different viruses or were mock-inoculated. Seven days after inoculation, inoculated leaves were collected, RNA was extracted and virus infection controlled. RNA fron infected plants was then used for microarrays hybridization. Three biological repeat have been done and two dye-swap.""","author":"Valerie Schurdi-Levraud,Jean-Pierre Renou,Frederique Bitton,Marie-Laure Martin-Magniette","date":datetime.datetime.now()}
	],
	"assay":{
		"type":"micro-array",
		"design":"CATMA v2.2"
	},
	"deposited":{
		"repository":"http://www.ncbi.nlm.nih.gov/projects/geo/query/acc.cgi?acc=GSE10711",
		"sample_description_url":"http://urgv.evry.inra.fr/cgi-bin/projects/CATdb/consult_expce.pl?experiment_id=207",
		"experimental_meta_data":"not deposited yet"

	},
	# xls parser configuration, are propagated to all entries in  "experimental_results",
	"xls_parsing":{
		"n_rows_to_skip":8,
		"column_keys":['idx','Est','Gene','I_S1','I_S2','logFC','P-VAL'],
		"sheet_index":0,
		"id_type":"Gene"
	},
	"experimental_results":[
		
		
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-Bl1LMV2-Bl1Mock2_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
		],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"bologna-1",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-CvlLMV1-CvlMock1_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
		],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"cape verde islands",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		},
                {
			"data_file":"Arabidopsis/arabidopsis_thaliana/transcriptomics/microarray/tobacco_etch_viruses/4/RA06-05_Potyvirus-CvlLMV2-CvlMock2_exp207.xlsx",
			"conditions":["non infected",{
				"infected":True,
				"infection_agent":"Lettuce mosaic virus",
				"type":"inoculated",
				"label":"Infected with LMV"
				}
		],
			"contrast":"infected VS non infected",
			"type":"contrast",
			"variety":"cape verde islands",
			"day_after_inoculation":7,
                        "material":"rosette"
			
		}
	]

}
samples_col.insert(AT_samples)













#tomato_pub={
#	"doi":"10.1186/1471-2164-10-467",
#	"url":"http://www.biomedcentral.com/1471-2164/10/467",
#	"first_author":"Albert Mascarell-Creus",
#	"pmid":19821986, # http://www.ncbi.nlm.nih.gov/pubmed/19821986
#	# rest can be populated automatically 
#}
