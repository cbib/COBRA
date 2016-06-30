<?php
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');
new_cobra_header("../..");
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
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");


	//REQUEST 

	
	
	
	
	$cursor_for_xp_name = $samplesCollection->find(array('name'=>$xpName), array('_id'=>1));
	foreach($cursor_for_xp_name as $line) {
		$xpID=$line['_id'];
	}
	
	//echo $xpID;

	
	
	$cursor = $samplesCollection->find(array('name'=>$xpName), array('comments'=>1,'species'=>1,'assay.type'=>1,'src_pub'=>1,'assay.design'=>1,'deposited.sample_description_url'=>1,'deposited.repository'=>1,'experimental_results'=>1,'_id'=>0));

	foreach($cursor as $line) {
 		$species=$line['species'];
 		$source_pub=$line['src_pub'];
 		$assay_info=$line['assay'];
 		$deposit_info=$line['deposited'];
        $comment=$line['comments'];
 		$experimental_results=$line['experimental_results'];
 		
 	}
//    $total_genes_for_given_species=$full_mappingsCollection->distinct("mapping_file.Gene ID",array('species'=>$species));
//    echo count($total_genes_for_given_species);

 	##http://www.ncbi.nlm.nih.gov/pubmed/19821986
    #http://www.ncbi.nlm.nih.gov/pmc/articles/PMC3832472/
 	##EXPERIMENT DETAILS
 	echo'<div class="container" background-color="blue">';
 	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Experiment details </h1>';
		echo '</div>';
	echo'<div id="xp-details">';
	echo '<hr>';
	echo '<dl class="dl-horizontal">
 	 	<dt>name</dt>
  		<dd>'.$xpName.'</dd>
        <dt>Abstract</dt>
  		<dd>'.$comment[0]['content'].'</dd>
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
    echo'<div id="species-details">';
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
    echo'<div id="dataset-details">';
 	echo '<dl class="dl-horizontal">
 	 	<dt>number of samples files</dt>
        
        <dd>'.count($experimental_results).'</dd>
        <dt>analysis type</dt>
  		<dd>'.$assay_info['type'].'</dd>
  		<dt>design</dt>
  		<dd>'.$assay_info['design'].'</dd>
  		<dt>Dataset repository</dt>
        <dd><a href="'.$deposit_info['repository'].'">'.$deposit_info['repository'].'</a></dd>
  		<dt>Sample description</dt>
  		<dd>'.$deposit_info['sample_description_url'].'</dd>
	</dl>';
	echo'</div>';
    echo '</div>';
	
//	echo'<div class="container">';
//	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
//		echo'<h1 style="text-align:center"> Samples Files </h1>';
//		echo '</div>';
//		$file_counter=0;
//	foreach($experimental_results as $details) {
//		$file_counter++;
//	}
// 	echo '<dl class="dl-horizontal">
// 	 	<dt>number of samples files</dt>
//  		<dd>'.$file_counter.'</dd>
//  		
//	</dl>';
//	
//	echo'</div>';
	
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
		echo'<h1 style="text-align:center"> Sample files details </h1>';
	echo '</div>';
    
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
        
        echo'<div id="sample-details">';
        echo '<div class="shift_line"></div>';
		
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
                <dd>'.$material.'</dd>
                <dt>day after inoculation</dt>
                <dd>'.$dpi.'</dd>';
        for ($i = 1	; $i <= count($conditions); $i++) {
  			if (is_array($conditions[$i-1])){
				if ($conditions[$i-1]['infected']==True){
					
					//echo'<h3>Condition '.$i.' : infected</h3><ul>';
					echo'<dt>Condition '.$i.' : infected</dt>
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
					echo'<dt>Condition '.$i.' : infected</dt>
  					<dd>'.$conditions[$i-1].'</dd>';
				}
			}
			else{
				//echo'<h3>Condition '.$i.' :'.$conditions[$i-1].'</h3>';
				echo'<dt>Condition '.$i.' : infected</dt>
  					<dd>'.$conditions[$i-1].'</dd>';
				//echo $conditions[$i-1];
			}
  		
  		}
        echo '<dt>min logFC threshold</dt>';
        echo ' <dd><select onchange="change_min_logFC(this)" data-id="'.str_replace(".", "-",$Measurement_FK).'" name="min_log_fc" class="minlogFC_'.str_replace(".", "-",$Measurement_FK).'">';
        for ($i = -0.5; $i >= -10; $i-=0.1) :
            echo '<option value="'.$i.'">'.$i.'</option>';
        endfor; 
        echo '</select></dd>';
        echo '<dt>max logFC threshold</dt>';
        echo ' <dd><select onchange="change_max_logFC(this)"  data-id="'.str_replace(".", "-",$Measurement_FK).'" name="max_log_fc" class="maxlogFC_'.str_replace(".", "-",$Measurement_FK).'">';
        for ($i = 0.5; $i <= 10; $i+=0.1) :
            echo '<option value="'.$i.'">'.$i.'</option>';
        endfor; 
        echo '</select></dd>';
               
        
        echo '</dl>';
        
        
        //echo '<div id="test_'.str_replace(".", "_",$Measurement_FK).'"> </div>';
        //$maxlogFCthreshold=1.5;
        //$minlogFCthreshold=-1.5;
        //$gene_significant_count=$measurementsCollection->find(array('xp'=>$Measurement_FK,'$or'=>array(array('logFC'=>array('$gt'=>$maxlogFCthreshold)),array('logFC'=>array('$lt'=>$minlogFCthreshold)))))->count();

        echo '<button onclick="load_heatmap(this)"  data-id="'.str_replace(".", "-",$Measurement_FK).'"  data-min=-0.5 data-max=0.5 class="heatmap_button_'.str_replace(".", "-",$Measurement_FK).'" type="button">Show heatmap</button>';

        
        echo '<center>'
            . '<div class="loading_'.str_replace(".", "-", $Measurement_FK).'" style="display: none"></div>
              </center>
              <div class="container animated fadeInDown">
                <div class="test_'.str_replace(".", "-",$Measurement_FK).'"> 
                    
                        <!--here comes the heatmap div-->
                </div>

              </div>';
        echo '<div class="shift_line"></div>';
        
        
        
        
