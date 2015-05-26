#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
from helpers import * 
from config import *

# Script supposed to be run in the background to populate the DB with available datasets 




## Setup
import logging 

from math import log

species_col.remove()
publications_col.remove()
samples_col.remove()
mappings_col.remove()
measurements_col.remove()
interactions_col.remove()
viruses_col.remove()
orthologs_col.remove()
#orthologs_col.files.drop()
#orthologs_col.chunks.drop()

#orthologs_col.gridfs.drop()
#db.drop_collection('orthologs_col')
 