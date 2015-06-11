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





echo '
<main id="content" class="homepage">
	<div id="mission-objectives">COBRA benefits from multidisciplinary research teams involving genomics, bio-informatics, population genetics, molecular biology, virology and plant breeding. It focuses on three major crops, barley for cereals, tomato for vegetables and Prunus species for fruit trees. The originality of COBRA is to test the generic mode of interference of plant viruses, from annual plants to perennials and from dicotyledons to monocotyledons and use this information 
			to implement complex and durable resistance in any crop species. COBRA database provides knowledges on the viral factor(s) that determine(s) the breaking of the resistance 
			provided by candidate genes identified in the above WPs and to evaluate the durability of the resistance conferred 
			by the new candidate genes prior to transfer to crop species
	</div> 
	<div id="protein-details">
	
	
	</div>  	
</main>
 
      
      
      ';

new_cobra_footer();

?>