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

	
	#all_species_names=aliases_for_species_matching({"_id":find_species_doc(species['full_name'])['_id']})
	
				
	#tgt_samples=samples_col.find({"species":{"$in":all_species_names},"experimental_results.conditions.infected":True})
	tgt_samples=samples_col.find({"species":species['full_name'],"experimental_results.conditions.infected":True})


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
        logger.info("species %s",species["full_name"])
        logger.info("preparing score reset")
        #full_mappings_col.update({'species':species["full_name"],'mapping_file.Score':{ "$gt": 0 }},{"$set": {'mapping_file.$.Score': 0 } })
        #full_mappings_col.update({'species':species["full_name"],'mapping_file.Score':{ "$gt": 0 }},{"$set": {'mapping_file.$.Score': 0 } })


        #increment score field when a gen is found  
        logger.info("Scores have been reset")
        logger.info("preparing new scoring step")
	for r in results:
                
            if species['full_name']== "Hordeum vulgare":
                if 'gene_original_id' in r:
                    full_mappings_col.update({'species':"Hordeum vulgare",'mapping_file.Transcript ID':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{"$set": {'mapping_file.$.Score': 0 } })
                    full_mappings_col.update({'species':"Hordeum vulgare",'mapping_file.Transcript ID':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{"$inc": {'mapping_file.$.Score': 1 } })

                else:
                    full_mappings_col.update({'species':"Hordeum vulgare","mapping_file.Transcript ID":r['gene']},{'$set': {'mapping_file.$.Score': 0 } })

                    full_mappings_col.update({'species':"Hordeum vulgare","mapping_file.Transcript ID":r['gene']},{'$inc': {'mapping_file.$.Score': 1 } })
                plaza_results=full_mappings_col.find({'species':"Hordeum vulgare",'mapping_file.Transcript ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

            elif species['full_name']== "Prunus domestica":
                full_mappings_col.update({'species':"Prunus domestica","mapping_file.Protein ID":r['gene']},{'$set': {"mapping_file.$.Score": 0 } })

                full_mappings_col.update({'species':"Prunus domestica","mapping_file.Protein ID":r['gene']},{'$inc': {"mapping_file.$.Score": 1 } })
                plaza_results=full_mappings_col.find({'species':"Prunus domestica",'mapping_file.Protein ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

            elif species['full_name']== "Prunus armeniaca":
                full_mappings_col.update({'species':"Prunus armeniaca","mapping_file.Gene ID":r['gene']},{'$set': {"mapping_file.$.Score": 0 } })

                full_mappings_col.update({'species':"Prunus armeniaca","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score": 1 } })
                plaza_results=full_mappings_col.find({'species':"Prunus armeniaca",'mapping_file.Gene ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

            elif species['full_name']== "Prunus persica":
                full_mappings_col.update({'species':"Prunus persica","mapping_file.Gene ID":r['gene']},{'$set': {"mapping_file.$.Score": 0 } })

                full_mappings_col.update({'species':"Prunus persica","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score": 1 } })
                plaza_results=full_mappings_col.find({'species':"Prunus persica",'mapping_file.Gene ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

            elif species['full_name']== "Cucumis melo":
                logger.info("gene id %s",r['gene'])
                full_mappings_col.update({'species':"Cucumis melo","mapping_file.Gene ID":r['gene']},{'$set': {"mapping_file.$.Score": 0 } })

                full_mappings_col.update({'species':"Cucumis melo","mapping_file.Gene ID":r['gene']},{'$inc': {"mapping_file.$.Score": 1 } })
                logger.info("gene id %s",r['gene'])
                plaza_results=full_mappings_col.find({'species':"Cucumis melo",'mapping_file.Gene ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )
                logger.info("gene id %s",r['gene'])


            elif species['full_name']== "Arabidopsis thaliana":
                #logger.info("gene id %s for probe id %s",r['gene'],r['gene_original_id'])
                full_mappings_col.update({'species':"Arabidopsis thaliana",'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$set': {'mapping_file.$.Score': 0 } })

                full_mappings_col.update({'species':"Arabidopsis thaliana",'mapping_file.Gene ID':r['gene'],'mapping_file.Probe ID':r['gene_original_id']},{'$inc': {'mapping_file.$.Score': 1 } })
                plaza_results=full_mappings_col.find({'species':"Arabidopsis thaliana",'mapping_file.Gene ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

            else:
                if 'gene_original_id' in r:
                    full_mappings_col.update({'species':species["full_name"],'mapping_file.Gene ID 2':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{'$set': {'mapping_file.$.Score': 0 } })

                    full_mappings_col.update({'species':species["full_name"],'mapping_file.Gene ID 2':r['gene'],"mapping_file.Probe ID":r['gene_original_id']},{'$inc': {'mapping_file.$.Score': 1 } })
                    plaza_results=full_mappings_col.find({'species':species["full_name"],'mapping_file.Gene ID 2':r['gene']},{'mapping_file.$.Plaza ID': 1 } )

                else:
                    full_mappings_col.update({'species':species["full_name"],"mapping_file.Gene ID":r['gene']},{'$set': {'mapping_file.$.Score': 0 } })

                    full_mappings_col.update({'species':species["full_name"],"mapping_file.Gene ID":r['gene']},{'$inc': {'mapping_file.$.Score': 1 } })
                    plaza_results=full_mappings_col.find({'species':species["full_name"],'mapping_file.Gene ID':r['gene']},{'mapping_file.$.Plaza ID': 1 } )
        
            for p in plaza_results:
                for values in p['mapping_file']:

                    logger.info("plaza id %s",values['Plaza ID'])
                    plaza_id=values['Plaza ID']

                    #orthologs_list_identifier
                    ortholog_result=orthologs_col.find({'species':species["full_name"],'mapping_file.Plaza gene id':plaza_id},{'mapping_file.$':1,'_id':0});
                    for ortholog in ortholog_result:

                        logger.info("ortholog list %s ",ortholog['mapping_file'][0]['orthologs_list_identifier'])
                        ortholog_list=ortholog['mapping_file'][0]['orthologs_list_identifier']
                        if ortholog_list.find(",") != -1:
                            ortholog_split_list=ortholog_list.split(',')
                            for ortholog_id in ortholog_split_list:
                                if ortholog_id!=plaza_id:
                                    full_mappings_col.update({"mapping_file.Plaza ID":ortholog_id},{"$inc": {'mapping_file.$.Score': 1 } })
                        else:
                            if ortholog_list!=plaza_id:
                                full_mappings_col.update({"mapping_file.Plaza ID":ortholog_list},{"$inc": {'mapping_file.$.Score': 1 } })
        
            
            