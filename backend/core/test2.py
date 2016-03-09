#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
from helpers.path import data_dir
from bson.son import SON

# Script supposed to be run in the background to populate the DB with available datasets 
## Setup

from numbers import Number
import collections
from math import log
if "log" not in globals():
  logger = Logger.init_logger('DATA_PROCESSOR_%s'%(cfg.language_code), load_config())

logger.info("Running %s",sys.argv[0])



#score all genes in interactions tables !!!
        
#score all genes in litterature interaction tables !!!
species_to_process=species_col.find({},{"full_name":1})
new_results=[]
counter=0
for species in species_to_process:

   # need to rebuid the markers file by type:
        #SSR pos_start pos end
        #SNP,IRSC ARRAY V1 SNP pos
        #AFLP
        #EST-SSR
        #RAPD
        #CANDIDATE GENE MARKER
   # markers_to_process=genetic_markers_col.find({"species":species['full_name']}{})
    #markers_to_process=list(genetic_markers_col.find({'mapping_file.Species':species['full_name']},{"mapping_file.Position":1,"mapping_file.Marker ID":1,"mapping_file.Map ID":1,"mapping_file.Chromosome":1,"_id":0} ))
    #markers_to_process=list(genetic_markers_col.find({'mapping_file.Species':species['full_name']},{"mapping_file.$":1,"_id":0} ))

    markers_to_process=list(genetic_markers_col.aggregate([
                            {'$project' : {'mapping_file':1,'_id':0}},
                            {'$unwind':'$mapping_file'},
                            {'$match' :  {'mapping_file.Species':species['full_name'],'mapping_file.Position': {'$ne':""}}}, 
                            {
                              '$project':
                                 {
                                   'mapping_file.Position':1,
                                   'mapping_file.Marker ID':1,
                                   'mapping_file.Map ID':1,
                                   'mapping_file.Chromosome':1,
                                   'mapping_file.Type':1,
                                   '_id': 0
                                 }
                            }
                        ]
                        , useCursor=False))


    #work for find request
       
    #for markers in markers_to_process:
    #    for m in markers['mapping_file']:
    #        if 'Position' in m and 'Chromosome' in m:
    #            if m['Position']!="Location":
    #                if m['Position']!="" and m['Chromosome']!="":
    #                    counter+=1
    #                    logger.info("count: %d species : %s ",counter, species['full_name'])                   
    #logger.info("count: %d species : %s ",counter, species['full_name'])

    counter=0
    
    available_first_level_keys=[]
    for r in markers_to_process:
            for k in r.keys():
                    
                    if k not in available_first_level_keys:
                            available_first_level_keys.append(k)
    #tt=PrettyTable(available_first_level_keys)
    for r in markers_to_process:
            counter+=1
            logger.info("count: %d",counter)
            #logger.info("keys %s",r.get("Position","NA"))
            #for k in available_first_level_keys:
            for k in r.keys():
                #print k['Position']
                #for keys in r.get(k,"NA"):
                 #   print keys
                m=r.get('mapping_file',"NA")
                #print m['Marker ID']
                
                
                qtl_to_process=list(qtls_col.aggregate([
                    #{'$match' : {'species': species['full_name']}},  
                    {'$project' : {'mapping_file':1,'_id':0}},
                    {'$unwind':'$mapping_file'},
                    {'$match' :  {"$or": [ { 'mapping_file.Colocalizing marker':{'$regex':m['Marker ID'], '$options': 'xi' }}, {'mapping_file.Marker ID':{'$regex':m['Marker ID'], '$options': 'xi' }} ]}}, 
                    #{'$match' :  {'mapping_file.Map ID': m['Map ID'],"$or": [ { 'mapping_file.Colocalizing marker':{'$regex':m['Marker ID'], '$options': 'xi' }}, {'mapping_file.Marker ID':{'$regex':m['Marker ID'], '$options': 'xi' }} ]}}, 

                    {
                      '$project':
                         {
                           'mapping_file.Trait Name':1,
                           'mapping_file.Trait Alias':1,
                           'mapping_file.Study':1,
                           '_id': 0
                         }
                    }
                ]
                , useCursor=False))
                
                if len(qtl_to_process)>0 :
                    #print m['Marker ID']
                    

                    genes_to_process=list(full_mappings_col.aggregate([
                        {'$match' : {'type':'full_table', 'species': species['full_name']}},  
                        {'$project' : {'mapping_file':1,'_id':0}},
                        {'$unwind':'$mapping_file'},
                        {'$match' :  {'mapping_file.Chromosome': m['Chromosome'],"$and": [ { "mapping_file.End": { "$gt": m['Position'] } }, { "mapping_file.Start": { "$lt": m['Position'] } } ]}}, 
                        {
                          '$project':
                            {
                                'mapping_file.Gene ID':1,
                                'mapping_file.Start':1,
                                'mapping_file.End':1,
                                'mapping_file.Score_exp':1,
                                'mapping_file.Score_int':1,
                                'mapping_file.Score_orthologs':1,
                                '_id': 0
                            }
                        }
                    ]
                    , useCursor=False))
                    
                    if len(genes_to_process)>0:
                        logger.info("count: %d marker : %s ",counter, m['Marker ID'])
                        cursor_to_table(qtl_to_process)
                        cursor_to_table(genes_to_process)
            #logger.info("keys %s",[r.get(k,"NA") for k in available_first_level_keys])
    logger.info("count: %d species : %s ",counter, species['full_name'])
