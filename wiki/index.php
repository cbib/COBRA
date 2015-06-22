<?php
require (realpath(dirname(__FILE__)) .'/'.'../src/session/control-session.php');
//session_start();

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('CONTENT_DIR', ROOT_DIR .'content/');
define('LIB_DIR', ROOT_DIR .'lib/');
define('CONTENT_EXT', '.md');
define('PLUGINS_DIR', ROOT_DIR .'plugins/');
define('THEMES_DIR', ROOT_DIR .'themes/');
define('CACHE_DIR', LIB_DIR .'cache/');

//error_log(ROOT_DIR);
require_once(ROOT_DIR .'vendor/autoload.php');
require_once(LIB_DIR .'pico.php');


$pico = new Pico();

?>