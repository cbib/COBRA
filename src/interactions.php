<?php
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body($_SESSION['login'], "Interactions","section_interactions","..");

	//Recuperation des variables de la page main
	#$requestID=control_post($_POST['requestID']);
	#$speciesID=control_post(htmlspecialchars($_POST['speciesID']));
	#$exp_typeID=control_post(htmlspecialchars($_POST['exp_typeID']));
	#$virusID=control_post(htmlspecialchars($_POST['virusID']));
	$textID=control_post(htmlspecialchars($_POST['textID']));


	echo'<div class="container">
	<h2>Results</h2>';
	#echo $requestID;
	/*
	echo $speciesID;
	echo '<br>';
	echo $textID;
	echo '<br>';
	echo $virusID; 
	echo '<br>';
	echo $exp_typeID; 
	echo '<br>';
	echo '</div>';
	*/
	//Instanciation de la connexion
	$db=mongoConnector();
	#$db=mongoPersistantConnector()
	//$db=mongoPersistantConnector();
	
	//Selection de la collection
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$interactionsCollection = new Mongocollection($db, "interactions");

	echo $textID;
	echo '<br>';
	//var_dump($cursor);
	
	//REQUEST 

	//$cursor = $sampleCollection->find(array(), array('name'=>1));
	
	//Find all species 
	//$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1,'taxid'=>1,'abbrev_name'=>1,'aliases'=>1,'classification.top_level' =>1,'classification.kingdom'=>1,'classification.order'=>1));
	//makeDatatableFromFind($cursor);
	
	
	
	
	//foreach($cursor as $doc){
	//	show_array($doc);
	//}
	
	//$cursor=$interactionsCollection->count();
	//echo $cursor;
	 
	
	$cursor=$interactionsCollection->aggregate(array( 
	array('$unwind'=>'$mapping_file'), 
	array('$match'=> array('mapping_file.Host_prot'=>'P58IPK')), 
	array('$project' => array('mapping_file.Host_virus'=>1,'mapping_file.host'=>1,'mapping_file.Accession_number'=>1,'mapping_file.Reference'=>1,'mapping_file.virus'=>1,'mapping_file.method'=>1,'_id'=>0)), 
	));
	
	//var_dump($cursor);
	
	//while ($cursor->hasNext() )
	//{
	//	var_dump( $cursor->getNext() );
	//}
	//print_r($cursor);
	
	
	/*
	for ($i = 0; $i < count($cursor['result']); $i++) {
		$test=$cursor['result'][$i]['mapping_file'];
		
		foreach ( $test as $id => $doc ){
			
			echo $id."=".$doc."<br/>";
		}
	}
	*/
	datatableFromAggregate($cursor);

	#makeDatatableFromAggregate($cursor);
	//makeDatatableFromFind(var_dump($cursor));
	
	//find all pathogens infecting angiosperms
    #$cursor=get_all_pathogens_infecting_angiosperm($speciesCollection,$sampleCollection);
   
    
    //$cursor=get_all_variety($samplesCollection);
    
    
    ###distinct request
    #$cursor=$db->command(array("distinct"=>"measurements","key"=>"xp"));
    
    
    
    
    
    
	
	
	#Find using Regex to quickly found a gene, useful to interpret which ids we encounter in xls files
	#$search_string='1';
	#$regex=new MongoRegex("/^$textID/m");
	#$cursor = find_gene_by_regex($measurementsCollection,$regex);
	
	
	
	#Count entries in sample collection
	#$cursor2 = $samplesCollection->count('experimental_results'=>1);
	
	#print_r($cursor);
	#foreach ( $cursor as $doc ){
	#	print_r($doc);
	#	echo'<br/>';
	#}
	
	#makeDatatableFromFind($cursor);
    #makeDatatableFromAggregate($cursor);
    
    
    //$txt='Cucumber mosaic virus';
    //$txt='monosporascus_cannonballus';
    //$cursor = find_species_doc($speciesCollection,'monosporascus_cannonballus');
    //$cursor = $speciesCollection->find(array('$or'=>array(array('full_name'=>$txt),array('aliases'=>$txt),array('abbrev_name'=>$txt))));

   
    	
	//makeDatatable($cursor);

	

?>

<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').dataTable( {
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

<?php
new_cobra_footer();
?>
