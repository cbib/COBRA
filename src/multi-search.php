<?php

include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');


//define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
//include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


new_cobra_header("..");

new_cobra_body($_SESSION['login'],"Multiple results Summary","section_result_tabs","..");
//Instanciation de la connexion
$db=mongoConnector();


    //Selection des collections
    $samplesCollection = new MongoCollection($db, "samples");
    $speciesCollection = new Mongocollection($db, "species");
    $mappingsCollection = new Mongocollection($db, "mappings");
    $measurementsCollection = new Mongocollection($db, "measurements");
    $virusesCollection = new Mongocollection($db, "viruses");
    $interactionsCollection = new Mongocollection($db, "interactions");
    $orthologsCollection = new Mongocollection($db, "orthologs");
    $GOCollection = new Mongocollection($db, "gene_ontology");



//$speciesID=control_post(htmlspecialchars($_GET['speciesID']));
$listID=control_post(htmlspecialchars($_GET['listID']));
//$textID=control_post(htmlspecialchars($_GET['q']));
// on remplace le retour charriot par <br>
$listID = str_replace('\r\n','<br>',$listID);
//echo $listID;
$id_details= explode("\r\n", $listID);
make_species_list(find_species_list($speciesCollection),"..");
echo '<div id="shift_line"></div>';
for ($c=0;$c<count($id_details);$c++){
    $search=$id_details[$c];
    $organism="All species";
    echo'<div class="panel-group" id="result_accordion_documents_'.str_replace(".", "_", $search).'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>
                        <a class="accordion-toggle collapsed" href="#result_'.str_replace(".", "_", $search).'" data-parent="#result_accordion_documents_'.str_replace(".", "_", $search).'" data-toggle="collapse">
                                '.$search.'
                        </a>				
                    </h3>
                </div>
                <div class="panel-body panel-collapse collapse" id="result_'.str_replace(".", "_", $search).'">';
                    $grid = $db->getGridFS();
                    //Selection des collections
                    $samplesCollection = new MongoCollection($db, "samples");
                    $full_mappingsCollection = new Mongocollection($db, "full_mappings");
                    $mappingsCollection = new Mongocollection($db, "mappings");
                    $measurementsCollection = new Mongocollection($db, "measurements");
                    $virusesCollection = new Mongocollection($db, "viruses");
                    $interactionsCollection = new Mongocollection($db, "interactions");
                    $sequencesCollection = new Mongocollection($db, "sequences");
                    $orthologsCollection = new Mongocollection($db, "orthologs");
                    $GOCollection = new Mongocollection($db, "gene_ontology");
                    
                    
                    
                    
                    
                    $go_id_list=array();
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
                    $go_duo_list=array();
                    //echo '<hr>';

                    //$timestart=microtime(true);
                    //get_everything using full table mapping

                    //$cursor = find_gene_by_regex($measurementsCollection,new MongoRegex("/^$search/m"));

                    //$searchQuery = array('gene'=>array('$regex'=> new MongoRegex("/^$search/xi")));
                    //$cursor = $measurementsCollection->find($searchQuery);
                    //var_dump($cursor);



                    //Add split function for search value in case of double value separated by colon
                    //consequently add multiple results page to test any alias when an alias is submitted.
                    $cursor=$full_mappingsCollection->aggregate(array(
                        array('$match' => array('type'=>'full_table')),  
                        array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                        array('$unwind'=>'$mapping_file'),
                        array('$match' => array('$or'=> array(array('mapping_file.Plaza ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Uniprot ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Transcript ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Protein ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Alias'=>new MongoRegex("/^$search/xi")),array('mapping_file.Probe ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/^$search/xi")),array('mapping_file.Gene ID'=>new MongoRegex("/$search$/xi")),array('mapping_file.Gene ID 2'=>new MongoRegex("/^$search/xi")),array('mapping_file.Symbol'=>new MongoRegex("/^$search/xi"))))),
                        array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0))));

                    if (count($cursor['result'])>0){
                        foreach ($cursor['result'] as $result) {
                            //echo $result['mapping_file']['Gene ID 2'];
                            //echo $result['mapping_file']['Gene ontology ID'];
                            $go_id_evidence = explode("_", $result['mapping_file']['Gene ontology ID']);
                            foreach ($go_id_evidence as $duo) {
                                if (!in_array($duo, $go_duo_list)){
                                    $tmp_array=array();
                                    array_push($go_duo_list, $duo);
                                    $duo_id=explode("-", $duo);
                                    $tmp_array['evidence']=$duo_id[1];
                                    $tmp_array['GO_ID']=$duo_id[0];
                                    array_push($go_id_list,$tmp_array);
                                }

                            }
                            if (in_array($result['mapping_file']['Uniprot ID'],$uniprot_id)==FALSE){
                                array_push($uniprot_id,$result['mapping_file']['Uniprot ID']);
                            }
                            if (in_array($result['mapping_file']['Protein ID'],$protein_id)==FALSE){
                                array_push($protein_id,$result['mapping_file']['Protein ID']);
                            }
                            if (in_array($result['mapping_file']['Description'],$descriptions)==FALSE){

                                array_push($descriptions,$result['mapping_file']['Description']);
                            }
                //            if (in_array($result['mapping_file']['Transcript ID'],$transcript_id)==FALSE){
                //
                //                array_push($transcript_id,$result['mapping_file']['Transcript ID']);
                //            }
                            if (in_array($result['mapping_file']['Gene ID'],$gene_id)==FALSE){

                                array_push($gene_id,$result['mapping_file']['Gene ID']);
                            }
                //            for ($i = 0; $i < count($gene_symbol); $i++) {
                //                    if (strstr($gene_symbol,",")){
                //                        $pos=$i;
                //                        $tmp_array=explode(",", $gene_symbol);
                //                        $gene_symbol[$i]=$tmp_array[0];
                //                        array_splice($gene_symbol, $i, 1);
                //                    }
                //                }
                            $symbol_list=explode(",", $result['mapping_file']['Symbol']);
                            foreach ($symbol_list as $symbol) {
                                //echo 'symbol : '.$symbol;
                                if (in_array($symbol,$gene_symbol)==FALSE){
                                    array_push($gene_symbol,$symbol);
                                }



                            }
                            if (in_array($result['mapping_file']['Gene ID 2'],$gene_id_bis)==FALSE && $result['mapping_file']['Gene ID 2']!="NA"){

                                array_push($gene_id_bis,$result['mapping_file']['Gene ID 2']);
                            }

                            if (in_array($result['mapping_file']['Alias'],$gene_alias)==FALSE && $result['mapping_file']['Alias']!="NA"){

                                array_push($gene_alias,$result['mapping_file']['Alias']);
                            }
                            if (in_array($result['mapping_file']['Probe ID'],$est_id)==FALSE){

                                array_push($est_id,$result['mapping_file']['Probe ID']);
                            }
                            array_push($plaza_ids,$result['mapping_file']['Plaza ID']);
                            $plaza_id=$result['mapping_file']['Plaza ID'];
                            $species=$result['species'];

                        }

                echo   '<div id="summary">';  

                      echo '<div id="protein-details">';

                                display_proteins_details($gene_id,$gene_symbol,$gene_alias,$descriptions,$uniprot_id,$species);



                                //display_expression_profile($measurementsCollection, $samplesCollection, $series, $categories, $logfc_array,$gene_id,$gene_id_bis,$gene_alias);


                                //start div expression_profile

                           echo'<div id="expression_profile">
                                    <h3>Expression profile</h3>
                                    <div class="panel-group" id="accordion_documents_expression">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">

                                                    <a class="accordion-toggle collapsed" href="#expression-chart" data-parent="#accordion_documents_expression" data-toggle="collapse">
                                                        <strong>  Expression data</strong>
                                                    </a>				

                                            </div>
                                            <div class="panel-body panel-collapse collapse" id="expression-chart"  >
                                                <div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" style="min-width: 310px; height: 400px;"></div>
                                            </div>

                                        </div>
                                    </div>'; 

                                    $series=array();
                                    $categories=array();
                                    $logfc_array=array();


                                    $cursor=$measurementsCollection->find(array(
                                    '$and'=>array(
                                        array('$or'=> array(
                                            array('gene'=>$gene_id[0]),
                                            array('gene'=>$transcript_id[0]),
                                            array('gene'=>$protein_id[0]),
                                            array('gene'=>$gene_id_bis[0]),
                                            array('gene'=>$gene_alias[0])
                                        )),
                                        array('gene'=> array('$ne'=>""))
                                    )),
                                    array('_id'=>0)
                                    );


                                    //$cursor=$measurementsCollection->find(array('$and'=>array('$or'=> array(array('gene'=>$gene_id[0]),array('gene'=>$protein_id[0]),array('gene'=>$gene_id_bis[0]),array('gene'=>$gene_alias[0]))),array('gene'=>$gene_alias[0])),array('_id'=>0));
                                    $counter=1;                       
                                    foreach ($cursor as $result) {
                                        $xp_full_name=explode(".", $result['xp']);                   
                                        $experiment_id=$xp_full_name[0];
                                        $xp_name=explode(".", get_experiment_name_with_id($samplesCollection,$experiment_id));

                                        if (isset($result['day_after_inoculation'])){
                                            if (isset($result['variety'])){
                                               $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
                                                //$categories[$gene_id[0]]= $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']; 
                                                array_push($categories, $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']); 
                                            }
                                            else{
                                                $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC']);
                                                //$categories[$gene_id[0]]= $result['species'].'/Day '.$result['day_after_inoculation'];

                                                array_push($categories, $result['species'].'/Day '.$result['day_after_inoculation']);
                                            }

                                        }
                                        else{
                                            if (isset($result['variety'])){
                                               $sample=array('y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
                                               ///$categories[$gene_id[0]]=  $result['species'].'/'.$result['variety'];
                                                array_push($categories, $result['species'].'/'.$result['variety']); 
                                            }
                                            else{
                                                $sample=array('y'=>$result['logFC'],'logFC'=>$result['logFC']);
                                                //$categories[$gene_id[0]]=  $result['species'];
                                                array_push($categories, $result['species']);
                                            }
                                        }
                                        array_push($logfc_array, $sample);

                                        $counter++;

                                    }
                                    $sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
                                    array_push($series, $sample);
                                    echo'<div id="shift_line"></div>'                
                              . '</div>';  
                                //end div expression profile

                                //start div goterms                    
                                load_and_display_gene_ontology_terms($GOCollection,$go_id_list);
                                //end div go_terms
                                display_external_references($uniprot_id,$search,$species);


                      echo '</div>';
                      // end left side div
                      // 
                      //start right side div
                      echo '<div id="stat-details">';
                                load_and_display_interactions($gene_id,$gene_alias,$descriptions, $gene_symbol,$uniprot_id,$species,$interactionsCollection);

                                load_and_display_orthologs($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id);


                           echo'<div id="sequences">';
                                echo '<h3>Sequences</h3>';
                                $transcript_id=count_transcript_for_gene($sequencesCollection,$gene_id[0],$gene_id_bis[0]);


                              echo '<div>'
                                . ' About this gene: This gene has '.count($transcript_id).' transcripts'
                                . '</div></br>';

                              echo '<div class="panel-group" id="accordion_documents_trancript_sequence">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">

                                                    <a class="accordion-toggle collapsed" href="#trancript_sequence_fasta" data-parent="#accordion_documents_trancript_sequence" data-toggle="collapse">
                                                        <strong>Transcripts sequences </strong>
                                                    </a>				

                                            </div>
                                            <div class="panel-body panel-collapse collapse" id="trancript_sequence_fasta">';
                                                //get the number of transcript for this gene


                                                //with the number of transcript
                                                for ($i=0;$i<count($transcript_id);$i++){
                                                    $sequence_metadata=$sequencesCollection->find(array('mapping_file.Transcript ID'=>$transcript_id[$i]),array('mapping_file.$'=>1));
                                                    foreach ($sequence_metadata as $data) {
                                                        foreach ($data as $key=>$value) {
                                                            if ($key==="mapping_file"){
                                                                foreach ($value as $values) {

                                                                    //echo '<TEXTAREA name="nom" rows=9 cols=60>'.$values['Sequence'].'</TEXTAREA></br>'; 
                                                                    //echo '<pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">'.'>'.$values['Transcript ID'].'</br>'.$values['Transcript Sequence'].'</pre></br>';


                                                                    echo '<pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">';
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



                                                                    echo  '<button onclick="myFunction(this)" data-id="'.str_replace(".", "__", $values['Transcript ID']).'" data-sequence="'.$values['Transcript Sequence'].'" id="blast_button" type="button">Blast sequence</button>';
                                                                    echo '</br>';
                                                                    echo '  <center>
                                                                                <div class="loading_'.str_replace(".", "__", $values['Transcript ID']).'" style="display: none">


                                                                                </div>
                                                                            </center>
                                                                        <div class="container animated fadeInDown">
                                                                            <div class="content_test_'.str_replace(".", "__", $values['Transcript ID']).'">

                                                                            </div>
                                                                        </div>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            echo '</div>

                                        </div>
                                    </div>';

                              echo '<div class="panel-group" id="accordion_documents_gene_sequence">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">

                                                    <a class="accordion-toggle collapsed" href="#gene_sequence_fasta" data-parent="#accordion_documents_gene_sequence" data-toggle="collapse">
                                                        <strong>Unspliced Genes </strong>
                                                    </a>				

                                            </div>
                                            <div class="panel-body panel-collapse collapse" id="gene_sequence_fasta">';
                                                //get the number of transcript for this gene


                                                //with the number of transcript

                                                    $sequence_metadata=$sequencesCollection->find(array('tgt'=>'Gene_Sequence','mapping_file.Gene ID'=>$gene_id[0]),array('mapping_file.$'=>1));
                                                    foreach ($sequence_metadata as $data) {
                                                        foreach ($data as $key=>$value) {
                                                            if ($key==="mapping_file"){
                                                                foreach ($value as $values) {

                                                                    //echo '<TEXTAREA name="nom" rows=9 cols=60>'.$values['Sequence'].'</TEXTAREA></br>'; 
                                                                    //echo '<pre style="margin-right: 2%; margin-left: 2%;width=100%; text-align: left">'.'>'.$values['Gene ID'].'</br>'.$values['Gene Sequence'].'</pre></br>';
                                                                    echo '<pre style="margin-right: 1%; margin-left: 1%; width=100%; text-align: left">';
                                                                    echo '>'.$values['Gene ID'].'</br>';
                                                                    for ($j=1;$j<=strlen($values['Gene Sequence']);$j++){
                                                                        if (($j%60===0) && ($j!==1)){
                                                                            echo $values['Gene Sequence'][$j-1].'</br>';
                                                                        }
                                                                        else{
                                                                            echo $values['Gene Sequence'][$j-1];
                                                                        }

                                                                    }
                                                                    echo '</pre></br>';
                                                                }
                                                            }
                                                        }
                                                    }


                                            echo '</div>

                                        </div>
                                    </div>'; 
                          echo '</div>';                       
                     echo'</div>';
                     // end right side div
                echo'</div>';

                    //                $timestart=microtime(true);             
                    //                $timeend=microtime(true);
                    //                $time=$timeend-$timestart;
                    //                //Afficher le temps d'éxecution
                    //                $page_load_time = number_format($time, 3);
                    //                echo "starting script at: ".date("H:i:s", $timestart);
                    //                echo "<br>Ending script at: ".date("H:i:s", $timeend);
                    //                echo "<br>Script for interaction data executed in " . $page_load_time . " sec";  
                    }
                    else{
                echo'<div id="summary">
                         <h2>No Results found for \''.$search.'\'</h2>'
                  . '</div>';	
                    }
    
    
           echo'</div>
            </div>
        </div>';
   

}



new_cobra_footer();


?>

<script type="text/javascript" class="init">
   var species="<?php echo $species; ?>"; 
    var genes="<?php echo $gene_id[0]; ?>"; 
    var genes_alias="<?php echo $gene_alias[0]; ?>";
    var xp_name="<?php echo $xp_name[0]; ?>";
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
                categories: <?php echo json_encode($categories); ?>
                
                //categories: ['Apples', 'Oranges', 'Oranges', 'Oranges', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                
                //title: {text: 'Samples'}
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Log FC'
                }
            
            },
//            yAxis: {
//                //type: 'logarithmic'
//                title: 'Log FC'
//            },
            
            series: <?php echo json_encode($series); ?>,
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



 
    
</script>

