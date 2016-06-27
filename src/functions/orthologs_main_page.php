<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_variation_profile","../..");
if (isset($_POST['plaza_id'],$_POST['species'])){    
    $db=mongoConnector();  
    $organism=$_POST['species'];
    $plaza_id=$_POST['plaza_id'];
    $orthologsCollection = new Mongocollection($db, "orthologs");
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");
    if (get_ortholog_table($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id)===""){
        echo 'No results found';
    }
    else{
        echo get_ortholog_table($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id);

    }
}
new_cobra_footer();	