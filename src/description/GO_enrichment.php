<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Experiments Details","section_experiments","../..");


if ((isset($_POST['search'])) && ($_POST['search']!='')){
    if  ((isset($_POST['min'])) && (isset($_POST['max']))){

        $xp=str_replace("-", ".",$_POST['search']);
        $maxlogFCthreshold=$_POST['max'];
        $minlogFCthreshold=$_POST['min'];
        $db=mongoConnector();
        $full_mappingsCollection = new Mongocollection($db, "full_mappings");
        $measurementsCollection = new Mongocollection($db, "measurements");


        $genes=array();
        


        //get all xp in the measurement collection
        //$data_xp=$measurementsCollection->distinct("xp",array('species'=>'Solanum lycopersicum'));
        //$data_xp=$measurementsCollection->find(array('xp'=>'56e595dae4fe0615a0086582.experimental_results.0'),array('xp'=>1));

        //$global_gene_count=$measurementsCollection->find(array('xp'=>array('$in'=>$data_xp)))->count();
        $global_gene_count=$measurementsCollection->find(array('xp'=>$xp))->count();


        //error_log('global gene number: '.$global_gene_count.'</br>');


        //get total number of gene for this assay
        //echo $xp;


        $deg=array();
        $total_xp_genes=array();
        //$total_genes=$measurementsCollection->find(array('xp'=>$xp))->count();





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

        foreach ($data['result'] as $result) {
            if (isset($result['gene'])&& $result['gene']!='' && $result['gene']!='-'){
                array_push($total_xp_genes, $result['gene']);
                echo (float)$result['logFC'].'</br>';
                if (isset($result['logFC']) && ((float)$result['logFC'] > $maxlogFCthreshold || (float)$result['logFC']< $minlogFCthreshold)){            

                    array_push($deg, $result['gene']);
                }
            }
        }
        $total_diff_exp_genes=count($deg);
        $total_genes=count($total_xp_genes);
        error_log('A total of '.$total_diff_exp_genes.' on '.$total_genes.' genes has been found with logFC higher than '.$maxlogFCthreshold.' and lower than '.$minlogFCthreshold.'</br>');




    /*####################### CODE TOCHECK   
    //    $cursor_global=$full_mappingsCollection->aggregate(array(
    //            array('$match' => array('type'=>'full_table')),  
    //            array('$project' => array('mapping_file'=>1,'_id'=>0)),
    //            array('$unwind'=>'$mapping_file'),
    //            array('$match' => array('mapping_file.Gene ID'=> array('$in' =>$total_xp_genes))),
    //            array('$project' => array("mapping_file.Gene ontology ID"=>1,'mapping_file.Gene ID'=>1,'_id'=>0))
    //        ));
    //    $go_global_id_list=array();
    //    if (count($cursor_global['result'])>0){
    //        //$timestart=microtime(true);
    //        foreach ($cursor_global['result'] as $result) {
    //
    //            if (isset($result['mapping_file']['Gene ontology ID']) && $result['mapping_file']['Gene ontology ID']!='' && $result['mapping_file']['Gene ontology ID']!='NA'){
    //
    //
    //                $gene_id=$result['mapping_file']['Gene ID'];
    //                $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
    //                //echo $gene_id.'</br>';
    //                foreach ($go_id_evidence as $duo) {
    //                    $duo_id=explode("-", $duo); 
    //
    //                    //echo $duo_id[0].'</br>';
    //                    if (array_key_exists($duo_id[0], $go_global_id_list) && $duo_id[0]!='NA') {
    //                        //echo 'key already exists';
    //                        $tmp=$go_global_id_list[$duo_id[0]];
    //                        //echo $tmp;
    //                        $go_global_id_list[$duo_id[0]] = $tmp+1;
    //                        //echo $go_id_list[$duo_id[0]];
    //                    }
    //                    else{
    //                        //echo 'new key';
    //                        //array_push(go_id_list,$duo_id[0]=>0);
    //                        $go_global_id_list[$duo_id[0]] = 0;
    //                    }
    //                }
    //            }
    //        }
    //    }
    //    foreach ($go_global_id_list as $key => $value) {
    //        $percentage=($value/$total_genes)*100;
    //        if ($percentage >= 5){
    //            echo $percentage.'% of genes ('.$value.')shows GO term with id: '.$key.'</br>';
    //            //echo $key.' appears '.$value.' times </br>';
    //        }
    //    }
    //    print_r("============================================</br>");
    //#################################################*/



        $cursor=$full_mappingsCollection->aggregate(array(
                array('$match' => array('type'=>'full_table')),  
                array('$project' => array('mapping_file'=>1,'_id'=>0)),
                array('$unwind'=>'$mapping_file'),
                array('$match' => array('mapping_file.Gene ID'=> array('$in' =>$deg))),
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

                        //echo $duo_id[0].'</br>';
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
        foreach ($go_id_list as $key => $value) {
            $percentage=($value/$total_diff_exp_genes)*100;
            if ($percentage >= 5){
                echo $percentage.'% of genes ('.$value.')shows GO term with id: '.$key.'</br>';
                //echo $key.' appears '.$value.' times </br>';
            }
        }
        error_log("============================================\n");


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



