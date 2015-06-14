<?php 

class ftp{
    public $conn;

    public function __construct($url){
        $this->conn = ftp_connect($url);
    }
   
    public function __call($func,$a){
        if(strstr($func,'ftp_') !== false && function_exists($func)){
            array_unshift($a,$this->conn);
            return call_user_func_array($func,$a);
        }else{
            // replace with your own error handler.
            die("$func is not a valid FTP function");
        }
    }
}

// Example
function is_logged($login){
if ((!isset($login)) || ($login == ''))
 {
	// La variable $_SESSION['login'] n'existe pas, ou bien elle est vide
	// <=> la personne ne s'est PAS connectée
	//echo '<p>You have to be <a href="/database/login.php"> logged</a>.</p>'."\n";
	//exit();
	return False;
 }
 else{
 	return True;
 
 }

}
function control_post ($value) {

	$return;
	if(isset($value)){
        	$return = $value;
	}else {
        	$return="";
		echo "Missing post value ";
	}
	return $return;
}

function show_array($array){
	echo"<pre>";
		print_r($array);
	echo"</pre>";
}
function make_plaza_orthologs($cursor){


}
function make_experiment_type_list($cursor){


	/*
	$array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    */
    echo '<label for="species">experiment type</label>';

    echo '<select class="form-control" id="exp_typeID" name="exp_typeID">';
    echo '<option value ="">----Choose type----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            //foreach(array_slice($keys,1) as $key => $value) {
              //      if(is_array($line[$value])){;
                             //   echo '<option value="type">'.show_array($line[$value]).'</option>';        
                   // }
                    //else {
                                echo '<option value="'.$line.'">'.$line.'</option>';
        
                    //}
            //  }
    }
    echo '</select>';
    
}

function make_user_preferences($user,Mongocollection $us){

	echo '<h2> User preferences</h2>
    		<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">
    			<h3> login details</h3>';
   foreach ( $user as $person ) { 
		if (($person['login'] != '') && ($person['pwd'] != '')){
			echo 'You are currently logged in as '.$person['login'].'.';
			
			
			
			
		}
	echo '</div></br>';	
		
	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">
			<div id="SpeciesSearch" class="js_panel">
    			<input type="hidden" class="panel_type" value="SearchBox" />
				<h3> Change password</h3>';
		
		echo'<form action="/database/src/users/reset_password.php" method="get" class="clear search-form homepage-search-form">
				<fieldset>
					<div class="form-field ff-multi">
						<div align="center" class="ff-inline ff-right" >';
					echo '<label for="q">enter password</label>		
							<wbr></wbr>
							<span class="inp-group">
								<input value="pwd1" name="pwd1" class="_string input inactive query optional ftext" id="pwd1" type="text" size="30" />
							
							</span>';
					echo '<label for="pwd">confirm password</label>		
							<wbr></wbr>
							<span class="inp-group">
								<input value="pwd2" name="pwd2" class="_string input inactive query optional ftext" id="pwd2" type="text" size="30" />
								<input value="Go" class="fbutton" type="submit" />
							</span>';
		echo'			</div>
					</div>
				</fieldset>
			  </form>';
   
   }
   echo '</div></div>';
}

