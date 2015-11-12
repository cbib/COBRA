# -*- coding: utf-8 -*-

import os


def get_or_create_dir(dirname):
    if not os.path.isdir(dirname):
        os.makedirs(dirname)
    return dirname


root_dir = os.path.abspath(os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', '..'))
res_dir = os.path.join(root_dir, 'resources')
config_dir = os.path.join(root_dir, 'config')
dump_dir = get_or_create_dir(os.path.join(root_dir, 'dump'))
log_dir = get_or_create_dir(os.path.join(root_dir, 'log'))
data_dir = get_or_create_dir(os.path.join('/', 'data/'))