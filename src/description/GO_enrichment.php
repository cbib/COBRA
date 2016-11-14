<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Experiments Details","section_experiments","../..");

unlink("/data/hypergeom_R_results/result.txt");
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
        $GO_enrichCollection = new Mongocollection($db, "go_enrichements");

        
        $today = date("F j, Y, g:i a");
        $document = array("job_owner_firstname" => $_SESSION['lastname'],
                      "job_owner_lastname" => $_SESSION['firstname'],
                      "date" => $today,
                      "xp_id"=> $xp,
                      "job_data" => "null"
                     );
        $GO_enrichCollection->insert($document);
        
        echo'<table class="table dataTable no-footer" id="testTable"> 
             <thead>
             <tr>';
             echo "<th>Date</th>";
             echo "<th>User</th>";
             echo "<th>xp</th>";
        echo'</tr>
             </thead>
             <tbody>';
       echo "<tr>"
        . "<td>".$today."</td>"
        . "<td>".$_SESSION['firstname']."</td>"
        . "<td>".$xp."</td>";
       echo "<tr>";
       echo'</tbody>

       </table>';

                    
        $genes=array();
        


        //get all xp in the measurement collection
        //$data_xp=$measurementsCollection->distinct("xp",array('species'=>'Solanum lycopersicum'));
        //$data_xp=$measurementsCollection->find(array('xp'=>'56e595dae4fe0615a0086582.experimental_results.0'),array('xp'=>1));

        //$global_gene_count=$measurementsCollection->find(array('xp'=>array('$in'=>$data_xp)))->count();
        //$global_gene_count=$measurementsCollection->find(array('xp'=>$xp))->count();


        //error_log('global gene number: '.$global_gene_count.'</br>');


        //get total number of gene for this assay
        //echo $xp;

        
        $deg=array();
        $total_xp_genes=array();
        //$total_genes=$measurementsCollection->find(array('xp'=>$xp))->count();

        $total_genes_for_given_species=$full_mappingsCollection->distinct("mapping_file.Gene ID",array('species'=>$species));
        //error_log(count($total_genes_for_given_species));
        //error_log($xp);
        $total_species_genes=count($total_genes_for_given_species);



        //get all genes upper/lower than the logFC threshold
    //    $data=$measurementsCollection->aggregate(
    //        array(
    //          array('$match' => array('xp'=>$xp,'$or'=>array(array('logFC'=>array('$gt'=>$maxlogFCthreshold)),array('logFC'=>array('$lt'=>$minlogFCthreshold))))),  
    //          array('$project' => array('gene'=>1,'_id'=>0)),
    //        )
    //    );


        $data=$measurementsCollection->aggregate(
            array(
              array('$match' => array('xp'=>$xp,'assay_type'=>'micro-array')),  
              array('$project' => array('gene'=>1,'logFC'=>1,'_id'=>0)),
            )
        );
        //error_log(var_dump($data['result']));
        foreach ($data['result'] as $result) {
            if (isset($result['gene'])&& $result['gene']!="" && $result['gene']!="-"){
                array_push($total_xp_genes, $result['gene']);
                //error_log($result['gene']);
                //error_log($result['logFC']);
                if (isset($result['logFC']) && ((float)$result['logFC'] > $maxlogFCthreshold || (float)$result['logFC']< $minlogFCthreshold)){            

                    array_push($deg, $result['gene']);
                }
            }
        }
        //error_log(json_encode($deg));
        
        
        $total_diff_exp_genes=count($deg);
        $total_genes=count($total_xp_genes);
        //error_log('A total of '.$total_diff_exp_genes.' on '.$total_genes.' genes has been found with logFC higher than '.$maxlogFCthreshold.' and lower than '.$minlogFCthreshold.'</br>');




    



        $cursor=$full_mappingsCollection->aggregate(array(
                array('$match' => array('type'=>'full_table','species'=>$species)),  
                array('$project' => array('mapping_file'=>1,'_id'=>0)),
                array('$unwind'=>'$mapping_file'),
                array('$match' => array('$or'=> array(
                    array('mapping_file.Gene ID'=> array('$in' =>$deg)),
                    array('mapping_file.Gene ID 2'=> array('$in' =>$deg))
                      ))),
    
                array('$project' => array("mapping_file.Gene ontology ID"=>1,'mapping_file.Gene ID'=>1,'_id'=>0))
            ));
        $go_id_list=array();
        if (count($cursor['result'])>0){
            //$timestart=microtime(true);
            foreach ($cursor['result'] as $result) {

                if (isset($result['mapping_file']['Gene ontology ID']) && $result['mapping_file']['Gene ontology ID']!='' && $result['mapping_file']['Gene ontology ID']!='NA'){


                    $gene_id=$result['mapping_file']['Gene ID'];
                    $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
                    //echo $gene_id.'</br>';
                    foreach ($go_id_evidence as $duo) {
                        $duo_id=explode("-", $duo); 

                        //error_log($duo_id[0].'</br>');
                        if (array_key_exists($duo_id[0], $go_id_list) && $duo_id[0]!='NA') {
                            //echo 'key already exists';
                            $tmp=$go_id_list[$duo_id[0]];
                            //echo $tmp;
                            $go_id_list[$duo_id[0]] = $tmp+1;
                            //echo $go_id_list[$duo_id[0]];
                        }
                        else{
                            //echo 'new key';
                            //array_push(go_id_list,$duo_id[0]=>0);
                            $go_id_list[$duo_id[0]] = 0;
                        }
                    }
                }
            }
        }
        
        //error_log("=================SEARCH IDENTIFIED GO TERMS IN ALL GENES===========================");
        foreach ($go_id_list as $key => $value) {
            //error_log($key);
            //$percentage=($value/$total_diff_exp_genes)*100;
            //if ($percentage >= 3){
            
            
            
            
            $cursor_GO=$full_mappingsCollection->aggregate(array(
            array('$match' => array('type'=>'full_table','species'=>$species)),  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.Gene ontology ID'=>new MongoRegex("/$key/xi"))),
            array('$project' => array("mapping_file.Gene ID"=>1,'_id'=>0))
            ));
            $global_value=count($cursor_GO['result']);
            //echo 'GO:0005515 term ID was found in '.count($cursor_GO['result']);
            //if ($value> 10){
                //error_log($value.'/'.$total_diff_exp_genes.' genes shows GO term with id: '.$key.'</br>');
               // error_log(count($cursor_GO['result']).'/'.$total_species_genes.' genes shows GO term with id: '.$key.'</br>');
                        //echo $key.' appears '.$value.' times </br>';
            //}


            //$GO_name=$GOCollection->find(array('GO_collections.id'=>$key),array('GO_collections.$'=>1,'_id'=>0));
            $GO_cursor=$GOCollection->aggregate(array(
            array('$project' => array('GO_collections'=>1,'_id'=>0)),
            array('$unwind'=>'$GO_collections'),
            array('$match' => array('GO_collections.id'=>$key)),
            array('$project' => array('GO_collections.name'=>1,'_id'=>0))
            ));
            
            
            
            foreach ($GO_cursor['result'] as $value_name) {
               $GO_name=$value_name['GO_collections']['name'];    
            }
            $GO_name=str_replace(" ", "_",$GO_name);
                
            
            $result_file = "/data/hypergeom_R_results/result.txt";
            
            $rscript="/data/hypergeom_R_results/my_rscript.R";
            $output = shell_exec("Rscript $rscript $value $global_value $total_species_genes $total_diff_exp_genes $key $GO_name>> $result_file");
            //$output = shell_exec("/data/applications/ncbi-blast-2.2.31+/bin/blastx -query $query_file -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out $result_file -outfmt 13");


                //}
        }
        $result_file_sorted = "/data/hypergeom_R_results/result_sorted.txt";
        $output = shell_exec("sort $result_file > $result_file_sorted");

        //error_log("============================================\n");

        
        
        //GO:0005515
        
        
        
