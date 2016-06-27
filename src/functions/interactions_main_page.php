<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_int","../..");

error_log("test---------------------------------");

if (isset($_POST['gene_ids'],$_POST['transcript_ids'],$_POST['protein_ids'],$_POST['species'],$_POST['mode'])){ 
    $db=mongoConnector();       
    $pv_interactionsCollection = new Mongocollection($db, "pv_interactions");
    $pp_interactionsCollection = new Mongocollection($db, "pp_interactions");
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");
    $gene_id=json_decode($_POST['gene_ids']);
    $uniprot_id=json_decode($_POST['protein_ids']);
    $species=$_POST['species'];
    $mode=$_POST['mode'];
    error_log("test---------------------------------");
    if ($mode==='PV'){
        error_log("PV mode");
        echo '<div class=PV>';
        load_and_display_pvinteractions($gene_id,$uniprot_id,$pv_interactionsCollection,$species);
        echo '</div>';

    }
    else{
        error_log("PP mode");
        $transcript_id=json_decode($_POST['transcript_ids']);
        echo '<div class=PP>';
        load_and_display_ppinteractions($full_mappingsCollection,$gene_id,$uniprot_id,$transcript_id,$pp_interactionsCollection,$species);
        echo '</div>';
    }
}
new_cobra_footer();	
