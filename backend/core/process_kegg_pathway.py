#! /usr/bin/python

__author__ = "benjamindartigues"
__date__ = "$Jul 8, 2016 11:21:01 AM$"
import sys
import os
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
from helpers.path import data_dir
from pymongo.errors import DocumentTooLarge,OperationFailure


# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
  logger = Logger.init_logger('PROCESS_GENETIC_MAPS_%s'%(cfg.language_code), load_config())



import urllib2


classe="Genetic Information Processing"
type="Transcription"
type_dict_transcription={'RNA polymerase':'03020','Basal transcription factors':'03022','Spliceosome':'03040'}

for key, value in type_dict_transcription.items():
    
    my_pathway=urllib2.urlopen("http://rest.kegg.jp/link/genes/pper"+value).read()
    print my_pathway
    for path in my_pathway.split(	):
	print path  
    
    
#    kegg_pathway_table={
#
#        'species':'Prunus persica',
#        'src':'Kegg_pathway',
#        'tgt':'gene_list',
#        'type':type,
#        'data':
#
#    }
#    kegg_pathway_col.insert(orthologs_table)
#type="Translation"
#type_dict_translation={ 'Ribosome':'03010','Aminoacyl-tRNA biosynthesis':'00970','RNA transport':'03013','mRNA surveillance pathway':'03015','Ribosome biogenesis in eukaryotes':'03008'}
#
#kegg_pathway_table={
#
#    'species':'Prunus persica',
#    'src':'Kegg_pathway',
#    'tgt':'gene_list'
#
#}
#kegg_pathway_col.insert(orthologs_table)
#
#type="Folding, sorting and degradation"
#type_dict_folding={ 'Protein export':'03060','Protein processing in endoplasmic reticulum':'04141','SNARE interactions in vesicular transport':'04130','Ubiquitin mediated proteolysis':'04120','Sulfur relay system':'04122','Proteasome':'03050','RNA degradation':'03018'}
#type="Replication and repair"
#type_dict_replication={ 'DNA replication':'03030','Base excision repair':'03410','Nucleotide excision repair':'03420','Mismatch repair':'03430','Homologous recombination':'03440','Non-homologous end-joining':'03450'}
#
#
#   
#
#classe2="Environmental Information Processing"
#type="Membrane transport"
#type_dict_transport_membrane={'ABC transporters':'02010'}
#
#type="Signal transduction"
#type_dict_signal_transduction={'Phosphatidylinositol signaling system':'04070','Plant hormone signal transduction':'04075'}
#
#
#classe3="Cellular Processes"
#
#type="Transport and catabolism"
#type_dict_transandcat={'Endocytosis':'04144','Phagosome':'04145','Peroxisome':'04146','Regulation of autophagy':'04140'}
#
#
#Organismal Systems
#
#    Environmental adaptation
#        04712  Circadian rhythm - plant
#        04626  Plant-pathogen interaction
#
#Human Diseases
#
#    Endocrine and metabolic diseases
#        04931  Insulin resistance
#        04933  AGE-RAGE signaling pathway in diabetic complications
#    Antimicrobial resistance
#        01502  Vancomycin resistance

#my_pathway=urllib2.urlopen("http://rest.kegg.jp/link/genes/pper04626").read()
#    print my_pathway
#    for path in my_pathway.split(	):
#	print path  