function make_viruses_list($cursor){


	/*
	$array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    */
    echo '<label for="viruses">viruses</label>';

    echo '<select class="form-control" id="virusID" name="virusID">';
    echo '<option value ="">----Choose type----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            //foreach(array_slice($keys,1) as $key => $value) {
              //      if(is_array($line[$value])){;
                             //   echo '<option value="type">'.show_array($line[$value]).'</option>';        
                   // }
                    //else {
                                echo '<option value="'.$line.'">'.$line.'</option>';
        
                    //}
            //  }
    }
    echo '</select>';
    
}
function make_whats_new(){
	echo '
	<div class="plain-box">
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="src/resultats.php" method="get" class="clear search-form homepage-search-form">
    		<fieldset>
    			<div class="form-field ff-multi">
    				<div class="ff-inline ff-right">
    					<label for="species" class="ff-label">Search:</label>

    					<span class="inp-group">
    						<select name="speciesID" class="fselect input" id="speciesID">
    							<option value="">All species</option>
    	 						<option disabled="disabled" value="">---</option>';   
						//Parcours de chaque ligne du curseur
					foreach($cursor as $line) {
					  	  echo '<option value="'.$line.'">'.$line.'</option>';
					}
					  echo '</select>
    						<label for="q">for</label>
    					</span>
    					<wbr></wbr>
    					<span class="inp-group">
    						<input value="" name="q" class="_string input inactive query optional ftext" id="q" type="text" size="30" />
    						<input value="Go" class="fbutton" type="submit" />
    					</span>
    					<wbr></wbr>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example">e.g. 
    						<a class="nowrap" href="src/resultats.php?speciesID=Arabidopsis+thaliana&q=AT5G03160">AT5G03160</a> 
    						or 
    						<a class="nowrap" href="/Multi/psychic?q=chx28;site=ensemblunit">chx28</a>
    					</p>
    				</div>
    			</div>
    		</fieldset>
    	</form>
    </div>
    </div>';


}
function make_gene_id_text_list(){

echo '
    <div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="/database/src/resultats_list.php" method="get" class="clear search-form homepage-search-form">
    		<fieldset>
    			<div class="form-group">
						<label for="listids">input list of gene ids</label>
						<textarea name="listID" class="form-control" rows="3">AT5G03160
AT1G06520
AT1G03110</textarea>
		
				</div>
				<wbr></wbr>
    				<span class="inp-group">
    					<input value="Go" class="fbutton" type="submit" />
    				</span>
    			<wbr></wbr>
    		</fieldset>
    	</form>
    </div>
    </div>';


}
function make_species_list($cursor){

    
    /*
    $array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    echo '<label for="species">Species</label>';

    echo '<select class="form-control" id="speciesID" name="speciesID">';
    echo '<option value ="">----Choose species----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            foreach(array_slice($keys,1) as $key => $value) {
                  if(is_array($line[$value])){;
                                echo '<option value="speciess">'.show_array($line[$value]).'</option>';        
    	            }
        	           else {
                                echo '<option value="'.$line[$value].'">'.$line[$value].'</option>';
        
          	         }
           }
    }
    echo '</select>';
    */
     //echo '<label for="species">species</label>';

    //echo '<select class="form-control" id="speciesID" name="speciesID">';
    echo '
    <div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="/database/src/result_search.php" method="get" class="clear search-form homepage-search-form">
            <fieldset>
                <div class="form-field ff-multi">
                    <div align="center" class="ff-inline ff-right" >
                        <label for="species" class="ff-label">Search:</label>

                            <span class="inp-group">
                                <select name="organism" class="fselect input" id="organism">
                                        <option value="">All species</option>
                                        <option disabled="disabled" value="">---</option>';   
                                //Parcours de chaque ligne du curseur
                            foreach($cursor as $line) {
                                    echo '<option value="'.$line.'">'.$line.'</option>';
                            }
                            echo '</select>
                                    <label for="search">for</label>
                            </span>
                            <wbr></wbr>
                            <span class="inp-group">
                                    <input value="" name="search" class="_string input inactive query optional ftext" id="search" type="text" size="30" />
                                    <i class="fa fa-search"></i> <span><input value="Search" class="fbutton" type="submit" /></span>
                            </span>
                            <wbr></wbr>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" href="/database/src/result_search.php?organism=Arabidopsis+thaliana&search=AT1G06520">AT1G06520</a> 
    						or 
    						<a class="nowrap" href="/database/src/result_search.php?organism=Solanum+lycopersicum&search=SGN-U603893">SGN-U603893</a>
    						
    					</p>
    				</div>
    			</div>
    		</fieldset>
    	</form>
    </div>
    </div>';
}

