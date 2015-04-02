#!/usr/bin/env python
# encoding: utf-8

import sys
sys.path.append("..")
sys.path.append(".")
from config import *
from helpers.basics import load_config
from helpers.logger import Logger
from helpers.db_helpers import * 


## Script specific 
import sys
import logging 
import collections
import datetime

if "log" not in globals():
  log = Logger.init_logger('STATS_%s'%(cfg.language_code), load_config())







def main():
	# mongodb stats can be obtained with cfg.db.command("collstats","dict")
	db_stats={
		'A/ report_date':datetime.datetime.now(),
		'B/ Number of samples':samples_col.count(),
		'C/ Number of normalized measures':measurements_col.count(),
		'C_a/ Tally of normalized measures':measurements_col.aggregate([{"$group":{"_id":"$type", "count": { "$sum": 1 }}}])['result'],
		'D/ Number of species':species_col.count(),
		'D_a/ Number of species per top_level':species_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result'],
		'D_b/ Number of viruses per top_level':viruses_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result']

	    }


	logger.info("Current DB stats:\n%s",pp.pformat([(k,v) for k,v in sorted(db_stats.items())]))
	return db_stats


if __name__ == "__main__":
	main()

