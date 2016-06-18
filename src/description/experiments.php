<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");

?>

<?php
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Experiments Details","section_experiments","../..");


	//Recuperation des variables de la page main
	//$requestID=control_post($_POST['requestID']);
	//$siteID=control_post($_POST['site']);
	//$speciesID=control_post(htmlspecialchars($_POST['speciesID']));
	//$exp_typeID=control_post(htmlspecialchars($_POST['exp_typeID']));
	//$virusID=control_post(htmlspecialchars($_POST['virusID']));
	//$textID=control_post(htmlspecialchars($_POST['q']));
	
	$xpName=str_replace('\s',' ',control_post(htmlspecialchars($_GET['xp'])));
	//$prot_ID=$_GET['protID'];
	//$logFCInput=control_post(htmlspecialchars($_POST['logFCInput']));


	

	
	//Instanciation de la connexion
	$db=mongoConnector();
	
	
	//Selection de la collection
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");


	//REQUEST 

	
	
	
	
	$cursor_for_xp_name = $samplesCollection->find(array('name'=>$xpName), array('_id'=>1));
	foreach($cursor_for_xp_name as $line) {
		$xpID=$line['_id'];
	}
	
	//echo $xpID;
	
	
	$cursor = $samplesCollection->find(array('name'=>$xpName), array('species'=>1,'assay.type'=>1,'src_pub'=>1,'assay.design'=>1,'deposited.sample_description_url'=>1,'deposited.repository'=>1,'experimental_results'=>1,'_id'=>0));

	foreach($cursor as $line) {
 		$species=$line['species'];
 		$source_pub=$line['src_pub'];
 		$assay_info=$line['assay'];
 		$deposit_info=$line['deposited'];
 		$experimental_results=$line['experimental_results'];
 		
 	}
 	##http://www.ncbi.nlm.nih.gov/pubmed/19821986
    #http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3832472/
 	##EXPERIMENT DETAILS
 	echo'<div class="container" background-color="blue">';
 	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Experiment details </h1>';
		echo '</div>';
	
	echo '<hr>';
	echo '<dl class="dl-horizontal">
 	 	<dt>name</dt>
  		<dd>'.$xpName.'</dd>
  		<dt>species</dt>
  		<dd>'.$species.'</dd>
  		<dt>type of assay</dt>
  		<dd>'.$assay_info['type'].'</dd>
  		<dt>pub med link</dt>';
        
    if ($source_pub != "not published"){
  		echo '<dd><a href=http://www.ncbi.nlm.nih.gov/pubmed/'.$source_pub.'>'.$source_pub.'</a></dd>';
  	}
    else{
        echo '<dd>Not published</dd>';
    }
  		
	echo '</dl>';
	echo'</div>';
 	
 	$cursor = $speciesCollection->findOne(array(
 														'$or'=>array(
 																array('full_name'=>$species),
 																array('aliases'=>$species),
 																array('abbrev_name'=>$species)
 														)
 													)
 												);

	//var_dump($cursor);
	echo'<div class="container">';
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Species details </h1>';
		echo '</div>';

 	echo '<hr>';
 	echo '<dl class="dl-horizontal">';
	foreach ($cursor as $key=>$value){
		//echo $value.'</br>';
		
		if ($key=='_id'){
			
		}
		else if ($key=='classification'){
			//foreach ($value as $doc){
			echo '<dt>classification : top level</dt>
					<dd>'.$value['top_level'].'</dd>';
			echo '<dt>classification : kingdom</dt>
					<dd>'.$value['kingdom'].'</dd>';
					
			echo '<dt>classification : Unranked</dt>';
			for ($i=0;$i<count($value['unranked']);$i++){
			//foreach ($value['unranked'] as $val){
					echo '<dd>'.$value['unranked'][$i];
			}
			echo '</dd>';
			echo '<dt>classification : genus</dt>
					<dd>'.$value['genus'].'</dd>';
			
			//}
		}
        else if ($key==='wikipedia'){
            echo '<dt>Wikipedia</dt>';
            $values=split('/', $value);
					echo '<dd><a href='.$value.'>'.$values[count($values)-1].'</a></dd>';
        }
		else{
			echo '<dt>'.$key.'</dt>
					<dd>'.$value.'</dd>';
		}
  	}
	echo'</dl>';
	echo'</div>';
	// "top_level":"Eukaryotes",
