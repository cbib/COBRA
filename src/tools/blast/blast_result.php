<?php
require '/var/www/html/COBRA/src/session/maintenance-session.php';
require '/var/www/html/COBRA/src/functions/html_functions.php';
require '/var/www/html/COBRA/src/functions/php_functions.php';
require '/var/www/html/COBRA/src/functions/mongo_functions.php';
require '/var/www/html/COBRA/src/session/control-session.php';

 
	new_cobra_header();
	new_cobra_body($_SESSION['login'],"job information details","section_job_details");
 	if ((isset($_GET['id'])) && ((isset($_GET['id'])))){
 		$id=htmlentities(trim($_GET['id']));;
        $db=mongoConnector();
        $jobsCollection = new Mongocollection($db, "jobs");
        echo new MongoId($id);
        $jobs=$jobsCollection->find(array('_id'=> new MongoId($id)),array());
    
        $json_string = json_encode($jobs);
        echo $json_string;
 	
 	}
 	else{
 		echo '<p>Incorrect id form </p>'."\n";
 		exit();

 	}
    
    
    new_cobra_footer();
 	
 
 
 ?>

    

