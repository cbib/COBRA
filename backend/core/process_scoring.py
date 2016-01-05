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
new_results=[]
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


	#pipeline=[
	#	{'$match' : {'experimental_results.conditions.infected':True,'species':species['full_name']}},     
	#	{'$unwind':'$experimental_results'},      
	#	{'$project' : {'experimental_results.data_file':1,'experimental_results.values':1,'experimental_results.conditions':1,'_id':0}},     
	#	{'$unwind':'$experimental_results.conditions'},        
	#	{'$project':{'experimental_results.values.logFC':1,'experimental_results.data_file':1,'infection_agent':'$experimental_results.conditions.infection_agent'}},     
	#	{'$unwind':'$experimental_results.values'},     
	#	{'$match':{'experimental_results.values.logFC': {'$gt': 0.05}}},     
	#	{'$project':{'experimental_results.values.logFC':1,'experimental_results.name':1,'infection_agent':'$experimental_results.conditions.infection_agent'}}
	#]
	
	#results=samples_col.aggregate(pipeline)
	

        #cursor_to_table(samples_col.aggregate(pipeline))
	
	#cursor_to_table(samples_col.find({"species":species['full_name']},{"experimental_results.variety":1}))
	#cursor_to_table(results)
	
	
	
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
        
        gene_set=[]
        
        #reset score to 0
        for r in results:
                if species['full_name']== "Hordeum vulgare":
                #    logger.info("gene id %s for species %s",r['gene'],species) 
                    full_mappings_col.update({"mapping_file.Transcript ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } })

                
                elif species['full_name']== "Prunus domestica":
                    full_mappings_col.update({"mapping_file.Protein ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } })


                else:
                #    logger.info("gene id %s for species %s",r['gene'],species)
                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } })

                
	for r in results:

                if species['full_name']== "Hordeum vulgare":

                    full_mappings_col.update({"mapping_file.Transcript ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } })
                
                elif species['full_name']== "Prunus domestica":

                    full_mappings_col.update({"mapping_file.Protein ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } })

                else:

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } })
                
                
                
		r['description']=tgt_description[r['xp']]
                #counter++
        
        #new_results[species]=gene_set
	#cursor_to_table(gene_set)
        #tmp_array=[]
        #tmp_array.append(species['full_name'])
        #tmp_array.append(gene_set)
        #new_results.append(tmp_array)
        #for array in new_results:
        #    print array[0]
        #cursor_to_table(results)


        for r in results:
            if r['gene'] != 'NA' and r['gene'] != '':
                logger.info("gene id %s for species %s",r['gene'],species)

                if species['full_name']== "Hordeum vulgare":

                    tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Transcript ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Transcript ID":r['gene']},{"mapping_file.$": 1 }))

                elif species['full_name']== "Prunus domestica":

                    tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Protein ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Protein ID":r['gene']},{"mapping_file.$": 1 }))

                else:
                    tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Gene ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Gene ID":r['gene']},{"mapping_file.$": 1 }))



                #for s in tmp:   

                logger.info("uniprot id %s",tmp['result'][0]['mapping_file']['Uniprot ID'])
