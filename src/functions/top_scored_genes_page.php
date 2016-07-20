<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_int","../..");


$db=mongoConnector();       

$full_mappingsCollection = new Mongocollection($db, "full_mappings");


$best_scored_genes=find_top_ranking_S_genes($full_mappingsCollection);

$CG_form_string="";
$CG_form_string.='<div class="top_scored"><table id="S-genes" class="table table-hover dataTable no-footer">';

//$table_string.='<table id="virus" class="table table-bordered" cellspacing="0" width="100%">';
$CG_form_string.='<thead><tr>';

//recupere le titre
$CG_form_string.='<th>Gene</th>';
$CG_form_string.='<th>Description</th>';
$CG_form_string.='<th>Alias</th>';
$CG_form_string.='<th>species</th>';
$CG_form_string.='<th>Score</th>';

//$table_string.='<th>tgt</th>';
//$table_string.='<th>tgt_version</th>';
//$table_string.='<th>species</th>';


//fin du header de la table
$CG_form_string.='</tr></thead>';
//Debut du corps de la table
$CG_form_string.='<tbody>';

foreach ($best_scored_genes['result'] as $value) {
    //var_dump($value['_id']['score']);
    //echo $value['_id']['score'].'<br/>';

        $score=$value['_id']['score'];
        if ( $score > 10){
            foreach ($value['genes'] as $gene) {
                $CG_form_string.='<tr>';
                //$CG_form_string.='<td>'.$gene['gene_id'].'</td>';
                $CG_form_string.='<td><a class="nowrap" target = "_blank" href="../../src/result_search_5.php?organism='.$gene['species'].'&search='.$gene['gene_id'].'">'.$gene['gene_id'].'</a></td>';
                $CG_form_string.='<td>'.$gene['gene_desc'].'</td>';
                $CG_form_string.='<td>'.$gene['gene_alias'].'</td>';
                $CG_form_string.='<td>'.$gene['species'].'</td>';
                $CG_form_string.='<td>'.$score.'</td>';
                $CG_form_string.='</tr>';
                //echo $gene;
            }
        }
}
$CG_form_string.='</tbody></table></div>';
echo $CG_form_string;
    


new_cobra_footer();	