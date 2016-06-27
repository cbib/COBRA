<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_variation_profile","../..");



if (isset($_POST['gene_ids'],$_POST['species'],$_POST['start'],$_POST['end'],$_POST['scaffold'],$_POST['mode'])){    
    $db=mongoConnector();       
    $variation_collection = new Mongocollection($db, "variations");
    $genetic_markers_collection=new Mongocollection($db, "genetic_markers");
    $qtl_collection=new Mongocollection($db, "qtls");
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");

    $gene_id=json_decode($_POST['gene_ids']);
    $species=$_POST['species'];
    $gene_start=$_POST['start'];
    $gene_end=$_POST['end'];
    $scaffold=$_POST['scaffold'];
    $mode=$_POST['mode'];

    $genetic_markers_result=array();

    if ($species==="Prunus persica"){


        $scaffold='scaffold_'.$scaffold;
        $genetic_markers_result=$genetic_markers_collection->aggregate(array(  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('$or'=>array(array('$and'=> array(
                                            array('mapping_file.Start'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.Start'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold )))
                                            ,
                                            array('$and'=> array(
                                            array('mapping_file.End'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.End'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold )))
                                            )
                                        )
                                    ),
            array('$project'=>  array('mapping_file.Marker ID'=> 1, 'mapping_file.HREF_markers'=> 1,'mapping_file.HREF_species'=> 1,'mapping_file.Species'=>1,'mapping_file.Start'=>1,'mapping_file.End'=>1,'mapping_file.Map ID'=>1,'mapping_file.Chromosome'=>1,'mapping_file.Type'=>1,'mapping_file.Linkage Group'=>1,'mapping_file.StartcM'=>1,'_id'=> 0))

        ));



        //echo 'start: '.$gene_start.'- end: '.$gene_end.' chrom: '.$scaffold;

        $var_results=$variation_collection->aggregate(array(
                    array('$match' => array('species'=> $species)),  
                    array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                    array('$unwind'=>'$mapping_file'),
                    array('$match' => array('$and'=> array(
                                                    array('mapping_file.Position'=>array('$gt'=> (int)$gene_start )),
                                                    array('mapping_file.Position'=>array('$lt'=> (int)$gene_end )),
                                                    array('mapping_file.Scaffold'=> $scaffold )
                                                    )
                                            )
                         ),
                    array('$project'=>  array('mapping_file.Variant ID'=> 1, 'mapping_file.Position'=>1,'mapping_file.Alleles'=>1))

                ));
        //foreach ($var_results as $value) {
        //     echo $value['mapping_file'];       
        //}

    }
    else if ($species==="Cucumis melo"){

        $scaffold_number=  explode('chr', $scaffold);
        $genetic_markers_result=$genetic_markers_collection->aggregate(array(  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('$and'=> array(
                                            array('mapping_file.Start'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.Start'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold_number[1] )
                                                )
                                    )
                ),
            array('$project'=>  array('mapping_file.Marker ID'=> 1,'mapping_file.Start'=>1,'mapping_file.Chromosome'=>1,'mapping_file.Type'=>1,'mapping_file.LG_ICuGI'=>1,'mapping_file.cM_ICuGI'=>1,'_id'=> 0))

        ));
    }
    else if($species==="Hordeum vulgare"){
        //http://archive.gramene.org/db/markers/marker_view?marker_name=AQGV002&vocabulary=markers&search_box_name=marker_name&search_box_id=marker_search_for&marker_type_id=20&taxonomy=Hordeum&action=marker_search&x=3&y=11
    }
    else{
        $var_results=$variation_collection->aggregate(array(
                    array('$match' => array('species'=> $species)),  
                    array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                    array('$unwind'=>'$mapping_file'),
                    array('$match' =>  array('mapping_file.Gene ID'=>array('$in'=>$gene_id))), 
                    array('$project'=>  array('mapping_file.Variant ID'=> 1,'mapping_file.Gene ID'=> 1, 'mapping_file.Position'=>1,'mapping_file.Description'=>1, 'mapping_file.Alleles'=>1))

                ));
    }
    
    if (isset($genetic_markers_result['result']) && count ($genetic_markers_result['result'])>0){
        //echo count ($genetic_markers_result['result']);
        if ($mode==="GM"){
            echo'<table class="table" id="table_markers">  
                <thead>
                <tr>';
                //echo "<th>gene ID</th>";
                if ($species === "Cucumis melo"){
                        echo "<th>Marker ID</th>";
                        echo "<th>Type</th>";
                        echo "<th>Start</th>";            
                        echo "<th>Chromosome</th>";
                        echo "<th>Linkage group</th>";
                        echo "<th>Position (cM)</th>";                                                       
                        echo "<th>Species</th>";

                        echo'
                    </tr>
                    </thead>

                    <tbody>';

                        foreach ($genetic_markers_result['result'] as $value) {
                            foreach($value as $data){
                                echo "<tr>";
                                //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                echo '<td>'.$data['Marker ID'].'</td>';
                                echo '<td>'.$data['Type'].'</td>';
                                echo '<td>'.$data['Start'].'</td>';                                              
                                echo '<td>'.$data['Chromosome'].'</td>';
                                echo '<td>'.$data['LG_ICuGI'].'</td>';
                                echo '<td>'.$data['cM_ICuGI'].'</td>';
                                echo '<td>'.$species.'</td>'; 


                                echo "</tr>";
                            }


                        }


                    echo'</tbody>

            </table>';
                }
                else{


                        echo "<th>Marker ID</th>";
                        echo "<th>Type</th>";
                        echo "<th>Start</th>";
                        echo "<th>End</th>";
                        echo "<th>Chromosome</th>";
                        echo "<th>Linkage group</th>";
                        echo "<th>Position (cM)</th>";
                        echo "<th>Map ID</th>";
                        echo "<th>Species</th>";

                        echo'
                    </tr>
                    </thead>

                    <tbody>';

                        foreach ($genetic_markers_result['result'] as $value) {
                            foreach($value as $data){
                                echo "<tr>";
                                //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                //echo '<td>'.$data['Gene ID'].'</td>';
                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data['HREF_markers'].'/'.$data['Marker ID'].'">'.$data['Marker ID'].'</a></td>';
                                echo '<td>'.$data['Type'].'</td>';
                                echo '<td>'.$data['Start'].'</td>';
                                echo '<td>'.$data['End'].'</td>';
                                echo '<td>'.$data['Chromosome'].'</td>';
                                $lg=explode(".",$data['Linkage Group']);
                                echo '<td>'.$lg[1].'</td>';
                                echo '<td>'.$data['StartcM'].'</td>';
                                echo '<td>'.$data['Map ID'].'</td>';
                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data['HREF_species'].'/'.$data['Species'].'">'.$data['Species'].'</a></td>';


                                echo "</tr>";
                            }


                        }


                    echo'</tbody>

            </table>';


            }
        }
        else{
            if ($species === "Cucumis melo"){
                echo'<table class="table" id="table_qtls">  
                        <thead>
                        <tr>';
                //echo "<th>gene ID</th>";
                echo "<th>QTL ID</th>";
                echo "<th>Map ID</th>";
                echo "<th>Start</th>";
                echo "<th>End</th>";
                echo "<th>Marker 1</th>"; 
                echo "<th>Marker 2</th>";
                echo'   </tr></thead><tbody>';
                $marker_list=array();
                foreach ($genetic_markers_result['result'] as $value) {
                    foreach($value as $data){
                        $marker_id=$data['Marker ID']; 
                        if (!in_array($marker_id, $marker_list)){
                            $genetic_qtls_result=$qtl_collection->aggregate(array(  
                                array('$project' => array('mapping_file'=>1,'_id'=>0)),
                                array('$unwind'=>'$mapping_file'),
                                array('$match' => array('$or'=> array(
                                            //array('mapping_file.Colocalizing marker'=>new MongoRegex("/^$marker_id/xi")),
                                            array('mapping_file.Marker ID'=>$marker_id),
                                            //array('mapping_file.Marker ID'=>new MongoRegex("/^$marker_id/xi"))
                                            array('mapping_file.Marker ID 2'=>$marker_id)
                                        )
                                    )
                                ),
                                array('$project'=>  array('mapping_file.QTL ID'=> 1, 'mapping_file.Map ID'=>1,'mapping_file.Marker ID'=>1,'mapping_file.Marker ID 2'=>1,'mapping_file.Start'=>1,'mapping_file.End'=>1,'_id'=> 0))
                            ));
                            foreach ($genetic_qtls_result['result'] as $value_qtl) {
                                foreach($value_qtl as $data_qtl){
                                    echo "<tr>";
                                    //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                    echo '<td>'.$data['QTL ID'].'</td>';
                                    //echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data_qtl['HREF_QTL'].'/'.$data_qtl['QTL ID'].'">'.$data_qtl['QTL ID'].'</a></td>';
                                    echo '<td>'.$data_qtl['Map ID'].'</td>';
                                    echo '<td>'.$data_qtl['Start'].'</td>';
                                    echo '<td>'.$data_qtl['End'].'</td>';
                                    echo '<td>'.$data_qtl['Marker ID'].'</td>';
                                    echo '<td>'.$data_qtl['Marker ID 2'].'</td>';
                                    //echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$href_marker.'/'.$marker_id.'">'.$marker_id.'</a></td>';


                                    echo "</tr>";
                                }
                            }
                            array_push($marker_list, $marker_id);
                        }
                    }   
                }
                echo'</tbody></table>';
            }
            else{
                echo'<table class="table" id="table_qtls"><thead><tr>';
                //echo "<th>gene ID</th>";
                echo "<th>QTL ID</th>";
                echo "<th>Trait Name</th>";
                echo "<th>Trait Alias</th>";
                echo "<th>Study</th>";
                echo "<th>Species</th>"; 
                echo "<th>Marker</th>";
                echo'</tr></thead><tbody>';
                $marker_list=array();
                foreach ($genetic_markers_result['result'] as $value) {
                    foreach($value as $data){



                        $href_marker=$data['HREF_markers'];
                        $marker_id=$data['Marker ID'];

                        if (!in_array($marker_id, $marker_list)){
                            $genetic_qtls_result=$qtl_collection->aggregate(array(  
                                array('$project' => array('mapping_file'=>1,'_id'=>0)),
                                array('$unwind'=>'$mapping_file'),
                                array('$match' => array('$or'=> array(
                                                                //array('mapping_file.Colocalizing marker'=>new MongoRegex("/^$marker_id/xi")),
                                                                array('mapping_file.Colocalizing marker'=>$marker_id),
                                                                //array('mapping_file.Marker ID'=>new MongoRegex("/^$marker_id/xi"))
                                                                array('mapping_file.Marker ID'=>$marker_id)
                                                                )
                                                        )
                                     ),
                                array('$project'=>  array('mapping_file.QTL ID'=> 1,'mapping_file.Trait Name'=> 1,'mapping_file.Species'=> 1,'mapping_file.HREF_QTL'=> 1, 'mapping_file.Trait Alias'=> 1,'mapping_file.Study'=>1,'_id'=> 0))

                            ));
                            foreach ($genetic_qtls_result['result'] as $value_qtl) {
                                foreach($value_qtl as $data_qtl){
                                    echo "<tr>";
                                    //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                    //echo '<td>'.$data['Gene ID'].'</td>';
                                    echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data_qtl['HREF_QTL'].'/'.$data_qtl['QTL ID'].'">'.$data_qtl['QTL ID'].'</a></td>';
                                    echo '<td>'.$data_qtl['Trait Name'].'</td>';
                                    echo '<td>'.$data_qtl['Trait Alias'].'</td>';
                                    echo '<td>'.$data_qtl['Study'].'</td>';
                                    echo '<td>'.$data_qtl['Species'].'</td>';
                                    echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$href_marker.'/'.$marker_id.'">'.$marker_id.'</a></td>';


                                    echo "</tr>";
                                }
                            }
                            array_push($marker_list, $marker_id);
                        }

                    }   

                }
                echo'</tbody></table>';
            }
        }
    }
    else{
        
        echo '<p class="no_results"> No results found </p>';
    }
}

new_cobra_footer();	