// PARTIE NON OPERATIONNELLE
        echo '<button onclick="load_GO_enrichment_new(this)"  data-id="'.str_replace(".", "-",$Measurement_FK).'"  data-min=-0.5 data-max=0.5 data-species="'.$species.'" class="GO_button_'.str_replace(".", "-",$Measurement_FK).'" type="button">Show Enriched GO Terms</button>';
        echo '<center>'
            . '<div class="GOloading_'.str_replace(".", "-", $Measurement_FK).'" style="display: none"></div>
              </center>
              <div class="container animated fadeInDown">
                
                <div class="GOtest_'.str_replace(".", "-",$Measurement_FK).'"> 
                    
                        <!--here comes the GO div-->
                </div>
                
                <p class="GOparagraph_'.str_replace(".", "-",$Measurement_FK).'" style="font-weight: bold" hidden> GO terms of the set of differentially expressed genes (n = not set yet, blue bars) 
                        is compared to terms of all micro array genes ('.$gene_count.', green bars). 
                        The y-axis displays the fraction relative to all GO Molecular Function terms. 
                        These terms do not show a significant enrichment (p>0.5).
                    </p>

              </div>';
        echo '<div class="shift_line"></div>';

        
        
        
        

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
        echo '</div>';
        echo '<div class="shift_line"></div>';
	}	
	echo '<hr></div>';
/*$data_gene_to_keep=$measurementsCollection->aggregate(
//    array(
//      array('$match' => array('name'=>$xpName,'$or'=>array(array('logFC'=>array('$gt'=>3)),array('logFC'=>array('$lt'=>-3))))),  
//      array('$project' => array('gene'=>1,'xp'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
//      array(
//        '$group'=>
//          array(
//            '_id'=> array('gene'=> '$gene'),
//            'logs'=> array('$addToSet'=> array('xp'=>'$xp'))
//          )
//      )
//));
////var_dump($data_gene_to_keep);
//foreach ($data_gene_to_keep['result'] as $value) {
//    if (count($value['logs'])===3){
//        echo $value['_id']['gene'];echo '</br>';
//        foreach ($value['logs'] as $values) {
//            echo $values['xp'];echo '</br>';
//        }
//    }
//
//
//}


#build the data array for logfc values
#search for distinct dpi for given species
  
#search and group logFCand dpi by gene to build x and y axis categories arrays 
#mongodb command below  
//$data_dist=$measurementsCollection->distinct('day_after_inoculation',array($xpName'species'=> 'Arabidopsis thaliana'));
//var_dump($data_dist);

//var_dump($y_categories);
    #'xp'=>$Measurement_FK,
//    $x_categories=array();
//    $y_categories=array();
//    $data=$measurementsCollection->aggregate(
//            array(
//              array('$match' => array('species'=>'Arabidopsis thaliana','$or'=>array(array('logFC'=>array('$gt'=>3)),array('logFC'=>array('$lt'=>-3))))),  
//              array('$project' => array('gene'=>1,'logFC'=>1,'day_after_inoculation'=>1,'name'=>1,'_id'=>0)),
//              array(
//                '$group'=>
//                  array(
//                    '_id'=> array('gene'=> '$gene'),
//                    'logs'=> array('$addToSet'=> array('log'=>'$logFC','dpi'=>'$day_after_inoculation'))
//                  )
//              )
//            )
//         );
//
//         
//         $counter_gene=0;
//         foreach ($data['result'] as $result) {
//         //    var_dump($result);echo '</br>';
//             //echo $result['_id']['gene'];echo '</br>';
//             array_push($x_categories, $result['_id']['gene']);
//             $y_sub_categories=array();
//
//             $tmp_value=0.0;
//             $counter_measures=0;
//             foreach ($result['logs'] as $values) {
//                 $tmp_value+=$values['log'];
//                 //echo $values['log'];echo '</br>';
//                 //echo $values['dpi'];echo '</br>';
//                 $counter_measures++;
//
//             }
//             $mean_value=$tmp_value/$counter_measures;
//             array_push($y_sub_categories, $counter_gene);
//             array_push($y_sub_categories, 0);
//             array_push($y_sub_categories, $mean_value);
//             $counter_gene++;
//
//             array_push($y_categories, $y_sub_categories);
//         //    foreach ($result['_id'] as $values) {
//         //        var_dump($values);echo '</br>';
//         //        
//         //        array_push($x_categories, $values);
//         ////        foreach ($values['logs'] as $value) {
//         ////            echo $value['log'];
//         ////            echo $value['dpi'];
//         ////            
//         ////        }
//         //    }
//         }
//echo count($x_categories);
//echo count($y_categories);
    
    

//echo'<div class="container">';
//	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
//		echo'<h1 style="text-align:center"> Expression profile heatmap </h1>';
//		
//    echo '</div>';
//    echo '<div id="container" style="height: 400px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>';
//
//echo '</div>';*/	

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
	
new_cobra_footer();


