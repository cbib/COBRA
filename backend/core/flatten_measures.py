#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 


# Script supposed to be run in the background to populate the DB with available datasets 
if "log" not in globals():
  logger = Logger.init_logger('FLATTEN_%s'%(cfg.language_code), load_config())



logger.info("Running %s",sys.argv[0])



logger.info("Flattening and normalizing experimental results")
already_existing_xp=measurements_col.distinct("xp")
samples_with_results=samples_col.find({"experimental_results":{"$elemMatch":{"values":{"$exists":True}}}})
# a_sample=samples_with_results[0]
n_op=0
measurements_to_insert=measurements_col.initialize_unordered_bulk_op()
for a_sample in samples_with_results:
	# i,experimental_results=enumerate(a_sample['experimental_results']).next()
	for i,experimental_results in enumerate(a_sample['experimental_results']):
		this_path=str(a_sample['_id'])+".experimental_results."+str(i)
		if this_path in already_existing_xp:
			continue
		logger.info("Having %d insertions to make",n_op)
		logger.info("normalizing sample %s (%s/%s)",this_path,a_sample['name'],os.path.split(experimental_results['data_file'])[-1])
		
		# get mapping to apply 
		parser_config=experimental_results.get('xls_parsing',{})
		parser_config.update(a_sample.get('xls_parsing',{}))
		# genome config 
		this_genome=find_species_doc(a_sample['species'])
		id_col=parser_config['id_type']

		this_mapping=get_mapping(id_col,this_genome['preferred_id'])
		if this_mapping==None:
			logger.critical("Cannot perform ID conversion")
			continue
		for measure in experimental_results['values']:
			for tgt_id in robust_id_mapping(measure[id_col],this_mapping):
				this_doc={"xp":this_path}
				if experimental_results['type']=="contrast":
					this_doc['type']="contrast"
					this_doc['gene']=tgt_id
					this_doc['gene_original_id']=measure[id_col]
					this_doc['logFC']=measure.get("logFC",None)
					if not this_doc['logFC']:
						try:
							this_doc['logFC']=log(measure.get("fold_change",None),2)
						except TypeError:
							logger.critical("Error calculating logFC")
							continue
					this_doc['FDR']=measure.get("FDR",None)
					this_doc['direction']="up" if this_doc['logFC']>=0 else "down"
				else:
					logger.critical("Experiment type %s not handled yet",experimental_results['type'])
					continue
				measurements_to_insert.insert(this_doc)
				n_op+=1
				if n_op>=10000:
					res=measurements_to_insert.execute()
					logger.info("Inserted %s documents",res)
					measurements_to_insert=measurements_col.initialize_unordered_bulk_op()
					n_op=0
if n_op>0:
	res=measurements_to_insert.execute()
	logger.info("Inserted %s documents",res)
