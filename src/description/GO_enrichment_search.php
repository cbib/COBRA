<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Experiments Details","section_experiments","../..");

//unlink("/data/hypergeom_R_results/result.txt");
if ((isset($_POST['xp_id'])) && ($_POST['xp_id']!='')){
    if  ((isset($_POST['min'])) && (isset($_POST['max']))){
        
        $species=$_POST['species'];

        $xp=str_replace("-", ".",$_POST['xp_id']);
        $maxlogFCthreshold=$_POST['max'];
        $minlogFCthreshold=$_POST['min'];
        $db=mongoConnector();
        $full_mappingsCollection = new Mongocollection($db, "full_mappings");
        $measurementsCollection = new Mongocollection($db, "measurements");
        $GOCollection = new Mongocollection($db, "gene_ontology");
        $GO_enrichCollection = new Mongocollection($db, "go_enrichments");
        $samplesCollection = new MongoCollection($db, "samples");


        
        $today = date("F j, Y, g:i a");
        
        //error_log($xp);
        list($xp_id, $tmp, $xp_array) = explode('.', $xp);
        //error_log($tmp);
        //error_log($xp_array);
        //error_log($xp_id);

        $names= find_xp_name_with_xp_id($samplesCollection, $xp_id);
        foreach ($names as $name) {
            $xp_name=$name['name'];
            //error_log($xp_name);
            
        }
        
        $document = array("job_owner_firstname" => $_SESSION['lastname'],
                      "job_owner_lastname" => $_SESSION['firstname'],
                      "min" => $minlogFCthreshold,
                      "max" => $maxlogFCthreshold,
                      "date" => $today,
                      "xp_id"=> $xp_id,
                      "xp_array"=> $xp_array,
                      "xp_name"=>$xp_name
                     );
        $document['_id'] = new MongoId();
        $GO_enrichCollection->insert($document);
        
        $newDocID = $document['_id'];
        echo $newDocID;
        echo '<div class="alert alert-info" id="testTable">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Info!</strong> Your job has been submitted..Check GO_enrichment table in <a href="../users/user.php?firstname='.$_SESSION['firstname'].'&lastname='.$_SESSION['lastname'].'"> user page</a>
              </div>';
        
        
//        echo'<table class="table dataTable no-footer" id="testTable"> 
//             <thead>
//             <tr>';
//             echo "<th>Date</th>";
//             echo "<th>User</th>";
//             echo "<th>min logFC</th>";
//             echo "<th>max logFC</th>";
//             echo "<th>xp</th>";
//             echo "<th>State</th>";
//        echo'</tr>
//             </thead>
//             <tbody>';
//       echo "<tr>"
//        . "<td>".$today."</td>"
//        . "<td>".$maxlogFCthreshold."</td>"
//        . "<td>".$minlogFCthreshold."</td>"
//        . "<td>".$_SESSION['firstname']."</td>"
//        . "<td>".$xp."</td>"
//        . "<td>Running</td>";
//       
//       echo "<tr>";
//       echo'</tbody>
//
//       </table>';
       //$result_file = "/data/hypergeom_R_results/result.txt";
       //$pythonscript="../../backend/core/process_GO_enrichment.py";
       //$pythonscript2="../../backend/core/test_background_routine.py";
       //shell_exec("python $pythonscript2 &");
       //$test="python ../../backend/core/process_GO_enrichment.py > /dev/null 2>&1 &";
       //system($test);
       
        $xp_formatted=str_replace(".", "__",$xp);
        $cmd='python ../../backend/core/process_GO_enrichment.py '.$xp_formatted.' '.$newDocID.' '.$minlogFCthreshold.' '.$maxlogFCthreshold;
        exec($cmd. " > /data/hypergeom_R_results/log.txt 2>&1 &");/// > dev/null 2>&1 &"
        #exec($cmd. " > /dev/null 2>&1 &");/// > dev/null 2>&1 &"


       //system("python ../../backend/core/process_GO_enrichment.py ".$xp_formatted." > dev/null 2>&1 &");/// > dev/null 2>&1 &"
       //error_log("script launched");
       
       
    }
        
    
    }
new_cobra_footer();