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
        
#########################################       
	#logger.info("species %s",species['species'])
	#pipeline= [
	#	{'$match' : {'species':species['full_name'], }}, 
	#	{'$group':  {'_id': 'total', 'count' :{'$sum':1}}} 
	#]
	#results=measurements_col.aggregate(pipeline, useCursor=False)

	#for genes in results:
	
	#	logger.info("Result for %s - Number of genes %s",species['full_name'],genes["count"])

	#pipeline= [
	#	{'$match' : {'species':species['full_name'], 'direction':'up'}}, 
	#	{'$group':  {'_id': 'total', 'count' :{'$sum':1}}} 
	#]
	#results=measurements_col.aggregate(pipeline, useCursor=False)

	#for genes in results:
	
	#	logger.info("Result for %s - Number of genes surexpressed %s",species['full_name'],genes["count"])

	#pipeline= [
	#	{'$match' : {"infection_agent" : "monosporascus_cannonballus", 'species':species['full_name'], 'direction':'up'}}, 
	#	{'$group':  {'_id': 'total', 'count' :{'$sum':1}}} 
	#]
	#results=measurements_col.aggregate(pipeline, useCursor=False)

	#for genes in results:
	
	#	logger.info("Result for %s - Number of genes infected by monosporascus and surexpressed %s",species['full_name'],genes["count"])

        #pipeline= [
	#	{'$match' : {"infection_agent" : "Plum pox virus", 'species':species['full_name'], 'direction':'up'}}, 
	#	{'$group':  {'_id': 'total', 'count' :{'$sum':1}}} 
	#]
	#results=measurements_col.aggregate(pipeline, useCursor=False)

	#for genes in results:
	
	#	logger.info("Result for %s - Number of genes infected by PPV and surexpressed %s",species['full_name'],genes["count"])
#########################################


	
	#results=samples_col.aggregate(pipeline, useCursor=False)
	

        #cursor_to_table(samples_col.aggregate(pipeline, useCursor=False))
	
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
                                                #logger.info("Path %s",this_path)
						tgt_path.append(this_path)
						tgt_description[this_path]=xp['contrast']+":"+condition.get('label',"")
						break
					else:
						this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)                                                    
                                                #logger.info("Path %s",this_path)
						tgt_path.append(this_path)
						tgt_description[this_path]=condition.get('label',"")
						break

	if len(tgt_path)<1:
		print "nothing found"

	#results=list(measurements_col.find({"xp":{"$in":tgt_path},"logFC":{"$gt":2}},{"_id":0}))
        results=list(measurements_col.find({ "xp":{"$in":tgt_path},"$or": [ { "logFC": { "$gt": 2 } }, { "logFC": { "$lt": -2 } } ] },{"_id":0} ))
       
	


        # annotate results
        
        gene_set=[]

        #reset score to 0
        for r in results:
                if species['full_name']== "Hordeum vulgare":
                    #logger.info("gene id %s for species %s",r['gene'],species) 
                    full_mappings_col.update({"mapping_file.Transcript ID":r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{"$set": {"mapping_file.$.Score": 0 } },multi=True)

                
                elif species['full_name']== "Prunus domestica":
                    full_mappings_col.update({"mapping_file.Protein ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } })


                elif species['full_name']== "Prunus armeniaca":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {"$set": {'mapping_file.$.Score': 0 } })

                elif species['full_name']== "Prunus persica":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$set": {"mapping_file.$.Score": 0 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {"$set": {'mapping_file.$.Score': 0 } })

                elif species['full_name']== "Cucumis melo":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$set": {"mapping_file.$.Score": 1 } })
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {"$set": {'mapping_file.$.Score': 0 } })

                elif species['full_name']== "Arabidopsis thaliana":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{"$set": {"mapping_file.$.Score": 1 } })
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {"$set": {'mapping_file.$.Score': 0 } })

                else:
                    
                    full_mappings_col.update({"$or": {"mapping_file.Gene ID":r['gene']},{"mapping_file.Gene ID 2":r['gene']},"mapping_file.Probe ID":r['gene_original_id']},{"$set": {"mapping_file.$.Score": 0 } })
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {"$set": {'mapping_file.$.Score': 0 } })


        #increment score field when a gen is found        
	for r in results:
                
                if species['full_name']== "Hordeum vulgare":

                    full_mappings_col.update({"mapping_file.Transcript ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Transcript ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })
                
                elif species['full_name']== "Prunus domestica":

                    full_mappings_col.update({"mapping_file.Protein ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Protein ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })

                elif species['full_name']== "Prunus armeniaca":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })

                elif species['full_name']== "Prunus persica":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })

                elif species['full_name']== "Cucumis melo":

                    full_mappings_col.update({"mapping_file.Gene ID":r['gene']},{"$inc": {"mapping_file.$.Score": 1 } },multi=True)
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })

                elif species['full_name']== "Arabidopsis thaliana":
                    logger.info("gene id %s for species %s",r['gene'],species)


                    full_mappings_col.update({'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$inc': {'mapping_file.$.Score': 1 } })
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene']}, {'$inc': {'mapping_file.$.Score': 1 } })

                else:
                    full_mappings_col.update({'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$inc': {'mapping_file.$.Score': 1 } })
                    #db.full_mappings.update_many({'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']}, {'$inc': {'mapping_file.$.Score': 1 } })
                    
                    #uniprot_result=list(full_mappings_col.find({"mapping_file.Gene ID":r['gene']},{"mapping_file.$": 1 } ))
                    #for u in uniprot_result:
                    #    logger.info("uniprot id %s for species %s",u['mapping_file'][0]['Uniprot ID'],species) 
                    #    pv_interactions_col.find({"$or":{{"mapping_file.Gene ID":r['gene']},{"mapping_file.Uniprot ID":u['mapping_file'][0]['Uniprot ID']}}},{})
                        
                
                #r['description']=tgt_description[r['xp']]
                #counter++
        
        #for r in results:
                
        #        if species['full_name']== "Hordeum vulgare":

        #            uniprot_result=full_mappings_col.find({"mapping_file.Transcript ID":r['gene']},{"mapping_file.Uniprot ID": 1 } )
                
        #        elif species['full_name']== "Prunus domestica":
                    
        #            uniprot_result=full_mappings_col.find({"mapping_file.Protein ID":r['gene']},{"mapping_file.Uniprot ID": 1 } )


        #        else:
        #            uniprot_result=full_mappings_col.find({"mapping_file.Gene ID":r['gene']},{"mapping_file.Uniprot ID": 1 } )

        #        cursor_to_table(uniprot_result)
                #r['description']=tgt_description[r['xp']]
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


        #for r in results:
        #    if r['gene'] != 'NA' and r['gene'] != '':
        #        logger.info("gene id %s for species %s",r['gene'],species)

        #        if species['full_name']== "Hordeum vulgare":

        #            tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Transcript ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Transcript ID":r['gene']},{"mapping_file.$": 1 }))

        #        elif species['full_name']== "Prunus domestica":

        #            tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Protein ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Protein ID":r['gene']},{"mapping_file.$": 1 }))

        #        else:
        #            tmp=full_mappings_col.aggregate([ {'$match': {'species':species['full_name']}}, {'$unwind':'$mapping_file'},  {'$match' : {'mapping_file.Gene ID':r['gene']}},    {'$project' : {'mapping_file.Uniprot ID':1,'_id':0}}])

                    #tmp=list(full_mappings_col.find({"mapping_file.Gene ID":r['gene']},{"mapping_file.$": 1 }))



                #for s in tmp:   

        #        logger.info("uniprot id %s",tmp['result'][0]['mapping_file']['Uniprot ID'])
