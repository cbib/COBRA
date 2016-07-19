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
    
    echo '<div class="GO_result"><h1>'.$_GET['name'].'</h1>';
    echo '<hr>';
    echo '<div class="sectionBP"><h2> Biological process</h2>'; 
    echo'   <table class="table dataTable no-footer" id="GO_enriched_TableBP"> 
                <thead>
                <tr>';
             echo "<th>GO ID</th>";
             echo "<th>GO Name</th>";
             echo "<th>P value</th>";
             echo "<th>Adjusted P value</th>";
           echo'</tr>
                </thead>
                <tbody>';
                
    $GO_result1=$GO_enrichCollection->find(array("_id"=>new MongoId($_GET['id'])));
    foreach ($GO_result1 as $result) {
        
        foreach ($result['result_file'] as $row){
            
            if ($row["GO NAMESPACE"]==="biological_process "){ 
                echo "<tr>"
                ."<td>".$row["GO ID"]."</td>"
                . "<td>".$row["GO NAME"]."</td>"

                . "<td>".$row["P value"]."</td>"
                . "<td>".$row["adjusted_pvalue"]."</td></tr>";
                
            }
           
            
        }
        
        
    }
    echo'</tbody></table>';
    echo '<div class="shift_line"></div>';      
    echo '</div>';  
    echo '<div class="sectionMF"><h2> Molecular function</h2>'; 
    echo'   <table class="table dataTable no-footer" id="GO_enriched_TableMF"> 
                <thead>
                <tr>';
             echo "<th>GO ID</th>";
             echo "<th>GO Name</th>";
             echo "<th>P value</th>";
             echo "<th>Adjusted P value</th>";
           echo'</tr>
                </thead>
                <tbody>';
                
    $GO_result2=$GO_enrichCollection->find(array("_id"=>new MongoId($_GET['id'])));
    foreach ($GO_result2 as $result) {
        
        foreach ($result['result_file'] as $row){
            if ($row["GO NAMESPACE"]=="molecular_function "){ 
                echo "<tr>"
             . "<td>".$row["GO ID"]."</td>"
             . "<td>".$row["GO NAME"]."</td>"

             . "<td>".$row["P value"]."</td>"
             . "<td>".$row["adjusted_pvalue"]."</td></tr>";
            }   
        }
        
        
    }
    echo'</tbody></table>';
    echo '<div class="shift_line"></div>';      
    echo '</div>'; 
    echo '<div class="sectionCC"><h2> Cellular component</h2>'; 
    echo'   <table class="table dataTable no-footer" id="GO_enriched_TableCC"> 
                <thead>
                <tr>';
             echo "<th>GO ID</th>";
             echo "<th>GO Name</th>";
             echo "<th>P value</th>";
             echo "<th>Adjusted P value</th>";
           echo'</tr>
                </thead>
                <tbody>';
                
    $GO_result3=$GO_enrichCollection->find(array("_id"=>new MongoId($_GET['id'])));
    foreach ($GO_result3 as $result) {
        
        foreach ($result['result_file'] as $row){
            if ($row["GO NAMESPACE"]=="cellular_component "){ 
                    echo "<tr>"
                 . "<td>".$row["GO ID"]."</td>"
                 . "<td>".$row["GO NAME"]."</td>"

                 . "<td>".$row["P value"]."</td>"
                 . "<td>".$row["adjusted_pvalue"]."</td></tr>";
            }  
        }
        
        
    }
    echo'</tbody></table>';
    echo '<div class="shift_line"></div>';      
    echo '</div>';
    echo '</div>';
    
    
    


}
new_cobra_footer();
    
    
    
   