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

species_col.remove()


##### Species 

###################################################################################################################
############################################ CUCUMIS MELO #####################################################
###################################################################################################################

melon={
	"full_name":"Cucumis melo",
	"abbrev_name":"C. melo",
	"aliases":["cucumis_melo","melon"],
	"taxid":3656, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=3656
	"wikipedia":"http://en.wikipedia.org/wiki/Muskmelon",
	"preferred_id":"Gene", #http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=MU60682&searchtype=unigene&organism=melon

	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked": ["Angiosperms","Eudicots","Rosids"],
		"order":	"Cucurbitales",
		"family":	"Cucurbitaceae",
		"genus":	"Cucumis",
		"species":	"C. melo",
	}
}
species_col.insert(melon)


###################################################################################################################
############################################ ORIZA SATIVA #####################################################
###################################################################################################################

#rice={
#	"full_name":"Oriza sativa Japonica",
#	"abbrev_name":"O. sativa",
#	"aliases":["oriza_sativa","rice","Japanese rice"],
#	"taxid":3656, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=39947
#	"wikipedia":"",
#	"preferred_id":"", #http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=MU60682&searchtype=unigene&organism=melon
#
#	"classification":{
#		"top_level":"Eukaryotes",
#		"kingdom":	"Plantae",
#		"unranked": ["Angiosperms","Eudicots","commelinids"],
#		"order":	"Poales",
#		"family":	"Poaceae",
#		"genus":	"Oriza",
#		"species":	"O. sativa",
#	}
#}
#species_col.insert(melon)

###################################################################################################################
############################################ PRUNUS DOMESTICA #####################################################
###################################################################################################################

prunus={
	"full_name":"Prunus domestica",
	"abbrev_name":"P. domestica",
	"aliases":["prunus_domestica","prunus"],
	"taxid":3758, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=3656
	"wikipedia":"http://en.wikipedia.org/wiki/Prunus_domestica",
	"preferred_id":"Protein",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked":	["Angiosperms","Eudicots","Rosids"],
		"order":	"Rosales",
		"family":	"Rosaceae",
		"genus":	"Prunus",
		"subgenus":	"Prunus",
		"section":	"Prunus",
		"species":	"P. domestica",
	}
}
species_col.insert(prunus)
###################################################################################################################
############################################ PRUNUS PERSICA #####################################################
###################################################################################################################

peach={
	"full_name":"Prunus persica",
	"abbrev_name":"P. persica",
	"aliases":["prunus_persica","peach"],
	"taxid":3760, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=3760
	"wikipedia":"https://en.wikipedia.org/wiki/Peach",
	"preferred_id":"Protein",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked":	["Angiosperms","Eudicots","Rosids"],
		"order":	"Rosales",
		"family":	"Rosaceae",
		"genus":	"Prunus",
		"subgenus":	"Amygdalus",
		"section":	"Prunus",
		"species":	"P. persica",
	}
}
species_col.insert(peach)


###################################################################################################################
############################################ PRUNUS ARMENIACA #####################################################
###################################################################################################################

apricot={
	"full_name":"Prunus armeniaca",
	"abbrev_name":"P. armeniaca",
	"aliases":["prunus_armeniaca","apricot"],
	"taxid":36596, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=36596
	"wikipedia":"https://en.wikipedia.org/wiki/Apricot",
	"preferred_id":"Gene",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked":	["Angiosperms","Eudicots","Rosids"],
		"order":	"Rosales",
		"family":	"Rosaceae",
		"genus":	"Prunus",
		"species":	"P. armeniaca",
	}
}
species_col.insert(apricot)


###################################################################################################################
############################################ ARABIDOPSIS THALIANA #####################################################
###################################################################################################################

arabidopsis_thaliana={
	"full_name":"Arabidopsis thaliana",
	"abbrev_name":"A. Thaliana",
	"aliases":["thale cress", "mouse-ear cress","arabidopsis"],
	"taxid":3702, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=4081
	"wikipedia":"http://en.wikipedia.org/wiki/Arabidopsis_thaliana",
	"preferred_id":"Gene",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked": ["Angiosperms","Eudicots","Rosids"],
		"order":	"Brassicales",
		"family":	"Brassicaceae",
		"genus":	"Arabidopsis",
		"species":	"A. Thaliana",
	}
}
species_col.insert(arabidopsis_thaliana)

###################################################################################################################
############################################ SOLANUM LYCOPERSICUM #####################################################
###################################################################################################################

tomato={
	"full_name":"Solanum lycopersicum",
	"abbrev_name":"S. Lycopersicum",
	"aliases":["Lycopersicon lycopersicum","Solanum lycopersicum L.","tomato"],
	"taxid":4081, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=4081
	"wikipedia":"http://en.wikipedia.org/wiki/Tomato",
	"preferred_id":"Gene",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked": ["Angiosperms","Eudicots","Asterids"],
		"order":	"Solanales",
		"family":	"Solanaceae",
		"genus":	"Solanum",
		"species":	"S. Lycopersicum",
	}
}
species_col.insert(tomato)

###################################################################################################################
############################################ HORDEUM VULGARE #####################################################
###################################################################################################################

barley={
	"full_name":"Hordeum vulgare",
	"abbrev_name":"H. vulgare",
	"aliases":["hordeum_vulgare","barley"],
	"taxid":4513, # taxURL: https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=4513
	"wikipedia":"http://en.wikipedia.org/wiki/Barley",
	"preferred_id":"Transcript",
	"classification":{
		"top_level":"Eukaryotes",
		"kingdom":	"Plantae",
		"unranked": ["Angiosperms","Monocots","Commelinids"],
		"order":	"Poales",
		"family":	"Poaceae",
		"genus":	"Pooideae",
		"species":	"H. vulgare",
	}
}
species_col.insert(barley)