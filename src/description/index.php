<?php
session_start();
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');

/*
define('ROOT_PATH', realpath(dirname(__FILE__)) .'/../../');

require ROOT_PATH.'src/functions/html_functions.php';
include ROOT_PATH.'src/functions/php_functions.php';
include ROOT_PATH.'src/functions/mongo_functions.php';
*/

new_cobra_header();


new_cobra_body();

$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$samplesCollection = new Mongocollection($db, "samples");
$mappingsCollection = new Mongocollection($db, "mappings");
$measurementsCollection = new Mongocollection($db, "measurements");
$publicationsCollection = new Mongocollection($db, "publications");
$interactionsCollection = new Mongocollection($db, "interactions");
$virusesCollection = new Mongocollection($db, "viruses");
#find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));



###EXPERIMENT REQUEST


 $cursor=find_all_xp_name($samplesCollection);


###DISPLAY EXPERIMENT LIST


 echo '<h1>COBRA Datasets</h1><h2> Experiments lists</h2> <div class="container"><ul>';
 //echo '<a href=experiments.php>test</a>';
 foreach($cursor as $line) {
 	$title=$line['name'];
 	//echo str_replace(' ','\s',$title);
	echo '<li value='.$line['name'].'><a href=experiments.php?xp='.str_replace(' ','\s',$title).'>'.$line['name'].'</a></li>';
	}
 //makeDatatableFromFind($cursor);
echo'</ul></div>';




/*##MAPPING LIST

echo '<h2> Mapping lists</h2> <div class="container"><ul>';
 //echo '<a href=experiments.php>test</a>';
 foreach($cursor as $line) {
	#echo '<li value='.$line['type'].'><a href=mappings.php?type='.$line['type'].'>'.$line['type'].'</a></li>';
	echo '<li value='.$line['type'].'>'.$line['type'].'('.$line['species'].')</a></li>';

}
 //makeDatatableFromFind($cursor);
echo'</div>';
*/

###MAPPING REQUEST

$cursor=find_all_mappings($mappingsCollection);


###MAPPING TABLE
echo '<h2> Mapping lists</h2> <div class="container">';
echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
echo'<thead><tr>';
	
	//recupere le titre
	echo "<th>type</th>";
	echo "<th>src</th>";
	echo "<th>src_version</th>";
	echo "<th>tgt</th>";
	echo "<th>tgt_version</th>";
	echo "<th>species</th>";

	
	//fin du header de la table
echo'</tr></thead>';
	
//Debut du corps de la table
echo'<tbody>';

foreach($cursor as $line) {
echo "<tr>";
	echo '<td>'.$line['type'].'</td>';
	echo '<td>'.$line['src'].'</td>';
	echo '<td>'.$line['src_version'].'</td>';
	echo '<td>'.$line['tgt'].'</td>';
	echo '<td>'.$line['tgt_version'].'</td>';
	echo '<td>'.$line['species'].'</td>';
echo "</tr>";

}
echo'</tbody></table>';
echo'</div>';


###SPECIES REQUEST

$cursor=find_all_species($speciesCollection);


###SPECIES TABLE



echo '<h2> Species lists</h2> <div class="container">';
echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
echo'<thead><tr>';
	
	//recupere le titre
	echo "<th>Full name</th>";
	echo "<th>Species</th>";
	echo "<th>Aliases</th>";
	echo "<th>Top level</th>";
	//echo "<th>tgt</th>";
	//echo "<th>tgt_version</th>";
	//echo "<th>species</th>";

	
	//fin du header de la table
echo'</tr></thead>';
	
//Debut du corps de la table
echo'<tbody>';

foreach($cursor['result'] as $line) {
echo "<tr>";
	echo '<td>'.$line['full_name'].'</td>';
	echo '<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		echo '<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				echo $line['aliases'][$i];
			}
			else{
				echo $line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		echo '</td>';
		
	}
	else{
		echo '<td>'.$line['aliases'].'</td>';
		}
	echo '<td>'.$line['top'].'</td>';
	//echo '<td>'.$line['tgt'].'</td>';
	//echo '<td>'.$line['tgt_version'].'</td>';
	//echo '<td>'.$line['species'].'</td>';
echo "</tr>";

}
echo'</tbody></table>';
echo'</div>';



###VIRUSES REQUEST

$cursor=find_all_viruses($virusesCollection);



###VIRUSES TABLE



echo '<h2> VIruses lists</h2> <div class="container">';
echo'<table id="example" class="table table-bordered" cellspacing="0">';
echo'<thead><tr>';
	
	//recupere le titre
	echo "<th>full name</th>";
	echo "<th>species</th>";
	echo "<th>Aliases</th>";
	echo "<th>top level</th>";
	//echo "<th>tgt</th>";
	//echo "<th>tgt_version</th>";
	//echo "<th>species</th>";

	
	//fin du header de la table
echo'</tr></thead>';
	
//Debut du corps de la table
echo'<tbody>';

foreach($cursor['result'] as $line) {
echo "<tr>";
	echo '<td>'.$line['full_name'].'</td>';
	echo '<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		echo '<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				echo $line['aliases'][$i];
			}
			else{
				echo $line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		echo '</td>';
		
	}
	else{
		echo '<td>'.$line['aliases'].'</td>';
		}
	echo '<td>'.$line['top'].'</td>';
	//echo '<td>'.$line['tgt'].'</td>';
	//echo '<td>'.$line['tgt_version'].'</td>';
	//echo '<td>'.$line['species'].'</td>';
echo "</tr>";

}
echo'</tbody></table>';
echo'</div>';











#'type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1)
new_cobra_species_container();


new_cobra_footer();


?>