// 		"kingdom":	"Plantae",
// 		"unranked": ["Angiosperms","Monocots","Commelinids"],
// 		"order":	"Poales",
// 		"family":	"Poaceae",
// 		"genus":	"Pooideae",
// 		"species":	"H. vulgare",
 	//$cursor = $speciessCollection->find(array(),array());
 	
 	##SPECIES DETAILS
 

	
	echo'<div class="container">';
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Dataset details </h1>';
		echo '</div>';
 
 	echo '<dl class="dl-horizontal">
 	<dt>design</dt>
  		
 	 	<dt>number of samples files</dt>
  		<dd>'.$assay_info['type'].'</dd>
  		<dt>design</dt>
  		<dd>'.$assay_info['design'].'</dd>
  		<dt>Dataset repository</dt>';
  		echo '<dd><a href="'.$deposit_info['repository'].'">'.$deposit_info['repository'].'</a></dd>
  		<dt>Sample description</dt>
  		<dd>'.$deposit_info['sample_description_url'].'</dd>
	</dl>';
	echo'</div>';
	
	echo'<div class="container">';
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Samples Files </h1>';
		echo '</div>';
		$file_counter=0;
	foreach($experimental_results as $details) {
		$file_counter++;
	}
 	echo '<dl class="dl-horizontal">
 	 	<dt>number of samples files</dt>
  		<dd>'.$file_counter.'</dd>
  		
	</dl>';
	
	echo'</div>';
	
