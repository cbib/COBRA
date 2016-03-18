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
for species in species_to_process:

   # need to rebuid the markers file by type:
        #SSR pos_start pos end
        #SNP pos
   # markers_to_process=genetic_markers_col.find({"species":species['full_name']}{})

    print species['full_name']
    if species['full_name'] == "Prunus persica" or species['full_name']== "Prunus armeniaca":
        markers_to_process=list(genetic_markers_col.find({'mapping_file.Species':species['full_name']},{"mapping_file.Start":1,"mapping_file.Marker ID":1,"mapping_file.Map ID":1,"mapping_file.Chromosome":1,"_id":0} ))
        counter=0
        for markers in markers_to_process:
            counter+=1
            for m in markers['mapping_file']:
                if 'Start' in m and 'Chromosome' in m:
                    if m['Start']!="Location":
                        if m['Start']!="" and m['Chromosome']!="":
                            logger.info("markers position %s chrom %s id %s map id %s",m['Start'],m['Chromosome'],m['Marker ID'],m['Map ID'])
                            #pos=int(m['Position'])
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


                            cursor_to_table(qtl_to_process)

                            gene_list=[]
                            gene_to_process=list(full_mappings_col.aggregate(
                                [
                                  {'$match' : {'type':'full_table', 'species': species['full_name']}},  
                                  {'$project' : {'mapping_file':1,'_id':0}},
                                  {'$unwind':'$mapping_file'},
                                  {'$match' :  {'mapping_file.Chromosome': m['Chromosome'],"$and": [ { "mapping_file.End": { "$gt": m['Start'] } }, { "mapping_file.Start": { "$lt": m['Start'] } } ]}}, 
                                  {
                                    '$project':
                                       {
                                         'mapping_file.Gene ID':1,
                                         'mapping_file.Start':1,
                                         'mapping_file.End':1,
                                         '_id': 0
                                       }
                                  }
                                ]
                             , useCursor=False))
                            for s in gene_to_process:
                                for l in s.keys():
                                    q=s.get('mapping_file',"NA")
                                    #print q['Gene ID']
                                    if q['Gene ID'] not in gene_list:
                                        gene_list.append(q['Gene ID'])
                   
                            if len(gene_to_process)>0:

                                logger.info("count: %d marker : %s gene number %d",counter, m['Marker ID'],len(gene_list))
                                cursor_to_table(qtl_to_process)
                                cursor_to_table(gene_to_process)   
                                for gene in gene_list:
                                    for s in qtl_to_process:
                                        for l in s.keys():
                                            q=s.get('mapping_file',"NA")
                                            #if q['Trait Name'].contains "resistance" +3
                                            if "resistance" in q['Trait Name'] or "Resistance" in q['Trait Name']:
                                                logger.info("resistance--- %s",q['Trait Name'])
                                                #full_mappings_col.update({'species':species["full_name"],"mapping_file.Gene ID":gene},{'$inc': {'mapping_file.$.Score_QTL': 2 } })

                                            else:
                                                logger.info("other--- %s",q['Trait Name'])
                                                #full_mappings_col.update({'species':species["full_name"],"mapping_file.Gene ID":gene},{'$inc': {'mapping_file.$.Score_QTL': 1 } })
                                            plaza_results=full_mappings_col.find({'species':"Prunus persica",'mapping_file.Gene ID':gene},{'mapping_file.$.Plaza ID': 1 } )
                                            for p in plaza_results:
                                                for values in p['mapping_file']:

                                                    plaza_id=values['Plaza ID']

                                                    ortholog_result=orthologs_col.find({'species':species["full_name"],'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
                                                    for ortholog in ortholog_result:

                                                        ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
                                                        if ortholog_list.find(",") != -1:
                                                            ortholog_split_list=ortholog_list.split(',')
                                                            for ortholog_id in ortholog_split_list:
                                                                if ortholog_id!=plaza_id:
                                                                    #full_mappings_col.update({"mapping_file.Plaza ID":ortholog_id},{"$inc": {'mapping_file.$.Score_orthologs': 0.5 } })
                                                        else:
                                                            if ortholog_list!=plaza_id:
                                                                #full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Score_orthologs': 0.5 } })
                        #cursor_to_table(gene_to_process)




                            #for features in gene_to_process:
                            #    for pos in features['mapping_file']:
                            #        logger.info("gene: %s",pos['Gene ID'])
                                    #logger.info("gene: %s start: %s end: %s",pos[0],pos[1],pos[2])
    #elif species['full_name']=="Cucumis melo":
    #      markers_to_process=list(genetic_markers_col.find({'species':species['full_name']},{"mapping_file.Start":1,"mapping_file.Marker ID":1,"mapping_file.Chromosome":1,"_id":0} ))
    #      for markers in markers_to_process:
    #        for m in markers['mapping_file']:
    #            if 'Start' in m and 'Chromosome' in m:
    #                if m['Start']!="" and m['Chromosome']!="":
    #                    logger.info("markers position %s chrom %s id %s",m['Start'],m['Chromosome'],m['Marker ID'])
                        
                        #qtl_to_process=list(qtls_col.aggregate([
                        #    {'$project' : {'mapping_file':1,'_id':0}},
                        #    {'$unwind':'$mapping_file'},
                        #    {'$match' :  {"$or": [ { 'mapping_file.Marker ID':{'$regex':m['Marker ID'], '$options': 'xi' }}, {'mapping_file.Marker ID 2':{'$regex':m['Marker ID'], '$options': 'xi' }} ]}}, 

                        #    {
                        #      '$project':
                        #         {
                        #           'mapping_file.QTL Name':1,
                        #           'mapping_file.Alias':1,
                        #           'mapping_file.QTL ID':1,
                        #           'mapping_file.Chromosome':1,
                        #           'mapping_file.Map ID':1,
                        #           'mapping_file.Start':1,
                        #           'mapping_file.End':1,
                        #           'mapping_file.Marker ID':1,
                        #           'mapping_file.Marker ID 2':1,
                        #           '_id': 0
                        #         }
                        #    }
                        #]
                        #, useCursor=False))
                        #cursor_to_table(qtl_to_process)



                        
    #                    gene_to_process=list(full_mappings_col.aggregate(
    #                        [
    #                          {'$match' : {'type':'full_table', 'species': species['full_name']}},  
    #                          {'$project' : {'mapping_file':1,'_id':0}},
    #                          {'$unwind':'$mapping_file'},
    #                          {'$match' :  {'mapping_file.Chromosome': m['Chromosome'],"$and": [ { "mapping_file.End": { "$gt": m['Start'] } }, { "mapping_file.Start": { "$lt": m['Start'] } } ]}}, 
    #                          {
    #                            '$project':
    #                               {
    #                                 'mapping_file.Gene ID':1,
    #                                 'mapping_file.Start':1,
    #                                 'mapping_file.End':1,
    #                                 '_id': 0
    #                               }
    #                          }
    #                        ]
    #                     , useCursor=False))
    #                    cursor_to_table(gene_to_process)
    #else:
    #    print "this species QTL is not described"
        
                        
   