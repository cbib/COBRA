<?php
include 'libs/html_functions.php';
include 'libs/php_functions.php';
include 'libs/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body();

	//Recuperation des variables de la page main
	$multipleGeneID = control_post($_POST['multipleID']);
	$geneID=control_post($_POST['geneID']);
	$textID=control_post($_POST['textInput']);

	echo'<div class="container">
	<h2>Resultats</h2>';
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
	var_dump($cursor);

	$cursor = $sampleCollection->find(array(), array('name'=>1));

	foreach($cursor as $doc) {
		show_array($doc);
	}
	
	makeDatatable($cursor);

	echo'</div>';
?>

<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#example').dataTable( {
		"scrollX": true,
		"jQueryUI": true,
		"pagingType": "full_numbers",
		"oLanguage": { 
			"sProcessing":   "Traitement en cours...",
			"sLengthMenu":   "Afficher _MENU_ éléments",
			"sZeroRecords":  "Aucun élément à afficher",
			"sInfo": "Affichage de l'élement _START_ à _END_ sur _TOTAL_ éléments",
			"sInfoEmpty": "Affichage de l'élement 0 à 0 sur 0 éléments",
			"sInfoFiltered": "(filtré de _MAX_ éléments au total)",
			"sInfoPostFix":  "",
			"sSearch":       "Rechercher: ",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Premier",
				"sPrevious": "Précédent",
				"sNext":     "Suivant",
				"sLast":     "Dernier"
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
