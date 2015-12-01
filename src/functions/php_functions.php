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
	//echo '<p>You have to be <a href="/login.php"> logged</a>.</p>'."\n";
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


return $cursor;

}
function go($stanza,$go_term_id){
    $go_id=$go_id_list[$i];
    return (isset($stanza['id']) && $stanza['id'] == $go_id_list[$i]);
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
function get_sample_table_in_string($cursor,$samplesCollection){
    $table_string="";
    $array = iterator_to_array($cursor);
    $keys =array();

    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
              }
    }
    $keys = array_values(array_unique($keys));
    $table_string.='<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';

    
    //header table start
    $table_string.='<thead><tr>';
    $table_string.='<thead><tr>';
    //recupere le titre
    foreach (array_slice($keys,1) as $key => $value) {
            if ($value=='gene'){
                $table_string.="<th>" . $value . "</th>";

            }
    }
    foreach (array_slice($keys,1) as $key => $value) {

            if ($value=='direction'){
                $table_string.="<th>" . $value . "</th>";

            }
    }
    foreach (array_slice($keys,1) as $key => $value) {

            if ($value=='logFC'){
                $table_string.="<th>" . $value . "</th>";

            }
    }
    foreach (array_slice($keys,1) as $key => $value) {

            if ($value=='type'){
                $table_string.="<th>" . $value . "</th>";

            }
    }
    foreach (array_slice($keys,1) as $key => $value) {

            if ($value=='xp'){
                $table_string.="<th>" . $value . "</th>";

            }
    }
    $table_string.='</tr></thead>';
    //header table end

    //Debut du corps de la table
    $table_string.='<tbody>';
    foreach($cursor as $line) {
        $table_string.="<tr>";

        //Slice de l'id Mongo
        #$table_string.=$line->count();

        foreach(array_slice($keys,1) as $key => $value) {


            #http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=MU60682&searchtype=unigene&organism=melon

            if ($value=='gene'){
                if (stristr($line[$value],"MU")) {
                    if(is_array($line[$value])){;
                        #http://www.arabidopsis.org/servlets/TairObject?name=AT5G03160&type=locus
                        $table_string.="<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".show_array($line[$value])."&searchtype=unigene&organism=melon\">".show_array($line[$value])."</a></td>";

                    }
                    else {
                        $table_string.="<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".$line[$value]."&searchtype=unigene&organism=melon\">".$line[$value]."</a></td>";

                    }
                }
                else if (stristr($line[$value],"AT")) {
                    if(is_array($line[$value])){;

                        $table_string.="<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".show_array($line[$value])."&type=locus\">".show_array($line[$value])."</a></td>";

                    }
                    else {
                        $table_string.="<td><a href=\"http://www.arabidopsis.org/servlets/TairObject?name=".$line[$value]."&type=locus\">".$line[$value]."</a></td>";
                    }
                }
                else{
                    if(is_array($line[$value])){;

                        $table_string.="<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".show_array($line[$value])."\">".show_array($line[$value])."</a></td>";

                    }

                    else {
                        //$url="http://solgenomics.net/search/unigene.pl?unigene_id=".$line[$value];
                        $table_string.="<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".$line[$value]."\">".$line[$value]."</a></td>";
                        #$table_string.="<td><a href=\"../src/prot_ref.php?protID=".$line[$value]."\">".$line[$value]."</a></td>";


                        #get_protein_info($url);
                        #$table_string.="<td>".$line[$value]."</td>";
                    }
                }

                # http://pgsb.helmholtz-muenchen.de/cgi-bin/db2/barleyV2/gene_report.cgi?gene=
                #use table from 


            }

        }

        foreach(array_slice($keys,1) as $key => $value) {

            if($value=='direction'){
                if(is_array($line[$value])){;
                    $table_string.="<td>".show_array($line[$value])."</td>";
                }
                else {
                    $table_string.="<td>".$line[$value]."</td>";
                }
            }
        }
        foreach(array_slice($keys,1) as $key => $value) {

            if($value=='logFC'){
                if(is_array($line[$value])){;
                    $table_string.="<td>".show_array($line[$value])."</td>";
                }
                else {
                    $table_string.="<td>".$line[$value]."</td>";
                }
            }
        }
        foreach(array_slice($keys,1) as $key => $value) {

            if($value=='type'){
                if(is_array($line[$value])){;
                    $table_string.="<td>".show_array($line[$value])."</td>";
                }
                else {
                    $table_string.="<td>".$line[$value]."</td>";
                }
            }
        }
        foreach(array_slice($keys,1) as $key => $value) {

            if($value=='xp'){
                if(is_array($line[$value])){;
                    $table_string.="<td>".show_array($line[$value])."</td>";
                }
                else {
                    //list($xp_String_id, $ex_results, $file_number) 
                    $xp_details= explode(".", $line[$value]);
                    $xp_String_id=$xp_details[0];
                    //$table_string.="<td>".$xp_String_id."</td>";
                    $file_number=$xp_details[2]+1;
                    $xp_id = new MongoId($xp_String_id);
                    $xp_name=$samplesCollection->findOne(array('_id'=>$xp_id),array('name'=>1,'_id'=>0));

                    $table_string.="<td><a href=https://services.cbib.u-bordeaux2.fr/cobra/description/experiments.php?xp=".str_replace(' ','\s',$xp_name['name']).">".$xp_name['name']."(Sample file ".$file_number.")</a></td>";
                    //$table_string.="<td>".$line[$value]."</td>";

                }
            }
        }


        $table_string.="</tr>";
    }
    $table_string.='</tbody>';
    $table_string.='</table>';
    return $table_string;
}
function display_sample_table($cursor,$samplesCollection){
    $array = iterator_to_array($cursor);
    $keys =array();

    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
              }
    }
    $keys = array_values(array_unique($keys));

    echo'<table id="example" class="table table-bordered" cellspacing="0" width="100%">';
    //header table start
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
    echo'</tr></thead>';
    //header table end

    //Debut du corps de la table
    echo'<tbody>';
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
                    $file_number=$xp_details[2]+1;
                    $xp_id = new MongoId($xp_String_id);
                    $xp_name=$samplesCollection->findOne(array('_id'=>$xp_id),array('name'=>1,'_id'=>0));

                    echo "<td><a href=https://services.cbib.u-bordeaux2.fr/cobra/description/experiments.php?xp=".str_replace(' ','\s',$xp_name['name']).">".$xp_name['name']."(Sample file ".$file_number.")</a></td>";
                    //echo"<td>".$line[$value]."</td>";

                }
            }
        }


        echo "</tr>";
    }
    echo'</tbody></table>'; 
}
function make_user_preferences($user,Mongocollection $us){

	echo '<h2> User preferences</h2>
    		<div id="user_pref">
    			<h3> login details</h3>';
    foreach ( $user as $person ) { 
		if (($person['login'] != '') && ($person['pwd'] != '')){
			echo 'You are currently logged in as '.$person['login'].'.';
	
		}
        echo '</div>'
        . '</br>';	
		
        echo '<div id="change_password">
                
                    <h3> Change password</h3>';
		
               echo'<form action="https://services.cbib.u-bordeaux2.fr/cobra/src/users/reset_password.php" method="get" class="clear search-form homepage-search-form">
                        <fieldset>
                            <div class="form-field ff-multi">
                                <div align="center" class="ff-inline ff-right" >';
                              echo '<label for="q">enter password</label>		
                                    <wbr></wbr>
                                    <span class="inp-group">
                                        <input type="password" value="" name="pwd1" class="_string input inactive query optional ftext" id="pwd1" type="text" size="30" />
                                    </span>';
                              echo '<label for="pwd">confirm password</label>		
                                    <wbr></wbr>
                                    <span class="inp-group">
                                        <input type="password" value="" name="pwd2" class="_string input inactive query optional ftext" id="pwd2" type="text" size="30" />
                                        <input value="Go" class="fbutton" type="submit" />
                                    </span>';
                           echo'</div>
                            </div>
				        </fieldset>
			        </form>';  
    }
        echo 
        '</div>';
        
       

}
function is_expression_variables_set(array $categories, array $result){
    if (isset($result['day_after_inoculation'])){
        if (isset($result['variety'])){
           $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
            array_push($categories, $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']); 
        }
        else{
            $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC']);
            array_push($categories, $result['species'].'/Day '.$result['day_after_inoculation']);
        }

    }
    else{
        if (isset($result['variety'])){
           $sample=array('y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
            array_push($categories, $result['species'].'/'.$result['variety']); 
        }
        else{
            $sample=array('y'=>$result['logFC'],'logFC'=>$result['logFC']);
            array_push($categories, $result['species']);
        }
    }
    return $categories;
    
}
function display_expression_profile(MongoCollection $measurementsCollection, MongoCollection $samplesCollection, array $series, array $categories, array $logfc_array){
    echo'<div id="expression_profile">
            <h3>Expression profile</h3>
            <div class="panel-group" id="accordion_documents_expression">
                <div class="panel panel-default">
                    <div class="panel-heading">

                            <a class="accordion-toggle collapsed" href="#expression-chart" data-parent="#accordion_documents_expression" data-toggle="collapse">
                                <strong>  Expression data</strong>
                            </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="expression-chart">
                        <div id="container" style="min-width: 310px; height: 400px;"></div>
                    </div>

                </div>
            </div>';               
            $cursor=$measurementsCollection->find(array('$or'=> array(array('gene'=>$gene_id[0]),array('gene'=>$gene_id_bis[0]),array('gene'=>$gene_alias[0]))),array('_id'=>0));
            $counter=1;                       
            foreach ($cursor as $result) {
                $xp_full_name=explode(".", $result['xp']);                   
                $experiment_id=$xp_full_name[0];
                $xp_name=explode(".", get_experiment_name_with_id($samplesCollection,$experiment_id));
                $categories=is_expression_variables_set($categories);
//                if (isset($result['day_after_inoculation'])){
//                    if (isset($result['variety'])){
//                       $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
//                        array_push($categories, $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']); 
//                    }
//                    else{
//                        $sample=array('y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC']);
//                        array_push($categories, $result['species'].'/Day '.$result['day_after_inoculation']);
//                    }
//
//                }
//                else{
//                    if (isset($result['variety'])){
//                       $sample=array('y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC']);
//                        array_push($categories, $result['species'].'/'.$result['variety']); 
//                    }
//                    else{
//                        $sample=array('y'=>$result['logFC'],'logFC'=>$result['logFC']);
//                        array_push($categories, $result['species']);
//                    }
//                }
                array_push($logfc_array, $sample);

                $counter++;

            }
            $sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
            array_push($series, $sample);
            echo'<div id="shift_line"></div>'                
      . '</div>'; 
}
function display_proteins_details(array $gene_id, array $gene_symbol, array $gene_alias, array $descriptions, array $proteins_id,$species='null'){
   echo'<div id="section_description">'.$gene_id[0].'
                    <div id="organism" class="right"><h4>'.$species.'</h4></div>';
                echo '<h1>';
                for ($i = 0; $i < count($gene_symbol); $i++) {
                    if ($i==count($gene_symbol)-1){
                        echo $gene_symbol[$i];
                    }
                    else{
                        echo $gene_symbol[$i].', ';
                    }
                    
                }
                if (count($gene_symbol)==0){
                    echo $gene_alias[0];
                }
                echo '</h1> ';
                if (count($descriptions)>0){
                    echo'<div id="aliases"> Description : ';
                    for ($i = 0; $i < count($descriptions); $i++) {
                        if ($i==count($descriptions)-1){
                            echo $descriptions[$i];
                        }

                        else{
                            echo $descriptions[$i].', ';
                        }
                    }
                    echo '</div>';
                }
                
                if (count($gene_alias)>0){
                    echo'<div id="aliases"> Alias : ';
                    for ($i = 0; $i < count($gene_alias); $i++) {
                        if ($i==count($gene_alias)-1){
                            echo $gene_alias[$i];
                        }
                        else{
                            echo $gene_alias[$i].', ';
                        }
                    }

                    echo '</div>';
                }
                if (count($proteins_id)>0){
                    echo'<div id="protein aliases"> Protein ids : ';
                    for ($i = 0; $i < count($proteins_id); $i++) {
                        if ($i==count($proteins_id)-1){
                            echo'<a target="_BLANK" href="http://www.uniprot.org/uniprot/'.$proteins_id[$i].'" title="UniprotKB Swissprot and Trembl Sequences">'.$proteins_id[$i].'</a>';
                            //echo $proteins_id[$i];
                        }
                        else{
                            echo'<a target="_BLANK" href="http://www.uniprot.org/uniprot/'.$proteins_id[$i].'" title="UniprotKB Swissprot and Trembl Sequences">'.$proteins_id[$i].'</a>, ';

                            //echo $proteins_id[$i].', ';
                        }
                    }
                    echo '</div>';
                }
                //$transcript_count=0;
                
                
                
                
                
                echo '</div>';//gene details end region 
}







function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
    	<form action="https://services.cbib.u-bordeaux2.fr/cobra/src/resultats.php" method="get" class="clear search-form homepage-search-form">
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
    						<a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/resultats.php?speciesID=Arabidopsis+thaliana&q=AT5G03160">AT5G03160</a> 
    						or 
    						<a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/Multi/psychic?q=chx28;site=ensemblunit">chx28</a>
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
    <!--<div class="tinted-box">-->
    <div id="ListSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="https://services.cbib.u-bordeaux2.fr/cobra/src/resultats_list3.php" method="get" class="clear search-form homepage-search-form">
    		<fieldset>
    			<div class="form-group">
						<label for="listids">input list of gene ids</label>
						<textarea name="listID" class="form-control" rows="3">AT5G03160
AT1G06520
AT1G03110</textarea>
		
				</div>
				<wbr/>
    				<span class="inp-group">
    					<input value="Go" class="fbutton" type="submit" />
    				</span>
    			<wbr/>
    		</fieldset>
    	</form>
    </div>
    <!--</div>-->';


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
    
    <div id="SpeciesSearch">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="https://services.cbib.u-bordeaux2.fr/cobra/src/Multi-results.php" method="get" class="clear search-form homepage-search-form">
            <fieldset>
                <div class="form-field ff-multi">
                    <div align="left" class="ff-inline ff-right" >
                        <label for="species" class="ff-label">Search:</label>

                            <span class="inp-group">
                                <select name="organism" class="fselect input" id="organism">
                                        <option value="All species" selected="selected">All species</option>
                                        <option disabled="disabled" value="">---</option>';   
                                //Parcours de chaque ligne du curseur
                            foreach($cursor as $line) {
                                    echo '<option value="'.$line.'">'.$line.'</option>';
                            }
                            echo '</select>
                                    <label for="search">for</label>
                            </span>
                            <wbr/>
                            <span class="inp-group">
                                    <input value="" name="search" class="_string input inactive query optional ftext" id="search" type="text" size="30" />
                                    <i class="fa fa-search"></i> <span><input value="Search" class="fbutton" type="submit" /></span>
                            </span>
                            <wbr/>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism=Arabidopsis+thaliana&search=AT1G75950">AT1G75950</a> 
    						or 
    						<a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism=Solanum+lycopersicum&search=SGN-U603893">SGN-U603893</a>
    						
    					</p>
    				</div>
    			</div>
    		</fieldset>
    	</form>
    </div>';
}

function make_CrossCompare_list($cursor){

    
    echo '
    <div class="tinted-box" style="border:1px">
    <h2> Cross compare datasets</h2>
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="https://services.cbib.u-bordeaux2.fr/cobra/src/cross_compare_resultats.php" method="get" class="clear search-form homepage-search-form">
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
    					<wbr/>
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
    					<wbr/>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/cross_compare_resultats.php?species1ID=Arabidopsis+thaliana&species2ID=Solanum+lycopersicum">Arabidospis thaliana versus Solanum lycopersicum</a> 
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
    	<form action="https://services.cbib.u-bordeaux2.fr/cobra/Multi/psychic" method="get" class="clear search-form homepage-search-form">
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
						#echo"<td><a href=\"https://services.cbib.u-bordeaux2.fr/cobra/src/prot_ref.php?protID=".$line[$value]."\">".$line[$value]."</a></td>";

								
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
								#echo"<td><a href=\"https://services.cbib.u-bordeaux2.fr/cobra/src/prot_ref.php?protID=".$line[$value]."\">".$line[$value]."</a></td>";

								
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


