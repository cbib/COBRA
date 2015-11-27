 <?php
 	session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header();


	new_cobra_body($_SESSION['login'],"Users information details","section_user_details");
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
	$user=$usersCollection->find(array("firstname"=>$firstname,"lastname"=>$lastname),array());

 	make_user_preferences($user,$usersCollection);
    
    //une table avec tous les jobs.
    
    $jobs=$jobsCollection->find(array("job_owner_firstname"=>$lastname,"job_owner_lastname"=>$firstname),array());
    
    $json_string = json_encode($data);
    
    
    echo '<div id="jobs ><h3> Blast Jobs</h3>';
    $table_string.='<table id="blast_jobs" class="table table-hover">';
    //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
    $table_string.='<thead><tr>';

        //recupere le titre
        //$table_string.='<th>type</th>';
        $table_string.='<th>query id</th>';
        $table_string.='<th>date</th>';



        //fin du header de la table
    $table_string.='</tr></thead>';

    //Debut du corps de la table
    $table_string.='<tbody>';
    foreach ($jobs as $line) {
        $table_string.='<tr>';
            //$table_string.='<td>'.$line['type'].'</td>';
            $table_string.='<td>'.$line['query_id'].'</td>';
            $table_string.='<td>'.$line['date'].'</td>';

        $table_string.='</tr>';

    }
    $table_string.='</tbody></table>';

    echo $table_string.'</div>';
        
    
    

    
    

    
    
 	new_cobra_footer();
 	
 
 
 ?>


<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#blast_jobs').dataTable( {
		"scrollX": true,
		"jQueryUI": true,
		"pagingType": "full_numbers",
		"oLanguage": { 
			"sProcessing":   "Processing...",
			"sLengthMenu":   "display _MENU_ items",
			"sZeroRecords":  "No item found",
			"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
			"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
			"sInfoFiltered": "(filtered from _MAX_ items in total)",
			"sInfoPostFix":  "",
			"sSearch":       "Search: ",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "First",
				"sPrevious": "Previous",
				"sNext":     "Next",
				"sLast":     "Last"
			}
		},
		"language": {
            		"decimal": ",",
            		"thousands": "."
        	}
	});
});
</script>