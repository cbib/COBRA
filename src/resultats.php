<?php
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';

new_cobra_header();

?>

<?php
new_cobra_body();

	//Recuperation des variables de la page main
	$requestID=control_post($_POST['requestID']);
	$speciesID=control_post(htmlspecialchars($_POST['speciesID']));
	$exp_typeID=control_post(htmlspecialchars($_POST['exp_typeID']));
	$virusID=control_post(htmlspecialchars($_POST['virusID']));
	$textID=control_post(htmlspecialchars($_POST['textInput']));
	$logFCInput=control_post(htmlspecialchars($_POST['logFCInput']));


	echo'<div class="container">
	<h2>Results</h2>';
	#echo $requestID;
	echo $logFCInput;
	echo '<br>';
	/*
	echo $speciesID;
	echo '<br>';
	echo $textID;
	echo '<br>';
	echo $virusID; 
	echo '<br>';
	echo $exp_typeID; 
	echo '<br>';
	echo '</div>';
	*/
	//Instanciation de la connexion
	$db=mongoConnector();
	#$db=mongoPersistantConnector()
	//$db=mongoPersistantConnector();
	
	//Selection de la collection
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");


	//var_dump($cursor);
	
	//REQUEST 

	//$cursor = $sampleCollection->find(array(), array('name'=>1));
	
	//Find all species 
	//$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1,'taxid'=>1,'abbrev_name'=>1,'aliases'=>1,'classification.top_level' =>1,'classification.kingdom'=>1,'classification.order'=>1));
	//makeDatatableFromFind($cursor);
	
	
	
	
	//foreach($cursor as $doc){
	//	show_array($doc);
	//}
	if($requestID =='Request1'){
	
		
	
		#$ftp = new ftp('ftp.solgenomics.net/genomes/Solanum_lycopersicum/annotation/ITAG2.4_release/ITAG2.4_proteins_full_desc.fasta');
		#$ftp->ftp_login('username','password');
		#var_dump($ftp->ftp_nlist()); 
	
		#echo 'launch request 1';
		#Find all genes up regiulated in a given species with a given virus in given experiment type
		$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,$logFCInput,$speciesID,$virusID,'');

    	#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,'arabidopsis','Tobacco etch virus','');
		#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,'melon','Watermelon mosaic virus','');
		
		#$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,'null','null','cFR15O8_c');

		#$cursor=$samplesCollection->find(array('experimental_results.conditions.infected'=>true),array('experimental_results'=>1));
		#echo $cursor['results'].'</br>';
		#echo $cursor['variety'].'</br>';
		//foreach($cursor as $doc){
		//	echo $doc['variety'].'</br>';
		//}
		
		#makeDatatableFromFind($cursorprot);
		makeDatatableFromAggregate($cursor);
		#makeDatatableFromFind($cursor);
	}
	
	else if ($requestID =='Request2'){
		#echo 'launch request 2';
		$cursor=get_all_pathogens_infecting_angiosperm($speciesCollection,$samplesCollection);
		#echo 'launch request 2';
		#makeDatatableFromFind($cursor);
   		makeDatatableFromAggregate($cursor);
	
	}
	
	else if($requestID =='Request3'){
		#echo 'launch request 3';
		#Find using Regex to quickly found a gene, useful to interpret which ids we encounter in xls files
		$search_string=$textID;
		$regex=new MongoRegex("/^$search_string/m");
		$cursor = find_gene_by_regex($measurementsCollection,$regex);
		makeDatatableFromFind($cursor);

	}
	else if($requestID =='Request4'){
		echo 'launch request 4';

	}
	else{
		echo 'launch request 5';

	}
	
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

	echo'</div>';
	echo'
<div class="container">
  <h2>Select examples</h2>
	<p>Select interactions if exists:</p>
  <form role="form" action="interactions.php" method="post" >
     <!--<div class="form-group">
     <label for="geneID">Liste Deroulante:</label>
      <select class="form-control" id="geneID" name="geneID">
       <option value ="">----Choisir----</option>
	   <option value="gene1">Gene 1</option>
       <option value="gene2">Gene 2</option>
       <option value="gene3">Gene 3</option>
       <option value="gene4">Gene 4</option>
      </select>
      <div class="form-group">
        <label for="multipleID">Muliple Select List</label>
            <select multiple class="form-control" id="multipleID" name="multipleID">
                <option value="multiple1">Gene 1</option>
                <option value="multiple2">Gene 2</option>
                <option value="multiple3">Gene 3</option>
                <option value="multiple4">Gene 4</option>
                <option value="multiple5">Gene 5</option>
            </select>
      </div>
      <br>
    </div>-->';
    #make_species_list(find_species_list($speciesCollection));
    #make_viruses_list(find_viruses_list($speciesCollection));
    #make_experiment_type_list(find_experiment_type_list($sampleCollection));
    #make_request_list();
    echo' 
    <br>
    <!--<div class="form-group">
        <label for="requestID">Multiple Select List</label>
        <select multiple class="form-control" id="requestID" name="requestID">
            <option value="Request1">get all uniprot id from genes up regulated from a given species in microarray analysis of infection by a given virus</option>
            <option value="Request2">get all angiosperms infected by a given pathogen</option>
            <option value="Request3">find a gene using a regular expression and retrieve prot interaction data if exist</option>
            <option value="Request4">Request 4</option>
        	<option value="Request5">Request 5</option>
        </select>
    </div>-->
    <div class="form-group">
      <label for="textInput">choose a prot id</label>
      <input type="text" name="textID" class ="form-control" placeholder="Tapez ici..." id="textID">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
    </form>
</div>
';

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
</script>

<?php
new_cobra_footer();
?>
