<?php
//session_start();
// on teste si le visiteur a soumis le formulaire de connexion
//if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
//	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

#set_include_path('/var/www/html/COBRA/');


require('./src/functions/html_functions.php');
require('./src/functions/php_functions.php');
require('./src/functions/mongo_functions.php');
require('src/session/control-session.php');


$_SESSION['maintenance'] = "yes"; 
require('./src/session/maintenance-session.php');



define('CONTENT_EXT', '.md');
//define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
//define('CONTENT_DIR', ROOT_DIR .'wiki/content/');
//define('CONTENT_EXT', '.md');
//define('LIB_DIR', ROOT_DIR .'wiki/lib/');
//define('PLUGINS_DIR', ROOT_DIR .'wiki/plugins/');
//define('THEMES_DIR', ROOT_DIR .'wiki/themes/');
//define('CACHE_DIR', LIB_DIR .'wiki/cache/');

new_cobra_header(".");
new_cobra_body(is_logged($_SESSION['login']), "Home","section_home",".");
$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
echo '
<main id="content" class="homepage">
    <br>
	<div id="mission-objectives"><p>COBRA database provides knowledges on the viral factor(s) that determine(s) the breaking of the resistance 
			provided by candidate genes identified in the above WPs and to evaluate the durability of the resistance conferred 
			by the new candidate genes prior to transfer to crop species</p>
	</div> 
	';

echo '</main>';




new_cobra_footer();

?>
