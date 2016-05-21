<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
//include '../wiki/vendor/autoload.php';
require('./session/control-session.php');





new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary","..");

if (((isset($_GET['organism'])) && ($_GET['organism']!='')) && ((isset($_GET['search'])) && ($_GET['search']!=''))){


	$organism=control_post(htmlspecialchars($_GET['organism']));
	$search=control_post(htmlspecialchars($_GET['search']));
	//$search=strtoupper($search);

    $list_search=array();
    if (count(split(",", $search))>1){
        $list_search=split(",", $search);
    }
    else{
        array_push($list_search, $search);
    }
    
	$db=mongoConnector();

	$grid = $db->getGridFS();
	//Selection des collections
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$virusesCollection = new Mongocollection($db, "viruses");
	$interactionsCollection = new Mongocollection($db, "interactions");
    $sequencesCollection = new Mongocollection($db, "sequences");
	$orthologsCollection = new Mongocollection($db, "orthologs");
    $GOCollection = new Mongocollection($db, "gene_ontology");

	
	//get_all_results_from_samples($measurementsCollection,$samplesCollection,$search);

    //if more than one results (often the case when search by gene symbol or keywords

    //put the search box again...
    make_species_list(find_species_list($speciesCollection),"..");
    
    
   
    $go_id_list=array();
    $go_grid_plaza_id_list=array();
    $go_grid_id_list=array();
    $gene_alias=array();
    $gene_id=array();
    $gene_symbol=array();
    $descriptions=array();
    $proteins_id=array();
    $plaza_ids=array();
    $est_id=array();
    $go_duo_list=array();
    //echo '<hr>';
    
    //$timestart=microtime(true);
    //get_everything using full table mapping
    
    //$cursor = find_gene_by_regex($measurementsCollection,new MongoRegex("/^$search/m"));
    
    //$searchQuery = array('gene'=>array('$regex'=> new MongoRegex("/^$search/xi")));
	//$cursor = $measurementsCollection->find($searchQuery);
    //var_dump($cursor);
    
//    $timestart1=microtime(true);
//    $cursor_score=$full_mappingsCollection->aggregate(array(
//    array('$match' => array('type'=>'full_table')),  
//    array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
//    array('$unwind'=>'$mapping_file'),
//    array('$match' => array('mapping_file.Gene ID'=>$search)),
//    array(
//        '$group'=>array(
//           '_id'=> array( 'gene'=> '$mapping_file.Gene ID' ),
//           'scores'=> array('$addToSet'=> '$mapping_file.Score' )
//        )
//    )
//   
//    ));
//    foreach ($cursor_score['result'] as $value) {
//        foreach ($value['scores'] as $tmp_score) {    
//            $score+=$tmp_score;    
//        }  
//    } 
//     $timeend1=microtime(true);
//    $time1=$timeend1-$timestart1;
//    //Afficher le temps d'éxecution
//    $page_load_time1 = number_format($time1, 3);
//    echo "Debut du script: ".date("H:i:s", $timestart1);
//    echo "<br>Fin du script: ".date("H:i:s", $timeend1);
//    echo "<br>Script for search score executed in " . $page_load_time1 . " sec";
    
    
    
    try
	{
        $cursor_array=array();
        if($organism=="All species"){
            //$timestart1=microtime(true);
            foreach ($list_search as $search) {
                $cursor=$full_mappingsCollection->aggregate(array(
                array('$match' => array('type'=>'full_table')),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                array('$unwind'=>'$mapping_file'),
                array('$match' => array('$or'=> array(array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Description'=>new MongoRegex("/^$search/xi")),array('mapping_file.Description'=>new MongoRegex("/$search/xi")),array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/$search$/xi")),array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi"))))),
                array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0))
                ));
                array_push($cursor_array, $cursor);
            }
            
//             $timeend1=microtime(true);
//            $time1=$timeend1-$timestart1;
//            //Afficher le temps d'éxecution
//            $page_load_time1 = number_format($time1, 3);
//            echo "Debut du script: ".date("H:i:s", $timestart1);
//            echo "<br>Fin du script: ".date("H:i:s", $timeend1);
//            echo "<br>Script for search all species executed in " . $page_load_time1 . " sec";
        }
        else{
            foreach ($search as $list_search) {
                //$timestart1=microtime(true);
                $cursor=$full_mappingsCollection->aggregate(array(
                array('$match' => array('type'=>'full_table','species'=>$organism)),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                array('$unwind'=>'$mapping_file'),
                array('$match' => array('$or'=> array(array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Description'=>new MongoRegex("/^$search/xi")),array('mapping_file.Description'=>new MongoRegex("/$search/xi")),array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/$search$/xi")),array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi"))))),
                array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0))
                ));
                array_push($cursor_array, $cursor);
            }
//            $timeend1=microtime(true);
//            $time1=$timeend1-$timestart1;
//            //Afficher le temps d'éxecution
//            $page_load_time1 = number_format($time1, 3);
//            echo "Debut du script: ".date("H:i:s", $timestart1);
//            echo "<br>Fin du script: ".date("H:i:s", $timeend1);
            //echo "<br>Script for given species executed in " . $page_load_time1 . " sec";
        }
	}
	catch ( MongoResultException $e )
	{
    		echo '<p>aggregation result exceeds maximum document size (16MB), you need to be more precise in your query</p>';
    		exit();
	}
     
    display_multi_results_table($cursor_array);
    
    
//    if (count($cursor['result'])>=1) { 
//               
//    }
//    else{
//        echo'<div id="summary"><h2>No Results found for \''.$search.'\'</h2></div></section>';	
//    }
    
}
else{
	echo'<div class="container">
        <h2>you have uncorrectly defined your request</h2>'
      . '</div></section>';	
}
new_cobra_footer();

?>

<script type="text/javascript" class="init">
$('#result_list').DataTable( {
        responsive: true
 });

</script>