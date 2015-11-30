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
      
        foreach ($jobs as $values) {
            foreach ($values as $key => $value) {
                
                
                if ($key==='job_data'){
                    foreach ($value as $blast_results) {
                        echo '<pre>';
                        echo '"program" :'.json_encode($blast_results['report']['program'], JSON_PRETTY_PRINT).'</br>';
                        echo '"version": '.json_encode($blast_results['report']['version'], JSON_PRETTY_PRINT).'</br>';
                        echo '"reference": '.json_encode($blast_results['report']['reference'], JSON_PRETTY_PRINT).'</br>';
                        echo '"blast db": "Arabidopsis, Barley, Tomato, Prunus and Melon Proteome”</br>';
                        echo '</pre>';
                        echo '<pre>';
                        echo json_encode($blast_results['report']['params'], JSON_PRETTY_PRINT).'</br>';
                        echo '</pre>';
                        echo '<pre>';
                        echo json_encode($blast_results['report']['results'], JSON_PRETTY_PRINT).'</br>';
                        echo '</pre>';
                    }
                    
                }
                else{
                    
                    echo '<pre>';
                    echo $key.': '.$value.'</br>';
                    echo '</pre>';
                    
                }
            }
            
        }
        
        
        //$json_string = json_encode($jobs);
        //echo $json_string;
 	
 	}
 	else{
 		echo '<p>Incorrect id form </p>'."\n";
 		exit();

 	}
    
    
    new_cobra_footer();
 	
 
 
 ?>

    