function make_CrossCompare_list($cursor){

    
    echo '
    <div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey">
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="../src/cross_compare_resultats.php" method="get" class="clear search-form homepage-search-form">
    		<fieldset>
    			<div class="form-field ff-multi">
    				<div align="center" class="ff-inline ff-right" >
    					<label for="species" class="ff-label">Search:</label>

    					<span class="inp-group">
    						<select name="species1ID" class="fselect input" id="species1ID">
    							<option value="">All species</option>
    	 						<option disabled="disabled" value="">---</option>';   
						//Parcours de chaque ligne du curseur
					foreach($cursor as $line) {
					  	  echo '<option value="'.$line.'">'.$line.'</option>';
					}
					  echo '</select>
    						<label for="q">versus</label>
    					</span>
    					<wbr></wbr>
    					<span class="inp-group">
    						<select name="species2ID" class="fselect input" id="species2ID">
    							<option value="">All species</option>
    	 						<option disabled="disabled" value="">---</option>';   
								//Parcours de chaque ligne du curseur
								foreach($cursor as $line) {
					  	  			echo '<option value="'.$line.'">'.$line.'</option>';
								}
					echo '</select>

    						<input value="Go" class="fbutton" type="submit" />
    					</span>
    					<wbr></wbr>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" href="src/cross_compare_resultats.php?species1ID=Arabidopsis+thaliana&species2ID=Solanum+lycopersicum">Arabidospis thaliana versus Solanum lycopersicum</a> 
    					</p>
    				</div>
    			</div>
    			
    		</fieldset>
    	</form>
    </div>
    </div>';
}
function make_species_list_2(){

	echo' 
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="/Multi/psychic" method="get" class="clear search-form homepage-search-form">
    			<fieldset>
    					<input value="ensemblunit" name="site" type="hidden" />
    					<div class="form-field ff-multi">
    						<label for="species" class="ff-label">Search:</label>
    						<div class="ff-inline ff-right">
    							<span class="inp-group">
    								<select name="species" class="fselect input" id="species">
    									<option value="">All species</option>
    									<option disabled="disabled" value="">---</option>
    									<optgroup label="Favourite species">
    										<option value="Arabidopsis_thaliana">Arabidopsis thaliana</option>
    										<option value="Oryza_sativa">Oryza sativa Japonica</option>
    										<option value="Triticum_aestivum">Triticum aestivum</option>
    										<option value="Hordeum_vulgare">Hordeum vulgare</option>
    										<option value="Zea_mays">Zea mays</option>
    										<option value="Physcomitrella_patens">Physcomitrella patens</option>
    									</optgroup>
    										<option disabled="disabled" value="">---</option>
    										<option value="Aegilops_tauschii">Aegilops tauschii</option>
    										<option value="Amborella_trichopoda">Amborella trichopoda</option>
    										<option value="Arabidopsis_lyrata">Arabidopsis lyrata</option>
    										<option value="Arabidopsis_thaliana">Arabidopsis thaliana</option>
    										<option value="Brachypodium_distachyon">Brachypodium distachyon</option>
    										<option value="Brassica_oleracea">Brassica oleracea</option>
    										<option value="Brassica_rapa">Brassica rapa</option>
    										<option value="Chlamydomonas_reinhardtii">Chlamydomonas reinhardtii</option>
    										<option value="Cyanidioschyzon_merolae">Cyanidioschyzon merolae</option>
    										<option value="Glycine_max">Glycine max</option>
    										<option value="Hordeum_vulgare">Hordeum vulgare</option>
    										<option value="Leersia_perrieri">Leersia perrieri</option>
    										<option value="Medicago_truncatula">Medicago truncatula</option>
    										<option value="Musa_acuminata">Musa acuminata</option>
    										<option value="Oryza_barthii">Oryza barthii</option>
    										<option value="Oryza_brachyantha">Oryza brachyantha</option>
    										<option value="Oryza_glaberrima">Oryza glaberrima</option>
    										<option value="Oryza_glumaepatula">Oryza glumaepatula</option>
    										<option value="Oryza_meridionalis">Oryza meridionalis</option>
    										<option value="Oryza_nivara">Oryza nivara</option>
    										<option value="Oryza_punctata">Oryza punctata</option>
    										<option value="Oryza_rufipogon">Oryza rufipogon</option>
    										<option value="Oryza_indica">Oryza sativa Indica</option>
    										<option value="Oryza_sativa">Oryza sativa Japonica</option>
    										<option value="Ostreococcus_lucimarinus">Ostreococcus lucimarinus</option>
    										<option value="Physcomitrella_patens">Physcomitrella patens</option>
    										<option value="Populus_trichocarpa">Populus trichocarpa</option>
    										<option value="Prunus_persica">Prunus persica</option>
    										<option value="Selaginella_moellendorffii">Selaginella moellendorffii</option>
    										<option value="Setaria_italica">Setaria italica</option>
    										<option value="Solanum_lycopersicum">Solanum lycopersicum</option>
    										<option value="Solanum_tuberosum">Solanum tuberosum</option>
    										<option value="Sorghum_bicolor">Sorghum bicolor</option>
    										<option value="Theobroma_cacao">Theobroma cacao</option>
    										<option value="Triticum_aestivum">Triticum aestivum</option>
    										<option value="Triticum_urartu">Triticum urartu</option>
    										<option value="Vitis_vinifera">Vitis vinifera</option>
    										<option value="Zea_mays">Zea mays</option>
    								</select>
    								<label for="q">for</label>
    							</span>
    							<wbr>
    							</wbr>
    							<span class="inp-group">
    								<input value="" name="q" class="_string input inactive query optional ftext" id="q" type="text" size="30" />
    								<input value="Go" class="fbutton" type="submit" />
    							</span>
    							<wbr>
    							</wbr>
    						</div>
    						<div class="ff-notes">
    							<p class="search-example">e.g. 
    								<a class="nowrap" href="/Multi/psychic?q=Carboxy*;site=ensemblunit">Carboxy*
    								</a> 
    								or 
    								<a class="nowrap" href="/Multi/psychic?q=chx28;site=ensemblunit">chx28
    								</a>
    							</p>
    						</div>
    					</div>
    			</fieldset>
    	</form>
    </div>';
}
function makeDatatableFromAggregate($cursor){

    
    //foreach($cursor as $doc){
    //print_r(count($cursor['result']));
    //print_r($cursor['result']['0']);
    //for ($i = 0; $i < count($cursor['result']); $i++) {
    //	 print_r($cursor['result'][$i]['id']);
    	 
	//}
    //}
    if (count($cursor['result'])==0){
    	echo'No results found';
    
    }
    else{
    	//table-striped table-bordered
		echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
		echo'<thead><tr>';
		foreach ( $cursor['result'] as $value )
		{
		
			//echo "level 1 value:".$value."<br/";
			$keys =array();
			foreach ( $value as $key=>$values )
			{
			
				//echo "level 2 value:".$values."<br/>";
				
			
				$keys[] = $key;
				
				/*foreach ($values as $valuess )

				{

					echo "level 3 key : ".$idss."=>".$valuess."<br/>";
					$keys[] = $valuess;
				
				
				}*/
			
			
			}
		
		}

	
	
		$keys = array_values(array_unique($keys));
	
	
		//recupere le titre
		foreach ($keys as $value) {

				echo "<th>" . $value . "</th>";
			
	
		}
		echo'</tr></thead>';
	
		//fill the table
		echo'<tbody>';
		foreach ( $cursor['result'] as $value )
		{
			echo "<tr>";
			foreach ( $value as $idss => $valuess )
			{
				
				
				//echo $values."<br/>";
					
				
				//foreach ($values as $idss => $valuess )
				//{
				
				
				//search gene id URL for barley 
				//pgsb.helmholtz-muenchen.de/cgi-bin/db2/barleyV2/gene_report.cgi?gene=MLOC_59128.1
				
				
				
				if($idss=='gene'){
					//echo $idss."<br/>";
					if (stristr($valuess,"MU")) {
						echo"<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".$valuess."&searchtype=unigene&organism=melon\">".$valuess."</a></td>";
						//echo "<td>" . $valuess . "</td>";
					}
					else if(stristr($valuess,"AT")){
						echo"<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".$valuess."&type=locus\">".$valuess."</a></td>";
					}
					else if (stristr($valuess,"SGN")){
						echo"<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".$valuess."\">".$valuess."</a></td>";
					}
					else{
						
						echo "<td>" . $valuess . "</td>";
					}
				}
				else{
					if(is_array($valuess)){
						//echo "<td>" . show_array($valuess) . "</td>";

					}
						
					else{
						echo "<td>" . $valuess . "</td>";
					}
				}	
				
			}   
			echo "</tr>";
		}
		echo'</tbody></table>'; 
	}
}
//function getURLParameter(url, name) {
//    return (RegExp(name + '=' + '(.+?)(&|$)').exec(url)||[,null])[1];
//}
function get_protein_info($url){
	echo 'entering get_protein_info<br>';
	
	// Create DOM from URL or file
	$html = file_get_html($url);

	// Find all images
	//foreach($html->find('img') as $element)
       //echo $element->src . '<br>';

	// Find all links
	foreach($html->find('a') as $element){
       #echo $element->name . '<br>';
       	if ($element->name=='protein_prediction_analysis_2'){
       			echo $element->name . '<br>'; 
       			echo $element->children(1);
       	}
    }
}

