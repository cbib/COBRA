<?php
//session_start();
require '../session/maintenance-session.php';
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

new_cobra_header("../..");


new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Datasets and statistics","section_description","../..");

$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$samplesCollection = new Mongocollection($db, "samples");
$mappingsCollection = new Mongocollection($db, "mappings");
$full_mappingsCollection = new Mongocollection($db, "full_mappings");
$measurementsCollection = new Mongocollection($db, "measurements");
$publicationsCollection = new Mongocollection($db, "publications");
$interactionsCollection = new Mongocollection($db, "interactions");
$virusesCollection = new Mongocollection($db, "viruses");
#find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));



###EXPERIMENT REQUEST

make_species_list(find_species_list($speciesCollection),"../..");
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<div id="data_description">';


//$experiment_cursor=find_all_xp_name($samplesCollection);

//$experiment_cursor2=get_xp_name_by_species($samplesCollection);

$experiment_cursor=find_xp_name_group_by_species($samplesCollection);

echo'<div class="panel-group" id="accordion_documents">
        <div class="panel panel-default">
            <div class="panel-heading">  
                    <a class="accordion-toggle collapsed" href="#Experiments_lists" data-parent="#accordion_documents" data-toggle="collapse">
                        <strong>Experiments</strong>
                    </a>				
            </div>
            <div class="panel-body panel-collapse collapse" id="Experiments_lists">


                   ';
                    foreach ($experiment_cursor['result'] as $value) {
                        foreach ($value['_id'] as $species) {
                            $experiment_table_string="";
                            $experiment_table_string.='<ul>';
                            foreach ($value['xps'] as $xpName) {

                                #echo $xpName;
                                $experiment_table_string.='<li value="'.$xpName['name'].'"><a href="experiments.php?xp='.str_replace(' ','\s',$xpName['name']).'">'.$xpName['name'].'</a> ('.$xpName['type'].')</li>';

                            }
                            $experiment_table_string.='</ul>';
                            add_accordion_panel($experiment_table_string, $species,str_replace(' ','_',$species));
                            echo'<br/>';

                        }
                    }
                    echo'

            </div>

        </div>
    </div>    
<br/>
<br/>';










/*//foreach ($experiment_cursor2['result'] as $doc){
//    #print $doc['specie'];
//        foreach ($doc['_id'] as $specie){
//            #print $specie;
//        }
//        foreach ($doc['names'] as $name){
//            #print $name;
//        }
//               
//}


//$experiment_table_string="";

###DISPLAY EXPERIMENT LIST

//$table_string.='<h1>COBRA Datasets</h1>';
 
//$experiment_table_string.='<ul>';
// //$table_string.='<a href=experiments.php>test</a>';
//foreach($experiment_cursor as $line) {
// 	$title=$line['name'];
//    $species=$line['species'];
// 	//echo str_replace(' ','\s',$title);
//	$experiment_table_string.='<li value='.$title.'><a href=experiments.php?xp='.str_replace(' ','\s',$title).'>'.$title.'</a></li>';
//}
// //makeDatatableFromFind($cursor);
//$experiment_table_string.='</ul>';
//add_accordion_panel($experiment_table_string, "Experiments","Experiments_lists");
//
//echo'<br/>';*/

/*##MAPPING LIST

$table_string.='<h2> Mapping lists</h2> <div class="container"><ul>';
 //$table_string.='<a href=experiments.php>test</a>';
 foreach($cursor as $line) {
	#$table_string.='<li value='.$line['type'].'><a href=mappings.php?type='.$line['type'].'>'.$line['type'].'</a></li>';
	$table_string.='<li value='.$line['type'].'>'.$line['type'].'('.$line['species'].')</a></li>';

}
 //makeDatatableFromFind($cursor);
$table_string.='</div>';
*/

$mapping_table_string="";
###MAPPING REQUEST

$mapping_cursor=find_all_mappings($mappingsCollection);


###MAPPING TABLE

$mapping_table_string.='<table id="mapping" class="table table-hover dataTable no-footer">';
//$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
$mapping_table_string.='<thead><tr>';
	
	//recupere le titre
	//$table_string.='<th>type</th>';
	$mapping_table_string.='<th>Source type</th>';
	$mapping_table_string.='<th>Version</th>';
	$mapping_table_string.='<th>Target Type</th>';
	$mapping_table_string.='<th>Version</th>';
	$mapping_table_string.='<th>Organism</th>';

	
	//fin du header de la table
$mapping_table_string.='</tr></thead>';
	
//Debut du corps de la table
$mapping_table_string.='<tbody>';

foreach($mapping_cursor as $line) {
$mapping_table_string.='<tr>';
	//$table_string.='<td>'.$line['type'].'</td>';
	$mapping_table_string.='<td>'.$line['src'].'</td>';
	$mapping_table_string.='<td>'.$line['src_version'].'</td>';
	$mapping_table_string.='<td>'.$line['tgt'].'</td>';
	$mapping_table_string.='<td>'.$line['tgt_version'].'</td>';
	$mapping_table_string.='<td>'.$line['species'].'</td>';
$mapping_table_string.='</tr>';

}
$mapping_table_string.='</tbody></table>';


