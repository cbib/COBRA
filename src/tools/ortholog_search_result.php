<?php

require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools");


$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$measurementsCollection = new Mongocollection($db, "measurements");
$mappingsCollection = new Mongocollection($db, "mappings");
$orthologsCollection = new Mongocollection($db, "orthologs");

$envoi = $_GET['envoi'];
if ($envoi == 'yes') {
    $options_text = implode(', ',$options);
    
    echo '<p>options:<br><br>'.$options_text.'</p>';
}
//$species='Arabidopsis thaliana';
$species='Hordeum vulgare';
//$species='Cucumis melo';
$gene_list_attributes=ben_function($mappingsCollection,$measurementsCollection,$speciesCollection,$species,20);

$species_id_type=$speciesCollection->find(array('full_name'=>$species),array('preferred_id'=>1));
foreach ($species_id_type as $value) {
    $favourite_id=$value['preferred_id'];
    //echo $value['preferred_id'];    
}
$plaza_favorite_tgt_id=$mappingsCollection->find(array('src'=>'plaza_gene_id','species'=>$species),array('tgt'=>1));
//only one value is possible
foreach ($plaza_favorite_tgt_id as $value) {
 $intermediary_id=$value['tgt'];
    //echo $value['tgt'];

}


    
foreach ($gene_list_attributes as $attributes) {
    echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
    echo'<thead><tr>';
    echo "<th>Gene id</th>";
    echo "<th>Gene preferred Id</th>";
    echo "<th>Protein uniprot id</th>";
    echo "<th>Plaza id</th>";
    echo "<th>logFC</th>";
    echo "<th>infection agent</th>";
    echo "<th>species</th>";
    echo'</tr></thead><tbody>';
    $cpt=0;
    foreach ($attributes as $key => $value) {
        if ($cpt==0){
            echo "<tr>";
            echo '<td>'.$attributes['gene'].'</td>';
            echo '<td>'.$attributes[$favourite_id].'</td>';
            echo '<td>'.$attributes[$intermediary_id].'</td>'; 
            echo '<td>'.$attributes['plaza_id'].'</td>';
            echo '<td>'.$attributes['logFC'].'</td>';
            echo '<td>'.$attributes['infection_agent'].'</td>';
            echo '<td>'.$species.'</td>';
            echo "</tr>";
            echo'</tbody></table>';
        }

        
        
        if ($value != "NA"){
            //echo $key."\r\t";
            //echo $value."\r\n";
            
            if ($key=="plaza_id"){
                //echo $key."\r\t";
                //echo $value."\r\n";
                //echo "</br>";
                ben_function2($grid,$mappingsCollection,$orthologsCollection,$species,$value);

                
            }
            else{
//                echo $key."\r\t";
//                echo $value."\r\n";
//                echo "</br>";
            }
        }
        else{
//            echo $key."\r\t";
//            echo $value."No id found\r\n";
//            
//            echo "</br>";
        }
        $cpt++;
        
    }
    
        //echo $attributes['gene'];
        //$attributes['gene'];
}
new_cobra_footer();

?>
