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

	
	
	
	
	$cursor = $samplesCollection->find(array('name'=>$xpName), array('_id'=>1));
	
	foreach($cursor as $line) {
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

#build the data array for logfc values
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
            categories: ['ATCG01100', 'ATCG02100', 'ATCG01300', 'ATCG01103', 'ATCG01600', 'ATCG01700', 'ATCG01800', 'ATCG21100', 'ATCG31100', 'ATCG61100']
        },

        yAxis: {
            categories: ['0dpi', '3dpi', '7dpi', '14dpi', '28dpi'],
            title: null
        },

        colorAxis: {
            min: 0,
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
            data: [[0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [0, 4, 67], [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [1, 4, 48], [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [2, 4, 52], [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [3, 4, 16], [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [4, 4, 115], [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [5, 4, 120], [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [6, 4, 96], [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [7, 4, 30], [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [8, 4, 84], [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48], [9, 4, 91]],
            dataLabels: {
                enabled: true,
                color: '#000000'
            }
        }]

    });
});
</script>

<?php
new_cobra_footer();
?>
