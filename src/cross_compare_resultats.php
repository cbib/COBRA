<?php
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('../session/control-session.php');


define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
session_start();

new_cobra_header();


	new_cobra_body($_SESSION['login'],"Cross comparison","section_cross_compare");
	//Instanciation de la connexion
	$db=mongoConnector();

	
	//Selection des collections
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$virusesCollection = new Mongocollection($db, "viruses");
	$interactionsCollection = new Mongocollection($db, "interactions");


	
	$species1ID=control_post(htmlspecialchars($_GET['species1ID']));
	//echo $species1ID;
	$species2ID=control_post(htmlspecialchars($_GET['species2ID']));
	



	echo'<div class="container">
		  <h2>Search Cross comparison between  \''.$species1ID.'\' and \''.$species2ID.'\'</h2>';
	




	
	//$cursor = $sampleCollection->find(array(), array('name'=>1));
	
	//Find all species 
	//$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1,'taxid'=>1,'abbrev_name'=>1,'aliases'=>1,'classification.top_level' =>1,'classification.kingdom'=>1,'classification.order'=>1));

   $cursor1=get_all_genes_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,$virusesCollection,$species1ID);
   
   $cursor2=get_all_genes_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,$virusesCollection,$species2ID);

	//var_dump($cursor1);
	//here we need to translate in prot ID and compare 
	$found=false;
	foreach ($cursor1 as $doc1){
		
		foreach ($cursor2 as $doc2){
		
			
			if ($doc1[1]==$doc2[1]){
				$found=true;
				echo $doc1[0].' and '.$doc1[0].'are upregulated';
			}
		}
		
	
	}
	if (!$found){
		echo 'no genes are shared in experiments between these two species';
	}
	//makeDatatableFromAggregate($cursor1);
	//datatableFromAggregate($cursor1);
	//makeDatatableFromAggregate($cursor2);
	
	/*
	# Get available mappings and process them 
	$mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('src'=>1,'tgt'=>1,'mapping_file'=>1,'_id'=>0));
	foreach ($mappings_to_process as $map_doc){
		
		$src_col = $map_doc['src'];
		$tgt_col = $map_doc['tgt'];
		$map_file = $map_doc['mapping_file'];
		
		foreach ($map_file as $doc){
			
			if ($doc[$src_col]==$textID){
			
				echo 'new entry for :'.$textID;
				foreach ($doc as $key =>$value){
					
					echo '<li>'.$key.' : '.$value.'</li></br>';
					
				
				}
				//for ($i = 0; $i < count($doc); $i++) {
				//	echo $doc[$i].'</br>';
				//}

			}
		
		}
		//echo $src_col;
		//echo $tgt_col;
		
		//$tgt_array=$mappingsCollection->find(array('mapping_file.$.'.$src_col=>$textID),array('tgt'=>'mapping_file.$.'.$tgt_col));
		//foreach ($tgt_array as $tgtname){
		//	echo $tgtname;
		
		//}
	}
	*/
	
	
	

	##search for related info on other species.


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
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
*/
	echo'</div>';
	echo'
	<div class="container">
  	<h2>Select examples</h2>
	<p>Select interactions if exists:</p>
  	<form role="form" action="interactions.php" method="post" >
     <!--<div class="form-group">
     <label for="geneID">Liste Deroulante:</label>
      <select class="form-control" id="geneID" name="geneID">
       <option value ="">----Choisir----</option>
	   <option value="gene1">Gene 1</option>
       <option value="gene2">Gene 2</option>
       <option value="gene3">Gene 3</option>
       <option value="gene4">Gene 4</option>
      </select>
      <div class="form-group">
        <label for="multipleID">Muliple Select List</label>
            <select multiple class="form-control" id="multipleID" name="multipleID">
                <option value="multiple1">Gene 1</option>
                <option value="multiple2">Gene 2</option>
                <option value="multiple3">Gene 3</option>
                <option value="multiple4">Gene 4</option>
                <option value="multiple5">Gene 5</option>
            </select>
      </div>
      <br>
    </div>-->';
    #make_species_list(find_species_list($speciesCollection));
    #make_viruses_list(find_viruses_list($speciesCollection));
    #make_experiment_type_list(find_experiment_type_list($sampleCollection));
    #make_request_list();
    echo' 
    <br>
    <!--<div class="form-group">
        <label for="requestID">Multiple Select List</label>
        <select multiple class="form-control" id="requestID" name="requestID">
            <option value="Request1">get all uniprot id from genes up regulated from a given species in microarray analysis of infection by a given virus</option>
            <option value="Request2">get all angiosperms infected by a given pathogen</option>
            <option value="Request3">find a gene using a regular expression and retrieve prot interaction data if exist</option>
            <option value="Request4">Request 4</option>
        	<option value="Request5">Request 5</option>
        </select>
    </div>-->
    <div class="form-group">
      <label for="textInput">choose a prot id</label>
      <input type="text" name="textID" class ="form-control" placeholder="Tapez ici..." id="textID">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
    </form>
</div>
';

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
$(document).ready(function() {
	$('#example2').dataTable( {
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
