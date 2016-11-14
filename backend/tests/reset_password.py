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
#characters = string.ascii_letters + string.punctuation  + string.digits
userlist=['Gallois','Aranda','Roch','Stein','Garcia','Decroocq','German-Retana','Walter','Schurdi-Levraud']


for name in userlist:
	characters = string.ascii_letters  + string.digits
	parser = HTMLParser()
	characters = parser.unescape(characters)
	password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
	print name + "password :" + password_gen
	password=hashlib.md5(password_gen).hexdigest()
	users_col.update({'firstname':name},{"$set":{'pwd':password}})
