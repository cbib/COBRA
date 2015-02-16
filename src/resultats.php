<?php
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body();

	//Recuperation des variables de la page main
	$multipleGeneID = control_post($_POST['multipleID']);
	$geneID=control_post($_POST['geneID']);
	$textID=control_post($_POST['textInput']);

	echo'<div class="container">
	<h2>Results</h2>';
	//echo $geneID;
	//echo '<br>';
	//echo $textID;
	//echo '<br>';
	//echo $multipleGeneID; 
	//echo '<br>';
	//echo '</div>';

	//Instanciation de la connexion
	$db=mongoConnector();
	//$db=mongoPersistantConnector();
	
	//Selection de la collection
	$sampleCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	

	//var_dump($cursor);
	
	//REQUEST 

	//$cursor = $sampleCollection->find(array(), array('name'=>1));
	//$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1,'taxid'=>1,'abbrev_name'=>1,'aliases'=>1,'classification.top_level' =>1,'classification.kingdom'=>1,'classification.order'=>1));
	
	//foreach($cursor as $doc){
	//	show_array($doc);
	//}
    $cursor=get_all_pathogens_infecting_angiosperm($speciesCollection,$sampleCollection);
    //$txt='Cucumber mosaic virus';
    //$txt='monosporascus_cannonballus';
    //$cursor = find_species_doc($speciesCollection,'monosporascus_cannonballus');
    //$cursor = $speciesCollection->find(array('$or'=>array(array('full_name'=>$txt),array('aliases'=>$txt),array('abbrev_name'=>$txt))));

    makeDatatableFromAggregate($cursor);
    //makeDatatableFromFind($cursor);	
	//makeDatatable($cursor);

	echo'</div>';
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
