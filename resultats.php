<?php
include 'libs/html_functions.php';
include 'libs/php_functions.php';
include 'libs/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body();



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


$db=mongoConnector();
$collection = new MongoCollection($db, "testData");
$query=array('name' => 'Toto');
$cursor = $collection->find();
$array = iterator_to_array($cursor);
$keys =array();

foreach ($array as $k => $v) {
	foreach ($v as $a => $b) {
		$keys[] = $a;
	}
}
$keys = array_values(array_unique($keys));

//foreach($cursor as $doc) {
//	var_dump($doc);
//}

echo'<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
echo'<thead><tr>';

foreach (array_slice($keys,1) as $key => $value) {
	echo "<th>" . $value . "</th>";
}
echo'</tr></thead>';
$cursor_count = $cursor->count();
echo'<tbody>';
foreach($cursor as $line) {
	echo "<tr>";
	foreach(array_slice($keys,1) as $key => $value) {
		echo "<td>".$line[$value]."</td>";
	}
	echo "</tr>";
}
echo'</tbody></table>';
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