//        ####################### CODE TOCHECK   
//        $cursor_global=$full_mappingsCollection->aggregate(array(
//                array('$match' => array('type'=>'full_table')),  
//                array('$project' => array('mapping_file'=>1,'_id'=>0)),
//                array('$unwind'=>'$mapping_file'),
//                array('$match' => array('$or'=> array(
//                    array('mapping_file.Gene ID'=> array('$in' =>$total_xp_genes)),
//                    array('mapping_file.Gene ID 2'=> array('$in' =>$total_xp_genes))
//                      ))),                array('$project' => array("mapping_file.Gene ontology ID"=>1,'mapping_file.Gene ID'=>1,'_id'=>0))
//            ));
//        $go_global_id_list=array();
//        if (count($cursor_global['result'])>0){
//            //$timestart=microtime(true);
//            foreach ($cursor_global['result'] as $result) {
//    
//                if (isset($result['mapping_file']['Gene ontology ID']) && $result['mapping_file']['Gene ontology ID']!='' && $result['mapping_file']['Gene ontology ID']!='NA'){
//    
//    
//                    $gene_id=$result['mapping_file']['Gene ID'];
//                    $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
//                    //echo $gene_id.'</br>';
//                    foreach ($go_id_evidence as $duo) {
//                        $duo_id=explode("-", $duo); 
//    
//                        //echo $duo_id[0].'</br>';
//                        if (array_key_exists($duo_id[0], $go_global_id_list) && $duo_id[0]!='NA') {
//                            //echo 'key already exists';
//                            $tmp=$go_global_id_list[$duo_id[0]];
//                            //echo $tmp;
//                            $go_global_id_list[$duo_id[0]] = $tmp+1;
//                            //echo $go_id_list[$duo_id[0]];
//                        }
//                        else{
//                            //echo 'new key';
//                            //array_push(go_id_list,$duo_id[0]=>0);
//                            $go_global_id_list[$duo_id[0]] = 0;
//                        }
//                    }
//                }
//            }
//        }
//        foreach ($go_global_id_list as $key => $value) {
//            $percentage=($value/$total_genes)*100;
//            if ($percentage >= 3){
//                error_log($percentage.'% of total genes ('.$value.')shows GO term with id: '.$key.'</br>');
//                //echo $key.' appears '.$value.' times </br>';
//            }
//        }
//        print_r("============================================</br>");
    #################################################
        
        
        
        
        
        
        
        
        

        $x_categories=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $y_categories=array(
            array(
                'name'=> 'Tokyo',
                'data'=> array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4)

            ),
            array(
                'name'=> 'New York',
                'data'=> array(83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3)

            ), array(
                'name'=> 'London',
                'data'=> array(48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2)

            ), array(
                'name'=> 'Berlin',
                'data'=> array(42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1)

            ));


        $x_categories = htmlspecialchars( json_encode($x_categories), ENT_QUOTES );
        $y_categories = htmlspecialchars( json_encode($y_categories), ENT_QUOTES );
        //$y_categories=json_encode($y_categories);
        //error_log($y_categories);
        //error_log('<div class="GO_'.str_replace(".", "-",$xp).'" data-series="'.$y_categories.'" data-x="'.$x_categories.'">GO enrichment</div>'); 

        echo '<div class="GO_'.str_replace(".", "-",$xp).'" data-series="'.$y_categories.'" data-x="'.$x_categories.'">'
           . 'GO enrichment'
           . '</div>';
    }

}
new_cobra_footer();



