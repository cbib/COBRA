<?php
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body();

	//Recuperation des variables de la page main
	#$requestID=control_post($_POST['requestID']);
	#$speciesID=control_post(htmlspecialchars($_POST['speciesID']));
	#$exp_typeID=control_post(htmlspecialchars($_POST['exp_typeID']));
	#$virusID=control_post(htmlspecialchars($_POST['virusID']));
	#$textID=control_post(htmlspecialchars($_POST['textInput']));


	echo'<div class="container">
	<h2>Results</h2>';
	
	
	$prot_ID=$_GET['protID'];
	echo $prot_ID;
	
	
	$url="http://solgenomics.net/search/unigene.pl?unigene_id=".$prot_ID;
	get_protein_info($url);
	
	
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
