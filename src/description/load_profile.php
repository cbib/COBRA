<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_load_profile","../..");

if ((isset($_POST['search'])) && ($_POST['search']!='')){
    if  ((isset($_POST['min'])) && (isset($_POST['max']))){
    
        $db=mongoConnector();
        $measurementsCollection = new Mongocollection($db, "measurements");
        $clicked_id=str_replace("-", ".",$_POST['search']);
        $x_categories=array();
        $y_categories=array();
        $maxlogFCthreshold=$_POST['max'];
        $minlogFCthreshold=$_POST['min'];
        $total_genes=$measurementsCollection->find(array('xp'=>$clicked_id))->count();
        
        //error_log($minlogFCthreshold);
        
        $data=$measurementsCollection->aggregate(
            array(
              array('$match'   => array('xp'    =>$clicked_id,'$or'=>array(array('logFC'=>array('$gt'=>(float)$maxlogFCthreshold)),array('logFC'=>array('$lt'=>(float)$minlogFCthreshold))))),  
              array('$project' => array('gene'  =>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
              array('$sort'    => array('logFC' => 1 ))

    //              array(
    //                '$group'=>
    //                  array(
    //                    '_id'=> array('gene'=> '$gene'),
    //                    'logs'=> array('$addToSet'=> array('log'=>'$logFC','dpi'=>'$day_after_inoculation'))
    //                  )
    //              )
            )
         );
       
         //var_dump($data['result']);echo '</br>';


         $counter_gene=0;
         foreach ($data['result'] as $result) {
         //    var_dump($result);echo '</br>';
             //error_log($result['gene'].'</br>');//echo '</br>';
             if ($result['gene'] != "" && $result['gene'] != "NA"){
                $dpi=$result['day_after_inoculation'];
                array_push($x_categories, $result['gene']);
                $y_sub_categories=array();

    //                $tmp_value=0.0;
    //                $counter_measures=0;
    //                foreach ($result['logs'] as $values) {
    //                    $tmp_value+=$values['log'];
    //                    //echo $values['log'];echo '</br>';
    //                    //echo $values['dpi'];echo '</br>';
    //                    $counter_measures++;
    //
    //                }
                //$mean_value=$tmp_value/$counter_measures;
                array_push($y_sub_categories, $counter_gene);
                array_push($y_sub_categories, 0);
                array_push($y_sub_categories, $result['logFC']);
                $counter_gene++;

                array_push($y_categories, $y_sub_categories);
             }

         }

    /*        $data_gene_to_keep=$measurementsCollection->aggregate(
    //            array(
    //              array('$match' => array('xp'=>$Measurement_FK,'$or'=>array(array('logFC'=>array('$gt'=>1.5)),array('logFC'=>array('$lt'=>-1.5))))),  
    //              array('$project' => array('gene'=>1,'xp'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
    //              array(
    //                '$group'=>
    //                  array(
    //                    '_id'=> array('gene'=> '$gene'),
    //                    'logs'=> array('$addToSet'=> array('xp'=>'$xp'))
    //                  )
    //              )
    //        ));
    //        //var_dump($data_gene_to_keep);
    //        $new_x_categories=array();
    //        foreach ($data_gene_to_keep['result'] as $value) {
    //            //if (count($value['logs'])===3){
    //            //echo $value['_id']['gene'];echo '</br>';
    //            array_push($new_x_categories, $value['_id']['gene']);
    //
    ////                foreach ($value['logs'] as $values) {
    ////                    echo $values['xp'];echo '</br>';
    ////                }
    //            //}
    //
    //
    //        }*/

        $x_categories = htmlspecialchars( json_encode($x_categories), ENT_QUOTES );
        $y_categories=json_encode($y_categories);
        //error_log(str_replace(".", "-",$clicked_id));
        //$y_categories = htmlspecialchars( $y_categories, ENT_QUOTES );

        echo '<div class="heatmap_'.str_replace(".", "-",$clicked_id).'" data-dpi="'.$dpi.'"data-total="'.$total_genes.'" data-total-diff="'.$counter_gene.'" data-series="'.$y_categories.'" data-x="'.$x_categories.'">HEATMAP</div>';  
    }
        
    //error_log('<div id="heatmap_'.str_replace(".", "__",$clicked_id).'" data-series="'.$y_categories.'" data-x="'.$x_categories.'"> </div>');
    
}
new_cobra_footer();	

