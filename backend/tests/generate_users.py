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

# clear users_collection 
users_col.remove()


#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits

print characters
parser = HTMLParser()
characters = parser.unescape(characters)
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "bdartigues password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'bdartigues',
	'pwd': password,
	'firstname':'Dartigues',
	'lastname' : 'Benjamin',
	'email_adress':'benjamin.dartigues@u-bordeaux.fr',
	'institution':'CBIB',
	'grade':'super_administrator'
	
}
users_col.insert(users_table)

#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "mnikolski password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'mnikolski',
	'pwd': password,
	'firstname':'Nikolski',
	'lastname' : 'Macha',
	'email_adress':'',
	'institution':'CBIB',
	'grade':'administrator'
	
}
users_col.insert(users_table)


#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "agroppi password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'agroppi',
	'pwd': password,
	'firstname':'Groppi',
	'lastname' : 'Alexis',
	'email_adress':'',
	'institution':'CBIB',
	'grade':'administrator'
	
}
users_col.insert(users_table)


#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "vdecroocq password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'vdecroocq',
	'pwd': password,
	'firstname':'Decroocq',
	'lastname' : 'Veronique',
	'email_adress':'',
	'institution':'INRA Villenave d\'Ornon',
	'grade':'administrator'
	
}
users_col.insert(users_table)


#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "sgerman_retana password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'sgerman_retana',
	'pwd': password,
	'firstname':'German Retana',
	'lastname' : 'Sylvie',
	'email_adress':'',
	'institution':'INRA Villenave d\'Ornon',
	'grade':'administrator'
	
}
users_col.insert(users_table)


#characters = string.ascii_letters + string.punctuation  + string.digits
characters = string.ascii_letters  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "jwalter password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'jwalter',
	'pwd': password,
	'firstname':'Walter',
	'lastname' : 'Jocelyne',
	'email_adress':'',
	'institution':'INRA Villenave d\'Ornon',
	'grade':'administrator'
	
}
users_col.insert(users_table)


characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "vschurdi_levraud password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'vschurdi_levraud',
	'pwd': password,
	'firstname':'Schurdi-Levraud',
	'lastname' : 'Valérie',
	'email_adress':'',
	'institution':'INRA Villenave d\'Ornon',
	'grade':'administrator'
	
}
users_col.insert(users_table)



characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "jlgallois :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'jlgallois',
	'pwd': password,
	'firstname':'Gallois',
	'lastname' : 'Jean Luc',
	'email_adress':'',
	'institution':'INRA Avignon',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "jmaudergeon password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'jmaudergeon',
	'pwd': password,
	'firstname':'Audergeon',
	'lastname' : 'Jean Marc',
	'email_adress':'',
	'institution':'INRA Avignon',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "brodamillans password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'brodamilans',
	'pwd': password,
	'firstname':'Rodamilans',
	'lastname' : 'Bernardo',
	'email_adress':'',
	'institution':'CSIC',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "jagarcia password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'jagarcia',
	'pwd': password,
	'firstname':'Garcia',
	'lastname' : 'Juan Antonio',
	'email_adress':'',
	'institution':'CNB CSIC',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "maaranda password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'maaranda',
	'pwd': password,
	'firstname':'Aranda',
	'lastname' : 'Miguel A.',
	'email_adress':'',
	'institution':'CEBAS CSIC',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "jaguero password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'jaguero',
	'pwd': password,
	'firstname':'Aguero',
	'lastname' : 'Jesus',
	'email_adress':'',
	'institution':'Abiopep',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "amendez password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'amendez',
	'pwd': password,
	'firstname':'Mendez',
	'lastname' : 'Antonio',
	'email_adress':'',
	'institution':'Abiopep',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "nstein password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'nstein',
	'pwd': password,
	'firstname':'Stein',
	'lastname' : 'Nils',
	'email_adress':'',
	'institution':'IPK',
	'grade':'administrator'
	
}
users_col.insert(users_table)




characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "leichel password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'leichel',
	'pwd': password,
	'firstname':'Eichel',
	'lastname' : 'Lisa',
	'email_adress':'',
	'institution':'IPK',
	'grade':'administrator'
	
}
users_col.insert(users_table)

characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "fordon password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'fordon',
	'pwd': password,
	'firstname':'Ordon',
	'lastname' : 'Franck',
	'email_adress':'',
	'institution':'JKI',
	'grade':'administrator'
	
}
users_col.insert(users_table)


characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "sfarber password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'sfarber',
	'pwd': password,
	'firstname':'Färber',
	'lastname' : 'Sarah',
	'email_adress':'',
	'institution':'JKI',
	'grade':'administrator'
	
}
users_col.insert(users_table)

characters = string.ascii_letters + string.punctuation  + string.digits
password_gen =  "".join(choice(characters) for x in range(randint(8, 16)))
print "dperovic password :" + password_gen
password=hashlib.md5(password_gen).hexdigest()

users_table={
	'login':'dperovic',
	'pwd': password,
	'firstname':'Perovic',
	'lastname' : 'Dragan',
	'email_adress':'',
	'institution':'JKI',
	'grade':'administrator'
	
}
users_col.insert(users_table)



