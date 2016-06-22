<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Experiments Details","section_experiments","../..");

$db=mongoConnector();
$full_mappingsCollection = new Mongocollection($db, "full_mappings");
$measurementsCollection = new Mongocollection($db, "measurements");


$genes=array();
$maxlogFCthreshold=2;
$minlogFCthreshold=-2;


//get all xp in the measurement collection
$data_xp=$measurementsCollection->distinct("xp",array('species'=>'Solanum lycopersicum'));
//$data_xp=$measurementsCollection->find(array('xp'=>'56e595dae4fe0615a0086582.experimental_results.0'),array('xp'=>1));

//$global_gene_count=$measurementsCollection->find(array('xp'=>array('$in'=>$data_xp)))->count();
$global_gene_count=$measurementsCollection->find(array('xp'=>'56e595dae4fe0615a0086582.experimental_results.0'))->count();


echo 'global gene number: '.$global_gene_count.'</br>';
foreach ($data_xp as $xp) {
    
    //get total number of gene for this assay
    //echo $xp;
    
    if ($xp==='56e595dae4fe0615a0086582.experimental_results.0'){
    
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
          array('$match' => array('xp'=>$xp)),  
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
    echo 'A total of '.$total_diff_exp_genes.' on '.$total_genes.' genes has been found with logFC higher than '.$maxlogFCthreshold.' and lower than '.$minlogFCthreshold.'</br>';

    //$cursor=$full_mappingsCollection->aggregate(array(
    //        array('$match' => array('type'=>'full_table','species'=>$species)),  
    //        array('$project' => array('mapping_file'=>1,'_id'=>0)),
    //        array('$unwind'=>'$mapping_file'),
    //        array('$match' => array('$or'=> array(
    //            array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),
    //            array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi"))))),
    //        array('$project' => array("mapping_file"=>1,'_id'=>0))
    //    ));

    $cursor_global=$full_mappingsCollection->aggregate(array(
            array('$match' => array('type'=>'full_table')),  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.Gene ID'=> array('$in' =>$total_xp_genes))),
            array('$project' => array("mapping_file.Gene ontology ID"=>1,'mapping_file.Gene ID'=>1,'_id'=>0))
        ));
    $go_global_id_list=array();
    if (count($cursor_global['result'])>0){
        //$timestart=microtime(true);
        foreach ($cursor_global['result'] as $result) {

            if (isset($result['mapping_file']['Gene ontology ID']) && $result['mapping_file']['Gene ontology ID']!='' && $result['mapping_file']['Gene ontology ID']!='NA'){


                $gene_id=$result['mapping_file']['Gene ID'];
                $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
                //echo $gene_id.'</br>';
                foreach ($go_id_evidence as $duo) {
                    $duo_id=explode("-", $duo); 

                    //echo $duo_id[0].'</br>';
                    if (array_key_exists($duo_id[0], $go_global_id_list) && $duo_id[0]!='NA') {
                        //echo 'key already exists';
                        $tmp=$go_global_id_list[$duo_id[0]];
                        //echo $tmp;
                        $go_global_id_list[$duo_id[0]] = $tmp+1;
                        //echo $go_id_list[$duo_id[0]];
                    }
                    else{
                        //echo 'new key';
                        //array_push(go_id_list,$duo_id[0]=>0);
                        $go_global_id_list[$duo_id[0]] = 0;
                    }
                }
            }
        }
    }
    
    
    foreach ($go_global_id_list as $key => $value) {
        $percentage=($value/$total_genes)*100;
        if ($percentage >= 5){
            echo $percentage.'% of genes ('.$value.')shows GO term with id: '.$key.'</br>';
            //echo $key.' appears '.$value.' times </br>';
        }
    }
    print_r("============================================</br>");
    
    
    
    
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
    print_r("============================================</br>");
    }
}
new_cobra_footer();



