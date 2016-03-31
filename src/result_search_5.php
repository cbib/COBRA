<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
//include '../wiki/vendor/autoload.php';
require('./session/control-session.php');




new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary","..");
//$global_timestart=microtime(true);
$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$historyCollection = new Mongocollection($db, "history");
//echo 'directory: '.PATH;
make_species_list(find_species_list($speciesCollection),"..");
if ((isset($_GET['organism'])  && $_GET['organism']!='' && $_GET['organism']!='NA') && (isset($_GET['search']) && $_GET['search']!='' && $_GET['search']!='NA')){

    array_push($_SESSION['historic'],$_GET['search']);
    //foreach ($_SESSION['historic'] as $value) {
    //    echo $value;
    //}
   
    
    
	$species=control_post(htmlspecialchars($_GET['organism']));
	$search=control_post(htmlspecialchars($_GET['search']));
	//$search=strtoupper($search);


    
    ////////////////////////////////////
    //ASSIGN ALL COLLECTIONS and GRIDS//
    ////////////////////////////////////
    $grid = $db->getGridFS();
	$samplesCollection = new MongoCollection($db, "samples");
	$full_mappingsCollection = new Mongocollection($db, "full_mappings");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$virusesCollection = new Mongocollection($db, "viruses");
	$interactionsCollection = new Mongocollection($db, "interactions");
    $pv_interactionsCollection = new Mongocollection($db, "pv_interactions");
    $pp_interactionsCollection = new Mongocollection($db, "pp_interactions");
    $sequencesCollection = new Mongocollection($db, "sequences");
	$orthologsCollection = new Mongocollection($db, "orthologs");
    $GOCollection = new Mongocollection($db, "gene_ontology");
    $variation_collection = new Mongocollection($db, "variations");
    $genetic_markers_collection=new Mongocollection($db, "genetic_markers");
    $qtl_collection=new Mongocollection($db, "qtls");
    ///////////////////////////////////
    //CREATE ALL ARRAYS and VARIABLES//
    ///////////////////////////////////
    $go_grid_plaza_id_list=array();
    $go_grid_id_list=array();
    $gene_alias=array();
    $gene_id=array();
    $gene_id_bis=array();
    $transcript_id=array();
    $gene_symbol=array();
    $descriptions=array();
    $uniprot_id=array();
    $protein_id=array();
    $plaza_ids=array();
    $est_id=array();
    $go_list=array();
    $percent_array=array();
    $score=0.0;
 
    /////////////////////////////////////////////
    //SEARCH THE CUMULATED SCORE FOR A GIVEN ID//
    /////////////////////////////////////////////
    //$timestart1=microtime(true);
//    $cursor_score=$full_mappingsCollection->aggregate(array(
//         array('$match' => array('type'=>'full_table','species'=>$species)),  
//         array('$project' => array('mapping_file'=>1,'_id'=>0)),
//         array('$unwind'=>'$mapping_file'),
//         array('$match' => array('mapping_file.Gene ID'=>$search)),
//         array(
//           '$group'=>
//             array(
//               '_id'=> array( 'gene'=> '$mapping_file.Gene ID' ),
//               //'scores'=> array('$addToSet'=> '$mapping_file.Score_exp')
//
//               'scores'=> array('$addToSet'=> array('exp'=>'$mapping_file.Score_exp','int'=>'$mapping_file.Score_int','ort'=>'$mapping_file.Score_orthologs','qtl'=>'$mapping_file.Score_QTL','snp'=>'$mapping_file.Score_SNP') )
//             )
//         )
//
//    ));
   
    ///////////////////////////////
    //SUM ALL SCORE FOR THIS GENE//
    ///////////////////////////////   
//    foreach ($cursor_score['result'] as $value) {
//        foreach ($value['scores'] as $tmp_score) {    
//            $score+=$tmp_score['exp'];
//            $score+=$tmp_score['int'];  
//            $score+=$tmp_score['ort'];  
//            $score+=$tmp_score['qtl'];  
//            $score+=$tmp_score['snp'];  
//        }  
//    } 
//    $today = date("F j, Y, g:i a");
//    $document = array("firstname" => $_SESSION['firstname'],
//                      "lastname" => $_SESSION['lastname'],
//                      "search id" => $_GET['search'],
//                      "type" => "search",
//                      "score" =>$score,
//                      "date" => $today
//    );
//    $historyCollection->insert($document);
    
    
    
    
    
    
    
    
//    $timeend1=microtime(true);
//    $time1=$timeend1-$timestart1;
//    //Afficher le temps d'éxecution
//    $page_load_time1 = number_format($time1, 3);
//    echo "Debut du script: ".date("H:i:s", $timestart1);
//    echo "<br>Fin du script: ".date("H:i:s", $timeend1);
//    echo "<br>Script for search score executed in " . $page_load_time1 . " sec";

    ///////////////////////////////////////////////////////
    //SEARCH ENTRY IN FULL TABLE MAPPING WITH SAME ID//
    ///////////////////////////////////////////////////////  
    //$timestart2=microtime(true);
    $cursor=$full_mappingsCollection->aggregate(array(
        array('$match' => array('type'=>'full_table','species'=>$species)),  
        array('$project' => array('mapping_file'=>1,'_id'=>0)),
        array('$unwind'=>'$mapping_file'),
        array('$match' => array('$or'=> array(
//            array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),


//            array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),
            //array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi"))))),
        array('$project' => array("mapping_file"=>1,'_id'=>0))
    ));

//    $timeend2=microtime(true);
//    $time2=$timeend2-$timestart2;
//    //Afficher le temps d'éxecution
//    $page_load_time2 = number_format($time2, 3);
//    echo "Debut du script: ".date("H:i:s", $timestart2);
//    echo "<br>Fin du script: ".date("H:i:s", $timeend2);
//    echo "<br>Script for global search executed in " . $page_load_time2 . " sec";

    //////////////////////////////////////////
    //PARSE RESULT AND FILL DEDICATED ARRAYS//
    //////////////////////////////////////////   
    
    if (count($cursor['result'])>0){
        //$timestart=microtime(true);
        foreach ($cursor['result'] as $result) {
            //
            //echo $result['mapping_file']['Gene ID'];
            //echo $result['mapping_file']['Gene ontology ID'];
            $go_id_list=array();
            $go_used_list=array();
            if (isset($result['mapping_file']['Gene ontology ID']) && $result['mapping_file']['Gene ontology ID']!='' && $result['mapping_file']['Gene ontology ID']!='NA'){

                if ((isset($result['mapping_file']['Evidence code'])|| isset($result['mapping_file']['GO Evidence']))&& ($result['mapping_file']['Evidence code']!='' || $result['mapping_file']['GO Evidence']!='')&&( $result['mapping_file']['Evidence code']!='NA'||$result['mapping_file']['GO Evidence']!='NA')){
                
                    
                    
                }
                else{
                    $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
                    foreach ($go_id_evidence as $duo) {
                        $duo_id=explode("-", $duo);                
                        if (in_array($duo_id[0], $go_used_list)){
                            for ($i = 0; $i < count($go_id_list); $i++) {
                                if ($go_id_list[$i][0]===$duo_id[0]){
                                   if (!in_array($duo_id[1], $go_id_list[$i][1])){
                                       array_push($go_id_list[$i][1], $duo_id[1]); 
                                   }                           
                                }
                            }
                        }
                        else{
                            $tmp_array=array();
                            $tmp_array[0]=$duo_id[0];
                            $tmp_array[1]=array($duo_id[1]);
                            array_push($go_id_list,$tmp_array);
                            array_push($go_used_list,$duo_id[0]);   
                        }
                    }
                }
            }
            if (isset($result['mapping_file']['Uniprot ID']) && $result['mapping_file']['Uniprot ID']!='' && $result['mapping_file']['Uniprot ID']!='NA'){
                if (in_array($result['mapping_file']['Uniprot ID'],$uniprot_id)==FALSE){
                    array_push($uniprot_id,$result['mapping_file']['Uniprot ID']);
                }
            }
            if (isset($result['mapping_file']['Protein ID']) && $result['mapping_file']['Protein ID']!='' && $result['mapping_file']['Protein ID']!='NA'){
                if (in_array($result['mapping_file']['Protein ID'],$protein_id)==FALSE){
                    array_push($protein_id,$result['mapping_file']['Protein ID']);
                }
            }
            if (isset($result['mapping_file']['Description'])&& $result['mapping_file']['Description']!='' && $result['mapping_file']['Description']!='NA'){
                if (in_array($result['mapping_file']['Description'],$descriptions)==FALSE){
                    array_push($descriptions,$result['mapping_file']['Description']);
                }
            }
             if (isset($result['mapping_file']['Gene ID'])&& $result['mapping_file']['Gene ID']!='' && $result['mapping_file']['Gene ID']!='NA'){
                if (in_array($result['mapping_file']['Gene ID'],$gene_id)==FALSE){
                    array_push($gene_id,$result['mapping_file']['Gene ID']);
                }
            }
            if (isset($result['mapping_file']['Symbol'])&& $result['mapping_file']['Symbol']!='' && $result['mapping_file']['Symbol']!='NA'){
                $symbol_list=explode(",", $result['mapping_file']['Symbol']);
                foreach ($symbol_list as $symbol) {
                    if (in_array($symbol,$gene_symbol)==FALSE && $symbol!='NA'){
                        array_push($gene_symbol,$symbol);
                    }
                }
            }
            if (isset($result['mapping_file']['Global_Score'])&& $result['mapping_file']['Global_Score']!='' && $result['mapping_file']['Global_Score']!='NA'){
                $score=(int)$result['mapping_file']['Global_Score'];
                $today = date("F j, Y, g:i a");
                $document = array("firstname" => $_SESSION['firstname'],
                      "lastname" => $_SESSION['lastname'],
                      "search id" => $_GET['search'],
                      "type" => "search",
                      "score" =>$score,
                      "date" => $today
                );
                $historyCollection->insert($document);
            }
            if (isset($result['mapping_file']['Score_exp'])&& $result['mapping_file']['Score_exp']!='' && $result['mapping_file']['Score_exp']!='NA'){
                $score_exp=(int)$result['mapping_file']['Score_exp'];
                //echo 'score_exp: '.$result['mapping_file']['Score_exp'];
                //echo 'global score: '.$score.'<br/>';
                $percent_exp=(float)(($score_exp/$score)* 100.0);
                //echo 'percentage: '.$percent_exp.' %<br/>';
            }
            else{
                $score_exp=0.0;
                $percent_exp=0.0;
            }
            array_push($percent_array, $percent_exp);
            if (isset($result['mapping_file']['Score_int'])&& $result['mapping_file']['Score_int']!='' && $result['mapping_file']['Score_int']!='NA'){
                $score_int=(int)$result['mapping_file']['Score_int'];
                //echo 'score_int: '.$result['mapping_file']['Score_int'];
                //echo $score.'<br/>';
                $percent_int=(float)(($score_int/$score)* 100.0);
                //echo $percent.'<br/>';
            }
            else{
                $score_int=0.0;
                $percent_int=0.0;
            }
            array_push($percent_array, $percent_int);
            if (isset($result['mapping_file']['Score_orthologs'])&& $result['mapping_file']['Score_orthologs']!='' && $result['mapping_file']['Score_orthologs']!='NA'){
                $score_ort=(int)$result['mapping_file']['Score_orthologs'];
                //echo 'score_ort: '.$result['mapping_file']['Score_orthologs'];
                //echo $score.'<br/>';
                $percent_ort=(float)(($score_ort/$score)* 100.0);
                //echo $percent.'<br/>';
            }
            else{
                $score_ort=0.0;
                $percent_ort=0.0;
            }
            array_push($percent_array, $percent_ort);
            if (isset($result['mapping_file']['Score_QTL'])&& $result['mapping_file']['Score_QTL']!='' && $result['mapping_file']['Score_QTL']!='NA'){
                $score_QTL=(int)$result['mapping_file']['Score_QTL'];
                //echo 'score_QTL: '.$result['mapping_file']['Score_QTL'];
                //echo $score.'<br/>';
                $percent_QTL=(float)(($score_QTL/$score)* 100.0);
                //echo $percent.'<br/>';
            }
            else{
                $score_QTL=0.0;
                $percent_QTL=0.0;
            }
            array_push($percent_array, $percent_QTL);
            if (isset($result['mapping_file']['Score_SNP'])&& $result['mapping_file']['Score_SNP']!='' && $result['mapping_file']['Score_SNP']!='NA'){
                $score_SNP=(int)$result['mapping_file']['Score_SNP'];
                //echo 'score_snp: '.$result['mapping_file']['Score_SNP'];
                //echo $score.'<br/>';
                $percent_SNP=(float)(($score_SNP/$score)* 100.0);
                //echo $percent.'<br/>';
            }
            else{
                $score_SNP=0.0;
                $percent_SNP=0.0;
            }
            array_push($percent_array, $percent_SNP);
            
            if (isset($result['mapping_file']['Start'])&& $result['mapping_file']['Start']!='' && $result['mapping_file']['Start']!='NA'){
                $gene_start=(int)$result['mapping_file']['Start'];
            }
            if (isset($result['mapping_file']['End'])&& $result['mapping_file']['End']!='' && $result['mapping_file']['End']!='NA'){
                $gene_end=(int)$result['mapping_file']['End'];
            }
            if (isset($result['mapping_file']['Chromosome'])&& $result['mapping_file']['Chromosome']!='' && $result['mapping_file']['Chromosome']!='NA'){
                $chromosome=$result['mapping_file']['Chromosome'];
            }
            if (isset($result['mapping_file']['Gene ID 2'])&& $result['mapping_file']['Gene ID 2']!=''&& $result['mapping_file']['Gene ID 2']!="NA"){
                if (in_array($result['mapping_file']['Gene ID 2'],$gene_id_bis)==FALSE){
                    array_push($gene_id_bis,$result['mapping_file']['Gene ID 2']);
                }
            }
            if (isset($result['mapping_file']['Alias'])&& $result['mapping_file']['Alias']!='' && $result['mapping_file']['Alias']!='NA'){
                if (in_array($result['mapping_file']['Alias'],$gene_alias)==FALSE){
                    array_push($gene_alias,$result['mapping_file']['Alias']);
                }
            }
            if (isset($result['mapping_file']['Gene Name'])&& $result['mapping_file']['Gene Name']!='' && $result['mapping_file']['Gene Name']!='NA'){
                if (in_array($result['mapping_file']['Gene Name'],$gene_alias)==FALSE){
                    array_push($gene_alias,$result['mapping_file']['Gene Name']);
                }
            }
            if (isset($result['mapping_file']['Probe ID'])&& $result['mapping_file']['Probe ID']!='' && $result['mapping_file']['Probe ID']!='NA'){
                if (in_array($result['mapping_file']['Probe ID'],$est_id)==FALSE){
                    array_push($est_id,$result['mapping_file']['Probe ID']);
                }
            }
            if (isset($result['mapping_file']['Plaza ID'])&& $result['mapping_file']['Plaza ID']!='' && $result['mapping_file']['Plaza ID']!='NA'){
                if (in_array($result['mapping_file']['Plaza ID'],$plaza_ids)==FALSE){
                    array_push($plaza_ids,$result['mapping_file']['Plaza ID']);
                }
                $plaza_id=$result['mapping_file']['Plaza ID'];
            } 
            if (isset($result['mapping_file']['Transcript ID'])&& $result['mapping_file']['Transcript ID']!='' && $result['mapping_file']['Transcript ID']!='NA'){
                if (in_array($result['mapping_file']['Transcript ID'],$transcript_id)==FALSE){
                    array_push($transcript_id,$result['mapping_file']['Transcript ID']);
                }
                
            } 
            
            //if (isset($result['species'])&& $result['species']!='' && $result['species']!='NA'){
              //  $species=$result['species']; 
            //}


        }
        
        
        
/* 
            if (isset($result['mapping_file']['Score'])){
                echo $result['mapping_file']['Score'];
                $score+=(int)$result['mapping_file']['Score'];
                echo $score;
            }
          if (in_array($result['mapping_file']['Transcript ID'],$transcript_id)==FALSE){

               array_push($transcript_id,$result['mapping_file']['Transcript ID']);
           }
           
           for ($i = 0; $i < count($gene_symbol); $i++) {
                   if (strstr($gene_symbol,",")){
                       $pos=$i;
                       $tmp_array=explode(",", $gene_symbol);
                      $gene_symbol[$i]=$tmp_array[0];
                      array_splice($gene_symbol, $i, 1);
                   }
               }
            
*/        
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Debut du script: ".date("H:i:s", $timestart);
//        echo "<br>Fin du script: ".date("H:i:s", $timeend);
//        echo "<br>Script for parsing and filling arrays executed in " . $page_load_time . " sec";
         //////////////////////////////////////////
        //DISPLAY RESULT HTML//
        //////////////////////////////////////////  
        echo'<div id="summary">';  

            // left side div
            echo'<div id="protein-details">';               
                    //$timestart=microtime(true);
                    load_and_display_proteins_details($gene_id,$gene_id_bis,$gene_symbol,$gene_alias,$descriptions,$uniprot_id,$species,$score_exp,$score_int,$score_ort,$score_QTL,$score_SNP,$score,$gene_start,$gene_end,$chromosome);
                    
                    //echo $score;
                    //load_and_display_score_pie();
                    //echo '<div id="container_pie" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>';
                    //echo '<div id="container_pie" data-exp="'.$percent_exp.'" data-int="'.$percent_int.'" data-ort="'.$percent_ort.'" data-QTL="'.$percent_QTL.'" data-SNP="'.$percent_SNP.'" style="min-width: 310px; height: 400px;"></div>';

//Afficher le temps d'éxecution
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for details executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    $expression_data_array=load_and_display_expression_profile($measurementsCollection, $samplesCollection,$gene_id,$transcript_id,$protein_id,$gene_id_bis,$gene_alias);
                    //Afficher le temps d'éxecution
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for expression executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_gene_ontology_terms($GOCollection,$go_id_list);
                    //Afficher le temps d'éxecution
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for GO executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_variations_result($genetic_markers_collection,$qtl_collection,$full_mappingsCollection,$variation_collection,$gene_id,$species,$gene_start,$gene_end,$chromosome);
                    //Afficher le temps d'éxecution
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for variant executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_external_references($uniprot_id,$search,$species);
                    //Afficher le temps d'éxecution
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for ext ref executed in " . $page_load_time . " sec";
            echo'</div>';

            //right side div    
            echo'<div id="stat-details">';
                    
                   
            
            
                    
                    //$timestart=microtime(true);
                    echo'<div id="interaction_section">
                        <h3>Interaction</h3>';
                    load_and_display_interactions($full_mappingsCollection,$gene_id,$uniprot_id,$transcript_id,$pv_interactionsCollection,$pp_interactionsCollection,$species);
                    echo'</div>';
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for interactions executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_orthologs($full_mappingsCollection,$orthologsCollection,$species,$plaza_id);
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for orthologs executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_sequences_data($sequencesCollection,$gene_id,$gene_id_bis);
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for sequences executed in " . $page_load_time . " sec";
                    
            echo'</div>';

        echo'</div>';
                
//    $global_timeend=microtime(true);
//    $global_time=$global_timeend-$global_timestart;
//    //Afficher le temps d'éxecution
//    $global_page_load_time = number_format($global_time, 3);
//    echo "Debut du script: ".date("H:i:s", $global_timestart);
//    echo "<br>Fin du script: ".date("H:i:s", $global_timeend);
//    echo "<br>Script for global page display executed in " . $global_page_load_time . " sec"; 
    }
    else{
        echo'<div id="summary">
                <h2>No Results found for \''.$search.'\'</h2>'
          . '</div>';	
    }
}
else{
    echo'<div class="container">
            <h2>you have uncorrectly defined your request</h2>'
      . '</div>';	
}


new_cobra_footer();

?>





<script type="text/javascript" class="init">
    
    var species="<?php echo $species; ?>"; 
    var genes="<?php echo $gene_id[0]; ?>"; 
    var genes_alias="<?php echo $gene_alias[0]; ?>";
    //var xp_name=echo $xp_name[0]; ?>;
   
    var global_score="<?php echo $score; ?>";

    
    var clicked_transcript_id="";
    
    $(function () {

        $('#container_pyramid').highcharts({
            chart: {
                type: 'pyramid',
                marginRight: 100
            },
            title: {
                text: '',
                x: -50
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b> ({point.y:,.0f})',
                        color: 'black',
                        softConnector: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Unique users',
                data: [
                    ['Expression Score', <?php echo(json_encode($score_exp)); ?>],
                    ['Interaction Score', <?php echo(json_encode($score_int)); ?>],
                    ['Orthology Score', <?php echo(json_encode($score_ort)); ?>],
                    ['QTL Score', <?php echo(json_encode($score_QTL)); ?>],
                    ['SNP Score', <?php echo(json_encode($score_SNP)); ?>]
                ]
            }]
        });
    });
    
    $(function () {
        
        $('#container_pie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Score: '+<?php echo(json_encode(max($percent_array))); ?>,
                colorByPoint: true,
                data: [{
                    name: 'Expression Score',
                    
                    y: <?php echo(json_encode($percent_exp)); ?>
                }, {
                    name: 'Interaction Score',
                    
                    y: <?php echo(json_encode($percent_int)); ?>,
                    
                    sliced: true,
                    selected: true
                }, {
                    name: 'Orthology Score',
                    y: <?php echo(json_encode($percent_ort)); ?>
                    
                }, {
                    name: 'QTL Score',
                    y: <?php echo(json_encode($percent_QTL)); ?>
                    
                }, {
                    name: 'Genetic Markers Score',
                    y: <?php echo(json_encode($percent_SNP)); ?>
            
                }]

            }]
        });
    });

    
    
    
    
    $(function () {
        var id= $('#container_profile').attr('data-id');
        var species=$('#container_profile').attr('data-species');
        $('#container_profile').highcharts({
            //alert ($(this).attr('data-alias'));
            chart: {
                type: 'column'
            },
            title: {
                text: id + ' differential expression ('+species+')' 
            },
//            subtitle: {
//                text: xp_name
//            },
            xAxis: {
                
                //categories: ['samples']
                categories: <?php echo json_encode($expression_data_array[0]); ?>
                
                //categories: ['Apples', 'Oranges', 'Oranges', 'Oranges', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                
                //title: {text: 'Samples'}
            },
            yAxis: {
                
                title: {
                    text: 'Log FC'
                }
            
            },
//            yAxis: {
//                //type: 'logarithmic'
//                title: 'Log FC'
//            },
            
            series: <?php echo json_encode($expression_data_array[1]); ?>,
            tooltip: {
                useHTML: true,
                formatter: function(genes) {
                //for series 
                //+this.series.name+ xp name
                    var s = '';
                    
                    var g=genes;
                    //window.alert(genes);
                    //echo './description/experiments.php?xp='.str_replace(' ','\s',$xp_name[0]);
                    http://127.0.0.1/src/description/experiments.php?xp=Transcriptionnal\sresponse\sto\spotyviruses\sinfection\sin\sArabidopsis\sPart\s3
                    s += '<ul><li><a target="_blank" href="./description/experiments.php?xp='+ this.point.xp_name +'">'+this.point.xp_name+'</a></li><li>'+'profile on Day '+ this.point.dpi +' post inoculation</li><li>Variety : '+ this.point.variety +'</li><li>logFC : '+ this.point.logFC +'</li></br>'
                         '</ul>';
                   
                    return s;
                }
            }
            //if (typeof variable === 'undefined' || variable === null) {}
              
 
              //series: serie

        });
    });
	$(document).ready(function() {
		$('#example').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#table_markers').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#table_qtls').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $('#samplestable').dataTable( {
        "scrollX": true,
        "jQueryUI": true,
        "pagingType": "full_numbers",
        "oLanguage": { 
            "sProcessing":   "Processing...",
            "sLengthMenu":   "display _MENU_ items",
            "sZeroRecords":  "No item found",
            "sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
            "sInfoEmpty": "Displaying item 0 to 0 on 0 items",
            "sInfoFiltered": "(filtered from _MAX_ items in total)",
            "sInfoPostFix":  "",
            "sSearch":       "Search: ",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "First",
                "sPrevious": "Previous",
                "sNext":     "Next",
                "sLast":     "Last"
            }
        },
        "language": {
                        "decimal": ",",
                        "thousands": "."
            }
    });
   

    
