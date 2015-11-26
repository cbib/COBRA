# helper functions & setup

```python
import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 
```

# Base queries 

* Find all available datasets

```python



cursor_to_table(samples_col.find({},{"name":1}))
```

	In [107]: cursor_to_table(samples_col.find({},{"name":1}))
	+--------------------------+-------------------------------------------------------+
	|           _id            |                          name                         |
	+--------------------------+-------------------------------------------------------+
	| 54c7a2fb068b850c76d89ea7 |        Transcriptomics of infection of C. melo        |
	| 54c7a2fb068b850c76d89eab | Transcriptomics of infection of P. prunus Jojo by PPV |
	+--------------------------+-------------------------------------------------------+

* Find all available datasets that have not been indexed into the db

```python
list(samples_col.find({"experimental_results":{"$elemMatch":{"values":{"$exists":False}}}}))
```



* Get all species 

```python
cursor_to_table(species_col.find({},{"_id":1,"full_name":1,"taxid":1,"abbrev_name":1,"aliases":1,"classification.top_level":1,"classification.kingdom":1,"classification.order":1}))
```

	+----------------------------------------------------------------------------------+--------+----------------------------+--------------------------+----------------+----------------------------------+
	|                                  classification                                  | taxid  |         full_name          |           _id            |  abbrev_name   |             aliases              |
	+----------------------------------------------------------------------------------+--------+----------------------------+--------------------------+----------------+----------------------------------+
	| {u'kingdom': u'Plantae', u'order': u'Cucurbitales', u'top_level': u'Eukaryotes'} |  3656  |        Cucumis Melo        | 54c7a2fb068b850c76d89ea2 |    C. melo     |   [u'cucumis_melo', u'melon']    |
	|  {u'kingdom': u'Fungi', u'order': u'Sordariales', u'top_level': u'Eukaryotes'}   | 155416 | Monosporascus Cannonballus | 54c7a2fb068b850c76d89ea3 | M. canonballus | [u'monosporascus_cannonballus']  |
	|               {u'order': u'Unassigned', u'top_level': u'viruses'}                |   NA   |   Cucumber mosaic virus    | 54c7a2fb068b850c76d89ea4 |       NA       |             [u'cmv']             |
	|   {u'kingdom': u'Plantae', u'order': u'Rosales', u'top_level': u'Eukaryotes'}    |  3758  |      Prunus Domestica      | 54c7a2fb068b850c76d89ea8 |  P. domestica  | [u'prunus_domestica', u'prunus'] |
	|                            {u'top_level': u'viruses'}                            |   NA   |          Plum pox          | 54c7a2fb068b850c76d89eaa |       NA       |       [u'sharka', u'ppv']        |
	+----------------------------------------------------------------------------------+--------+----------------------------+--------------------------+----------------+----------------------------------+

* Get all viruses

```python
cursor_to_table(species_col.find({"classification.top_level":"viruses"},{"_id":1,"full_name":1,"taxid":1,"abbrev_name":1,"aliases":1,"classification.top_level":1,"classification.kingdom":1,"classification.order":1}))

```

	+--------------------------+-----------------------+-----------------------------------------------------+---------------------+
	|           _id            |       full_name       |                    classification                   |       aliases       |
	+--------------------------+-----------------------+-----------------------------------------------------+---------------------+
	| 54c7a2fb068b850c76d89ea4 | Cucumber mosaic virus | {u'order': u'Unassigned', u'top_level': u'viruses'} |       [u'cmv']      |
	| 54c7a2fb068b850c76d89eaa |        Plum pox       |              {u'top_level': u'viruses'}             | [u'sharka', u'ppv'] |
	+--------------------------+-----------------------+-----------------------------------------------------+---------------------+

* Find all variety of the melon for which we have xp data 

```python

all_melon_names=aliases_for_species_matching({"_id":find_species_doc("melon")['_id']})

cursor_to_table(samples_col.find({"species":{"$in":list(all_melon_names)}},{"experimental_results.variety":1}))
```

	+--------------------------+----------------------------------------------------------------------------+
	|           _id            |                            experimental_results                            |
	+--------------------------+----------------------------------------------------------------------------+
	| 54c7abc9068b850c76d89eb1 | [{u'variety': u'T-111'}, {u'variety': u'pat81'}, {u'variety': u'Tendral'}] |
	+--------------------------+----------------------------------------------------------------------------+

* Find all angiosperms

```python
cursor_to_table(species_col.find({"classification.unranked":"Angiosperms"},{"full_name":1}))
```

* Find all pathogens experimentally infecting any angiosperm

```python

# get all aliases 
angiosperms_names=aliases_for_species_matching({"classification.unranked":"Angiosperms"})


foo=list(samples_col.find({"species":{"$in":list(angiosperms_names)},"experimental_results.conditions.infected":True}))

all_agents=[]
for xp in foo:
	for xp_results in xp['experimental_results']:
		for condition in xp_results['conditions']:
			if isinstance(condition,type({})) and condition.get("infected",False):
				all_agents.append(
					{"agent":condition.get("infection_agent","None"),
					"species":xp['species'],
					"name":xp['name']})
				break

# equivalent a 
cursor_to_table(
	samples_col.aggregate([
	{"$match":{"species":{"$in":list(angiosperms_names)},"experimental_results.conditions.infected":True}},
	{"$unwind":"$experimental_results"},
	{"$project":{"species":1,"name":1,"experimental_results.conditions":1,"_id":0}},
	{"$unwind":"$experimental_results.conditions"},
	{"$match":{"experimental_results.conditions.infected":True}},
	{"$project":{"species":1,"name":1,"agent":"$experimental_results.conditions.infection_agent"}}
	])['result'])

```