// <dt>aliases</dt>
//   		<dd>'.$species.'</dd>
//   		<dt>type of assay</dt>
//   		<dd>'.$assay_info['type'].'</dd>
//   		<dt>design</dt>
//   		<dd>'.$assay_info['design'].'</dd>
//   		<dt>Dataset repository</dt>
//   		<dd>'.$deposit_info['repository'].'</dd>
//   		<dt>Sample description</dt>
//   		<dd>'.$deposit_info['sample_description_url'].'</dd>	
// 	
// 	
	
	echo'<div class="container">';
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Samples Details </h1>';
		echo '</div>
        <div class="col-sm-6 col-md-3">
        <div class="chart-wrapper">
            <div class="chart-title">
                Cell Title
            </div>
            <div class="chart-stage">
                <div id="grid-1-1">
                    <!-- chart goes here! -->
                </div>
            </div>
            <div class="chart-notes">
                Notes about this chart
            </div>
        </div>
  </div>';
	$conditions=array();
	$file_counter=0;

	foreach($experimental_results as $details) {
		//$data_file=$details['data_file'];
		$Measurement_FK=$xpID.'.experimental_results.'.$file_counter;
		//echo $Measurement_FK;
		$gene_count=$measurementsCollection->find(array('xp'=>$Measurement_FK))->count();
		$gene_up_count=$measurementsCollection->find(array('xp'=>$Measurement_FK,'direction'=>"up"))->count();
		$gene_down_count=$measurementsCollection->find(array('xp'=>$Measurement_FK,'direction'=>"down"))->count();
		$conditions=$details['conditions'];
		$contrast=$details['contrast'];
		$type=$details['type'];
		$variety=$details['variety'];
		$dpi=$details['day_after_inoculation'];
		$material=$details['material'];
        
        
        
		
		echo '<dl class="dl-horizontal">
 	 	<dt>type of contrast</dt>
  		<dd>'.$contrast.'</dd>
  		<dt>total genes </dt>
  		<dd>'.$gene_count.'</dd>
  		<dt>up regulated</dt>
  		<dd>'.$gene_up_count.'</dd>
  		<dt>down regulated</dt>
  		<dd>'.$gene_down_count.'</dd>
  		<dt>Plant variety</dt>
  		<dd>'.$variety.'</dd>
  		<dt>Material</dt>
  		<dd>'.$material.'</dd>';
  		echo'<dt>day after inoculation</dt>
  		<dd>'.$dpi.'</dd>';
  		for ($i = 1	; $i <= count($conditions); $i++) {
  			if (is_array($conditions[$i-1])){
				if ($conditions[$i-1]['infected']==True){
					
					//echo'<h3>Condition '.$i.' : infected</h3><ul>';
					echo'<dt>Condition'.$i.' : infected</dt>
  					<dd>infected</dd>';
  					echo'<dt>infection agent</dt>
  					<dd>'.$conditions[$i-1]['infection_agent'].'</dd>';
  					echo'<dt>infection type</dt>
  					<dd>'.$conditions[$i-1]['type'].'</dd>';
  					
					//echo '<h4>infection agent : '.$conditions[$i-1]['infection_agent'].'</h4>';
					//echo '<h4>material type : '.$conditions[$i-1]['type'].'</h4></br></ul>';
				}
				else{
					//echo'<h3>Condition '.$i.' :'.$conditions[$i-1].' </h3></ul>';
					echo'<dt>Condition'.$i.' : infected</dt>
  					<dd>'.$conditions[$i-1].'</dd>';
				}
			}
			else{
				//echo'<h3>Condition '.$i.' :'.$conditions[$i-1].'</h3>';
				echo'<dt>Condition'.$i.' : infected</dt>
  					<dd>'.$conditions[$i-1].'</dd>';
				//echo $conditions[$i-1];
			}
  		
  		}
        
        
        
        
        
        
        
	echo '</dl>';
		$file_counter++;
		/*
		
		
		echo '<h2> type of contrast : '.$contrast.'</h2></br><ul>';
		echo '<h3> total genes : '.$gene_count.'</h3><ul>';
		echo '<h4> up regulated : '.$gene_up_count.'</h4>';
		echo '<h4> down regulated : '.$gene_down_count.'</h4></ul>';
		echo '<h3> Plant variety : '.$variety.'</h3>';
		echo '<h3> Material : '.$material.'</h3>';
		for ($i = 1	; $i <= count($conditions); $i++) {
		

		
		
			//echo'<h2>Condition : '.$i.'</h2>';
		
			if (is_array($conditions[$i-1])){
				//for ($j = 0; $j < count($conditions[$i]); $j++) {
			
				
				//}
				
				if ($conditions[$i-1]['infected']==True){
					
					echo'<h3>Condition '.$i.' : infected</h3><ul>';
					echo '<h4>infection agent : '.$conditions[$i-1]['infection_agent'].'</h4>';
					echo '<h4>material type : '.$conditions[$i-1]['type'].'</h4></br></ul>';
				}
				else{
					echo'<h3>Condition '.$i.' :'.$conditions[$i-1].' </h3></ul>';

				}
			}
			else{
				echo'<h3>Condition '.$i.' :'.$conditions[$i-1].'</h3>';
				//echo $conditions[$i-1];
			}
			
		
	
		}
		echo '</ul>';
		$file_counter++;
		*/

	}	
	echo '<hr></div>';
    echo $xpName;