function recursive_read($array){


//return 
}
function datatableFromAggregate($cursor){


	echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
	echo'<thead><tr>';
	for ($i = 0; $i < count($cursor['result']); $i++) {
		$test=$cursor['result'][$i];
		
		if(is_array($test)){
			foreach ( $test as $id => $doc ){
			
				if(is_array($doc)){
					
					foreach ( $doc as $ids => $docs ){
						echo "<tr>";
						if ($i==0){
							
							echo "<th>" . $ids . "</th>";
						}
						else{
							
							
							echo "<td>" . $doc . "</td>";


						}	
						echo "</tr>";

						
					}
					
					
					
				}
				else{
					echo "<tr>";
					if ($i==0){
					
						echo "<th>" . $id . "</th>";
					}
					else{
					
						
						//echo $id."=".$doc."<br/>";
						echo "<td>" . $doc . "</td>";
						

					}
					echo "</tr>";

				}
				

			}
		}
		else{
			foreach ( $test as $doc ){
			
				echo $doc."<br/>";

			}

		}
		if ($i==0){
			echo'</tr></thead>';
	
			//fill the table
			echo'<tbody>';
		}
		
		
	}
	echo'</tbody></table>'; 

}


function makeDatatableFromFindByRegex($cursor) {

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
       		echo $value;
       	}
	}
	foreach (array_slice($keys,1) as $key => $value) {
			
       	if ($value=='logFC'){
       		echo "<th>" . $value . "</th>";
       		echo $value;
       	}
	}
	foreach (array_slice($keys,1) as $key => $value) {
			
       	if ($value=='type'){
       		echo "<th>" . $value . "</th>";
       		echo $value;
       	}
	}
	foreach (array_slice($keys,1) as $key => $value) {
			
       	if ($value=='xp'){
       		echo "<th>" . $value . "</th>";
       		echo $value;
       	}
	}
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
        	   	
            	echo "<td>".$line[$value]."</td>";
            }
         }
      }
	   
	   
      echo "</tr>";
	}
	echo'</tbody></table>';
}
function makeDatatableFromFind($cursor) {

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
			
       		echo "<th>" . $value . "</th>";
	}
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
			


								#echo "<td>".$line[$value]."</td>";
						}
					}
					else if (stristr($line[$value],"AT")) {
						if(is_array($line[$value])){;
					
								echo"<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".show_array($line[$value])."&type=locus\">".show_array($line[$value])."</a></td>";
							
						}
						else {
								echo"<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".$line[$value]."&type=locus\">".$line[$value]."</a></td>";
			


								#echo "<td>".$line[$value]."</td>";
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
               	else{
               		if(is_array($line[$value])){;
                	        echo"<td>".show_array($line[$value])."</td>";
	                }
        	        else {
                	        echo "<td>".$line[$value]."</td>";
               		}
               	
               	}
	        }
        	echo "</tr>";
	}
	echo'</tbody></table>';
}



?>


