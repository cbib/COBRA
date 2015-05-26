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
publications_col= db.publications
samples_col=db.samples
measurements_col=db.measurements
interactions_col=db.interactions
viruses_col=db.viruses
orthologs_col=db.orthologs
fs = gridfs.GridFS(db)
