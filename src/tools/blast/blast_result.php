<?php
require '../../session/maintenance-session.php';
require '../../functions/html_functions.php';
require '../../functions/php_functions.php';
require '../../functions/mongo_functions.php';
require '../../session/control-session.php';

 
	new_cobra_header("../../..");
	new_cobra_body($_SESSION['login'],"job information details","section_job_details","../../..");
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
                        echo '<h3> program details</h3>';
                        echo '<pre>';
                        echo '"program" :'.json_encode($blast_results['report']['program'], JSON_PRETTY_PRINT).'</br>';
                        echo '"version": '.json_encode($blast_results['report']['version'], JSON_PRETTY_PRINT).'</br>';
                        echo '"reference": '.json_encode($blast_results['report']['reference'], JSON_PRETTY_PRINT).'</br>';
                        echo '"blast db": "Arabidopsis, Barley, Tomato, Prunus and Melon Proteome”</br>';
                        echo '</pre>';
                        echo '<h3> program settings</h3>';
                        echo '<pre>';
                        echo json_encode($blast_results['report']['params'], JSON_PRETTY_PRINT).'</br>';
                        echo '</pre>';
                        echo '<h3> Results</h3>';
                        echo '<pre>';                
                        echo json_encode($blast_results['report']['results']['search'], JSON_PRETTY_PRINT).'</br>';
                        echo '</pre>';
                    }
                    
                }
                elseif($key==='date'){
                    echo '<h3> Job informations</h3>';
                    echo '<pre>';
                    echo 'Date: '.$value.'</br>';
                    
                    
                }
                elseif($key==='query_id'){
                    
                  
                    echo 'Query: '.$value.'</br>';
                    echo '</pre>';
                    
                }
                else{
                    
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

    

