<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');





new_cobra_header();

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary");

if (((isset($_GET['organism'])) && ($_GET['organism']!='')) && ((isset($_GET['search'])) && ($_GET['search']!=''))){


	$organism=control_post(htmlspecialchars($_GET['organism']));
	$search=control_post(htmlspecialchars($_GET['search']));
	//$search=strtoupper($search);

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
    make_species_list(find_species_list($speciesCollection));
    
    
   
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
    
    
    
    //Add split funstion for search value in case of double value separated by colon
    //consequently add multiple results page to test any alias when an alias is submitted.
    $cursor=$full_mappingsCollection->aggregate(array(
        array('$match' => array('type'=>'full_table')),  
        array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
        array('$unwind'=>'$mapping_file'),
        array('$match' => array('$or'=> array(array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Description'=>new MongoRegex("/^$search/xi")),array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/$search$/xi")),array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi"))))),
        array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0))
    ));

    //var_dump($cursor);

    
    if (count($cursor['result'])>=1) {
        
        $table_string.='<table id="result_list" class="table table-hover">';
        //$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
        $table_string.='<thead><tr>';

            //recupere le titre
            //$table_string.='<th>type</th>';
            $table_string.='<th>id</th>';
            $table_string.='<th>Protein description</th>';
            $table_string.='<th>species</th>';
            


            //fin du header de la table
        $table_string.='</tr></thead>';

        //Debut du corps de la table
        $table_string.='<tbody>';
        foreach ($cursor['result'] as $result) {
            $table_string.='<tr>';
            if (in_array($result['mapping_file']['Gene ID'],$gene_id)==FALSE){

                array_push($gene_id,$result['mapping_file']['Gene ID']);
                $table_string.='<td><a href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.str_replace(" ", "+", $result['species']).'&search='.$result['mapping_file']['Gene ID'].'">'.$result['mapping_file']['Gene ID'].'</a></td>';
                $table_string.='<td>'.$result['mapping_file']['Description'].'</td>';
                $table_string.='<td>'.$result['species'].'</td>';
            }
            
            
            //$table_string.='<td>'.$line['type'].'</td>';
           
            
            $table_string.='</tr>';

        }
        
        

        
        $table_string.='</tbody></table>';
        echo $table_string;
        
    }
    else{
        

        echo'<div id="summary"><h2>No Results found for \''.$search.'\'</h2></div></section>';	
    }
    
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
        responsive: true,
        
		
        
 } );
</script>