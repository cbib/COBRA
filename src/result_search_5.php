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
date_default_timezone_set('Europe/Paris');
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
            array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),
            array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi")),
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
            if (isset($result['mapping_file']['Uniprot ID']) && $result['mapping_file']['Uniprot ID']!='' && $result['mapping_file']['Uniprot ID']!='NA'){
                
                
                $uniprot_ids = preg_split("/[\s,]+/",$result['mapping_file']['Uniprot ID']);
                //print_r($uniprot_ids);
                foreach ($uniprot_ids as $id) {
                    if (in_array($id,$uniprot_id)==FALSE){
                        array_push($uniprot_id,$id);
                    }
                }
                
                
            }
//            if (isset($result['mapping_file']['Protein ID']) && $result['mapping_file']['Protein ID']!='' && $result['mapping_file']['Protein ID']!='NA'){
//                if (in_array($result['mapping_file']['Protein ID'],$protein_id)==FALSE){
//                    array_push($protein_id,$result['mapping_file']['Protein ID']);
//                }
//            }
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
                
                
                $gene_ids_bis = preg_split("/[\s,]+/",$result['mapping_file']['Gene ID 2']);
                //print_r($uniprot_ids);
                foreach ($gene_ids_bis as $id) {
                    if (in_array($id,$gene_id_bis)==FALSE){
                        array_push($gene_id_bis,$id);
                    }
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
                
                
                $est_ids = preg_split("/[\s,]+/",$result['mapping_file']['Probe ID']);
                //print_r($uniprot_ids);
                foreach ($est_ids as $id) {
                    if (in_array($id,$est_id)==FALSE){
                        array_push($est_id,$id);
                    }
                }
            }
            if (isset($result['mapping_file']['Plaza ID'])&& $result['mapping_file']['Plaza ID']!='' && $result['mapping_file']['Plaza ID']!='NA'){
                if (in_array($result['mapping_file']['Plaza ID'],$plaza_ids)==FALSE){
                    array_push($plaza_ids,$result['mapping_file']['Plaza ID']);
                }
                $plaza_id=$result['mapping_file']['Plaza ID'];
            } 
            if (isset($result['mapping_file']['Transcript ID'])&& $result['mapping_file']['Transcript ID']!='' && $result['mapping_file']['Transcript ID']!='NA'){
                
                $transcript_ids = preg_split("/[\s,]+/",$result['mapping_file']['Transcript ID']);
                //print_r($uniprot_ids);
                foreach ($transcript_ids as $id) {
                    if (in_array($id,$transcript_id)==FALSE){
                        array_push($transcript_id,$id);
                    }
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
                    //$timestart= start_time_capture();
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

                    load_and_display_expression_profile_with_ajax($gene_id,$transcript_id,$protein_id,$gene_id_bis,$gene_alias,$species);

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
//                    
//                    $timestart=microtime(true);
                    
                    
                    load_and_display_variations_result_with_ajax($gene_id,$species,$gene_start,$gene_end,$chromosome);

                    
                    //load_and_display_variations_result($genetic_markers_collection,$qtl_collection,$full_mappingsCollection,$variation_collection,$gene_id,$species,$gene_start,$gene_end,$chromosome);
                    
                    
                    
                    
                    
                    
                    
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
                    
                   
            
            
                    

                    //load_and_display_interactions($full_mappingsCollection,$gene_id,$uniprot_id,$transcript_id,$pv_interactionsCollection,$pp_interactionsCollection,$species);
                    
            
                    
                    load_and_display_interactions_with_ajax($gene_id,$uniprot_id,$transcript_id,$species);
                    
                    
                    load_and_display_orthologs_with_ajax($species,$plaza_id);
                    
                    load_and_display_sequences_data_with_ajax($gene_id,$gene_id_bis,$species);
                    //stop_time_capture($timestart);
                    
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





<script type="text/javascript">
    
    










//highcharts container

//pyramid container
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
//pie container
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
//chart container
$(function () {
    $('#container_chart').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Stacked bar chart'
        },
        xAxis: {
            categories: ['Global Score']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Score'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Transcriptomics',
            data: [<?php echo(json_encode($score_exp)); ?>]
        }, {
            name: 'Interactomics',
            data: [<?php echo(json_encode($score_int)); ?>]
        },{
            name: 'orthology',
            data: [<?php echo(json_encode($score_ort)); ?>]
        },{
            name: 'genetics',
            data: [<?php echo(json_encode($score_QTL)); ?>]
        }, {
            name: 'Polymorphism',
            data: [<?php echo(json_encode($score_SNP)); ?>]
        }]
    });
});



//Datatables

//example datatable
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
//table markers
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
//table qtls
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
//table samples
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

//table pp interactions
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
//table pp biogrid
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
//table pp string
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
//table pv Literature
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
//table pv hpidb
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
//table orthologs
$(document).ready(function() {
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
//table variants
$(document).ready(function() {
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
</script>






