 <?php
 	//session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header("../..");


	new_cobra_body($_SESSION['login'],"Users details","section_user_details","../..");
 	if ((isset($_GET['firstname'])) && ((isset($_GET['lastname'])))){
 		$firstname=htmlentities(trim($_GET['firstname']));
 		$lastname=htmlentities(trim($_GET['lastname']));
 	
 	}
 	else{
 		echo '<p>You are not registered </p>'."\n";
 		exit();

 	}
 	$db=mongoConnector();
	$usersCollection = new Mongocollection($db, "users");
    $jobsCollection = new Mongocollection($db, "jobs");
    $speciesCollection = new Mongocollection($db, "species");
    $historyCollection = new Mongocollection($db, "history");
    $GO_enrichedCollection = new Mongocollection($db, "go_enrichments");

	$user=$usersCollection->find(array("firstname"=>$firstname,"lastname"=>$lastname),array());
    make_species_list(find_species_list($speciesCollection),"../..");
 	make_user_preferences($user,$usersCollection);
    
    //une table avec tous les GO enrichments
    
    $GO=$GO_enrichedCollection->find(array("job_owner_firstname"=>$lastname,"job_owner_lastname"=>$firstname),array());
    $GOtable_string='';
    echo '<div id="GOEnrichedJobsTable">'
    . ' <h3> GO enriched Jobs</h3>';
    $GOtable_string.='<table id="go_jobs" class="table table-hover">';
    //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
    $GOtable_string.='<thead><tr>';

        //recupere le titre
        //$table_string.='<th>type</th>';
        $GOtable_string.='<th>Experiment name</th>';
        $GOtable_string.='<th>array number</th>';
        $GOtable_string.='<th>Date</th>';
        $GOtable_string.='<th>Min</th>';
        $GOtable_string.='<th>Max</th>';
        $GOtable_string.='<th>Results</th>';
        $GOtable_string.='<th>State</th>';



        //fin du header de la table
    $GOtable_string.='</tr></thead>';

    //Debut du corps de la table
    $GOtable_string.='<tbody>';
    foreach ($GO as $line) {
        
        $GOtable_string.='<tr>';
            //$table_string.='<td>'.$line['type'].'</td>';
        
            $GOtable_string.='<td>'.$line['xp_name'].'</td>';
            $GOtable_string.='<td>'.$line['xp_array'].'</td>';
            $GOtable_string.='<td>'.$line['date'].'</td>';
            $GOtable_string.='<td>'.$line['min'].'</td>';
            $GOtable_string.='<td>'.$line['max'].'</td>';
            $GOtable_string.='<td><a href="../description/GO_enrichment_results.php?id='.$line['_id'].'">View results</td>';
            if(isset($line['result_file'])){
                $GOtable_string.='<td style="background:#01DF74;">Finished</td>';
            }
            else{
                $GOtable_string.='<td style="background:#FA8258;">Running</td>';
            }

        $GOtable_string.='</tr>';

    }
    $GOtable_string.='</tbody></table>';
    $GOtable_string.='</div>';

    echo $GOtable_string;
    
    
    //une table avec tous les jobs blast.
    
    $jobs=$jobsCollection->find(array("job_owner_firstname"=>$lastname,"job_owner_lastname"=>$firstname),array());
    
    //$json_string = json_encode($data);
    
    $table_string='';
    echo '<div id="BlastJobsTable"><h3> Blast Jobs</h3>';
    $table_string.='<table id="blast_jobs" class="table table-hover">';
    //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
    $table_string.='<thead><tr>';

        //recupere le titre
        //$table_string.='<th>type</th>';
        $table_string.='<th>Query id</th>';
        $table_string.='<th>Date</th>';
        $table_string.='<th>Results</th>';



        //fin du header de la table
    $table_string.='</tr></thead>';

    //Debut du corps de la table
    $table_string.='<tbody>';
    foreach ($jobs as $line) {
        $table_string.='<tr>';
            //$table_string.='<td>'.$line['type'].'</td>';
            $table_string.='<td>'.$line['query_id'].'</td>';
            $table_string.='<td>'.$line['date'].'</td>';
            $table_string.='<td><a href="../tools/blast/blast_result.php?id='.$line['_id'].'">View results</td>';

        $table_string.='</tr>';

    }
    $table_string.='</tbody></table>';
    $table_string.='</div>';

    echo $table_string;
    
    echo '</br>';
    echo '</br>';
    echo '<br/>';
    
    //une table avec tous l'historique de recherche
        
    $table_string='';
    
    if ($firstname==="Dartigues"){
        $searches=$historyCollection->find(array(),array());
    }
    else{
        $searches=$historyCollection->find(array("lastname"=>$lastname,"firstname"=>$firstname,"type" => "search"),array());
    }
    
    echo '<div id="search_history"><h3> History</h3>';
    $table_string.='<table id="history" class="table table-hover">';
    //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
    $table_string.='<thead><tr>';

        //recupere le titre
        //$table_string.='<th>type</th>';
        $table_string.='<th>Query id</th>';
        $table_string.='<th>Date</th>';
        $table_string.='<th>Score</th>';
        if ($firstname==="Dartigues"){
            $table_string.='<th>User</th>';

        }
        



        //fin du header de la table
    $table_string.='</tr></thead>';

    //Debut du corps de la table
    $table_string.='<tbody>';
    foreach ($searches as $line) {
        if ($line['type']==="search"){
            $table_string.='<tr>';
            //$table_string.='<td>'.$line['type'].'</td>';
            $table_string.='<td>'.$line['search id'].'</td>';
            $table_string.='<td>'.$line['date'].'</td>';
            if(isset($line['score'])){
                $table_string.='<td>'.$line['score'].'</td>';
            }
            else{
                $table_string.='<td>-</td>';
            }
            if ($firstname==="Dartigues"){
                $table_string.='<td>'.$line['firstname'].'</td>';
            } 
        }

            
            

        $table_string.='</tr>';

    }
    $table_string.='</tbody></table></div>';

    echo $table_string;
    
    
    
    
    echo '</br>';
 
    $table_string='';
    
    echo '<div id="log_history"><h3> Login History</h3>';
    $table_string.='<table id="login_history" class="table table-hover">';
    //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
    $table_string.='<thead><tr>';

        //recupere le titre
        //$table_string.='<th>type</th>';

        $table_string.='<th>Date</th>';
        $table_string.='<th>User</th>';



        //fin du header de la table
    $table_string.='</tr></thead>';

    //Debut du corps de la table
    $table_string.='<tbody>';
    foreach ($searches as $line) {
        if ($line['type']!="search"){
            $table_string.='<tr>';
            //$table_string.='<td>'.$line['type'].'</td>';

            $table_string.='<td>'.$line['date'].'</td>';

            $table_string.='<td>'.$line['firstname'].'</td>';

            $table_string.='</tr>';
        }

    }
    $table_string.='</tbody></table></div>';

    if ($firstname==="Dartigues"){
        echo $table_string;
    }

    echo '</br>';
    
 	new_cobra_footer();
 	
 
 
 ?>


<script type="text/javascript" class="init">

$(document).ready(function() {
    $('#blast_jobs').DataTable( {
        responsive: true    
    });
    $('#history').DataTable( {
        responsive: true    
    });
    $('#login_history').DataTable( {
        responsive: true    
    });

});

</script>