* Find all genes up-regulated in the melon when infected with CMV

```python
all_melon_names=aliases_for_species_matching({"_id":find_species_doc("melon")['_id']})
all_cmv_names=aliases_for_species_matching({"_id":find_species_doc("cmv")['_id']})


cursor_to_table(samples_col.aggregate([
	{"$match":{"species":{"$in":all_melon_names},"experimental_results.conditions.infection_agent":{"$in":all_cmv_names}}},
	{"$unwind":"$experimental_results"},
	{"$match":{"species":{"$in":all_melon_names},"experimental_results.conditions.infection_agent":{"$in":all_cmv_names}}},
	{"$unwind":"$experimental_results.values"},
	{"$match":{"experimental_results.values.fold_change":{"$gt":10}}},
	{"$project":{"_id":0,"infection_agent":"$experimental_results.conditions.infection_agent","name":1,"src_pub":1,"contrast":"$experimental_results.contrast","id":"$experimental_results.values.est_unigen","FC":"$experimental_results.values.fold_change"}}
	])['result'])

```

Using the flattened data table 

```python
tgt_samples=samples_col.find({"species":{"$in":all_melon_names},"experimental_results.conditions.infection_agent":{"$in":all_cmv_names}})

# browse the doc and gather the path of the tgt xp 

tgt_path=[]
tgt_description={}
for a_sample in tgt_samples:
	for i,xp in enumerate(a_sample['experimental_results']):
		for j,condition in enumerate(xp['conditions']):
			if "infection_agent" in condition and condition['infection_agent'] in all_cmv_names:
				this_path=str(a_sample['_id'])+"."+"experimental_results."+str(i)
				tgt_path.append(this_path)
				tgt_description[this_path]=xp['contrast']+":"+condition.get('label',"")
				break

if len(tgt_path)<1:
	print "nothing found"

results=list(measurements_col.find({"xp":{"$in":tgt_path},"logFC":{"$gt":4}},{"_id":0}))
# annotate results
for r in results:
	r['description']=tgt_description[r['xp']]
cursor_to_table(results)
```

* Find all contrasts where a given gene is up-regulated


```python

#sub_doc = {"experimental_results.values":{"$elemMatch":{"est_unigen":"cCI_23-A07-M13R_c","fold_change":{"$gt":10}}}}
#foo=cursor_to_table(samples_col.find(,{"name":1,"experimental_results.contrast":1}))

#cursor_to_table(samples_col.find({"experimental_results.values.fold_change.est_unigen":"cCL2371Contig1","experimental_results.values.fold_change":{"$gt":5}},{"name":1}))


# with aggregation 

foo=samples_col.aggregate([
	# first match to ensure index usage to select the doc 
	{"$match":{"experimental_results.values.est_unigen":"cCI_23-A07-M13R_c","experimental_results.values.fold_change":{"$gt":10}}}
	,{"$unwind":"$experimental_results"}
	,{"$unwind":"$experimental_results.values"}
	# select nested document from the flattened doc 
	,{"$match":{"experimental_results.values.est_unigen":"cCI_23-A07-M13R_c","experimental_results.values.fold_change":{"$gt":10}}}
	,{"$project":{"xp_name":"$name","contrast":"$experimental_results.contrast","xp":"$experimental_results.conditions.label","est_unigen":"$experimental_results.values.est_unigen","FC":"$experimental_results.values.fold_change"}}
	,{"$unwind":"$xp"}
	])

```


Using the flattened result table 

```python
tgt_gene="MU46700"
possible_species_aliases=get_possible_aliases("melon")

all_results=[]
all_xp=[r['xp'] for r in measurements_col.find({"gene":tgt_gene,"type":"contrast","logFC":{"$gt":4}},{"xp":1,"_id":0})]
#xp=all_xp[0]
for xp in all_xp:
	path=xp.split(".")
	oid=path[0]
	this_xp=samples_col.find_one({"_id":ObjectId(oid),"species":{"$in":possible_species_aliases}})
	if not this_xp:
		continue
	for path_c in path[1:]:
		if path_c.isdigit():
			path_c=int(path_c)
		print path_c
		this_xp=this_xp[path_c]
	del this_xp['values']
	all_results.append(this_xp)

```
**TODO** Check how much will this scale. Any estimate on the number of exp we will track ? 


**TODO** Build a measurement collection, collecting all measurements from all experiments in a flat array, indexed with unified gene id, to retrieve specific measurements. Update this table after each insertion. 

**TODO** Add full text indexing by adding a _txt_ field to each document from each collection
 
**TODO** Function to quickly get species by text search 
**TODO** Check whether we need a slug 


* Find all documents with a wikipedia link

* Find all documents with a wikipedia link that have not been donwloaded 

* Find all articles 

* Find all articles that have not been indexed 

* Check that all conditions with infections are linked to a virus

* Search using aliases 

* Free text search in all document fields (including linked text such as wikipedia page, article abstract etc.)

* Find all available mapping

* Guess type of ID used in a data file
* Detect cross links
* Interactomic
* Make page for units: (statistics & links)
	* Virus
	* Plant
	* Experiment
	* Mappings
	* Publications



# next sprint

* Find orthologous genes 
* Find experimental data linked with a publication found by free text search
* Transcription factor
* Get an issue tracker for data set interpretation. E.g. :
	* for [C. melo infection](#Transcriptomics of infection of C. melo), the values are "fold change" or "log(fold change)?"


