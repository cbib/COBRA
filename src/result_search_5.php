<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');




new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary","..");
//$global_timestart=microtime(true);
$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
//echo 'directory: '.PATH;
make_species_list(find_species_list($speciesCollection),"..");
if ((isset($_GET['organism'])  && $_GET['organism']!='' && $_GET['organism']!='NA') && (isset($_GET['search']) && $_GET['search']!='' && $_GET['search']!='NA')){


	$organism=control_post(htmlspecialchars($_GET['organism']));
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
    $score=0;
 
    /////////////////////////////////////////////
    //SEARCH THE CUMULATED SCORE FOR A GIVEN ID//
    /////////////////////////////////////////////
    //$timestart1=microtime(true);
    $cursor_score=$full_mappingsCollection->aggregate(array(
         array('$match' => array('type'=>'full_table','species'=>$organism)),  
         array('$project' => array('mapping_file'=>1,'_id'=>0)),
         array('$unwind'=>'$mapping_file'),
         array('$match' => array('mapping_file.Gene ID'=>$search)),
         array(
           '$group'=>
             array(
               '_id'=> array( 'gene'=> '$mapping_file.Gene ID' ),
               'scores'=> array('$addToSet'=> '$mapping_file.Score' )
             )
         )

    ));
   
    ///////////////////////////////
    //SUM ALL SCORE FOR THIS GENE//
    ///////////////////////////////   
    foreach ($cursor_score['result'] as $value) {
        foreach ($value['scores'] as $tmp_score) {    
            $score+=$tmp_score;    
        }  
    } 
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
        array('$match' => array('type'=>'full_table','species'=>$organism)),  
        array('$project' => array('mapping_file'=>1,'_id'=>0)),
        array('$unwind'=>'$mapping_file'),
        array('$match' => array('$or'=> array(
//            array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),
//            array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),
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
            if (isset($result['species'])&& $result['species']!='' && $result['species']!='NA'){
                $species=$result['species']; 
            }

/* 
            //if (isset($result['mapping_file']['Score'])){
                //echo $result['mapping_file']['Score'];
            //    $score+=(int)$result['mapping_file']['Score'];
                //echo $score;
            //}
//            if (in_array($result['mapping_file']['Transcript ID'],$transcript_id)==FALSE){
//
//                array_push($transcript_id,$result['mapping_file']['Transcript ID']);
//            }
           
//            for ($i = 0; $i < count($gene_symbol); $i++) {
//                    if (strstr($gene_symbol,",")){
//                        $pos=$i;
//                        $tmp_array=explode(",", $gene_symbol);
//                        $gene_symbol[$i]=$tmp_array[0];
//                        array_splice($gene_symbol, $i, 1);
//                    }
//                }
            
*/
        }
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
                    load_and_display_proteins_details($gene_id,$gene_symbol,$gene_alias,$descriptions,$uniprot_id,$species,$score);
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
                    load_and_display_variations_result($variation_collection,$gene_id,$species);
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
                    load_and_display_interactions($gene_id,$uniprot_id,$pv_interactionsCollection,$pp_interactionsCollection,$species);
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for interactions executed in " . $page_load_time . " sec";
                    
                    //$timestart=microtime(true);
                    load_and_display_orthologs($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id);
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
    
    var clicked_transcript_id="";
    $(function () {
        var id= $('#container_profile').attr('data-id');
        $('#container_profile').highcharts({
            //alert ($(this).attr('data-alias'));
            chart: {
                type: 'column'
            },
            title: {
                text: id + ' differential expression'
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
                
                    s += '<ul><li>'+'profile on Day '+ this.point.dpi +' post inoculation</li><li>Variety : '+ this.point.variety +'</li><li>logFC : '+ this.point.logFC +'</li></br>'
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
    $('#orthologs_table').DataTable( {
        responsive: true
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
    
</script>






