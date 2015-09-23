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


# Script supposed to be run in the background to populate the DB with available datasets 
## Setup

from numbers import Number
import collections
from math import log
if "log" not in globals():
  logger = Logger.init_logger('DATA_PROCESSOR_%s'%(cfg.language_code), load_config())

logger.info("Running %s",sys.argv[0])

# Get available gene_ontology and insert them in the DB 

# a_sample=samples_col.find_one({"experimental_results.values":{"$exists":False}})

GO_to_process=gene_ontology_col.find({"GO_collections":{"$exists":False}})
logger.info("Found %d gene_ontology to process",GO_to_process.count())

for go_doc in GO_to_process:
	file= data_dir+go_doc['data_file']

	termCounter = 0
	#go_list = collections.defaultdict(list)
	for goTerm in parseGOOBO(file):
		termCounter += 1
		if 'is_obsolete' not in goTerm.keys():
			gene_ontology_col.update({"_id":go_doc['_id']},{"$push":{"GO_collections":{'_id':termCounter,'id':goTerm['id'],'name':goTerm['name'],'namespace':goTerm['namespace']}}})
			#gene_ontology_col.update({"_id":go_doc['_id']},{"$set":{"GO_collections.$.values":parsed_data}})
			if termCounter % 1000==0 :
				#print "go id %s" % goTerm['namespace']
				print "Found %d GO terms" % termCounter
		#else:
			#print 'obsolete term'
	#gene_ontology_col.update({"_id":go_doc['_id']},{"$set":{"GO_collections.$.values":parseGOOBO(file).items()}})
	
        #db.gene_ontology.createIndex({GO_collections:1})

        logger.info("Indexation on field \"GO_collections.id\" from collection \"gene_ontology\"")

        gene_ontology_col.create_index("GO_collections.id",sparse=True)
