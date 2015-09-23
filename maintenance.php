 <?php
 	//session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	//require '../session/control-session.php';
 
	new_cobra_header();


	new_cobra_body($_SESSION['login'],"Maintenance page","section_maintenance");
 	
 	echo '<p>The site is currently under maintenance </p>'."\n";
 

    
    
 	new_cobra_footer();
 	
 
 
 ?>