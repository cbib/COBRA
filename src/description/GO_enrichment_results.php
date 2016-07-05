<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

 
new_cobra_header("../..");
new_cobra_body($_SESSION['login'],"job GO enrichment details","section_job_go_details","../..");
if ((isset($_GET['id'])) && ((isset($_GET['id'])))){
    $db=mongoConnector();
    $GO_enrichCollection = new Mongocollection($db, "go_enrichments");
//    $document = array("job_owner_firstname" => $_SESSION['lastname'],
//                      "job_owner_lastname" => $_SESSION['firstname'],
//                      "min" => $minlogFCthreshold,
//                      "max" => $maxlogFCthreshold,
//                      "date" => $today,
//                      "xp_id"=> $xp
//                     );
    

        
    echo'   <table class="table dataTable no-footer" id="GO_enriched_Table"> 
                <thead>
                <tr>';
             echo "<th>GO ID</th>";
             echo "<th>GO Name</th>";
             echo "<th>P value</th>";
           echo'</tr>
                </thead>
                <tbody>';
                
    $GO_result=$GO_enrichCollection->find(array("_id"=>new MongoId($_GET['id'])));
    foreach ($GO_result as $result) {
        
        foreach ($result['result_file'] as $row){
           echo "<tr>"
        . "<td>".$row["GO ID"]."</td>"
        . "<td>".$row["GO NAME"]."</td>"
        . "<td>".$row["P value"]."</td></tr>";
            
        }
        
        
    }
           echo'</tbody>

       </table>';
    
    
    


}
new_cobra_footer();
    
    
    
   