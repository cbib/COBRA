<?php
//session_start();
// on teste si le visiteur a soumis le formulaire de connexion
//if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
//	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {
require './src/functions/html_functions.php';
require './src/functions/php_functions.php';
require './src/functions/mongo_functions.php';
require './src/session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']), "Home");
$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");

echo '
<main id="content" class="homepage">
	<div id="mission-objectives">COBRA database provides knowledges on the viral factor(s) that determine(s) the breaking of the resistance 
			provided by candidate genes identified in the above WPs and to evaluate the durability of the resistance conferred 
			by the new candidate genes prior to transfer to crop species
	</div> 
	<div id="search-box">';
        make_species_list(find_species_list($speciesCollection));
echo'
	</div> 
    

    <input id="topQuery" type="hidden" value=""></input>

    <input id="query" class="ui-autocomplete-input" type="search" name="query" accesskey="4" value="" autocomplete="off"></input>

    <span class="ui-helper-hidden-accessible" role="status" aria-live="polite"></span>

    <a id="advanced-search-toggle" class="caret_grey" href="#">Advanced</a>
    <input type="hidden" name="sort" value="score"></input>

    <a id="search-button" class="icon icon-functional button" href="" onclick="return false" data-icon="1" title="Search">Search</a>
</main>
 
      
      
      ';

new_cobra_footer();

?>