<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
require('./session/control-session.php');




new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary","..");
$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$historyCollection = new Mongocollection($db, "history");
date_default_timezone_set('Europe/Paris');
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

    
 
/*    /////////////////////////////////////////////
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
//    $historyCollection->insert($document);*/
    

    ///////////////////////////////////////////////////////
    //SEARCH ENTRY IN FULL TABLE MAPPING WITH SAME ID//
    ///////////////////////////////////////////////////////  
    $cursor=$full_mappingsCollection->aggregate(array(
        array('$match' => array('type'=>'full_table','species'=>$species)),  
        array('$project' => array('mapping_file'=>1,'_id'=>0)),
        array('$unwind'=>'$mapping_file'),
        array('$match' => array('$or'=> array(
            /*array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),
            //array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),*/
            array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),
            array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi")),
            array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi"))))),
        array('$project' => array("mapping_file"=>1,'_id'=>0))
    ));
    
    
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


    //////////////////////////////////////////
    //PARSE RESULT AND FILL DEDICATED ARRAYS//
    //////////////////////////////////////////   
    
    if (count($cursor['result'])>0){

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
        
        
            

         //////////////////////////////////////////
        //DISPLAY RESULT HTML//
        //////////////////////////////////////////  
        echo'<div id="summary">';  

            // left side div
            echo'<div id="protein-details">';               

                    //$timestart= start_time_capture();
                    load_and_display_proteins_details($gene_id,$gene_id_bis,$gene_symbol,$gene_alias,$descriptions,$uniprot_id,$species,$score_exp,$score_int,$score_ort,$score_QTL,$score_SNP,$score,$gene_start,$gene_end,$chromosome);
                    load_and_display_expression_profile_with_ajax($gene_id,$transcript_id,$protein_id,$gene_id_bis,$gene_alias,$species);
                    load_and_display_gene_ontology_terms($GOCollection,$go_id_list);                  
                    load_and_display_variations_result_with_ajax($gene_id,$species,$gene_start,$gene_end,$chromosome);                    
                    //load_and_display_variations_result($genetic_markers_collection,$qtl_collection,$full_mappingsCollection,$variation_collection,$gene_id,$species,$gene_start,$gene_end,$chromosome);                    
                    load_and_display_external_references($uniprot_id,$search,$species);
                    
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








