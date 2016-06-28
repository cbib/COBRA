<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo $Measurement_FK;
//        $x_categories=array();
//        $y_categories=array();
//        $data=$measurementsCollection->aggregate(
//            array(
//              array('$match' => array('xp'=>$Measurement_FK,'$or'=>array(array('logFC'=>array('$gt'=>1.5)),array('logFC'=>array('$lt'=>-1.5))))),  
//              array('$project' => array('gene'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
//
////              array(
////                '$group'=>
////                  array(
////                    '_id'=> array('gene'=> '$gene'),
////                    'logs'=> array('$addToSet'=> array('log'=>'$logFC','dpi'=>'$day_after_inoculation'))
////                  )
////              )
//            )
//        );
//        //var_dump($data['result']);echo '</br>';
//
//         
//        $counter_gene=0;
//        foreach ($data['result'] as $result) {
//         //    var_dump($result);echo '</br>';
//             //echo $result['_id']['gene'];echo '</br>';
//            if ($result['gene'] != ""){
//              
//                array_push($x_categories, $result['gene']);
//                $y_sub_categories=array();
//
////                $tmp_value=0.0;
////                $counter_measures=0;
////                foreach ($result['logs'] as $values) {
////                    $tmp_value+=$values['log'];
////                    //echo $values['log'];echo '</br>';
////                    //echo $values['dpi'];echo '</br>';
////                    $counter_measures++;
////
////                }
//                //$mean_value=$tmp_value/$counter_measures;
//                array_push($y_sub_categories, $counter_gene);
//                array_push($y_sub_categories, 0);
//                array_push($y_sub_categories, $result['logFC']);
//                $counter_gene++;
//
//                array_push($y_categories, $y_sub_categories);
//            }
//
//        }
//        $x_categories = htmlspecialchars( json_encode($x_categories), ENT_QUOTES );
//        $y_categories=json_encode($y_categories);
        
        
        
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
        
        
        //$y_categories = htmlspecialchars( $y_categories, ENT_QUOTES );
        //echo $test;
        
        //$test = json_encode(array( 'row' => 1, 'col' => 6, 'color' => 'pink' ));
        //echo $test;
        
        //echo '<dt>Show heatmap</dt>';
       //echo '<dd><button onclick="show_heatmap(this)" data-dpi="'.$dpi.'" data-series="'.$y_categories.'" data-x="'.$x_categories.'" data-id="'.str_replace(".", "_",$Measurement_FK).'"   id="heatmap_button_'.str_replace(".", "_",$Measurement_FK).'" type="button">Show heatmap</button></dd>';
        
        //
        //
        ////echo' <dd><button onclick="myFunction(this)" data-id="heat_'.str_replace(".", "_",$Measurement_FK).'" data-xcategories="'.$new_x_categories.'" data-title="hello world">Hello world</dd>';
        //<dd><a href="heat_'.str_replace(".", "_",$Measurement_FK).'" onclick="myFunction(this)" data-id="heat_'.str_replace(".", "_",$Measurement_FK).'" data-xcategories="'.$new_x_categories.'" data-title="hello world">Hello world</a></dd>';
//<script type="text/javascript">
//$(document).ready(function() {
//		$('#pretty_table').dataTable( {
//			"scrollX": true,
//			"jQueryUI": true,
//			"pagingType": "full_numbers",
//			"oLanguage": { 
//				"sProcessing":   "Processing...",
//				"sLengthMenu":   "display _MENU_ items",
//				"sZeroRecords":  "No item found",
//				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
//				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
//				"sInfoFiltered": "(filtered from _MAX_ items in total)",
//				"sInfoPostFix":  "",
//				"sSearch":       "Search: ",
//				"sUrl":          "",
//				"oPaginate": {
//					"sFirst":    "First",
//					"sPrevious": "Previous",
//					"sNext":     "Next",
//					"sLast":     "Last"
//				}
//			},
//			"language": {
//							"decimal": ",",
//							"thousands": "."
//				}
//		});
//	});
//    
//</script>