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

#species_to_process=mappings_col.find({"src":"plaza_gene_id",'type':{"$nin":['gene_to_go']}},{"species":1})
species_to_process=species_col.find({},{"full_name":1})

for species in species_to_process:
	#logger.info("species %s",species['species'])
	pipeline= [
		{'$match' : {'species':species['full_name'], }}, 
		{'$group':  {'_id': 'Cucumis melo', 'count' :{'$sum':1}}} 
	]
	results=measurements_col.aggregate(pipeline)

	for genes in results['result']:
	
		logger.info("Result for %s - Number of genes %s",species['full_name'],genes["count"])

	pipeline= [
		{'$match' : {'species':species['full_name'], 'direction':'up'}}, 
		{'$group':  {'_id': 'Cucumis melo', 'count' :{'$sum':1}}} 
	]
	results=measurements_col.aggregate(pipeline)

	for genes in results['result']:
	
		logger.info("Result for %s - Number of genes surexpressed %s",species['full_name'],genes["count"])

	pipeline= [
		{'$match' : {"infection_agent" : "monosporascus_cannonballus", 'species':species['full_name'], 'direction':'up'}}, 
		{'$group':  {'_id': 'Cucumis melo', 'count' :{'$sum':1}}} 
	]
	results=measurements_col.aggregate(pipeline)

	for genes in results['result']:
	
		logger.info("Result for %s - Number of genes infected by monosporascus and surexpressed %s",species['full_name'],genes["count"])


	pipeline=[
		{'$match' : {'experimental_results.conditions.infected':True,'species':species['full_name']}},     
		{'$unwind':'$experimental_results'},      
		{'$project' : {'experimental_results.data_file':1,'experimental_results.values':1,'experimental_results.conditions':1,'_id':0}},     
		{'$unwind':'$experimental_results.conditions'},        
		{'$project':{'experimental_results.values.logFC':1,'experimental_results.data_file':1,'infection_agent':'$experimental_results.conditions.infection_agent'}},     
		{'$unwind':'$experimental_results.values'},     
		{'$match':{'experimental_results.values.logFC': {'$gt': 0.05}}},     
		{'$project':{'experimental_results.values.logFC':1,'experimental_results.name':1,'infection_agent':'$experimental_results.conditions.infection_agent'}}
	]
	
	results=samples_col.aggregate(pipeline)
	#cursor_to_table(samples_col.aggregate(pipeline))
	
	#cursor_to_table(samples_col.find({"species":species['full_name']},{"experimental_results.variety":1}))
	#cursor_to_table(results)
	
	
	#for key_one in results['result']:
	#	for key_two in key_one['experimental_results']:
	#		for key_three in key_two:
	#			print key_three
			#logger.info("Result for %s - Number of genes %s",species['full_name'],key_two)
			#for key_three in key_two:
			#	logger.info("Result for %s - Number of genes %s",species['full_name'],key_three)
	
	all_species_names=aliases_for_species_matching({"_id":find_species_doc(species['full_name'])['_id']})
	#all_cmv_names=aliases_for_species_matching({"_id":find_species_doc("cmv")['_id']})
	
				
	tgt_samples=samples_col.find({"species":{"$in":all_species_names},"experimental_results.conditions.infected":True})

	# browse the doc and gather the path of the tgt xp 

	tgt_path=[]
	tgt_description={}
	for a_sample in tgt_samples:
		for i,xp in enumerate(a_sample['experimental_results']):
			for j,condition in enumerate(xp['conditions']):
				if "infection_agent" in condition :
                                        
					if 'contrast' in xp:
						this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)
                                                logger.info("Path %s",this_path)
						tgt_path.append(this_path)
						tgt_description[this_path]=xp['contrast']+":"+condition.get('label',"")
						break
					else:
						this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)                                                    
                                                logger.info("Path %s",this_path)
						tgt_path.append(this_path)
						tgt_description[this_path]=condition.get('label',"")
						break

	if len(tgt_path)<1:
		print "nothing found"

	results=list(measurements_col.find({"xp":{"$in":tgt_path},"logFC":{"$gt":2}},{"_id":0}))
       
	


        # annotate results
	for r in results:
                tmp_results=list(
                                mappings_col.find(
                                                {
                                                "type":"full_table",
                                                {"$or":[{'mapping_file.Gene ID':r['gene']},{'mapping_file.Transcript ID':r['gene']}]}
                                                },
                                                {'_id':0}
                                                )
                                )
                cursor_to_table(tmp_results)
                #mappings_col.update({"type":"full_table",{$or:{{"mapping_file.Gene ID:r['gene']},{"mapping_file.Transcript ID:r['gene']}},{"$inc": { "mapping_file.Score": 1 } })

                #logger.info("gene id %s",r['gene'])
                
		r['description']=tgt_description[r['xp']]
	#cursor_to_table(results)			
				
