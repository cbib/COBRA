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
    $transcript_id=json_decode($_POST['transcript_ids']);
    $protein_id=json_decode($_POST['protein_ids']);
    $gene_id_bis=json_decode($_POST['genebis_ids']);
    $gene_alias=json_decode($_POST['alias_ids']);
    $species=$_POST['species'];
    $series=array();
    $categories=array();
    $xp_name=array();

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
    if (count($cursor)==0){
        foreach ($cursor as $result) {
            $logfc_array=array();
            $xp_full_name=explode(".", $result['xp']);
            $experiment_id=$xp_full_name[0];
            $xp_name=get_experiment_name_with_id($samplesCollection,$experiment_id);
            $species=$result['species'];

            if (isset($result['day_after_inoculation'])){
                if (isset($result['variety'])){
                   $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                    array_push($categories, $result['variety'].'/Day '.$result['day_after_inoculation']); 
                }
                else{
                    $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                    array_push($categories, '/Day '.$result['day_after_inoculation']);
                }
            }
            else{
                if (isset($result['variety'])){
                   $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                    array_push($categories, $result['variety']); 
                }
                else{
                    $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                    array_push($categories, $result['species']);
                }
            }


            array_push($logfc_array, $sample);
            $counter++;
            $sample=array('name'=>$xp_name,'data'=>$logfc_array);
            array_push($series, $sample);
        }

        echo '<div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" data-species="'.$species.'" data-series="'.htmlspecialchars( json_encode($series), ENT_QUOTES ).'" data-categories="'.htmlspecialchars( json_encode($categories), ENT_QUOTES ).'" style="min-width: 310px; height: 400px;"></div>';

    }
    else{
        echo '<p class="no_results"> No results found </p>';
    }
}

new_cobra_footer();	