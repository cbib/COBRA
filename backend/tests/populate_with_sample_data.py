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



publications_col.remove()
samples_col.remove()
measurements_col.remove()
interactions_col.remove()
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

# Melon 

melo_samples={
    "src_pub":23134692, # Any field from the pub, doi, pmid, first author etc. 
    "species":"C. melo", # any abbrev name, key or full name, 
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
		"column_keys":['idx','est_unigen','description','fold_change','function'],
		"sheet_index":0,
		"id_type":"est_unigen"
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
    "species":"C. melo", # any abbrev name, key or full name, 
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
        "column_keys":['idx','est_unigen','adjP_Val','P_Value','t','B','logFC','SPOT_ID'],
        "sheet_index":0,
        "id_type":"est_unigen"
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
	"species":"C. melo", # any abbrev name, key or full name, 
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
		"column_keys":['idx','est_unigen','length','description','fold_change'],
		"sheet_index":0,
		"id_type":"est_unigen"
	},
	"experimental_results":[
		{
			"data_file":"Cucumis/cucumis_melo/transcriptomics/micro_array/no_infection/condition_15d_VS_46d/1471-2164-10-467-S1.XLS",
			"conditions":["15d","46d"],
			"contrast":"46d VS 15d",
			"type":"contrast",
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
			"variety":"Tendral",
			"day_after_inoculation":"NA",
         "material":"cotyledon"
			
		}
	]

}
samples_col.insert(melo_samples)

# Tomato

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
		"column_keys":['idx','SGN_S','Block','Column','Row','ID','logFC','A','t','P_Value','B','5_unigen_build_1_2','5_GO_annotation','3_unigen_build_1_2','3_GO_annotation'],
		"sheet_index":0,
		"id_type":"SGN_S"
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


# Arabidopsis

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
		"column_keys":['idx','CATMA_ID','AGI_TAIR','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','R','P-VAL','logFC'],
		"sheet_index":0,
		"id_type":"CATMA_ID"
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
		"column_keys":['idx','CATMA_ID','AGI_TAIR','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','R','P-VAL','logFC'],
		"sheet_index":0,
		"id_type":"CATMA_ID"
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
		"column_keys":['idx','CATMA_ID','AGI_TAIR','FUNCTION','TYPE_QUAL','PCR_RESULT','I_S1','I_S2','R','P-VAL','logFC'],
		"sheet_index":0,
		"id_type":"CATMA_ID"
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


# Prunus 

prunus_samples={
	"src_pub":19821986, # Any field from the pub, doi, pmid, first author etc. 
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
		"column_keys":['idx',"unigene", "Sequence", "Jojo-W1", "Jojo-W2", "Jojo-W+PPV", "Jojo-M+PPV", "fold_change", "logFC", "logCPM", "PValue", "FDR", "Description", "AccPrunus", "DescPrunus", "AccNCBI", "DescNCBI", "AccPlants", "DescPlants", "AccPRG", "DescPRG"],
		"sheet_index":0,
		"id_type":"unigene" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":"journal.pone.0100477.s004.xls",
		"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s004.xls",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"ppv","label":"infected with PPV"}
		]
	}, {
		"name":"journal.pone.0100477.s005.xls",
		"data_file":"Prunus/prunus_domestica/transcriptomics/rna-seq/plum_pox_virus/journal.pone.0100477.s005.xls",
		"description":"Differentially expressed unigenes found in PRGdb",
		"type":"contrast",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"ppv","label":"infected with PPV"}
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
		"column_keys":['idx',"Morex_Contig","start","end","value_1","value_2","log2(fold_change)","significant","value_1","value_2","logFC","significant","value_1","value_2","log2(fold_change)","significant","#Polymorphism(55vs56)","assembly info","#significant"],
		"sheet_index":0,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":"RNASeq_summary_short.xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/RNASeq_summary_short.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":2,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":3,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":4,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":5,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":6,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":7,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"strain":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":8,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":9,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":10,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":11,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":12,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":13,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
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
	"name":"Transcriptional analysis of Hordeum vulgare infected by Barley yellow dwarf virus",
	"xp_page":{
	"content":""""""},
	"assay":{"type":"RNA-Seq"},
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx',"gene","GO_BP_ID","GO_BP_TERM","GO_MF_ID","GO_MF_TERM","GO_CC_ID","GO_CC_TERM","Morex_Contig","popseq_chr","popseq_cM","morex_contig_length","gene_start","gene_end","gene_id","confidence","annotation","inter_pro","blast2GO","ETC_1_normalized","ETC_2_normalized","ETC_3_normalized","Sync_1_normalized","Sync_2_normalized","Sync_3_normalized","ETC_1_raw","ETC_2_raw","ETC_3_raw","Sync_1_raw","Sync_2_raw","Sync_3_raw","baseMean","logFC","lfcSE","stat","pvalue","padj"],
		"sheet_index":14,
		"id_type":"Morex_Contig" #**TODO** check ID type for prunus 
	},
	"experimental_results":[{
		"name":".xls",
		"data_file":"Hordeum/hordeum_vulgare/transcriptomics/rna-seq/barley_yellow_dwarf_virus/Resistenzgene_die_hier.xlsx",
		"description":"Differentially expressed unigenes",
		"type":"contrast",
		"conditions":[
			"non-infected",
			{"infected":True,"infection_agent":"Barley yellow dwarf virus","label":"infected with BYDV"}
		]
	}]
}
samples_col.insert(barley_samples)


#### Interactions Table


interactions_table={
	"data_file":"interactomics/potyvirus/Potyvirus.Interactors.xls",
	"src":"Virus_prot",
	"tgt":"Host_prot",
	"virus_class":"potyvirus",
	"xls_parsing":{
		"n_rows_to_skip":3,
		"column_keys":['idx','Virus_prot','Host_prot','method','virus','host','Putative_function','Reference','Accession_number'],
		"sheet_index":0,
		
	}

}
interactions_col.insert(interactions_table)


interactions_table={
	"data_file":"interactomics/Intact/hpidb2_plant_only.xls",
	"src":"protein_xref_1",
	"tgt":"protein_xref_2",
	"species_one":"protein_taxid_1_name",
	"species_two":"protein_taxid_2_name",
	"virus_class":"various",
	"xls_parsing":{
		"n_rows_to_skip":1,
		"column_keys":['idx','protein_xref_1','alternative_identifiers_1','protein_alias_1','protein_xref_2','alternative_identifiers_2','protein_alias_2','detection_method','author_name','pmid','protein_taxid_1','protein_taxid_2','interaction_type','source_database_id','database_identifier','confidence','protein_xref_1_unique','protein_xref_2_unique','protein_taxid_1_cat','protein_taxid_2_cat','protein_taxid_1_name','protein_taxid_2_name','protein_seq1','protein_seq2','source_database','comment'],
		"sheet_index":0,
		
	}

}
interactions_col.insert(interactions_table)




#for key, value in orthologs_table.items():
	
#orthologs_col.put(orthologs_table.items())








#tomato_pub={
#	"doi":"10.1186/1471-2164-10-467",
#	"url":"http://www.biomedcentral.com/1471-2164/10/467",
#	"first_author":"Albert Mascarell-Creus",
#	"pmid":19821986, # http://www.ncbi.nlm.nih.gov/pubmed/19821986
#	# rest can be populated automatically 
#}
