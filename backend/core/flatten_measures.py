#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 


#measurements_col.remove()

# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
  logger = Logger.init_logger('FLATTEN_%s'%(cfg.language_code), load_config())
logger.info("Running %s",sys.argv[0])



logger.info("Flattening and normalizing experimental results")
already_existing_xp=measurements_col.distinct("xp")
#add "state":"processed" exist false requirements
#samples_with_results=samples_col.find({"experimental_results":{"$elemMatch":{"values":{"$exists":True}}}})
samples_with_results=samples_col.find({'$and': [{"state":{"$exists":False}},{"experimental_results":{"$elemMatch":{"values":{"$exists":True}}}}]})
# a_sample=samples_with_results[0]
n_op=0
measurements_to_insert=measurements_col.initialize_unordered_bulk_op()
for a_sample in samples_with_results:
	# i,experimental_results=enumerate(a_sample['experimental_results']).next()
        assay=a_sample['assay']
        name=a_sample['name']
	for i,experimental_results in enumerate(a_sample['experimental_results']):
		this_path=str(a_sample['_id'])+".experimental_results."+str(i)
		if this_path in already_existing_xp:
			continue
		logger.info("Having %d insertions to make",n_op)
		logger.info("normalizing sample %s (%s/%s)",this_path,a_sample['name'],os.path.split(experimental_results['data_file'])[-1])
		
		
		conditions=experimental_results.get('conditions',{})
                
                
                
		if(not isinstance(conditions[1], (str, unicode))):
			infection_agent=conditions[1].get('infection_agent',{})
		else:
			infection_agent=conditions[1]
                        
                        
                if isinstance(conditions[0], dict):
                    first_condition_type=conditions[0].get('type',{})

                else:
                    first_condition_type=conditions[0]
                if isinstance(conditions[1], dict):
                    second_condition_type=conditions[1].get('type',{})
                else:
                    second_condition_type=conditions[1]



                

                #logger.info("conditions %s",infection_agent)
		# get mapping to apply 
		parser_config=experimental_results.get('xls_parsing',{})
		
		parser_config.update(a_sample.get('xls_parsing',{}))
		# genome config 
		this_genome=find_species_doc(a_sample['species'])
		#logger.info("species = %s",this_genome['full_name'])
		id_col=parser_config['id_type']
		this_mapping=get_mapping(id_col,this_genome['preferred_id'],this_genome['full_name'])
		#logger.info("mapping length %d",len(this_mapping))
		
		#if this_genome['full_name']=="Prunus domestica":	
		#logger.info("10005 = %s",this_mapping.keys())
		if this_mapping==None:
			logger.critical("Cannot perform ID conversion")
			continue
		for measure in experimental_results['values']:
			#logger.info("new measure %s",measure[id_col])

			for tgt_id in robust_id_mapping(measure[id_col],this_mapping):
				#logger.info("tgt_id %s",tgt_id)
				#logger.info("Tgid = %s",tgt_id)
				this_doc={"xp":this_path}
				if experimental_results['type']=="contrast":
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                        #here we need to add checkfelimiter condition
#                                        if measure[id_col].find(",") != -1:
#                                            print "found a comma, preparing to split"
#                                            split_list=measure[id_col].split(',')
#                                            for id in split_list:
					this_doc['type']="contrast"
					this_doc['gene']=tgt_id
                                        this_doc['name']=name
                                        this_doc['assay_type']=assay['type']
					this_doc['infection_agent']=infection_agent
                                        this_doc['first_condition']=first_condition_type
                                        this_doc['second_condition']=second_condition_type
					this_doc['gene_original_id']=measure[id_col]
                                        this_doc['species']=this_genome['full_name']
                                        if assay['type']=="micro-array":
                                        
                                            if experimental_results['day_after_inoculation']!="" and experimental_results['day_after_inoculation']!="NA":
                                                this_doc['day_after_inoculation']=experimental_results['day_after_inoculation']
                                            if experimental_results['variety']!="" and experimental_results['variety']!="NA":
                                                this_doc['variety']=experimental_results['variety']
                                            if experimental_results['material']!="" and experimental_results['material']!="NA":
                                                this_doc['material']=experimental_results['material']

					
			
                                            
                                        #logger.info("Tgid = %s name %s logFC %s",tgt_id,name,measure.get("logFC",None))
					
					if measure.get("logFC",None)!=None and measure.get("logFC",None)!="NA":
                                            this_doc['logFC']=float(measure.get("logFC",None))
                                        else:
                                            this_doc['logFC']=measure.get("logFC",None)
					
					if not this_doc['logFC']:
						
						try:
							this_doc['logFC']=log(measure.get("fold_change",None),2)
                                                        this_doc['direction']="up" if this_doc['logFC']>=0 else "down"
					
                                                        measurements_to_insert.insert(this_doc)
                                                        n_op+=1
						except TypeError:
							logger.critical("Error calculating logFC")
							continue
					elif this_doc['logFC']=="NA":
						logger.critical("Error calculating logFC")
						continue
					else:	
						
						this_doc['FDR']=measure.get("FDR",None)
                                                this_doc['direction']="up" if this_doc['logFC']>=0 else "down"
					
                                                measurements_to_insert.insert(this_doc)
                                                n_op+=1
				else:
					logger.critical("Experiment type %s not handled yet",experimental_results['type'])
					continue
				#measurements_to_insert.insert(this_doc)
				#n_op+=1
				if n_op>=10000:
					res=measurements_to_insert.execute()
					logger.info("Inserted %s documents",res)
					measurements_to_insert=measurements_col.initialize_unordered_bulk_op()
					n_op=0
if n_op>0:
	res=measurements_to_insert.execute()
	logger.info("Inserted %s documents",res)
rem=measurements_col.remove({'$or':[{'gene':"NA"},{'gene':""}]})
logger.info("Removed %s documents",rem)