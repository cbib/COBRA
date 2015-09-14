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
print "plambert password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'plambert',
	'pwd': password,
	'firstname':'Lambert',
	'lastname' : 'Patrick',
	'email_adress':'patrick.lambert@avignon.inra.fr',
	'institution':'INRA',
	'grade':'administrator'
	
}
users_col.insert(users_table)