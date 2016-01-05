<?php

include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');


//define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
//include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Multiple results Summary","section_result_tabs","..");
//Instanciation de la connexion
$db=mongoConnector();


    //Selection des collections
    $samplesCollection = new MongoCollection($db, "samples");
    $speciesCollection = new Mongocollection($db, "species");
    $mappingsCollection = new Mongocollection($db, "mappings");
    $measurementsCollection = new Mongocollection($db, "measurements");
    $virusesCollection = new Mongocollection($db, "viruses");
    $interactionsCollection = new Mongocollection($db, "interactions");
    $orthologsCollection = new Mongocollection($db, "orthologs");
    $GOCollection = new Mongocollection($db, "gene_ontology");



//$speciesID=control_post(htmlspecialchars($_GET['speciesID']));
$listID=control_post(htmlspecialchars($_GET['listID']));
//$textID=control_post(htmlspecialchars($_GET['q']));
// on remplace le retour charriot par <br>
$listID = str_replace('\r\n','<br>',$listID);
//echo $listID;
$id_details= explode("\r\n", $listID);
make_species_list(find_species_list($speciesCollection),"..");
echo '<div id="shift_line"></div>';
var_dump(realpath(dirname(FILE)));
for ($c=0;$c<count($id_details);$c++){
    $search=$id_details[$c];
    $organism="All species";
    echo'<div class="panel-group" id="result_accordion_documents_'.str_replace(".", "_", $search).'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        <a class="accordion-toggle collapsed" href="#result_'.str_replace(".", "_", $search).'" data-parent="#result_accordion_documents_'.str_replace(".", "_", $search).'" data-toggle="collapse">
                                '.$search.'
                        </a>				
                    </h3>
                </div>
                <div class="panel-body panel-collapse collapse" id="result_'.str_replace(".", "_", $search).'">';
    
                    include("./result_search.php?organism=".$organism."&search=".$search);
    
    
            echo'</div>
            </div>
        </div>';
   

}



new_cobra_footer();


?>

