<?php
session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');


define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


new_cobra_header();

?>

<?php
new_cobra_body($_SESSION['login']);
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
$grid = $db->getGridFS();


//$speciesID=control_post(htmlspecialchars($_GET['speciesID']));
$listID=control_post(htmlspecialchars($_GET['listID']));
//$textID=control_post(htmlspecialchars($_GET['q']));
// on remplace le retour charriot par <br>
$listID = str_replace('\r\n','<br>',$listID);
//echo $listID;
$id_details= explode("\r\n", $listID);

echo '<ul class="nav nav-tabs" id ="operation">';
for ($c=0;$c<count($id_details);$c++){
//	$textID=$listID
//?speciesID=&q=SGN-U603893


	
		if ($c==0){
	
        echo '<li class="active"><a data-toggle="tab" href="#'.$id_details[$c].'">'.$id_details[$c].'</a></li>';
			
		}
		else{
		  echo '<li><a data-toggle="tab" href="#'.$id_details[$c].'">'.$id_details[$c].'</a></li>';

		}
       

    
}
echo '</ul>';


#echo '<div class="tab-content">';
   // echo ' <ul class="nav nav-tabs">
// 
//         <li class="active"><a href="resultats.php">Home</a></li>
// 
//         <li><a href="#">Profile</a></li>
// 
//         <li><a href="#">Messages</a></li>
// 
//     </ul>';
#echo '<div class="tab-content">';
echo '<div class="tab-content">';
	for ($c=0;$c<count($id_details);$c++){
		$speciesID="Arabidopsis thaliana";
		$textID=$id_details[$c];
		$class="tab-pane active";
		if ($c==0){
			echo'<div id='.$textID.' class='.$class.'>';
		  
		  
		}
		else{
			echo'<div id='.$textID.' class=tab-pane>';
		}
		  
	
		echo '<h2>Search Results for \''.$textID.'\'</h2>';


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
			$search_string=$textID;
			$regex=new MongoRegex("/^$search_string/m");
			$cursor = find_gene_by_regex($measurementsCollection,$regex);
			echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
			echo'<h1 style="text-align:center"> Samples informations </h1>';
			echo '</div>';
			//makeDatatableFromFindByRegex($cursor);
	
			$array = iterator_to_array($cursor);
			$keys =array();

			foreach ($array as $k => $v) {
					foreach ($v as $a => $b) {
						$keys[] = $a;
					  }
			}
			$keys = array_values(array_unique($keys));
	
			echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
			echo'<thead><tr>';

			//recupere le titre
			foreach (array_slice($keys,1) as $key => $value) {
					if ($value=='gene'){
						echo "<th>" . $value . "</th>";
			
					}
			}
			foreach (array_slice($keys,1) as $key => $value) {
		
					if ($value=='direction'){
						echo "<th>" . $value . "</th>";
				
					}
			}
			foreach (array_slice($keys,1) as $key => $value) {
		
					if ($value=='logFC'){
						echo "<th>" . $value . "</th>";
				
					}
			}
			foreach (array_slice($keys,1) as $key => $value) {
		
					if ($value=='type'){
						echo "<th>" . $value . "</th>";
				
					}
			}
			foreach (array_slice($keys,1) as $key => $value) {
		
					if ($value=='xp'){
						echo "<th>" . $value . "</th>";
				
					}
			}
			//echo "<th>infection agent</th>";
			//fin du header de la table
			echo'</tr></thead>';

			//Debut du corps de la table
			echo'<tbody>';
			//Parcour de chaque ligne du curseur
			foreach($cursor as $line) {
				echo "<tr>";
	
				//Slice de l'id Mongo
				#echo $line->count();
	  
				foreach(array_slice($keys,1) as $key => $value) {
			
			
					#http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=MU60682&searchtype=unigene&organism=melon
			
					if ($value=='gene'){
						if (stristr($line[$value],"MU")) {
							if(is_array($line[$value])){;
								#http://www.arabidopsis.org/servlets/TairObject?name=AT5G03160&type=locus
								echo"<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".show_array($line[$value])."&searchtype=unigene&organism=melon\">".show_array($line[$value])."</a></td>";
						
							}
							else {
								echo"<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".$line[$value]."&searchtype=unigene&organism=melon\">".$line[$value]."</a></td>";
		
							}
						}
						else if (stristr($line[$value],"AT")) {
							if(is_array($line[$value])){;
				
								echo"<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".show_array($line[$value])."&type=locus\">".show_array($line[$value])."</a></td>";
						
							}
							else {
								echo"<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".$line[$value]."&type=locus\">".$line[$value]."</a></td>";
							}
						}
						else{
							if(is_array($line[$value])){;
				
								echo"<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".show_array($line[$value])."\">".show_array($line[$value])."</a></td>";
						
							}
					
							else {
								//$url="http://solgenomics.net/search/unigene.pl?unigene_id=".$line[$value];
								echo"<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".$line[$value]."\">".$line[$value]."</a></td>";
								#echo"<td><a href=\"../src/prot_ref.php?protID=".$line[$value]."\">".$line[$value]."</a></td>";

							
								#get_protein_info($url);
								#echo "<td>".$line[$value]."</td>";
							}
						}
				
						# http://pgsb.helmholtz-muenchen.de/cgi-bin/db2/barleyV2/gene_report.cgi?gene=
						#use table from 
				
				
					}
		
				}
	
				foreach(array_slice($keys,1) as $key => $value) {

					if($value=='direction'){
						if(is_array($line[$value])){;
							echo"<td>".show_array($line[$value])."</td>";
						}
						else {
							echo "<td>".$line[$value]."</td>";
						}
					}
				}
				foreach(array_slice($keys,1) as $key => $value) {

					if($value=='logFC'){
						if(is_array($line[$value])){;
							echo"<td>".show_array($line[$value])."</td>";
						}
						else {
							echo "<td>".$line[$value]."</td>";
						}
					}
				}
				foreach(array_slice($keys,1) as $key => $value) {

					if($value=='type'){
						if(is_array($line[$value])){;
							echo"<td>".show_array($line[$value])."</td>";
						}
						else {
							echo "<td>".$line[$value]."</td>";
						}
					}
				}
				foreach(array_slice($keys,1) as $key => $value) {

					if($value=='xp'){
						if(is_array($line[$value])){;
							echo"<td>".show_array($line[$value])."</td>";
						}
						else {
							//list($xp_String_id, $ex_results, $file_number) 
							$xp_details= explode(".", $line[$value]);
							$xp_String_id=$xp_details[0];
							//echo "<td>".$xp_String_id."</td>";

							$xp_id = new MongoId($xp_String_id);
							$xp_name=$samplesCollection->findOne(array('_id'=>$xp_id),array('name'=>1,'_id'=>0));
							echo "<td>".$xp_name['name']."</td>";
							//echo"<td>".$line[$value]."</td>";
					
						}
					}
				}
	
	
				echo "</tr>";
			}
			echo'</tbody></table>';
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
			//$cursor=get_all_genes_up_regulated($measurementsCollection,$speciesCollection,$samplesCollection,$mappingsCollection,$virusesCollection,0.04,$speciesID,$virusID,'');
			//makeDatatableFromAggregate($cursor);
		}
		/*
		# Get available mappings and process them 
		$mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('src'=>1,'tgt'=>1,'mapping_file'=>1,'_id'=>0));
		foreach ($mappings_to_process as $map_doc){
	
			$src_col = $map_doc['src'];
			$tgt_col = $map_doc['tgt'];
			$map_file = $map_doc['mapping_file'];
	
			foreach ($map_file as $doc){
		
				if ($doc[$src_col]==$textID){
		
					echo 'new entry for :'.$textID;
					foreach ($doc as $key =>$value){
				
						echo '<li>'.$key.' : '.$value.'</li></br>';
				
			
					}
					//for ($i = 0; $i < count($doc); $i++) {
					//	echo $doc[$i].'</br>';
					//}

				}
	
			}
			//echo $src_col;
			//echo $tgt_col;
	
			//$tgt_array=$mappingsCollection->find(array('mapping_file.$.'.$src_col=>$textID),array('tgt'=>'mapping_file.$.'.$tgt_col));
			//foreach ($tgt_array as $tgtname){
			//	echo $tgtname;
	
			//}
		}
		*/



		$mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('type'=>1,'description'=>1,'url'=>1,'src'=>1,'tgt'=>1,'mapping_file'=>1,'_id'=>0));


		//echo'<div class="container" bg-blue">';
		$gene_symbol=array();
		$gene_ids=array();
		$uniprot_ids=array();
		$descriptions=array();
		echo '<hr>';
		echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Related informations </h1>';
		echo '</div>';
		echo'<h1> Protein related informations </h1>';
		foreach ($mappings_to_process as $map_doc){
	
			$src_col = $map_doc['src'];
			$tgt_col = $map_doc['tgt'];
			$type=$map_doc['type'];
			$description=$map_doc['description'];
			$url = $map_doc['url'];
			$map_file = $map_doc['mapping_file'];
	
	
			if ($type=='gene_to_prot'){
		

				//echo '<dl class="dl-horizontal">';
	
				foreach ($map_file as $doc){


					if ($doc[$tgt_col]==$textID){
		
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
				
						//echo '</div>';
						echo '<br>';
						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx" OR $key==$tgt_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
				
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
					if ($doc[$src_col]==$textID){
						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						//echo '</div>';
						echo '<br>';
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx" OR $key==$src_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
						
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
								array_push($uniprot_ids,$value);
						

							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
		
	
				}
				//echo' </dl>';
			}
	
	
	
		}
		echo'<h1> Gene related informations </h1>';
		foreach ($mappings_to_process as $map_doc){
	
			$src_col = $map_doc['src'];
			$tgt_col = $map_doc['tgt'];
			$type=$map_doc['type'];
			$description=$map_doc['description'];
			$url = $map_doc['url'];
			$map_file = $map_doc['mapping_file'];
	
	
			if ($type=='gene_to_gene'){
		
				echo '<dl class="dl-horizontal">';
	
				foreach ($map_file as $doc){


					if ($doc[$tgt_col]==$textID){
		
		

						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
				
						//echo '</div>';
						echo '<br>';
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx" OR $key==$tgt_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
								array_push($gene_ids,$value);

							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
					if ($doc[$src_col]==$textID){
				

						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						//echo '</div>';
						echo '<br>';
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx" OR $key==$src_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
										array_push($gene_ids,$value);

							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
		
	
				}
				echo' </dl>';
			}
	
	
	
	
		}
		echo'<h1> Gene symbol related informations </h1>';

		foreach ($mappings_to_process as $map_doc){
	
			$src_col = $map_doc['src'];
			$tgt_col = $map_doc['tgt'];
			$type=$map_doc['type'];
			$description=$map_doc['description'];
			$url = $map_doc['url'];
			$map_file = $map_doc['mapping_file'];
	
	
	
			if ($type=='gene_to_symbol'){
		
				echo '<dl class="dl-horizontal">';
				foreach ($map_file as $doc){


					if ($doc[$tgt_col]==$textID){
		
		
						//echo'<h1> Gene Symbol related informations </h1>';
						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						//echo'<h1> Gene symbol related informations </h1>';
						//echo '</div>';
						echo '<br>';
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx"){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
					
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
					if ($doc[$src_col]==$textID){
						//echo'<h1> Gene Symbol related informations </h1>';
						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						//echo'<h1> Gene symbol related informations </h1>';
						//echo '</div>';
						echo '<br>';
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							if ($key=="idx" OR $key==$src_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$tgt_col){
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
								array_push($gene_symbol,$doc[$tgt_col]);
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						echo '<hr>';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
		
	
				}
				echo' </dl>';
			}
	
	
	
		}
		foreach ($mappings_to_process as $map_doc){
	
			$src_col = $map_doc['src'];
			$tgt_col = $map_doc['tgt'];
			$type=$map_doc['type'];
			$description=$map_doc['description'];
			$url = $map_doc['url'];
			$map_file = $map_doc['mapping_file'];
	
	
	
			if ($type=='est_to_gene'){
		
				echo '<dl class="dl-horizontal">';
	
				foreach ($map_file as $doc){


					if ($doc[$tgt_col]==$textID){
		
		
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						echo'<h1> Est informations </h1>';
						//echo '</div>';
						echo '<br>';
						//echo '<h2> Results search related informations </h2>';

						//echo 'new entry for :'.$docs;
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							//echo $key;
							if ($key=="idx" OR $key==$tgt_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
					if ($doc[$src_col]==$textID){
						//echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">';
						echo'<h1> Est informations </h1>';
						//echo '</div>';
						echo '<br>';

						//echo 'new entry for :'.$docs;
						echo '<dl class="dl-horizontal">';
						foreach ($doc as $key =>$value){
				
							if ($key=="idx" OR $key==$tgt_col){
								//echo '<li>'.$key.' : '.$value.'</li></br>';
						
							}
							else if($key==$description){
								array_push($descriptions,$value);
							}
							else{
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
							}
				
			
						}
						echo'<dt>Source file</dt>
									  <dd>'.$url.'</dd>';
						echo' </dl>';
						//echo ' <hr />';
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
		
	
				}
		
			}
	
	
	
		}

		echo '<dl class="dl-horizontal">';
		echo'<dt> Uniprot ids </dt><dd>';
		foreach ($uniprot_ids as $uniprot){

			echo $uniprot.' ';

		}
		echo '</dd>';

		echo' </dl>';


		// Here do the request in interactions table with Symbols ID
		///////
		########

		echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Interaction informations </h1>';
		echo '</div>';
		foreach ($gene_symbol as $symbol){
			$cursor=$interactionsCollection->aggregate(array( 
				array('$unwind'=>'$mapping_file'), 
				array('$match'=> array('mapping_file.Host_prot'=>$symbol)),
				array('$project' => array('mapping_file.Host_virus'=>1,'mapping_file.Virus_prot'=>1,'mapping_file.Putative_function'=>1,'mapping_file.host'=>1,'mapping_file.Accession_number'=>1,'mapping_file.Reference'=>1,'mapping_file.virus'=>1,'mapping_file.method'=>1,'_id'=>0)), 
			));
			if (count($cursor['result'])!=0){
				echo '<h2> interactions was found for this gene'.$symbol.'</h2>';
				//var_dump($cursor);
				echo '<dl class="dl-horizontal">';
				for ($i = 0; $i < count($cursor['result']); $i++) {
					$mapping_file=$cursor['result'][$i]['mapping_file'];
			
					//echo $mapping_file['Reference'];
										echo'<dt>Host</dt>
										<dd>'.$mapping_file['host'].'</dd>';
										echo'<dt>Virus</dt>
									  <dd>'.$mapping_file['virus'].'</dd>';
									  echo'<dt>Viral Protein</dt>
									  <dd>'.$mapping_file['Virus_prot'].'</dd>';
									  echo'<dt>Putative function</dt>
									  <dd>'.$mapping_file['Putative_function'].'</dd>';
									  echo'<dt>Reference</dt>
									  <dd>'.$mapping_file['Reference'].'</dd>';
									  echo'<dt>Accession number</dt>
									  <dd>'.$mapping_file['Accession_number'].'</dd>';
									  echo'<dt>Method</dt>
									  <dd>'.$mapping_file['method'].'</dd>';
							  
				}
				echo' </dl>';
			}
	
		}

		$current_plaza_id="";
		echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Others related gene informations </h1>';
		echo '</div>';


		#### search in mapping table for a given id


		#get all tgt for a given source in the src_to_tgt sub-document

		$cursor=$mappingsCollection->aggregate(array( 
			//array('$match' => array('type'=>'gene_to_prot')),  
			array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),    
			array('$unwind'=>'$src_to_tgt'),    
			array('$match' => array('src_to_tgt.0'=>$textID)),  
			array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))
			)); 
		
		##Display the results table

		$tgts=array();
		echo '<h2> query as source in mapping</h2> <div class="container">';
		if (count($cursor['result'])!=0){

			echo'<table id="example2" class="table table-bordered" cellspacing="0" width="100%">';
			echo'<thead><tr>';

			//recupere le titre
			#echo "<th>type</th>";
			echo "<th>Mapping type</th>";
			echo "<th>src ID</th>";
			echo "<th>src type</th>";
			echo "<th>src_version</th>";
			echo "<th>tgt ID</th>";
			echo "<th>tgt type</th>";
			echo "<th>tgt_version</th>";
			echo "<th>species</th>";


			//fin du header de la table
			echo'</tr></thead>';

			//Debut du corps de la table
			echo'<tbody>';

			foreach($cursor['result'] as $line) {

				//echo $line['src_to_tgt'];
				for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
					echo "<tr>";
					echo '<td>'.$line['type'].'</td>';

					echo '<td>'.$line['src_to_tgt'][0].'</td>';
					echo '<td>'.$line['src'].'</td>';
					if ($line['src']=='plaza_gene_id'){
				
					$current_plaza_id=$line['src_to_tgt'][0];
					}
					echo '<td>'.$line['src_version'].'</td>';

					//for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {

					echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
					array_push($tgts,$line['src_to_tgt'][1][$i]);
		
	
					//}
					echo '<td>'.$line['tgt'].'</td>';
					echo '<td>'.$line['tgt_version'].'</td>';
					echo '<td>'.$line['species'].'</td>';
					echo "</tr>";
				}

			}
			echo'</tbody></table></div>';
		}
		else{
			echo '<p> No Results found for : '.$textID .'</p>';
			echo'</div>';
		}



		$cursor=$mappingsCollection->aggregate(array( 
			//array('$match' => array('type'=>'gene_to_prot')),   
			array('$project' => array('tgt_to_src'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),     
			array('$unwind'=>'$tgt_to_src'),     
			array('$match' => array('tgt_to_src.0'=>$textID)),   
			array('$project' => array('tgt_to_src'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))));
	
		echo '<h2> query as target in mapping</h2> <div class="container">';

		if (count($cursor['result'])!=0){
			//echo '<h2> mapping target to source</h2> <div class="container">';
			echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
			echo'<thead><tr>';

			//recupere le titre
			#echo "<th>type</th>";
			echo "<th>Mapping type (reverse mode)</th>";
			echo "<th>tgt ID</th>";
			echo "<th>tgt type</th>";
			echo "<th>tgt_version</th>";
			echo "<th>src ID</th>";
			echo "<th>src type</th>";
			echo "<th>src_version</th>";
			echo "<th>species</th>";


			//fin du header de la table
			echo'</tr></thead>';

			//Debut du corps de la table
			echo'<tbody>';

			foreach($cursor['result'] as $line) {

				//echo $line['src_to_tgt'];
				for ($i = 0; $i < count($line['tgt_to_src'][1]); $i++) {
					echo "<tr>";
					echo '<td>'.$line['type'].'</td>';

					echo '<td>'.$line['tgt_to_src'][0].'</td>';
					echo '<td>'.$line['tgt'].'</td>';
					if ($line['src']=='plaza_gene_id'){
				
					$current_plaza_id=$line['tgt_to_src'][0];
					}
					echo '<td>'.$line['tgt_version'].'</td>';

					//for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {

					echo '<td>'.$line['tgt_to_src'][1][$i].'</td>';
					array_push($tgts,$line['tgt_to_src'][1][$i]);

					//array_push($tgts,$line['tgt_to_tgt'][1][$i]);
		
	
					//}
					echo '<td>'.$line['src'].'</td>';
					echo '<td>'.$line['src_version'].'</td>';
					echo '<td>'.$line['species'].'</td>';
					echo "</tr>";
				}

			}
		echo'</tbody></table>';
		echo'</div>';
		}
		else{
			echo '<p> No Results found for : '.$textID .'</p>';
			echo'</div>';
		}
	

			//echo'</div>';
		#
		//$foaf = new EasyRdf_Graph("http://www.uniprot.org/uniprot/Q9SHJ5.rdf");
		//$foaf->load();
		//$me = $foaf->primaryTopic();
		//echo "My name is: ".$me->get('foaf:name')."\n";


		# Get available extra info mappings and process them 
		echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center">New search with novels target</h1>';
		echo '</div>';

		foreach( $tgts as $docs)	{
			//echo $docs;
			$mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('src'=>1,'tgt'=>1,'mapping_file'=>1,'_id'=>0));
			foreach ($mappings_to_process as $map_doc){
		
				$src_col = $map_doc['src'];
				$tgt_col = $map_doc['tgt'];
				$map_file = $map_doc['mapping_file'];
		
				foreach ($map_file as $doc){
			
					if ($doc[$tgt_col]==$docs && $doc[$tgt_col]!=""){
		
						//echo 'new entry for :'.$docs;
						if (strcasecmp($doc[$src_col], $textID) != 0){
				
							echo 'new gene :'.$doc[$src_col].'has been found to produce the same protein';

							echo '<dl class="dl-horizontal">';

							foreach ($doc as $key =>$value){
					
								//echo '<li>'.$key.' : '.$value.'</li></br>';
					
								echo'<dt>'.$key.'</dt>
									  <dd>'.$value.'</dd>';
					
				
							}
							echo' </dl>';
							echo ' <hr />';
						}
						//for ($i = 0; $i < count($doc); $i++) {
						//	echo $doc[$i].'</br>';
						//}

					}
		
				}
			}
		}

		

		
		foreach( $tgts as $doc)	{
			
			//echo $doc;
			if ($doc!=""){
				echo '<h2> use target from previous query as target</h2> <div class="container">';
				echo 'try to find a tgt with the same id</br>';
				$cursor=$mappingsCollection->aggregate(array( 
				//array('$match' => array('type'=>'gene_to_prot')),   
				array('$project' => array('tgt_to_src'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),     
				array('$unwind'=>'$tgt_to_src'),     
				array('$match' => array('tgt_to_src.0'=>$doc)),   
				array('$project' => array('tgt_to_src'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))));

				if (count($cursor['result'])!=0){
		
					echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
					echo'<thead><tr>';
	
					//recupere le titre
					#echo "<th>type</th>";
					echo "<th>Mapping type (reverse mode)</th>";
					echo "<th>tgt ID</th>";
					echo "<th>tgt type</th>";
					echo "<th>tgt_version</th>";
					echo "<th>src ID</th>";
					echo "<th>src type</th>";
					echo "<th>src_version</th>";
					echo "<th>species</th>";

	
					//fin du header de la table
					echo'</tr></thead>';
	
					//Debut du corps de la table
					echo'<tbody>';
					$related_gene_ids=array();
					foreach($cursor['result'] as $line) {

						//echo $line['src_to_tgt'];
						for ($i = 0; $i < count($line['tgt_to_src'][1]); $i++) {
							echo "<tr>";
							echo '<td>'.$line['type'].'</td>';
							array_push($tgts,$line['tgt_to_src'][0]);

							echo '<td>'.$line['tgt_to_src'][0].'</td>';
							echo '<td>'.$line['tgt'].'</td>';
							echo '<td>'.$line['tgt_version'].'</td>';
	
							//for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
	
							echo '<td>'.$line['tgt_to_src'][1][$i].'</td>';
							array_push($related_gene_ids,$line['tgt_to_src'][1][$i]);
							if ($line['src']=='plaza_gene_id'){
								$current_plaza_id=$line['tgt_to_src'][1][$i];
							}
							echo '<td>'.$line['src'].'</td>';
							echo '<td>'.$line['src_version'].'</td>';
							echo '<td>'.$line['species'].'</td>';
							echo "</tr>";
						}

					}
					echo'</tbody></table>';
					echo '<h3>samples hits</h3></br>';

					foreach( $related_gene_ids as $ids)	{
						$search_string=$ids;
						if ($search_string!=$textID){
							$regex=new MongoRegex("/^$search_string/im");
							$cursor = find_gene_by_regex($measurementsCollection,$regex);
							//echo $ids.'</br>';

							makeDatatableFromFind($cursor);
						}
					}
					echo'</div>';
				}
				else{
					echo '<p> No Results as target found for : '.$doc .'</p>';
					echo'</div>';
				}
			
	
	
	
	
	
				echo '<h2>  use target from previous query as  source</h2> <div class="container">';
				echo 'try to find a src with the same id</br>';
				$cursor=$mappingsCollection->aggregate(array( 
					//array('$match' => array('type'=>'gene_to_prot')),  
					array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),    
					array('$unwind'=>'$src_to_tgt'),    
					array('$match' => array('src_to_tgt.0'=>$doc)),  
					array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))
					)); 

			
				if (count($cursor['result'])!=0){

					echo'<table id="example2" class="table table-bordered" cellspacing="0" width="100%">';
					echo'<thead><tr>';
	
					//recupere le titre
					#echo "<th>type</th>";
					echo "<th>Mapping type</th>";
					echo "<th>src ID</th>";
					echo "<th>src type</th>";
					echo "<th>src_version</th>";
					echo "<th>tgt ID</th>";
					echo "<th>tgt type</th>";
					echo "<th>tgt_version</th>";
					echo "<th>species</th>";

	
					//fin du header de la table
					echo'</tr></thead>';
	
					//Debut du corps de la table
					echo'<tbody>';
					$related_gene_ids=array();
					foreach($cursor['result'] as $line) {

						//echo $line['src_to_tgt'];
						for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
							echo "<tr>";
							echo '<td>'.$line['type'].'</td>';

							echo '<td>'.$line['src_to_tgt'][0].'</td>';
							array_push($related_gene_ids,$line['src_to_tgt'][0]);

							if ($line['src']=='plaza_gene_id'){
				
								$current_plaza_id=$line['src_to_tgt'][0];
							}
							echo '<td>'.$line['src'].'</td>';
							echo '<td>'.$line['src_version'].'</td>';
	
							//for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
	
							echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
							array_push($tgts,$line['src_to_tgt'][1][$i]);
			
		
							//}
							echo '<td>'.$line['tgt'].'</td>';
							echo '<td>'.$line['tgt_version'].'</td>';
							echo '<td>'.$line['species'].'</td>';
							echo "</tr>";
						}

					}
					echo'</tbody></table>';
					echo '<h3>samples hits</h3></br>';

					foreach( $related_gene_ids as $ids)	{
						$search_string=$ids;
						$regex=new MongoRegex("/^$search_string/im");
						$cursor = find_gene_by_regex($measurementsCollection,$regex);
						//echo $ids.'</br>';

						makeDatatableFromFind($cursor);
					}
					echo '</div>';
				}
	
				else{
					echo '<p> No Results as source found for : '.$doc .'</p>';
					echo'</div>';
				}
				#echo count($tgts);
			}
			
			

		}
		####################################################################	
		############## Orthology informations ##############################
		####################################################################	

		#####search for related info on other species.

		// Here do the request in orthologs table with gene_id ID

		echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
		echo'<h1 style="text-align:center"> Orthology informations </h1>';
		echo '</div>';
		#$current_plaza_id="AT1G01060";
		echo "test plaza id ".$current_plaza_id;

		if ($current_plaza_id!=""){
	
		
		
			echo $current_plaza_id;
			#echo $species_ID;
			$MongoGridFSCursor=get_plaza_orthologs($grid, $orthologsCollection,$speciesID,$current_plaza_id,'plaza_gene_identifier');
			#$MongoGridFSCursor->skip(3)->limit(8);
			foreach($MongoGridFSCursor as $MongoGridFSFile) {
				#error_log($MongoGridFSFile->getBytes(), 0);

			
			
				$stream = $MongoGridFSFile->getResource();
				if ($stream) {
					#while (($buffer = fgets($stream, 4096)) !== false) {
					$cpt=0;
					while (($buffer = stream_get_line($stream, 1024, "\n")) !== false) {
	//         			#echo $buffer;
						#$row=split('[\t]', $buffer);
					
					
						#if ($cpt<10){
					
						#echo "start line : ".$buffer."\n";
						#$row=split('[\t]', $buffer);
						$row=preg_split('/\s+/', $buffer);
						if ($current_plaza_id==$row[0]){
							echo "start line : ".$buffer."\n";
							$ortholog_list_id=split('[,]', $row[1]);
							foreach ($ortholog_list_id as $ortholog){
								#echo "start line : ".$buffer."\n";
								$cursor=$mappingsCollection->aggregate(array( 
									array('$match' => array('type'=>'gene_to_prot')),  
									array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),    
									array('$match' => array('src'=>"plaza_gene_id")),  
									array('$unwind'=>'$src_to_tgt'),    
									array('$match' => array('src_to_tgt.0'=>$ortholog)),  
									array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))
								));
							
								if (count($cursor['result'])!=0){
									echo '<h2> orthologs table </h2> <div class="container">';
									echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
									echo'<thead><tr>';

									//recupere le titre
									#echo "<th>type</th>";
									echo "<th>Mapping type</th>";
									echo "<th>src ID</th>";
									echo "<th>src type</th>";
									echo "<th>src_version</th>";
									echo "<th>tgt ID</th>";
									echo "<th>tgt type</th>";
									echo "<th>tgt_version</th>";
									echo "<th>species</th>";
								
									echo'</tr></thead>';

									//Debut du corps de la table
									echo'<tbody>';

									foreach($cursor['result'] as $line) {

										//echo $line['src_to_tgt'];
										for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
											echo "<tr>";
										
											echo '<td>'.$line['type'].'</td>';

											echo '<td>'.$line['src_to_tgt'][0].'</td>';
											echo '<td>'.$line['src'].'</td>';
											echo '<td>'.$line['src_version'].'</td>';
											echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
		
	
											//}
											echo '<td>'.$line['tgt'].'</td>';
											echo '<td>'.$line['tgt_version'].'</td>';
											echo '<td>'.$line['species'].'</td>';
											echo "</tr>";
										}

									}
									echo'</tbody></table></div>';
							
								}
							
							
							}
						}
					
					}
				}
		
			}
		}
		echo'</div>';
		
		##search for related info on other species.

	}
echo '</div>';	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
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
$(document).ready(function() {
	$('#example2').dataTable( {
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

$(document).ready(function(){
   $('#operation').click(function (e) {
       e.preventDefault();
       $(this).tab('show');
   });
});
</script>

<?php
new_cobra_footer();
?>