//	$(document).ready(function() {
//        $("#blast_button").click(function(){
//                $.ajax({
//                    url : './tools/blast/blast.php', // La ressource ciblée
//                    type : 'POST' ,// Le type de la requête HTTP.
//                    data : 'search=' + genes + '&sequence=' + sequence,
//                    dataType : 'html',
//                    success:function(myoutput){                   
//                        $(":hidden").val(myoutput.srno);
//                        if(myoutput.flag=="1")
//                        {                                       
//                            window.location="chat.php";
//                        }
//                        else
//                        {
//                            $("#msg").html("Invalid Login");
//                        }
//                    }
//                });
//          });
//    });
        
    //var button_clicked = document.getElementById("blast_button");
//    var button_clicked=document.getElementById('blast_button').onclick();
    
    //alert(clicked_transcript_id);

	
    
    //$(this).attr('trancript_sequence_fasta').children();
//    function loader(){
//        $('#blast_button').click(function() {
//                //alert(clicked_transcript_id);
//                //var seq= $(this).getAttribute("data-sequence");
//                var target = $(this).attr('data-id');
//                alert(target);
//				$.ajax({
//                    
//					 url : './tools/blast/blast.php', // La ressource ciblée
//
//                    type : 'POST' ,// Le type de la requête HTTP.
//
//                    //data : 'search=' + genes + '&sequence=' + clicked_sequence,
//                    data : 'search=' + clicked_transcript_id + '&species=' + species,
//
//                   
//                    method: 'post',
//					cache: false,
//					async: true,
//					dataType: "html",
//					success: function (data) {
//						//alert(data);
//                        var jqObj = jQuery(data);
//                        var par=jqObj.find("#blast_results");
//                        
//                        $(".content_test_"+clicked_transcript_id ).empty().append(par);
//                        
//                        //works to load results in element
////                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
////                            search : genes,
////
////                            sequence : sequence
////                            
////                        } );
//                        
//                        
//                        
//                        //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
//						//$('.content_test').empty().html(data);
//					}
//				});
//        });
//    }
    
    function myFunction(element){
        //alert(element.getAttribute('data-id')) ;
        clicked_transcript_id = element.getAttribute('data-id');
        
       
        $.ajax({
                    
            url : './tools/blast/blast.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'search=' + clicked_transcript_id + '&species=' + species,


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            success: function (data) {
                //alert(data);
                var jqObj = jQuery(data);
                var par=jqObj.find("#blast_results");

                $(".content_test_"+clicked_transcript_id ).empty().append(par);

                //works to load results in element
//                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
//                            search : genes,
//
//                            sequence : sequence
//                            
//                        } );



            //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
            //$('.content_test').empty().html(data);
            }
        });
        
    }
