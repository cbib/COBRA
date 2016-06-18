<?php

require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"differently expressed genes","section_diff_exp_genes","../..");


$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$measurementsCollection = new Mongocollection($db, "measurements");
$mappingsCollection = new Mongocollection($db, "mappings");
$full_mappingsCollection = new Mongocollection($db, "full_mappings");
$orthologsCollection = new Mongocollection($db, "orthologs");

$data = $_POST['species'];
$regulation=$_POST['regulation'];
$Topgene=$_POST['Topgene'];


foreach ($data as $species){
    //echo 'species: '.$species;
    if ($species=="Prunus species"){
        echo '<H1>Results for Prunus species</H1>';
        $species_id_type=$speciesCollection->find(array('classification.genus'=>'Prunus'),array('preferred_id'=>1,'full_name'=>1));
        foreach ($species_id_type as $species_value) {
            //echo 'full name: '.$species_value['full_name'];
            $timestart=microtime(true);
            $gene_list_attributes=get_ortholog_list_2($full_mappingsCollection,$measurementsCollection,$speciesCollection,$species_value['full_name'],$genes,$Topgene);
            //$gene_list_attributes=get_ortholog_list($mappingsCollection,$measurementsCollection,$speciesCollection,$value['full_name'],$genes,$Topgene);
            
            
            //make_orthologs_page($gene_list_attributes,'Prunus persica');
            foreach ($gene_list_attributes as $attributes) {



                $cpt=0;
                foreach ($attributes as $key => $value) {
                    if ($cpt==0){

                        echo '<div style="cursor: pointer;" onclick="window.location=\'../Multi-results.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['search'].'\';" class="resultsbox" id="results">
                                <div class="results-right">
                                    <div class="organism"> Organism:'.$species_value['full_name'].'</div>
                                    <div class="infection agent"> Infection agent: '.$attributes['infection_agent'].'</div>

                                </div>
                                <div class="results-left">
                                    <div class="officialSymbol"> Gene identifier: '.$attributes['search'].'</div>
                                    <div class="logFC"> Log fold change: '.$attributes['logFC'].'</div>

                                </div>

                        </div>';
                    }




                    if ($value != "NA"){


                        if ($key=="plaza_id"){
                            //echo 'key: '.$value;

                            echo'<div class="panel-group" id="accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3>
                                                <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-toggle="collapse">
                                                        Ortholog table 
                                                        <!--<div id="organism" class="right"><h4>Prunus species</h4></div>-->
                                                </a>				
                                            </h3>
                                        </div>
                                        <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">

                                            <table class="table table-hover">                                                                
                                                <thead>
                                                <tr>';
                                                    //echo "<th>Mapping type</th>";
                                                    echo "<th>Gene ID</th>";
                                                    echo "<th>Source</th>";
                                                    //echo "<th>tgt ID</th>";
                                                    echo "<th>Transcript/protein ID</th>";
                                                    echo "<th>Source</th>";
                                                    echo "<th>Species</th>";
                                                    echo'
                                                </tr>
                                                </thead>

                                                <tbody>';
                                                    //echo 'before entering into table_ortholog';
                                                    echo table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,'Prunus persica',$value);

                                           echo'</tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>';    

                            echo '<div id="shift_line"></div>';

                        }

                    }

                    $cpt++;

                }

            }
        }
        
    }
    else{
        echo '<H1>Results for '.$species.'</H1>';

        //$type=$genes;

        $cursor=get_n_top_diff_expressed_genes($measurementsCollection,$species,$Topgene,$regulation);

        foreach ($cursor as $value) {

            //array_push($gene_list,array('search'=>$value['gene'],'logFC'=>$value['logFC'],'infection_agent'=>$value['infection_agent']));
            echo '<div style="cursor: pointer;" onclick="window.open(\'../result_search_5.php?organism='.str_replace(" ", "+", $species).'&search='.$value['gene'].'\');" class="resultsbox" id="results">
                    <div class="results-right">
                        <div class="organism"> Organism:'.$species.'</div>
                        <div class="infection agent"> Infection agent: '.$value['infection_agent'].'</div>
                    </div>
                    <div class="results-left">
                        <div class="officialSymbol"> Gene identifier: '.$value['gene'].'</div>
                        <div class="logFC"> Log fold change: '.$value['logFC'].'</div>

                    </div>

                  </div>';
        

        }
        
//        $gene_list_attributes=get_ortholog_list($mappingsCollection,$measurementsCollection,$speciesCollection,$species,$genes,$Topgene);
//
//       
//
//        foreach ($gene_list_attributes as $attributes) {
//
//
//
//            $cpt=0;
//            foreach ($attributes as $key => $value) {
//                if ($cpt==0){
//
//                    echo '<div style="cursor: pointer;" onclick="window.open(\'../result_search_5.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['search'].'\');" class="resultsbox" id="results">
//                            <div class="results-right">
//                                <div class="organism"> Organism:'.$species.'</div>
//                                <div class="infection agent"> Infection agent: '.$attributes['infection_agent'].'</div>
//
//                            </div>
//                            <div class="results-left">
//                                <div class="officialSymbol"> Gene identifier: '.$attributes['search'].'</div>
//                                <div class="logFC"> Log fold change: '.$attributes['logFC'].'</div>
//
//                            </div>
//
//                    </div>';
//                }
//
//
//
//
//                if ($value != "NA"){
//
//
//                    if ($key=="plaza_id"){
//
//                        echo'<div class="panel-group" id="accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'">
//                                <div class="panel panel-default">
//                                    <div class="panel-heading">
//                                        <h3>
//                                            <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-toggle="collapse">
//                                                    Ortholog table 
//                                                    <!--<div id="organism" class="right"><h4></h4></div>-->
//                                            </a>				
//                                        </h3>
//                                    </div>
//                                    <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">
//
//                                        <table class="table table-hover">                                                                
//                                            <thead>
//                                            <tr>';
//                                                //echo "<th>Mapping type</th>";
//                                                echo "<th>Gene ID</th>";
//                                                //echo "<th>Source</th>";
//                                                //echo "<th>tgt ID</th>";
//                                                echo "<th>Transcript/protein ID</th>";
//                                                //echo "<th>Source</th>";
//                                                echo "<th>Species</th>";
//                                                echo'
//                                            </tr>
//                                            </thead>
//
//                                            <tbody>';
//                                                echo table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,$species,$value);
//
//                                       echo'</tbody>
//
//                                        </table>
//                                    </div>
//
//                                </div>
//                            </div>    
//                     <div id="shift_line"></div>';
//
//                    }
//                    else{
//
//                    }
//                }
//                else{
//
//                }
//                $cpt++;
//
//            }
//
//        }
    }
}

    

new_cobra_footer();
////////////////////////////////////////////////////
//echo "</br>";
//$gene_list_attributes=array();
//$species='Solanum lycopersicum';
////$species='Hordeum vulgare';
//$gene_list_attributes=ben_function($mappingsCollection,$measurementsCollection,$speciesCollection,$species);
//foreach ($gene_list_attributes as $attributes) {
//    foreach ($attributes as $key => $value) {
//        echo $key."\r\t";
//        echo $value."\r\n";
//        echo "</br>";
//    }      
//        //echo $attributes['gene'];
//        //$attributes['gene'];
//}







?>







