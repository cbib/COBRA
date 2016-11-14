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
from HTMLParser import HTMLParser

# Script 
import datetime
if "log" not in globals():
  log = Logger.init_logger('SAMPLE_DATA_%s'%(cfg.language_code), load_config())


parser = HTMLParser()
characters = string.ascii_letters  + string.digits
characters = parser.unescape(characters)
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "ghost password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'ghost',
	'pwd': password,
	'firstname':'Ghost',
	'lastname' : 'User',
	'email_adress':'ghost@bordeaux.fr',
	'institution':'Castle',
	'grade':'super-debugger'
	
}
users_col.insert(users_table)

#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "mnikolski password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'mnikolski',
#	'pwd': password,
#	'firstname':'Nikolski',
#	'lastname' : 'Macha',
#	'email_adress':'macha@labri.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "dbenaben password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'dbenaben',
#	'pwd': password,
#	'firstname':'Benaben',
#	'lastname' : 'David',
#	'email_adress':'david.benaben@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "fgilbert password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'fgilbert',
#	'pwd': password,
#	'firstname':'Gilbert',
#	'lastname' : 'Florian',
#	'email_adress':'',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "edarbo password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'edarbo',
#	'pwd': password,
#	'firstname':'Darbo',
#	'lastname' : 'Elodie',
#	'email_adress':'elodie.darbo@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "qschaeverbeke password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'qschaeverbeke',
#	'pwd': password,
#	'firstname':'Schaeverbeke',
#	'lastname' : 'Quentin',
#	'email_adress':'',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "esevin password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'esevin',
#	'pwd': password,
#	'firstname':'Sevin',
#	'lastname' : 'Emeric',
#	'email_adress':'emeric.sevin@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "ruricaru password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'ruricaru',
#	'pwd': password,
#	'firstname':'Uricaru',
#	'lastname' : 'Raluca',
#	'email_adress':'ruricaru@labri.fr',
#	'institution':'LaBri',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "ebouilhol password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'ebouilhol',
#	'pwd': password,
#	'firstname':'Bouilhol',
#	'lastname' : 'Emmanuel',
#	'email_adress':'emmanuel.bouilhol@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "jrudewicz password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'jrudewicz',
#	'pwd': password,
#	'firstname':'Rudewicz',
#	'lastname' : 'Justine',
#	'email_adress':'j.rudewicz@bordeaux.unicancer.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "abarre password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'abarre',
#	'pwd': password,
#	'firstname':'Barré',
#	'lastname' : 'Aurélien',
#	'email_adress':'aurelien.barre@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
#
#characters = string.ascii_letters  + string.digits
#characters = parser.unescape(characters)
#password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
#print "mgasparoux password :" + password_gen
#password=hashlib.md5(password_gen).hexdigest()
#
#users_table={
#	'login':'mgasparoux',
#	'pwd': password,
#	'firstname':'Gasparoux',
#	'lastname' : 'Marie',
#	'email_adress':'marie.gasparoux@u-bordeaux.fr',
#	'institution':'CBIB',
#	'grade':'administrator'
#	
#}
#users_col.insert(users_table)