$data_gene_to_keep=$measurementsCollection->aggregate(
            array(
              array('$match' => array('name'=>$xpName,'$or'=>array(array('logFC'=>array('$gt'=>1)),array('logFC'=>array('$lt'=>-1))))),  
              array('$project' => array('gene'=>1,'xp'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
              array(
                '$group'=>
                  array(
                    '_id'=> array('gene'=> '$gene'),
                    'logs'=> array('$addToSet'=> array('xp'=>'$xp'))
                  )
              )
));
//var_dump($data_gene_to_keep);
foreach ($data_gene_to_keep['result'] as $value) {
    echo $value['_id']['gene'];echo '</br>';
    foreach ($value['logs'] as $values) {
        echo $values['xp'];echo '</br>';
    }
    
    
}

#build the data array for logfc values
#search for distinct dpi for given species
  
#search and group logFCand dpi by gene to build x and y axis categories arrays 
#mongodb command below  
//$data_dist=$measurementsCollection->distinct('day_after_inoculation',array($xpName'species'=> 'Arabidopsis thaliana'));
//var_dump($data_dist);

//var_dump($y_categories);
    #'xp'=>$Measurement_FK,
        $x_categories=array();
    $y_categories=array();
    $data=$measurementsCollection->aggregate(
            array(
              array('$match' => array('species'=>'Arabidopsis thaliana','$or'=>array(array('logFC'=>array('$gt'=>3)),array('logFC'=>array('$lt'=>-3))))),  
              array('$project' => array('gene'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
              array(
                '$group'=>
                  array(
                    '_id'=> array('gene'=> '$gene'),
                    'logs'=> array('$addToSet'=> array('log'=>'$logFC','dpi'=>'$day_after_inoculation'))
                  )
              )
            )
         );

         
         $counter_gene=0;
         foreach ($data['result'] as $result) {
         //    var_dump($result);echo '</br>';
             //echo $result['_id']['gene'];echo '</br>';
             array_push($x_categories, $result['_id']['gene']);
             $y_sub_categories=array();

             $tmp_value=0.0;
             $counter_measures=0;
             foreach ($result['logs'] as $values) {
                 $tmp_value+=$values['log'];
                 //echo $values['log'];echo '</br>';
                 //echo $values['dpi'];echo '</br>';
                 $counter_measures++;

             }
             $mean_value=$tmp_value/$counter_measures;
             array_push($y_sub_categories, $counter_gene);
             array_push($y_sub_categories, 0);
             array_push($y_sub_categories, $mean_value);
             $counter_gene++;

             array_push($y_categories, $y_sub_categories);
         //    foreach ($result['_id'] as $values) {
         //        var_dump($values);echo '</br>';
         //        
         //        array_push($x_categories, $values);
         ////        foreach ($values['logs'] as $value) {
         ////            echo $value['log'];
         ////            echo $value['dpi'];
         ////            
         ////        }
         //    }
         }
echo count($x_categories);
echo count($y_categories);
    
    

echo'<div class="container">';
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Expression profile heatmap </h1>';
		echo '</div>';
        echo '<div id="container" style="height: 400px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>';

echo '</div>';	
	
	
	
	
	
	//echo'<h2>Study type :</h2>';
	
	/*
	//Find all species 
	//$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1,'taxid'=>1,'abbrev_name'=>1,'aliases'=>1,'classification.top_level' =>1,'classification.kingdom'=>1,'classification.order'=>1));
	//makeDatatableFromFind($cursor);
	
	
	
	
	//foreach($cursor as $doc){
	//	show_array($doc);
	//}
	// if($requestID =='Request1'){
// 	
// 		
// 	
// 		#$ftp = new ftp('ftp.solgenomics.net/genomes/Solanum_lycopersicum/annotation/ITAG2.4_release/ITAG2.4_proteins_full_desc.fasta');
// 		#$ftp->ftp_login('username','password');
// 		#var_dump($ftp->ftp_nlist()); 
// 	
// 		#echo 'launch request 1';
// 		#Find all genes up regiulated in a given species with a given virus in given experiment type
// 		$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,$logFCInput,$speciesID,$virusID,'');
// 
//     	#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,'arabidopsis','Tobacco etch virus','');
// 		#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,'melon','Watermelon mosaic virus','');
// 		
// 		#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,'null','null','cFR15O8_c');
// 
// 		#$cursor=$samplesCollection->find(array('experimental_results.conditions.infected'=>true),array('experimental_results'=>1));
// 		#echo $cursor['results'].'</br>';
// 		#echo $cursor['variety'].'</br>';
// 		//foreach($cursor as $doc){
// 		//	echo $doc['variety'].'</br>';
// 		//}
// 		
// 		#makeDatatableFromFind($cursorprot);
// 		makeDatatableFromAggregate($cursor);
// 		#makeDatatableFromFind($cursor);
// 	}
// 	
// 	else if ($requestID =='Request2'){
// 		#echo 'launch request 2';
// 		$cursor=get_all_pathogens_infecting_angiosperm($speciesCollection,$samplesCollection);
// 		#echo 'launch request 2';
// 		#makeDatatableFromFind($cursor);
//    		makeDatatableFromAggregate($cursor);
// 	
// 	}
// 	
// 	else if($requestID =='Request3'){
// 		#echo 'launch request 3';
// 		#Find using Regex to quickly found a gene, useful to interpret which ids we encounter in xls files
// 		$search_string=$textID;
// 		$regex=new MongoRegex("/^$search_string/m");
// 		$cursor = find_gene_by_regex($measurementsCollection,$regex);
// 		makeDatatableFromFind($cursor);
// 
// 	}
// 	else if($requestID =='Request4'){
// 		echo 'launch request 4';
// 
// 	}
// 	else{
// 		//echo 'launch request 5';
// 		$search_string=$textID;
// 		$regex=new MongoRegex("/^$search_string/m");
// 		$cursor = find_gene_by_regex($measurementsCollection,$regex);
// 		makeDatatableFromFind($cursor);
// 
// 
// 		$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,4,$speciesID,$virusID,'');
// 		makeDatatableFromAggregate($cursor);
// 
// 	}
	
	//find all pathogens infecting angiosperms
    #$cursor=get_all_pathogens_infecting_angiosperm($speciesCollection,$sampleCollection);
   
    
    //$cursor=get_all_variety($samplesCollection);
    
    
    ###distinct request
    #$cursor=$db->command(array("distinct"=>"measurements","key"=>"xp"));
    
    
    
    
    
    
	
	
	#Find using Regex to quickly found a gene, useful to interpret which ids we encounter in xls files
	#$search_string='1';
	#$regex=new MongoRegex("/^$textID/m");
	#$cursor = find_gene_by_regex($measurementsCollection,$regex);
	
	
	
	#Count entries in sample collection
	#$cursor2 = $samplesCollection->count('experimental_results'=>1);
	
	#print_r($cursor);
	#foreach ( $cursor as $doc ){
	#	print_r($doc);
	#	echo'<br/>';
	#}
	
	#makeDatatableFromFind($cursor);
    #makeDatatableFromAggregate($cursor);
    
    
    //$txt='Cucumber mosaic virus';
    //$txt='monosporascus_cannonballus';
    //$cursor = find_species_doc($speciesCollection,'monosporascus_cannonballus');
    //$cursor = $speciesCollection->find(array('$or'=>array(array('full_name'=>$txt),array('aliases'=>$txt),array('abbrev_name'=>$txt))));

   
    	
	//makeDatatable($cursor);

	*/
	

?>

<script type="text/javascript" class="init">
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
$(function () {

    $('#container').highcharts({

        chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 80,
            plotBorderWidth: 1
        },


        title: {
            text: 'Differentially expressed genes'
        },

        xAxis: {
            categories: <?php echo json_encode($x_categories); ?>,

//            categories: ['ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100',
//'ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100'],

        },
        

        yAxis: {
            categories: ['21dpi'],
            title: null
        },

        colorAxis: {
            min: -5,
            max:5,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[0]
        },

        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 25,
            symbolHeight: 280
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.series.xAxis.categories[this.point.x] + '</b> log fold change equals to <br><b>' +
                    this.point.value + '</b> on <br><b>' + this.series.yAxis.categories[this.point.y] + '</b>';
            }
        },

        series: [{
            name: 'Sales per employee',
            borderWidth: 1,
            data: <?php echo json_encode($y_categories); ?>,

//            data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [0, 4, 67], 
//[1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [1, 4, 48], 
//[2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [2, 4, 52], 
//[3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [3, 4, 16], 
//[4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [4, 4, 115], 
//[5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [5, 4, 120], 
//[6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [6, 4, 96], 
//[7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [7, 4, 30], 
//[8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [8, 4, 84], 
//[9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48], [9, 4, 91],
//[10, 0, 10], [10, 1, 19], [10, 2, 8], [10, 3, 24], [10, 4, 67], 
//[11, 0, 92], [11, 1, 58], [11, 2, 78], [11, 3, 117], [11, 4, 48], 
//[12, 0, 35], [12, 1, 15], [12, 2, 123], [12, 3, 64], [12, 4, 52], 
//[13, 0, 72], [13, 1, 132], [13, 2, 114], [13, 3, 19], [13, 4, 16], 
//[14, 0, 38], [14, 1, 5], [14, 2, 8], [14, 3, 117], [14, 4, 115], 
//[15, 0, 88], [15, 1, 32], [15, 2, 12], [15, 3, 6], [15, 4, 120], 
//[16, 0, 13], [16, 1, 44], [16, 2, 88], [16, 3, 98], [16, 4, 96], 
//[17, 0, 31], [17, 1, 1], [17, 2, 82], [17, 3, 32], [17, 4, 30], 
//[18, 0, 85], [18, 1, 97], [18, 2, 123], [18, 3, 64], [18, 4, 84], 
//[19, 0, 47], [19, 1, 114], [19, 2, 31], [19, 3, 48], [19, 4, 91],
//[20, 0, 10], [20, 1, 19], [20, 2, 8], [20, 3, 24], [20, 4, 67], 
//[21, 0, 92], [21, 1, 58], [21, 2, 78], [21, 3, 117], [21, 4, 48], 
//[22, 0, 35], [22, 1, 15], [22, 2, 123], [22, 3, 64], [22, 4, 52], 
//[23, 0, 72], [23, 1, 132], [23, 2, 114], [23, 3, 19], [23, 4, 16], 
//[24, 0, 38], [24, 1, 5], [24, 2, 8], [24, 3, 117], [24, 4, 115], 
//[25, 0, 88], [25, 1, 32], [25, 2, 12], [25, 3, 6], [25, 4, 120], 
//[26, 0, 13], [26, 1, 44], [26, 2, 88], [26, 3, 98], [26, 4, 96], 
//[27, 0, 31], [27, 1, 1], [27, 2, 82], [27, 3, 32], [27, 4, 30], 
//[28, 0, 85], [28, 1, 97], [28, 2, 123], [28, 3, 64], [28, 4, 84], 
//[29, 0, 47], [29, 1, 114], [29, 2, 31], [29, 3, 48], [29, 4, 91],
//[30, 0, 10], [30, 1, 19], [30, 2, 8], [30, 3, 24], [30, 4, 67], 
//[31, 0, 92], [31, 1, 58], [31, 2, 78], [31, 3, 117], [31, 4, 48], 
//[32, 0, 35], [32, 1, 15], [32, 2, 123], [32, 3, 64], [32, 4, 52], 
//[33, 0, 72], [33, 1, 132], [33, 2, 114], [33, 3, 19], [33, 4, 16], 
//[34, 0, 38], [34, 1, 5], [34, 2, 8], [34, 3, 117], [34, 4, 115], 
//[35, 0, 88], [35, 1, 32], [35, 2, 12], [35, 3, 6], [35, 4, 120], 
//[36, 0, 13], [36, 1, 44], [36, 2, 88], [36, 3, 98], [36, 4, 96], 
//[37, 0, 31], [37, 1, 1], [37, 2, 82], [37, 3, 32], [37, 4, 30], 
//[38, 0, 85], [38, 1, 97], [38, 2, 123], [38, 3, 64], [38, 4, 84], 
//[39, 0, 47], [39, 1, 114], [39, 2, 31], [39, 3, 48], [39, 4, 91],
//[40, 0, 10], [40, 1, 19], [40, 2, 8], [40, 3, 24], [40, 4, 67], 
//[41, 0, 92], [41, 1, 58], [41, 2, 78], [41, 3, 117], [41, 4, 48], 
//[42, 0, 35], [42, 1, 15], [42, 2, 123], [42, 3, 64], [42, 4, 52], 
//[43, 0, 72], [43, 1, 132], [43, 2, 114], [43, 3, 19], [43, 4, 16], 
//[44, 0, 38], [44, 1, 5], [44, 2, 8], [44, 3, 117], [44, 4, 115], 
//[45, 0, 88], [45, 1, 32], [45, 2, 12], [45, 3, 6], [45, 4, 120], 
//[46, 0, 13], [46, 1, 44], [46, 2, 88], [46, 3, 98], [46, 4, 96], 
//[47, 0, 31], [47, 1, 1], [47, 2, 82], [47, 3, 32], [47, 4, 30], 
//[48, 0, 85], [48, 1, 97], [48, 2, 123], [48, 3, 64], [48, 4, 84], 
//[49, 0, 47], [49, 1, 114], [49, 2, 31], [49, 3, 48], [49, 4, 91],
//[50, 0, 10], [50, 1, 19], [50, 2, 8], [50, 3, 24], [50, 4, 67], 
//[51, 0, 92], [51, 1, 58], [51, 2, 78], [51, 3, 117], [51, 4, 48], 
//[52, 0, 35], [52, 1, 15], [52, 2, 123], [52, 3, 64], [52, 4, 52], 
//[53, 0, 72], [53, 1, 132], [53, 2, 114], [53, 3, 19], [53, 4, 16], 
//[54, 0, 38], [54, 1, 5], [54, 2, 8], [54, 3, 117], [54, 4, 115], 
//[55, 0, 88], [55, 1, 32], [55, 2, 12], [55, 3, 6], [55, 4, 120], 
//[56, 0, 13], [56, 1, 44], [56, 2, 88], [56, 3, 98], [56, 4, 96], 
//[57, 0, 31], [57, 1, 1], [57, 2, 82], [57, 3, 32], [57, 4, 30], 
//[58, 0, 85], [58, 1, 97], [58, 2, 123], [58, 3, 64], [58, 4, 84], 
//[59, 0, 47], [59, 1, 114], [59, 2, 31], [59, 3, 48], [59, 4, 91],
//[60, 0, 10], [60, 1, 19], [60, 2, 8], [60, 3, 24], [60, 4, 67], 
//[61, 0, 92], [61, 1, 58], [61, 2, 78], [61, 3, 117], [61, 4, 48], 
//[62, 0, 35], [62, 1, 15], [62, 2, 123], [62, 3, 64], [62, 4, 52], 
//[63, 0, 72], [63, 1, 132], [63, 2, 114], [63, 3, 19], [63, 4, 16], 
//[64, 0, 38], [64, 1, 5], [64, 2, 8], [64, 3, 117], [64, 4, 115], 
//[65, 0, 88], [65, 1, 32], [65, 2, 12], [65, 3, 6], [65, 4, 120], 
//[66, 0, 13], [66, 1, 44], [66, 2, 88], [66, 3, 98], [66, 4, 96], 
//[67, 0, 31], [67, 1, 1], [67, 2, 82], [67, 3, 32], [67, 4, 30], 
//[68, 0, 85], [68, 1, 97], [68, 2, 123], [68, 3, 64], [68, 4, 84], 
//[69, 0, 47], [69, 1, 114], [69, 2, 31], [69, 3, 48], [69, 4, 91],
//[70, 0, 10], [70, 1, 19], [70, 2, 8], [70, 3, 24], [70, 4, 67], 
//[71, 0, 92], [71, 1, 58], [71, 2, 78], [71, 3, 117], [71, 4, 48], 
//[72, 0, 35], [72, 1, 15], [72, 2, 123], [72, 3, 64], [72, 4, 52], 
//[73, 0, 72], [73, 1, 132], [73, 2, 114], [73, 3, 19], [73, 4, 16], 
//[74, 0, 38], [74, 1, 5], [74, 2, 8], [74, 3, 117], [74, 4, 115], 
//[75, 0, 88], [75, 1, 32], [75, 2, 12], [75, 3, 6], [75, 4, 120], 
//[76, 0, 13], [76, 1, 44], [76, 2, 88], [76, 3, 98], [76, 4, 96], 
//[77, 0, 31], [77, 1, 1], [77, 2, 82], [77, 3, 32], [77, 4, 30], 
//[78, 0, 85], [78, 1, 97], [78, 2, 123], [78, 3, 64], [78, 4, 84], 
//[79, 0, 47], [79, 1, 114], [79, 2, 31], [79, 3, 48], [79, 4, 91],
//[80, 0, 10], [80, 1, 19], [80, 2, 8], [80, 3, 24], [80, 4, 67], 
//[81, 0, 92], [81, 1, 58], [81, 2, 78], [81, 3, 117], [81, 4, 48], 
//[82, 0, 35], [82, 1, 15], [82, 2, 123], [82, 3, 64], [82, 4, 52], 
//[83, 0, 72], [83, 1, 132], [83, 2, 114], [83, 3, 19], [83, 4, 16], 
//[84, 0, 38], [84, 1, 5], [84, 2, 8], [84, 3, 117], [84, 4, 115], 
//[85, 0, 88], [85, 1, 32], [85, 2, 12], [85, 3, 6], [85, 4, 120], 
//[86, 0, 13], [86, 1, 44], [86, 2, 88], [86, 3, 98], [86, 4, 96], 
//[87, 0, 31], [87, 1, 1], [87, 2, 82], [87, 3, 32], [87, 4, 30], 
//[88, 0, 85], [88, 1, 97], [88, 2, 123], [88, 3, 64], [88, 4, 84], 
//[89, 0, 47], [89, 1, 114], [89, 2, 31], [89, 3, 48], [89, 4, 91],
//[90, 0, 10], [90, 1, 19], [90, 2, 8], [90, 3, 24], [90, 4, 67], 
//[91, 0, 92], [91, 1, 58], [91, 2, 78], [91, 3, 117], [91, 4, 48], 
//[92, 0, 35], [92, 1, 15], [92, 2, 123], [92, 3, 64], [92, 4, 52], 
//[93, 0, 72], [93, 1, 132], [93, 2, 114], [93, 3, 19], [93, 4, 16], 
//[94, 0, 38], [94, 1, 5], [94, 2, 8], [94, 3, 117], [94, 4, 115], 
//[95, 0, 88], [95, 1, 32], [95, 2, 12], [95, 3, 6], [95, 4, 120], 
//[96, 0, 13], [96, 1, 44], [96, 2, 88], [96, 3, 98], [96, 4, 96], 
//[97, 0, 31], [97, 1, 1], [97, 2, 82], [97, 3, 32], [97, 4, 30], 
//[98, 0, 85], [98, 1, 97], [98, 2, 123], [98, 3, 64], [98, 4, 84], 
//[99, 0, 47], [99, 1, 114], [99, 2, 31], [99, 3, 48], [99, 4, 91]],
            
//            dataLabels: {
//                //enabled: true,
//                color: '#000000'
//            }
        }]

    });
});







</script>

<?php
new_cobra_footer();
?>
