#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
import string
from random import *

# Script 
import datetime
if "log" not in globals():
  log = Logger.init_logger('SAMPLE_DATA_%s'%(cfg.language_code), load_config())

# clear db 

gene_ontology_col.drop()

# for grid_out in fs.find({}, timeout=False):
# 	
# 	fs.delete(grid_out._id)


##Mapping PRunus Domestica


mapping_table={
	"data_file":"gene_ontology/obo/gene_ontology.obo",
	"type":"rdf/XML",
	"url":"",
	"doi":"",	
}
gene_ontology_col.insert(mapping_table)