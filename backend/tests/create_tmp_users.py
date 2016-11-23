#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
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
userlist=['1','2','3','4','5','6','7','8','9','10']


for name in userlist:
	characters = string.ascii_letters  + string.digits
	parser = HTMLParser()
	characters = parser.unescape(characters)
	password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
	print 'user'+name + "password :" + password_gen
	password=hashlib.md5(password_gen).hexdigest()
	#users_col.update({'firstname':name},{"$set":{'pwd':password}})
        login="user"+name
        users_table={
            'login':login,
            'pwd': password,
            'firstname':'User',
            'lastname' : name,
            'email_adress':'cobra@bordeaux.fr',
            'institution':'Cobra',
            'grade':'tmp_user'
	
        }
        users_col.insert(users_table)

    
