#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import sys
import os
import subprocess

sys.path.append("../../backend")
sys.path.append(".")




#from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
__author__ = "benjamindartigues"
__date__ = "$Jun 30, 2016 4:22:48 PM$"

if __name__ == "__main__":
    print "Hello World";
    xps=db.measurements.distinct('xp')
    #os.remove('/data/hypergeom_R_results/result.txt')
    for xp in xps:

        array_to_process=db.measurements.aggregate([
            {'$match': {"xp" : xp}},
            {'$group' : {'_id' : '$species', 'xp_data':{'$addToSet':{'gene':"$gene","logFC":"$logFC"}}}}
        ]);
    #    array_to_process=db.measurements.aggregate([
    #        {'$match': {"type" : "contrast"}},
    #        {'$group' : {'_id' : '$xp', 'xp_id':{'$addToSet':{'type':"$type","assay_type":"$assay_type","species":"$species"}}}}
    #    ]);
        for array in array_to_process:

            xp_id=xp 
            species=array['_id']
            total_genes_for_species=db.full_mappings.distinct("mapping_file.Gene ID",{'species':species});

            print species
            data_array=array['xp_data']
            #print "xp id: "+xp_id
            genelist=[]
            for data in data_array:
                #type=data['type']
                #assay_type=data['assay_type']

                gene=data['gene']
                logFC=data['logFC']
                if logFC > 2 or logFC < -2:
                    genelist.append(gene)

            #get size of differentially expressed genes list 
            total_de_genes=len(genelist)