//    $(document).ready(function(){
//        //loader();
//        $('#blast_button').click(function() {
//                //alert(clicked_transcript_id);
//                //var seq= $(this).getAttribute("data-sequence");
//                var target = $(this).attr('data-id');
//                //alert(target);
//				$.ajax({
//                    
//					 url : './tools/blast/blast.php', // La ressource ciblée
//
//                    type : 'POST' ,// Le type de la requête HTTP.
//
//                    //data : 'search=' + genes + '&sequence=' + clicked_sequence,
//                    data : 'search=' + clicked_transcript_id + '&species=' + species,
//
//                   
//                    method: 'post',
//					cache: false,
//					async: true,
//					dataType: "html",
//					success: function (data) {
//						//alert(data);
//                        var jqObj = jQuery(data);
//                        var par=jqObj.find("#blast_results");
//                        
//                        $(".content_test_"+clicked_transcript_id ).empty().append(par);
//                        
//                        //works to load results in element
////                        $( ".content_test" ).load( "tools/blast/blast.php #paragraph",{
////                            search : genes,
////
////                            sequence : sequence
////                            
////                        } );
//                        
//                        
//                        
//                        //$( ".loading" ).load( "tools/blast/blast.php #paragraph" );
//						//$('.content_test').empty().html(data);
//					}
//				});
//        });
//    });
    