add_accordion_panel($mapping_table_string, "Mappings", "mapping_table");
echo'<br/>';







$species_table_string="";

###SPECIES REQUEST

$species_cursor=find_all_species($speciesCollection);


###SPECIES TABLE



$species_table_string.='<table id="species" class="table table-hover dataTable no-footer">';
$species_table_string.='<thead><tr>';
	
	//recupere le titre
	$species_table_string.='<th>Full name</th>';
	$species_table_string.='<th>Species</th>';
	$species_table_string.='<th>Aliases</th>';
	$species_table_string.='<th>Top level</th>';
	//$table_string.='<th>tgt</th>';
	//$table_string.='<th>tgt_version</th>';
	//$table_string.='<th>species</th>';

	
	//fin du header de la table
$species_table_string.='</tr></thead>';
	
//Debut du corps de la table
$species_table_string.='<tbody>';

foreach($species_cursor['result'] as $line) {
$species_table_string.='<tr>';
	$species_table_string.='<td>'.$line['full_name'].'</td>';
	$species_table_string.='<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		$species_table_string.='<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				$species_table_string.=$line['aliases'][$i];
			}
			else{
				$species_table_string.=$line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		$species_table_string.='</td>';
		
	}
	else{
		$species_table_string.='<td>'.$line['aliases'].'</td>';
		}
	$species_table_string.='<td>'.$line['top'].'</td>';
	//$table_string.='<td>'.$line['tgt'].'</td>';
	//$table_string.='<td>'.$line['tgt_version'].'</td>';
	//$table_string.='<td>'.$line['species'].'</td>';
$species_table_string.='</tr>';

}
$species_table_string.='</tbody></table>';
add_accordion_panel($species_table_string, "Species", "Species_table");
echo'<br/>';



###VIRUSES TABLE

$virus_table_string="";

$virus_cursor=find_all_viruses($virusesCollection);
$virus_table_string.='<table id="virus" class="table table-hover dataTable no-footer">';

//$table_string.='<table id="virus" class="table table-bordered" cellspacing="0" width="100%">';
$virus_table_string.='<thead><tr>';
	
	//recupere le titre
	$virus_table_string.='<th>full name</th>';
	$virus_table_string.='<th>species</th>';
	$virus_table_string.='<th>Aliases</th>';
	$virus_table_string.='<th>top level</th>';
    $virus_table_string.='<th>Genus</th>';
	//$table_string.='<th>tgt</th>';
	//$table_string.='<th>tgt_version</th>';
	//$table_string.='<th>species</th>';

	
	//fin du header de la table
$virus_table_string.='</tr></thead>';
	
//Debut du corps de la table
$virus_table_string.='<tbody>';

foreach($virus_cursor['result'] as $line) {
$virus_table_string.='<tr>';
	$virus_table_string.='<td>'.$line['full_name'].'</td>';
	$virus_table_string.='<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		$virus_table_string.='<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				$virus_table_string.=$line['aliases'][$i];
			}
			else{
				$virus_table_string.=$line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		$virus_table_string.='</td>';
		
	}
	else{
		$virus_table_string.='<td>'.$line['aliases'].'</td>';
		}
	$virus_table_string.='<td>'.$line['top'].'</td>';
    $virus_table_string.='<td>'.$line['genus'].'</td>';
	//$table_string.='<td>'.$line['tgt'].'</td>';
	//$table_string.='<td>'.$line['tgt_version'].'</td>';
	//$table_string.='<td>'.$line['species'].'</td>';
$virus_table_string.='</tr>';

}
$virus_table_string.='</tbody></table>';
add_accordion_panel($virus_table_string, "Viruses", "virus_table");
echo'<br/>';



add_ajax_accordion_panel("load_top_scored_genes()","Top-Ranking-Sgenes", "table_Top-Ranking-Sgenes","TopScoredloading","top_score_area");


//echo '<div class="panel-group" id="accordion_documents_Top-Ranking-Sgenes">
//            <div class="panel panel-default">
//                <div class="panel-heading" onclick="load_top_scored_genes()">
//
//                        <a class="accordion-toggle collapsed" href="#table_Top-Ranking-Sgenes" data-parent="#accordion_documents_Top-Ranking-Sgenes" data-toggle="collapse">
//                                <strong>Top Ranking susceptibility genes using COBRA scoring function</strong>
//                        </a>				
//
//                </div>
//                <center>
//                    <div class="TopScoredloading" style="display: none"></div>
//                </center>
//                <div class="panel-body panel-collapse collapse" id="table_Top-Ranking-Sgenes">
//                    <div class="top_score_area"> 
//
//                    <!--here comes the top scored genes table div-->
//                    </div>';
//           echo'</div>
//
//            </div>
//        </div>
//    <div class="shift_line"></div>';

//add_accordion_panel($CG_form_string, "Top Ranking susceptibility genes using COBRA scoring function","Top-Ranking-Sgenes"); 

echo'<br/>';


echo'</div>';





#'type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1)
#new_cobra_species_container();


new_cobra_footer();

?>

<script>
    $(document).ready(function() {
    $('#mapping').DataTable( {
        responsive: true
    });
});

</script>

