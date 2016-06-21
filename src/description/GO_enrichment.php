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


$data_xp=$measurementsCollection->distinct("xp");
//var_dump($data_xp);
foreach ($data_xp as $xp) {
    
    $total_genes=0;
    $data=$measurementsCollection->aggregate(
        array(
          array('$match' => array('xp'=>$xp,'$or'=>array(array('logFC'=>array('$gt'=>$maxlogFCthreshold)),array('logFC'=>array('$lt'=>$minlogFCthreshold))))),  
          array('$project' => array('gene'=>1,'_id'=>0)),
        )
    );





    foreach ($data['result'] as $result) {
        if ($result['gene'] != ""){
            //echo $result['gene'];
            array_push($genes, $result['gene']);
        }



    }
    $total_genes=count($genes);
    echo 'A total of '.count($genes).' genes has been found with logFC higher than '.$maxlogFCthreshold.' and lower than '.$minlogFCthreshold.'</br>';

    //$cursor=$full_mappingsCollection->aggregate(array(
    //        array('$match' => array('type'=>'full_table','species'=>$species)),  
    //        array('$project' => array('mapping_file'=>1,'_id'=>0)),
    //        array('$unwind'=>'$mapping_file'),
    //        array('$match' => array('$or'=> array(
    //            array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),
    //            array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi"))))),
    //        array('$project' => array("mapping_file"=>1,'_id'=>0))
    //    ));


    $cursor=$full_mappingsCollection->aggregate(array(
            array('$match' => array('type'=>'full_table')),  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.Gene ID'=> array('$in' =>$genes))),
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
                    if (array_key_exists($duo_id[0], $go_id_list)) {
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






    //                if (in_array($duo_id[0], $go_used_list)){
    //                    for ($i = 0; $i < count($go_id_list); $i++) {
    //                        if ($go_id_list[$i][0]===$duo_id[0]){
    //                           if (!in_array($duo_id[1], $go_id_list[$i][1])){
    //                               array_push($go_id_list[$i][1], $duo_id[1]); 
    //                           }                           
    //                        }
    //                    }
    //                }
    //                else{
    //                    $tmp_array=array();
    //                    $tmp_array[0]=$duo_id[0];
    //                    $tmp_array[1]=array($duo_id[1]);
    //                    array_push($go_id_list,$tmp_array);
    //                    array_push($go_used_list,$duo_id[0]);   
    //                }
                }


            }


        }
    }



    foreach ($go_id_list as $key => $value) {
        $percentage=($value/$total_genes)*100;
        if ($percentage >= 7){
            echo $percentage.'% of genes shows GO term with id: '.$key.'</br>';
            //echo $key.' appears '.$value.' times </br>';
        }
    }
    print_r("============================================\n");
    
}
new_cobra_footer();



