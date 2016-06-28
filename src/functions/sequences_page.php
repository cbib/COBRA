<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_sequence","../..");


if (isset($_POST['gene_ids'],$_POST['gene_ids_bis'],$_POST['species'],$_POST['mode'])){  
    
    $db=mongoConnector();  
    $gene_id=json_decode($_POST['gene_ids']);
    $gene_id_bis=json_decode($_POST['gene_ids_bis']);
    $species=$_POST['species'];
    $mode=$_POST['mode'];
    $sequencesCollection = new Mongocollection($db, "sequences");
    $transcript_id=count_transcript_for_gene($sequencesCollection,$gene_id,$gene_id_bis);
    
    if ($mode==="transcript"){
    
        for ($i=0;$i<count($transcript_id);$i++){
            $sequence_metadata=$sequencesCollection->find(array('mapping_file.Transcript ID'=>$transcript_id[$i]),array('mapping_file.$'=>1));
            foreach ($sequence_metadata as $data) {
                foreach ($data as $key=>$value) {
                    if ($key==="mapping_file"){
                        foreach ($value as $values) {

                            //echo '<TEXTAREA name="nom" rows=9 cols=60>'.$values['Sequence'].'</TEXTAREA></br>'; 
                            //echo '<pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">'.'>'.$values['Transcript ID'].'</br>'.$values['Transcript Sequence'].'</pre></br>';


                            echo '<div class="tr_results" ><pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">';
                            echo '>'.$values['Transcript ID'].'</br>';
                            for ($j=1;$j<=strlen($values['Transcript Sequence']);$j++){
                                if (($j%60===0) && ($j!==1)){
                                    echo $values['Transcript Sequence'][$j-1].'</br>';
                                }
                                else{
                                    echo $values['Transcript Sequence'][$j-1];
                                }

                            }
                            echo '</pre></br>';



                            echo  '<button onclick="runBlast(this)" data-species="'.$species.'" data-id="'.str_replace(".", "__", $values['Transcript ID']).'"  data-sequence="'.$values['Transcript Sequence'].'" id="blast_button" type="button">Blast sequence</button>';
                            echo '</br>';
                            echo '  <center>
                                        <div class="loading_'.str_replace(".", "__", $values['Transcript ID']).'" style="display: none">


                                        </div>
                                    </center>
                                <div class="container animated fadeInDown">
                                    <div class="content_test_'.str_replace(".", "__", $values['Transcript ID']).'">

                                    </div>
                                </div>
                            </div>';
                        }
                    }
                }
            }
        }
    }
    else{
        error_log($_POST['mode']);
        $sequence_metadata=$sequencesCollection->find(array('tgt'=>'Gene_Sequence','mapping_file.Gene ID'=>$gene_id[0]),array('mapping_file.$'=>1));
            foreach ($sequence_metadata as $data) {
                foreach ($data as $key=>$value) {
                    if ($key==="mapping_file"){
                        foreach ($value as $values) {

                            //echo '<TEXTAREA name="nom" rows=9 cols=60>'.$values['Sequence'].'</TEXTAREA></br>'; 
                            //echo '<pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">'.'>'.$values['Gene ID'].'</br>'.$values['Gene Sequence'].'</pre></br>';
                            echo '<div class="un_results"><pre style="margin-right: 1%; margin-left: 1%; width=100%; text-align: left">';
                            echo '>'.$values['Gene ID'].'</br>';
                            for ($j=1;$j<=strlen($values['Gene Sequence']);$j++){
                                if (($j%60===0) && ($j!==1)){
                                    echo $values['Gene Sequence'][$j-1].'</br>';
                                }
                                else{
                                    echo $values['Gene Sequence'][$j-1];
                                }

                            }
                            echo '</pre></br></div>';
                        }
                    }
                }
            }
    }

    
    

}
new_cobra_footer();	

