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
interactions_col=db.interactions
viruses_col=db.viruses
orthologs_col=db.orthologs
gene_ontology_col=db.gene_ontology
users_col=db.users
sequences_col=db.sequences

fs = gridfs.GridFS(db)
