import os
import pymongo
import collections
from pymongo import MongoClient
from bson.objectid import ObjectId
import gridfs

client = MongoClient()
db = client.cobra_db
species_col = db.species
mappings_col = db.mappings
full_mappings_col=db.full_mappings
publications_col= db.publications
samples_col=db.samples
measurements_col=db.measurements
pv_interactions_col=db.pv_interactions
pp_interactions_col=db.pp_interactions
viruses_col=db.viruses
orthologs_col=db.orthologs
gene_ontology_col=db.gene_ontology
users_col=db.users
sequences_col=db.sequences
variations_col=db.variations

#fs = gridfs.GridFS(db)