//    $(document).ready(function() {
//        $('#trancript_sequence_fasta').on('click button', function(event) {
//            var $target = $(event.target),
//                itemId = $target.data('id');
//                alert(itemId);
//
//            //do something with itemId
//        });
//    });

    $(document).on({
        ajaxStart: function() { 
                    //$(".content_test_"+clicked_transcript_id).fadeOut("slow");
                    $(".content_test_"+clicked_transcript_id).hide();
                    $('.loading_'+clicked_transcript_id).html("<img src='../images/ajax-loader.gif' />");
                    
                    $(".loading_"+clicked_transcript_id).show();
                    
        },
//        ajaxStop: function() {
//                    setTimeout(function() { 
//                    $(".loading").fadeOut("slow");
//                    $(".content_test").show("slow");
//                    
//                  }, 5000);                                        
//        }, 
        ajaxComplete: function() {
                    
                    $(".loading_"+clicked_transcript_id).fadeOut("slow");
                    $(".content_test_"+clicked_transcript_id).show("slow");
                                                         
        }    
    });




    $(document).ready(function() {
		$('#pretty_table_pp_intact').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#pretty_table_pp_biogrid').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#pretty_table_pp_string').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#pretty_table_pv_litterature').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    $(document).ready(function() {
		$('#pretty_table_pv_hpidb').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    
    (document).ready(function() {
		$('#orthologs_table').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    (document).ready(function() {
		$('#table_variants').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
    /**
 * Dark theme for Highcharts JS
 * @author Torstein Honsi
 */

// Load the fonts
Highcharts.createElement('link', {
   href: '//fonts.googleapis.com/css?family=Unica+One',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ["#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: "'Unica One', sans-serif"
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
    
</script>






