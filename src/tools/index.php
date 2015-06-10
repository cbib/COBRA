<?php

require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools");





echo '
<main id="content" class="toolpage">
	<div id="mission-objectives">
	</div>    	
</main>
 
      
      
      ';

new_cobra_footer();

?>