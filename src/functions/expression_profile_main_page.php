<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_load_profile","../..");





if (isset($_POST['gene_ids'],$_POST['transcript_ids'],$_POST['protein_ids'],$_POST['genebis_ids'],$_POST['alias_ids'])) {
    
$db=mongoConnector();
$measurementsCollection = new Mongocollection($db, "measurements");
$samplesCollection=new Mongocollection($db, "samples");

$gene_id=json_decode($_POST['gene_ids']);
//$test=json_decode($gene_id);

$transcript_id=json_decode($_POST['transcript_ids']);
$protein_id=json_decode($_POST['protein_ids']);
$gene_id_bis=json_decode($_POST['genebis_ids']);
$gene_alias=json_decode($_POST['alias_ids']);
$species=$_POST['species'];
//error_log($test);
$series=array();
$categories=array();

$xp_name=array();
//foreach ($test as $id) {
//    error_log($id);
    
//}
$cursor=$measurementsCollection->find(array(
'$and'=>array(
    array('$or'=> array(
        array('gene'=>array('$in'=>$gene_id)),
        array('gene'=>array('$in'=>$transcript_id)),
        array('gene'=>array('$in'=>$protein_id)),
        array('gene'=>array('$in'=>$gene_id_bis)),
        array('gene'=>array('$in'=>$gene_alias))
    )),
    array('gene'=> array('$ne'=>""))
)),
array('_id'=>0)
);
$counter=1;

foreach ($cursor as $result) {
    $logfc_array=array();
    $xp_full_name=explode(".", $result['xp']);
    #$first_condition=$result['first_condition'];
    #$second_condition=$result['second_condition'];

    $experiment_id=$xp_full_name[0];
    #$xp_name=explode(".", get_experiment_name_with_id($samplesCollection,$experiment_id));
    $xp_name=get_experiment_name_with_id($samplesCollection,$experiment_id);

    //error_log($xp_name[0]);

    $species=$result['species'];


    if (isset($result['day_after_inoculation'])){
        if (isset($result['variety'])){
           $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
            //$categories[$gene_id[0]]= $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']; 
            array_push($categories, $result['variety'].'/Day '.$result['day_after_inoculation']); 
        }
        else{
            $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
            //$categories[$gene_id[0]]= $result['species'].'/Day '.$result['day_after_inoculation'];

            array_push($categories, '/Day '.$result['day_after_inoculation']);
        }
    }
    else{
        if (isset($result['variety'])){
           $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
           ///$categories[$gene_id[0]]=  $result['species'].'/'.$result['variety'];
            array_push($categories, $result['variety']); 
        }
        else{
            $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
            //$categories[$gene_id[0]]=  $result['species'];
            array_push($categories, $result['species']);
        }
    }
    //description/experiments.php?xp=

    array_push($logfc_array, $sample);
    $counter++;
    $sample=array('name'=>$xp_name,'data'=>$logfc_array);
    array_push($series, $sample);
}


#$sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
#array_push($series, $sample);
//$global_array=array($categories,$series);



//error_log()json_encode($series);
//$categories = htmlspecialchars( json_encode($categories), ENT_QUOTES );
//$series = htmlspecialchars( json_encode($series), ENT_QUOTES );
//$y_categories=json_encode($y_categories);
//error_log($y_categories);
//error_log('<div class="GO_'.str_replace(".", "-",$xp).'" data-series="'.$y_categories.'" data-x="'.$x_categories.'">GO enrichment</div>'); 


//error_log('<div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" data-species="'.$species.'" data-series="'.htmlspecialchars( json_encode($series), ENT_QUOTES ).'" data-categories="'.htmlspecialchars( json_encode($categories), ENT_QUOTES ).'" style="min-width: 310px; height: 400px;"></div>');

echo '<div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" data-species="'.$species.'" data-series="'.htmlspecialchars( json_encode($series), ENT_QUOTES ).'" data-categories="'.htmlspecialchars( json_encode($categories), ENT_QUOTES ).'" style="min-width: 310px; height: 400px;"></div>';


}






/*echo'<div id="expression_profile_section">
                <h3>Expression profile</h3>
                <div  class="panel-group" id="accordion_documents_expression">
                    <div  class="panel panel-default">
                        <div class="panel-heading">
                            <a class="accordion-toggle collapsed" href="#expression-chart" data-parent="#accordion_documents_expression" data-toggle="collapse">
                                <strong onclick="load_expression_profiles(this)"  data-test="hello ben" >  Expression data</strong>
                            </a>				
                        </div>
                        <div class="panel-body panel-collapse collapse" id="expression-chart"  >
                            <div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" data-species="'.$species.'" style="min-width: 310px; height: 400px;"></div>
                        </div>
                    </div>
                </div>'; 
           echo'<div id="shift_line"></div>'                
          . '</div>'; */
//var_dump($global_array);




new_cobra_footer();	