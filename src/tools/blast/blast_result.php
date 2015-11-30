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
        //echo new MongoId($id);
        $jobs=$jobsCollection->find(array('_id'=> new MongoId($id)),array('_id'=>0));
        echo '<pre>';
        foreach ($jobs as $values) {
            foreach ($values as $key => $value) {
                echo $key.': '.$value.'</br>';
                if ($key==='job_data'){
                    foreach ($value as $blast_results) {
                        echo json_encode($blast_results['report']['program'], JSON_PRETTY_PRINT);
                        echo json_encode($blast_results['report']['version'], JSON_PRETTY_PRINT);
                        echo json_encode($blast_results['report']['reference'], JSON_PRETTY_PRINT);
                        echo "\"blast db\": \"Arabidopsis, Barley, Tomato, Prunus and Melon Proteome\”";
                        echo json_encode($blast_results['report']['params'], JSON_PRETTY_PRINT);
                        echo json_encode($blast_results['report']['results'], JSON_PRETTY_PRINT);
                        
                    }
                    
                }
            }
            
        }
        echo '</pre>';
        
        //$json_string = json_encode($jobs);
        //echo $json_string;
 	
 	}
 	else{
 		echo '<p>Incorrect id form </p>'."\n";
 		exit();

 	}
    
    
    new_cobra_footer();
 	
 
 
 ?>

    

