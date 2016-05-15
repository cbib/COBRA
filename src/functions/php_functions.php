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
function display_statistics(){
    $db=mongoConnector();
    $speciesCollection = new Mongocollection($db, "species");
    $sampleCollection = new Mongocollection($db, "samples");
    $virusCollection = new Mongocollection($db, "viruses");
    $measurementsCollection = new Mongocollection($db, "measurements");
    //$publicationsCollection = new Mongocollection($db, "publications");
    $pp_interactionsCollection = new Mongocollection($db, "pp_interactions");
    $pv_interactionsCollection = new Mongocollection($db, "pv_interactions");
    
    echo'<div class="container">';
        $stat_string="";
        $today = date("F j, Y, g:i a");
        //$stat_string.='<h4>Last update : '.getlastmod().'</h4>

        $stat_string.='<h4>Last update : '.$today.'</h4>
                    <h4>Samples : '.$sampleCollection->count().'</h4>
                    <h4>Normalized measures : '.$measurementsCollection->count().'</h4>';
                    
                    $pv_fields=array(array('$project' => array('mapping_file'=>1,'_id'=>0)));
                    $cursor_pvi=$pv_interactionsCollection->aggregate($pv_fields);
                    //var_dump($cursor_ppi);
                    $total_pvi=0;
                    foreach ($cursor_pvi['result'] as $value) {
                        foreach ($value['mapping_file'] as $mapping_file) {
                            $total_pvi++;
                        }

                    }
                    $stat_string.= '<h4>Plant-Virus [HPIDB + Literature] interactions: '.$total_pvi.'</h4>';
                    
                    $pp_biogrid_fields=array(array('$match' => array('origin'=>'BIOGRID')),array('$project' => array('mapping_file'=>1,'_id'=>0)));
                    $cursor_ppi_biogrid=$pp_interactionsCollection->aggregate($pp_biogrid_fields);
                    $total_ppi_biogrid=0;
                    foreach ($cursor_ppi_biogrid['result'] as $value) {
                        foreach ($value['mapping_file'] as $mapping_file) {
                            $total_ppi_biogrid++;
                        }

                    }
                    
                    $stat_string.= '<h4>Biogrid Plant-Plant interactions: '.$total_ppi_biogrid.'</h4>';
                    $pp_intact_fields=array(array('$match' => array('origin'=>'INTACT')),array('$project' => array('mapping_file'=>1,'_id'=>0)));
                    $cursor_ppi_intact=$pp_interactionsCollection->aggregate($pp_intact_fields);
                    $total_ppi_intact=0;
                    foreach ($cursor_ppi_intact['result'] as $value) {
                        foreach ($value['mapping_file'] as $mapping_file) {
                            $total_ppi_intact++;
                        }

                    }
                    
                    $stat_string.= '<h4>Intact Plant-Plant interactions: '.$total_ppi_intact.'</h4>';
                    $stat_string.= '<h4>String Plant-Plant interactions: 25382632</h4>';

                    $stat_string.= '<h4>Species : '.$speciesCollection->count().'</h4>';

                    $cursor_species=$speciesCollection->aggregate(array(
                    array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
                    ));
                    $stat_string.='<h4>Species per top_level</h4>';
                    foreach ($cursor_species['result'] as $doc){
                            $stat_string.='<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
                    }
                    $stat_string.= '<h4>Viruses : '.$virusCollection->count().'</h4>';
                    $cursor_virus=$virusCollection->aggregate(array(
                    array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
                    ));
                    $stat_string.='<h4> Pathogens per top_level</h4>';
                    foreach ($cursor_virus['result'] as $doc){
                            $stat_string.='<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
                    }
        add_accordion_panel($stat_string, "Some statistics", "stat_panel");


    echo' </div>';
}
function make_user_preferences($user,Mongocollection $us){
    #echo '<div id="user_pref">';

    		echo '<div id="log_details">
    			<h3> login details</h3>';
                foreach ( $user as $person ) { 
                    if (($person['login'] != '') && ($person['pwd'] != '')){
                        echo 'You are currently logged in as '.$person['login'].'.';
	
                    }
            echo '</div>'
                 . '</br>';	
		
            echo '<div id="change_password">
                
                    <h3> Change password</h3>';
		
               echo'<form action="../users/reset_password.php" method="get" class="clear search-form homepage-search-form">
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
            echo '</div>';
        
    #echo '</div>';  

}
function is_expression_variables_set(array $categories, array $result, array $logfc_array){
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
    array_push($logfc_array, $sample);
    return $categories;
    
}
function display_expression_profile_old(MongoCollection $measurementsCollection, MongoCollection $samplesCollection, array $series, array $categories, array $logfc_array,array $gene_id, array $gene_id_bis, array $gene_alias){
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
                $categories=is_expression_variables_set($categories,$result,$logfc_array);
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
                //array_push($logfc_array, $sample);

                $counter++;

            }
            $sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
            array_push($series, $sample);
            echo'<div id="shift_line"></div>'                
      . '</div>'; 
}

function load_and_display_expression_profile(MongoCollection $measurementsCollection,MongoCollection $samplesCollection,array $gene_id,array $transcript_id, array $protein_id,array $gene_id_bis,array $gene_alias){
    $series=array();
    $categories=array();
    $logfc_array=array();
    $xp_name=array();
    $cursor=$measurementsCollection->find(array(
    '$and'=>array(
        array('$or'=> array(
            array('gene'=>array('$in'=>$gene_id)),
            array('gene'=>array('$in'=>$transcript_id)),
            array('gene'=>array('$in'=>$protein_id)),
            array('gene'=>array('$in'=>$gene_id_bis)),
            array('gene'=>array('$in'=>$gene_alias))
        )),
        array('gene'=> array('$ne'=>""))
    )),
    array('_id'=>0)
    );
    $counter=1;
    if (count($cursor)===0){
        
        echo count($cursor);
    }
    foreach ($cursor as $result) {
        $xp_full_name=explode(".", $result['xp']);
        #$first_condition=$result['first_condition'];
        #$second_condition=$result['second_condition'];
        
        $experiment_id=$xp_full_name[0];
        #$xp_name=explode(".", get_experiment_name_with_id($samplesCollection,$experiment_id));
        $xp_name=get_experiment_name_with_id($samplesCollection,$experiment_id);

        #print $xp_name[0];
      
        $species=$result['species'];
        

        if (isset($result['day_after_inoculation'])){
            if (isset($result['variety'])){
               $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                //$categories[$gene_id[0]]= $result['species'].'/'.$result['variety'].'/Day '.$result['day_after_inoculation']; 
                array_push($categories, $result['variety'].'/Day '.$result['day_after_inoculation']); 
            }
            else{
                $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'dpi'=>$result['day_after_inoculation'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                //$categories[$gene_id[0]]= $result['species'].'/Day '.$result['day_after_inoculation'];

                array_push($categories, '/Day '.$result['day_after_inoculation']);
            }
        }
        else{
            if (isset($result['variety'])){
               $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'variety'=>$result['variety'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
               ///$categories[$gene_id[0]]=  $result['species'].'/'.$result['variety'];
                array_push($categories, $result['variety']); 
            }
            else{
                $sample=array('infection_agent'=>$result['infection_agent'],'first_condition'=>$result['first_condition'],'second_condition'=>$result['second_condition'],'y'=>$result['logFC'],'logFC'=>$result['logFC'],'xp_name'=>str_replace(' ','\s',$xp_name));
                //$categories[$gene_id[0]]=  $result['species'];
                array_push($categories, $result['species']);
            }
        }
        //description/experiments.php?xp=
        
        array_push($logfc_array, $sample);
        $counter++;
        

    }
    $sample=array('name'=>$xp_name,'data'=>$logfc_array);

    #$sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
    array_push($series, $sample);
    $global_array=array($categories,$series);
    echo'<div id="expression_profile_section">
                    <h3>Expression profile</h3>
                    <div class="panel-group" id="accordion_documents_expression">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle collapsed" href="#expression-chart" data-parent="#accordion_documents_expression" data-toggle="collapse">
                                    <strong>  Expression data</strong>
                                </a>				
                            </div>
                            <div class="panel-body panel-collapse collapse" id="expression-chart"  >
                                <div id="container_profile" data-id="'.$gene_id[0].'" data-alias="'.$gene_alias[0].'" data-species="'.$species.'" style="min-width: 310px; height: 400px;"></div>
                            </div>
                        </div>
                    </div>'; 
               echo'<div id="shift_line"></div>'                
              . '</div>'; 
    //var_dump($global_array);
    return $global_array;

    //$global_array=array($categories,$series);
}

function load_and_display_expression_profile_bis(MongoCollection $measurementsCollection,MongoCollection $samplesCollection,array $gene_id,array $transcript_id, array $protein_id,array $gene_id_bis,array $gene_alias){
    $series=array();
    $categories=array();
    $global_categories=array();
    $global_series=array();
    $logfc_array=array();
    $xp_name=array();
    $cursor=$measurementsCollection->find(array(
    '$and'=>array(
        array('$or'=> array(
            array('gene'=>array('$in'=>$gene_id)),
            array('gene'=>array('$in'=>$transcript_id)),
            array('gene'=>array('$in'=>$protein_id)),
            array('gene'=>array('$in'=>$gene_id_bis)),
            array('gene'=>array('$in'=>$gene_alias))
        )),
        array('gene'=> array('$ne'=>""))
    )),
    array('_id'=>0)
    );
    $counter=1;
    $xp_current_name="";
    $xp_previous_name="";
    foreach ($cursor as $result) {
        $xp_full_name=explode(".", $result['xp']);  
        
        $experiment_id=$xp_full_name[0];
        $xp_name=explode(".", get_experiment_name_with_id($samplesCollection,$experiment_id));
        if ($counter===1){
            $xp_current_name=$xp_name[0];
            $xp_previous_name=$xp_name[0];
            
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
            
            
            
        }
        else{
            
            $xp_current_name=$xp_name[0];
            
            if ($xp_current_name===$xp_previous_name){
                

                //echo $xp_name[0].'</br>';
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
                $xp_previous_name=$xp_current_name;
            }
            else{
                $series=array('name'=>$xp_current_name,'data'=>$logfc_array);
                array_push($global_series, $series);
                array_push($global_categories,$categories);
                $categories=array();
                $logfc_array=array();
                
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
                $xp_current_name=$xp_name[0];
                $xp_previous_name=$xp_name[0];
                
                
                
            }
            
        }
        $counter++;

    }
    $series=array('name'=>$xp_current_name,'data'=>$logfc_array);
    array_push($global_series, $series);
    array_push($global_categories,$categories);
    //$sample=array('name'=>$xp_name[0],'data'=>$logfc_array);
    //array_push($series, $sample);
    $global_array=array($global_categories,$global_series);
    echo'<div id="expression_profile_section">
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
               echo'<div id="shift_line"></div>'                
              . '</div>'; 
    var_dump($global_array);
    return $global_array;

    //$global_array=array($categories,$series);
}

function load_and_display_score_pie(){
    echo'<div id="section_score">';
    echo '<!-- Button trigger modal -->
                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">
                          View score details
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Score repartition</h4>
                              </div>
                              <div class="modal-body">
                                <div id="container_pie" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
                                <p> The score is computed using every resources of COBRA database following this scheme</p> 
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                              </div>
                            </div>
                          </div>
                        </div>';
    echo '</div>';
    
}

function load_and_display_proteins_details(array $gene_id, array $gene_id_bis,array $gene_symbol, array $gene_alias, array $descriptions, array $proteins_id,$species='null',$score_exp='null',$score_int='null',$score_ort='null',$score_QTL='null',$score_SNP='null',$score='null',$gene_start='null',$gene_end='null',$chromosome='null'){
   echo'<div id="section_description"><B>';
        if (isset($gene_id[0])){echo $gene_id[0];}else{echo $gene_id_bis[0];} echo '</B> ';
                for ($i = 0; $i < $score_exp; $i++) { 
                   echo '<i class="fa fa-star" id="score_exp"></i>';
                }
                for ($i = 0; $i < $score_int; $i++) { 
                   echo '<i class="fa fa-star" id="score_int"></i>';
                }
                for ($i = 0; $i < $score_ort; $i++) { 
                   echo '<i class="fa fa-star" id="score_ort"></i>';
                }
                for ($i = 0; $i < $score_QTL; $i++) { 
                   echo '<i class="fa fa-star" id="score_QTL"></i>';
                }
                for ($i = 0; $i < $score_SNP; $i++) { 
                   echo '<i class="fa fa-star" id="score_SNP"></i>';
                }
                
                
                
                
                echo '<!-- Button trigger modal -->
                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">
                          View score details
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Score repartition</h4>
                              </div>
                              <div class="modal-body">
                                <!--<div class= col-md-6>
                                    <div id="container_chart" style=" height: 300px; max-width: 100%; margin: 0 auto"></div>-->
                                    <div id="container_pie" style=" height: 300px; max-width: 100%; margin: 0 auto"></div>

                           
                                <!--</div>-->
                                <!--<div class= col-md-6>-->
                                <!--    <div id="container_pyramid" style="min-width: 350px; height: 400px; max-width: 450px; margin: 0 auto"></div>-->
                                <!--</div>-->
                                
                              </div>
                              <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Score details</h4>
                                    <p> The score is computed using every resources of COBRA database following this scheme</p> 
                                    <!--<img src="../images/COBRA_18032016.jpg" width="100%"></img>-->
                                </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                              </div>
                            </div>
                          </div>
                        </div>';
                
                
                
                
                
                
                echo'<B class="right"><i>'.$species.'</i></B>';
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
                    for ($i = 0; $i < count($gene_alias); $i++) {

                        if ($gene_alias[$i]!='NA'){
                            if ($i==count($gene_alias)-1){
                        
                                echo $gene_alias[$i];
                            }
                            else{
                                echo $gene_alias[$i].', ';
                            }
                        }
                    }
                }
                echo '</h1> ';
//                echo 'Score: ';
//                for ($i = 0; $i < $score; $i++) { 
//                   echo '<i class="fa fa-star"></i>';
//                }
//                echo '<br>';
                
                if (count($descriptions)>0){
                    echo'<div id="description"> <B>Description</B> : ';
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
                    echo'<div id="aliases"> <B>Alias</B> : ';
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
                    if ($proteins_id[0]!='NA'){
                        echo'<div id="protein aliases"> <B>Protein ids</B> : ';
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
                }
                echo'<div id="sequence_info"> <B>Location</B> : ';
                echo $chromosome.':'.$gene_start.'-'.$gene_end;
                echo '</div>';
                //$transcript_count=0;
                
                
                
                
                
                echo '</div>';//gene details end region 
}




function load_and_display_variations_result(MongoCollection $genetic_markers_collection,MongoCollection $qtl_collection,MongoCollection $full_mappings_collection,MongoCollection $variation_collection,array $gene_id,$species='null',$gene_start=0,$gene_end=0,$scaffold=0){
    
    
    //$gene_start=0;
    //$gene_end=0;
    $genetic_markers_result=array();
   
    if ($species==="Prunus persica"){
//        foreach ($gene_id as $gene) {
//            $gene_position_cursor=$full_mappings_collection->find(array('mapping_file.Gene ID'=>$gene),array('mapping_file.$'=>1));
//            foreach ($gene_position_cursor as $value) {
//                $gene_start=$value['mapping_file'][0]['Start'];
//                $gene_end=$value['mapping_file'][0]['End'];
//                $scaffold=$value['mapping_file'][0]['Chromosome'];
//
//            }
//            
//        }
        
        $scaffold='scaffold_'.$scaffold;
        $genetic_markers_result=$genetic_markers_collection->aggregate(array(  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('$or'=>array(array('$and'=> array(
                                            array('mapping_file.Start'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.Start'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold )))
                                            ,
                                            array('$and'=> array(
                                            array('mapping_file.End'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.End'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold )))
                                            )
                                        )
                                    ),
            array('$project'=>  array('mapping_file.Marker ID'=> 1, 'mapping_file.HREF_markers'=> 1,'mapping_file.HREF_species'=> 1,'mapping_file.Species'=>1,'mapping_file.Start'=>1,'mapping_file.End'=>1,'mapping_file.Map ID'=>1,'mapping_file.Chromosome'=>1,'mapping_file.Type'=>1,'mapping_file.Linkage Group'=>1,'mapping_file.StartcM'=>1,'_id'=> 0))

        ));
        
        
        
        //echo 'start: '.$gene_start.'- end: '.$gene_end.' chrom: '.$scaffold;

        $var_results=$variation_collection->aggregate(array(
                    array('$match' => array('species'=> $species)),  
                    array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                    array('$unwind'=>'$mapping_file'),
                    array('$match' => array('$and'=> array(
                                                    array('mapping_file.Position'=>array('$gt'=> (int)$gene_start )),
                                                    array('mapping_file.Position'=>array('$lt'=> (int)$gene_end )),
                                                    array('mapping_file.Scaffold'=> $scaffold )
                                                    )
                                            )
                         ),
                    array('$project'=>  array('mapping_file.Variant ID'=> 1, 'mapping_file.Position'=>1,'mapping_file.Alleles'=>1))

                ));
        //foreach ($var_results as $value) {
        //     echo $value['mapping_file'];       
        //}
        
    }
    else if ($species==="Cucumis melo"){
        
        $scaffold_number=  explode('chr', $scaffold);
        $genetic_markers_result=$genetic_markers_collection->aggregate(array(  
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('$and'=> array(
                                            array('mapping_file.Start'=>array('$gt'=> $gene_start )),
                                            array('mapping_file.Start'=>array('$lt'=> $gene_end )),
                                            array('mapping_file.Chromosome'=> $scaffold_number[1] )
                                                )
                                    )
                ),
            array('$project'=>  array('mapping_file.Marker ID'=> 1,'mapping_file.Start'=>1,'mapping_file.Chromosome'=>1,'mapping_file.Type'=>1,'mapping_file.LG_ICuGI'=>1,'mapping_file.cM_ICuGI'=>1,'_id'=> 0))

        ));
    }
    else if($species==="Hordeum vulgare"){
        //http://archive.gramene.org/db/markers/marker_view?marker_name=AQGV002&vocabulary=markers&search_box_name=marker_name&search_box_id=marker_search_for&marker_type_id=20&taxonomy=Hordeum&action=marker_search&x=3&y=11
    }
    else{
        $var_results=$variation_collection->aggregate(array(
                    array('$match' => array('species'=> $species)),  
                    array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
                    array('$unwind'=>'$mapping_file'),
                    array('$match' =>  array('mapping_file.Gene ID'=>array('$in'=>$gene_id))), 
                    array('$project'=>  array('mapping_file.Variant ID'=> 1,'mapping_file.Gene ID'=> 1, 'mapping_file.Position'=>1,'mapping_file.Description'=>1, 'mapping_file.Alleles'=>1))

                ));
    }
    
    
//https://www.rosaceae.org/gb/gbrowse/prunus_persica/?name=
//http://plants.ensembl.org/Arabidopsis_thaliana/Variation/Explore?r=1:1-841;v=ENSVATH00000001;vdb=variation;vf=1
    
        echo'<div id="variation_section">
                <h3>Variation and polymorphism</h3>';
                    /*echo'<div class="panel-group" id="accordion_documents_var_'.$gene_id.'">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#var-table_'.$gene_id.'" data-parent="#accordion_documents_var__'.$gene_id.'" data-toggle="collapse">
                                            <strong>Variants table</strong>
                                    </a>				

                            </div>
                            <div class="panel-body panel-collapse collapse" id="var-table_'.$gene_id.'">';
                                if (count($var_results['result'])>0 ){
                                    
                                        echo'<table class="table" id="table_variants">  
                                                <thead>
                                                <tr>';
                                                //echo "<th>gene ID</th>";
                                                    echo "<th>variant ID</th>";
                                                    echo "<th>Position</th>";
                                                    if ($species!="Prunus persica"){
                                                        echo "<th>Description</th>";
                                                    }

                                                    echo "<th>Variant Alleles</th>";
                                                    echo'
                                                </tr>
                                                </thead>

                                                <tbody>';

                                                    foreach ($var_results['result'] as $value) {
                                                        foreach($value as $data){
                                                            echo "<tr>";
                                                            //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                                            //echo '<td>'.$data['Gene ID'].'</td>';
                                                            if ($species==="Prunus persica"){

                                                                echo '<td><a target = "_blank" href="https://www.rosaceae.org/gb/gbrowse/prunus_persica/?name='.$data['Variant ID'].'">'.$data['Variant ID'].'</a></td>';
                                                                echo '<td>'.$data['Position'].'</td>';
                                                                echo '<td>'.$data['Alleles'].'</td>';
                                                            }
                                                            else{
                                                                echo '<td><a target = "_blank" href="http://plants.ensembl.org/Arabidopsis_thaliana/Variation/Explore?r=1:1-841;v='.$data['Variant ID'].';vdb=variation;vf=1">'.$data['Variant ID'].'</a></td>';
                                                                echo '<td>'.$data['Position'].'</td>';
                                                                echo '<td>'.$data['Description'].'</td>';
                                                                echo '<td>'.$data['Alleles'].'</td>';
                                                            }
                                                            echo "</tr>";
                                                        }


                                                    }


                                                echo'</tbody>

                                            </table>';
                                    
                                    
                                }
                                else{
                                    echo '<p> No results found</p>';
                                }
                                    
                           echo'</div>

                        </div>
                    </div>
                     * 
                     */
                    echo '<div id="shift_line"></div>
                    

                    <div class="panel-group" id="accordion_documents_mark_'.$gene_id[0].'">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#mark-table_'.$gene_id[0].'" data-parent="#accordion_documents_mark_'.$gene_id[0].'" data-toggle="collapse">
                                            <strong>Genetic markers</strong>
                                    </a>				

                            </div>
                            <div class="panel-body panel-collapse collapse" id="mark-table_'.$gene_id[0].'">';
                                if (isset($genetic_markers_result['result']) && count ($genetic_markers_result['result'])>0){
                                        //echo count ($genetic_markers_result['result']);
                                        echo'<table class="table" id="table_markers">  
                                                <thead>
                                                <tr>';
                                                //echo "<th>gene ID</th>";
                                                if ($species === "Cucumis melo"){
                                                        echo "<th>Marker ID</th>";
                                                        echo "<th>Type</th>";
                                                        echo "<th>Start</th>";            
                                                        echo "<th>Chromosome</th>";
                                                        echo "<th>Linkage group</th>";
                                                        echo "<th>Position (cM)</th>";                                                       
                                                        echo "<th>Species</th>";

                                                        echo'
                                                    </tr>
                                                    </thead>

                                                    <tbody>';

                                                        foreach ($genetic_markers_result['result'] as $value) {
                                                            foreach($value as $data){
                                                                echo "<tr>";
                                                                //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                                                echo '<td>'.$data['Marker ID'].'</td>';
                                                                echo '<td>'.$data['Type'].'</td>';
                                                                echo '<td>'.$data['Start'].'</td>';                                              
                                                                echo '<td>'.$data['Chromosome'].'</td>';
                                                                echo '<td>'.$data['LG_ICuGI'].'</td>';
                                                                echo '<td>'.$data['cM_ICuGI'].'</td>';
                                                                echo '<td>'.$species.'</td>'; 


                                                                echo "</tr>";
                                                            }


                                                        }


                                                    echo'</tbody>

                                            </table>';
                                                }
                                                else{
                                                    
                                                
                                                        echo "<th>Marker ID</th>";
                                                        echo "<th>Type</th>";
                                                        echo "<th>Start</th>";
                                                        echo "<th>End</th>";
                                                        echo "<th>Chromosome</th>";
                                                        echo "<th>Linkage group</th>";
                                                        echo "<th>Position (cM)</th>";
                                                        echo "<th>Map ID</th>";
                                                        echo "<th>Species</th>";

                                                        echo'
                                                    </tr>
                                                    </thead>

                                                    <tbody>';

                                                        foreach ($genetic_markers_result['result'] as $value) {
                                                            foreach($value as $data){
                                                                echo "<tr>";
                                                                //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                                                //echo '<td>'.$data['Gene ID'].'</td>';
                                                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data['HREF_markers'].'/'.$data['Marker ID'].'">'.$data['Marker ID'].'</a></td>';
                                                                echo '<td>'.$data['Type'].'</td>';
                                                                echo '<td>'.$data['Start'].'</td>';
                                                                echo '<td>'.$data['End'].'</td>';
                                                                echo '<td>'.$data['Chromosome'].'</td>';
                                                                $lg=explode(".",$data['Linkage Group']);
                                                                echo '<td>'.$lg[1].'</td>';
                                                                echo '<td>'.$data['StartcM'].'</td>';
                                                                echo '<td>'.$data['Map ID'].'</td>';
                                                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data['HREF_species'].'/'.$data['Species'].'">'.$data['Species'].'</a></td>';


                                                                echo "</tr>";
                                                            }


                                                        }


                                                    echo'</tbody>

                                            </table>';
                                            
                                            
                                        }
                                }
                                else{
                                    echo '<p> No results found</p>';
                                }
                                    
                           echo'</div>

                        </div>
                    </div>
                    <div id="shift_line"></div>
                    <div class="panel-group" id="accordion_documents_qtl_'.$gene_id[0].'">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#qtl-table_'.$gene_id[0].'" data-parent="#accordion_documents_qtl_'.$gene_id[0].'" data-toggle="collapse">
                                            <strong>QTLs</strong>
                                    </a>				

                            </div>
                            <div class="panel-body panel-collapse collapse" id="qtl-table_'.$gene_id[0].'">';
                                if (isset($genetic_markers_result['result']) && count ($genetic_markers_result['result'])>0 ){

                                            
                                                if ($species === "Cucumis melo"){
                                                    echo'<table class="table" id="table_qtls">  
                                                    <thead>
                                                    <tr>';
                                                    //echo "<th>gene ID</th>";
                                                        echo "<th>QTL ID</th>";
                                                        echo "<th>Map ID</th>";
                                                        echo "<th>Start</th>";
                                                        echo "<th>End</th>";
                                                        echo "<th>Marker 1</th>"; 
                                                        echo "<th>Marker 2</th>";
                                                        echo'
                                                    </tr>
                                                    </thead>

                                                    <tbody>';
                                                    $marker_list=array();
                                                        foreach ($genetic_markers_result['result'] as $value) {
                                                                foreach($value as $data){

                                                                        $marker_id=$data['Marker ID']; 
                                                                        if (!in_array($marker_id, $marker_list)){
                                                                            $genetic_qtls_result=$qtl_collection->aggregate(array(  
                                                                                array('$project' => array('mapping_file'=>1,'_id'=>0)),
                                                                                array('$unwind'=>'$mapping_file'),
                                                                                array('$match' => array('$or'=> array(
                                                                                                                //array('mapping_file.Colocalizing marker'=>new MongoRegex("/^$marker_id/xi")),
                                                                                                                array('mapping_file.Marker ID'=>$marker_id),
                                                                                                                //array('mapping_file.Marker ID'=>new MongoRegex("/^$marker_id/xi"))
                                                                                                                array('mapping_file.Marker ID 2'=>$marker_id)
                                                                                                                )
                                                                                                        )
                                                                                     ),
                                                                                array('$project'=>  array('mapping_file.QTL ID'=> 1, 'mapping_file.Map ID'=>1,'mapping_file.Marker ID'=>1,'mapping_file.Marker ID 2'=>1,'mapping_file.Start'=>1,'mapping_file.End'=>1,'_id'=> 0))

                                                                            ));
                                                                            foreach ($genetic_qtls_result['result'] as $value_qtl) {
                                                                                foreach($value_qtl as $data_qtl){
                                                                                    echo "<tr>";
                                                                                    //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                                                                    echo '<td>'.$data['QTL ID'].'</td>';
                                                                                    //echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data_qtl['HREF_QTL'].'/'.$data_qtl['QTL ID'].'">'.$data_qtl['QTL ID'].'</a></td>';
                                                                                    echo '<td>'.$data_qtl['Map ID'].'</td>';
                                                                                    echo '<td>'.$data_qtl['Start'].'</td>';
                                                                                    echo '<td>'.$data_qtl['End'].'</td>';
                                                                                    echo '<td>'.$data_qtl['Marker ID'].'</td>';
                                                                                    echo '<td>'.$data_qtl['Marker ID 2'].'</td>';
                                                                                    //echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$href_marker.'/'.$marker_id.'">'.$marker_id.'</a></td>';


                                                                                    echo "</tr>";
                                                                                }
                                                                            }
                                                                            array_push($marker_list, $marker_id);
                                                                        }


                                                                }   

                                                        }
                                                        echo'</tbody>

                                                            </table>';
                                                }
                                                else{
                                                    echo'<table class="table" id="table_qtls">  
                                                <thead>
                                                <tr>';
                                                //echo "<th>gene ID</th>";
                                                    echo "<th>QTL ID</th>";
                                                    echo "<th>Trait Name</th>";
                                                    echo "<th>Trait Alias</th>";
                                                    echo "<th>Study</th>";
                                                    echo "<th>Species</th>"; 
                                                    echo "<th>Marker</th>";
                                                    echo'
                                                </tr>
                                                </thead>

                                                <tbody>';
                                                $marker_list=array();
                                                    foreach ($genetic_markers_result['result'] as $value) {
                                                            foreach($value as $data){

                                                                
                                                                    
                                                                    $href_marker=$data['HREF_markers'];
                                                                    $marker_id=$data['Marker ID'];

                                                                    if (!in_array($marker_id, $marker_list)){
                                                                        $genetic_qtls_result=$qtl_collection->aggregate(array(  
                                                                            array('$project' => array('mapping_file'=>1,'_id'=>0)),
                                                                            array('$unwind'=>'$mapping_file'),
                                                                            array('$match' => array('$or'=> array(
                                                                                                            //array('mapping_file.Colocalizing marker'=>new MongoRegex("/^$marker_id/xi")),
                                                                                                            array('mapping_file.Colocalizing marker'=>$marker_id),
                                                                                                            //array('mapping_file.Marker ID'=>new MongoRegex("/^$marker_id/xi"))
                                                                                                            array('mapping_file.Marker ID'=>$marker_id)
                                                                                                            )
                                                                                                    )
                                                                                 ),
                                                                            array('$project'=>  array('mapping_file.QTL ID'=> 1,'mapping_file.Trait Name'=> 1,'mapping_file.Species'=> 1,'mapping_file.HREF_QTL'=> 1, 'mapping_file.Trait Alias'=> 1,'mapping_file.Study'=>1,'_id'=> 0))

                                                                        ));
                                                                        foreach ($genetic_qtls_result['result'] as $value_qtl) {
                                                                            foreach($value_qtl as $data_qtl){
                                                                                echo "<tr>";
                                                                                //echo '<td><a class="nowrap" target = "_blank" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                                                                                //echo '<td>'.$data['Gene ID'].'</td>';
                                                                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$data_qtl['HREF_QTL'].'/'.$data_qtl['QTL ID'].'">'.$data_qtl['QTL ID'].'</a></td>';
                                                                                echo '<td>'.$data_qtl['Trait Name'].'</td>';
                                                                                echo '<td>'.$data_qtl['Trait Alias'].'</td>';
                                                                                echo '<td>'.$data_qtl['Study'].'</td>';
                                                                                echo '<td>'.$data_qtl['Species'].'</td>';
                                                                                echo '<td><a target = "_blank" href="http://www.rosaceae.org/node/'.$href_marker.'/'.$marker_id.'">'.$marker_id.'</a></td>';


                                                                                echo "</tr>";
                                                                            }
                                                                        }
                                                                        array_push($marker_list, $marker_id);
                                                                    }
                                                                
                                                            }   

                                                    }
                                                    echo'</tbody>

                                                        </table>';
                                                }
                                                
                                        
                                }
                                else{
                                    echo '<p> No results found</p>';
                                }
                                    
                           echo'</div>

                        </div>
                    </div>
                    









                </div>';
    
    
    
    
    
    
    
    
}
function load_and_display_gene_ontology_terms(MongoCollection $go_collection, array $go_id_list){
    $total_go_biological_process=array();
    $total_go_cellular_component=array();
    $total_go_molecular_function=array();
    if (count($go_id_list)!=0){

        foreach ($go_id_list as $go_info){

            //$timestart1=microtime(true);
            $go_term=$go_collection->find(array('GO_collections.id'=>$go_info[0]),array('GO_collections.$'=>1,'_id'=>0));
            foreach ($go_term as $term){
                foreach ($term as $go){
                    foreach ($go as $value){
                       if ($value['namespace']=='molecular_function'){


                            //$go_info['GO_ID']=$value['id'];
                            $go_info[2]=$value['name'];
                            $go_info[3]=$value['namespace'];
                            //echo $value['name'];
                            //$go_info['evidence']=$go_id_list[$i]['evidence'];
                            array_push($total_go_molecular_function, $go_info);
                            //array_push($already_added_go_term,$go_info);
                        }
                        if ($value['namespace']=='biological_process') {
                            $go_info[2]=$value['name'];   
                            $go_info[3]=$value['namespace'];
                            array_push($total_go_biological_process, $go_info);
                            //array_push($already_added_go_term,$go_info);

                        }
                        if ($value['namespace']=='cellular_component'){
                            $go_info[2]=$value['name']; 
                            $go_info[3]=$value['namespace'];
                            array_push($total_go_cellular_component, $go_info);
                            //array_push($already_added_go_term,$go_info);
                        }   
                       //echo $go['namespace']; 
                    }

                }

            }

        }
    }
    //start div goterms
    echo'<div id="goTerms">
        <h3>Gene Ontology</h3>
        <div class="goTermsBlock">

            <div class="panel-group" id="accordion_documents_go_process">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="accordion-toggle collapsed" href="#go_process" data-parent="#accordion_documents_go_process" data-toggle="collapse">
                            <strong>Biological Process </strong> ('.  count($total_go_biological_process).')
                        </a>				
                    </div>
                    <div class="panel-body panel-collapse collapse" id="go_process">
                    ';
                    if (count($total_go_biological_process)!=0){
                        echo'
                        <div class="goProcessTerms goTerms">
                        ';
                       
                        
                       
                        foreach ($total_go_biological_process as $go_info){
                            
                        echo'
                            <ul>
                                <span class="goTerm">
                                    <li>

                                        <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[0].'" title="'.$go_info[2].'">'.$go_info[2].'</a>';
                        
                        foreach ($go_info[1] as $evidence) {
                            echo '<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$evidence.'" title="Go Evidence Code">'.$evidence.'</a>]</span>';

                        }
                               echo' </span>
                            </ul>';
                        }
                        echo'
                        </div>';
                    }
                    echo'
                    </div>
                </div>
            </div>';
            echo'
            <div class="panel-group" id="accordion_documents_go_component">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#go_component" data-parent="#accordion_documents_go_component" data-toggle="collapse">
                            <strong>Cellular Component </strong> ('.  count($total_go_cellular_component).')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="go_component">
                    ';
                    if (count($total_go_cellular_component)!=0){
                        echo'
                        <div class="goProcessTerms goTerms">

                        ';
                        foreach ($total_go_cellular_component as $go_info){
                        echo'
                            <ul>
                                <span class="goTerm">
                                    <li>

                                        <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[0].'" title="'.$go_info[2].'">'.$go_info[2].'</a>';
                                        foreach ($go_info[1] as $evidence) {
                                            echo '<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$evidence.'" title="Go Evidence Code">'.$evidence.'</a>]</span>';
                                        }
                                echo '</span>
                            </ul>';
                        }
                        echo'
                        </div>';
                    }
                    echo'
                    </div>
                </div>
            </div>    
            <!--<br/>-->';
                    echo'
            <div class="panel-group" id="accordion_documents_go_function">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#go_function" data-parent="#accordion_documents_go_function" data-toggle="collapse">
                            <strong>Molecular Function </strong> ('.  count($total_go_molecular_function).')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="go_function">
                    ';
                    if (count($total_go_molecular_function)!=0){
                        echo'
                        <div class="goProcessTerms goTerms">

                        ';
                        foreach ($total_go_molecular_function as $go_info){
                        echo'
                            <ul>
                                <span class="goTerm">
                                    <li>

                                        <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[0].'" title="'.$go_info[2].'">'.$go_info[2].'</a>';
                                        foreach ($go_info[1] as $evidence) {
                                            echo '<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$evidence.'" title="Go Evidence Code">'.$evidence.'</a>]</span>';
                                        }
                               echo '</span>
                            </ul>';
                        }
                        echo'
                        </div>';
                    }
                    echo'
                    </div>
                </div>
            </div>';                               
            echo'
        </div>
        <div id="shift_line"></div>
    </div>';
}
function load_and_display_external_references( array $proteins_id,$search='null',$species='null'){
    echo' 
    <div id="linkouts">
        <h3>External Database Linkouts</h3>';
        /*<a target="_BLANK" href="http://arabidopsis.org/servlets/TairObject?type=locus&name='.$search.'" title="TAIR AT5G03160 LinkOut">TAIR</a>
        //<!--| <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/gene/831917" title="Entrez-Gene 831917 LinkOut">Entrez Gene</a> 
        //| <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/sites/entrez?db=protein&cmd=DetailsSearch&term=NP_195936" title="NCBI RefSeq Sequences">RefSeq</a> -->
        ';*/

        if ($species == "Arabidopsis thaliana"){
            echo'<a target="_BLANK" href="http://arabidopsis.org/servlets/TairObject?type=locus&name='.$search.'" title="TAIR '.$search.' LinkOut">TAIR</a>';
        }
        else if ($species == "Solanum lycopersicum"){

            echo'<a target="_BLANK" href="http://solgenomics.net/search/unigene.pl?unigene_id='.$search.'">Sol genomics</a>';
        }
        else if ($species == "Cucumis melo"){


        }
        else if ($species == "Hordeum vulgare"){


        }
        else{

        }
        for ($i = 0; $i < count($proteins_id); $i++) {                        
            echo'| <a target="_BLANK" href="http://www.uniprot.org/uniprot/'.$proteins_id[$i].'" title="UniprotKB Swissprot and Trembl Sequences">UniprotKB</a>';   
        } 
        echo'
    </div>
    <div class="bottomSpacer"></div> </br> '; 
}
function load_and_display_ppinteractions($full_mappingsCollection,$gene_id,$proteins_id,$transcript_id,$interactionsCollection,$species){
    

    
    $interaction_array=get_intact_plant_plant_interactor($proteins_id,$interactionsCollection,$species);
    $hits_number_intact= count($interaction_array['result']);

    if ($hits_number_intact>0){
        echo'
            <div class="panel-group" id="accordion_documents_intact">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#intact" data-parent="#accordion_documents_intact" data-toggle="collapse">
                            <strong> Plant Plant Interaction (Intact)</strong> ('.$hits_number_intact.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="intact">';

                        echo'
                        <div class="pp_interaction">';
                            $intact_headers=array('EBI ref','Alias','Uniprot','Pubmed','Author','detection_method','Organism','interaction_type','source_database_id','interaction_identifier');
                            $intact_values=array();
                            foreach ($interaction_array['result'] as $value) {
                                
                                
                                foreach ($value as $data) {
                                    
                                    
                                    
                                    $href_id='<a href="http://www.ebi.ac.uk/intact/interaction/'.$data['protein_EBI_ref_2'].'">'.$data['protein_EBI_ref_2'].'</a>';
                                    array_push($intact_values, $href_id);
                                    $aliases=explode("|", $data['alternative_identifiers_2']);
                                    $counter=0;
                                    $alias_string="";
                                    foreach ($aliases as $alias) {
                                      if($counter===count($aliases)-1){
                                           //$short=explode(":", $alias);
                                           //$aliases2=explode("(", $short[1]);
                                           $alias_string.=$alias;
                                           array_push($intact_values, $alias_string);
                                       }
                                       else{
                                          $alias_string.=$alias.',';
                                          //$short=explode(":", $alias);
                                          //$aliases2=explode("(", $short[1]);
                                          //array_push($values, $aliases2[0]); 
                                       }
                                       
                                       $counter++;
                                       
                                    }
                                    
                                   $href_uniprot='<a href="http://www.uniprot.org/uniprot/'.$data['Uniprot ID 2'].'">'.$data['Uniprot ID 2'].'</a>';
                                   array_push($intact_values, $href_uniprot);
                                   $split_pmid=explode("|", $data['pmid']);
                                   $href_pmid="";
                                   foreach ($split_pmid as $pmid) {
                                        $split_pmid2=explode(":", $pmid);
                                        if (!strstr($split_pmid2[0],"imex") && !strstr($split_pmid2[0],"MINT")){
                                            $href_pmid.=' <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$split_pmid2[1].'"> '.$split_pmid2[1].' </a> ';  

                                        }
                                        
                                        
                                   }
                                   array_push($intact_values, $href_pmid);
                                   
                                   $split_author=explode("|", $data['author_name']);
                                   $author_string="";
                                   foreach ($split_author as $author) {
                                       $author_string.=$author.'</br>';
                                       
                                       
                                   }
                                   array_push($intact_values, $author_string);
                                   
                                   $split_method=explode("|", $data['detection_method']);
                                   
                                   $id_string_method="";
                                   //psi-mi :"MI:0469"(IntAct)
                                   //    :"MI:0469" (IntAct)
                                   $already_in=array();
                                   foreach ($split_method as $method) {
                                       
                                      
                                      $split_method_bis=explode(':"', $method);
                                      $split_method_ter=explode('"', $split_method_bis[1]);
                                      $method_name=$split_method_ter[1];
                                      $id_method=$split_method_ter[0];
                                      if (!in_array($id_method, $already_in)) {
                                          array_push($already_in,$id_method);
                                          $id_string_method.=' <a href="http://www.ebi.ac.uk/ontology-lookup/?termId='.$id_method.'"> '.$id_method.' </a> ';
                                          $id_string_method.=$method_name;
                                      }
 
                                   }
                                   array_push($intact_values, $id_string_method);
                                   
                                   //http://www.ebi.ac.uk/ontology-lookup/?termId=MI:0397
                                   array_push($intact_values, $data['Taxid interactor B']);
                                   
                                   
                                   
                                   $split_interaction_type=explode("|", $data['interaction_type']);
                                   $already_in=array();
                                   $id_string_interaction_type="";
                                   foreach ($split_interaction_type as $interaction_type) {
                                       
                                      
                                      $split_interaction_type_bis=explode(':"', $interaction_type);
                                      $split_interaction_type_ter=explode('"', $split_interaction_type_bis[1]);
                                      $method_name=$split_interaction_type_ter[1];
                                      $id_method=$split_interaction_type_ter[0];
                                      if (!in_array($id_method, $already_in)) {
                                          array_push($already_in,$id_method);
                                          $id_string_interaction_type.=' <a href="http://www.ebi.ac.uk/ontology-lookup/?termId='.$id_method.'"> '.$id_method.' </a> ';
                                          $id_string_interaction_type.=$method_name;
                                      }
 
                                   }
                                   array_push($intact_values, $id_string_interaction_type);
                                   array_push($intact_values, $data['source_database_id']);
                                   
                                  
                                   $split_interaction_identifier=explode("|", $data['interaction_identifier']);
                                   $href_interaction_identifier="";
                                   if (count($split_interaction_identifier)===0){
                                        array_push($intact_values, $data['interaction_identifier']);
                                   }
                                   else{
                                        foreach ($split_interaction_identifier as $interaction_identifier) {
                                            $href_interaction_identifier.=' <a href="http://www.ebi.ac.uk/intact/interaction/'.$interaction_identifier.'"> '.$interaction_identifier.' </a> ';

                                        }
                                   }
                                   array_push($intact_values, $href_interaction_identifier);
               
//                                   $split_method=explode(":", $data['detection_method']);
//                                   foreach ($split_method as $alias) {
//                                       $short=explode(":", $alias); 
//                                   }
                                   //array_push($values, $short[1]);

                                }

                            }
                            pretty_table($intact_headers, $intact_values,"pp_intact");
                            
                            
                        echo'</div>';

                    echo'
                    </div></div></div> ';
    }
   
    $biogrid_array=get_biogrid_plant_plant_interactor($gene_id,$interactionsCollection,$species); 
    $hits_number_biogrid= count($biogrid_array['result']);
    $biogrid_headers=array('Gene Id','Official symbol','Aliases','Experimental SYSTEM','Author','Pubmed','Organism');
    $biogrid_values=array();
    if ($hits_number_biogrid>0){
        echo'
                <div class="panel-group" id="accordion_documents_biogrid">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <a class="accordion-toggle collapsed" href="#biogrid" data-parent="#accordion_documents_biogrid" data-toggle="collapse">
                                <strong> Plant Plant Interaction (Biogrid)</strong> ('.$hits_number_biogrid.')
                            </a>				

                        </div>
                        <div class="panel-body panel-collapse collapse" id="biogrid">';

                            echo'
                            <div class="pp_interaction">';
                            
                            
                            foreach ($biogrid_array['result'] as $value) {
                                
                                $species= $value['species'];
                                
                                foreach ($value as $data) {
                                    if (is_array($data)){
                                    
                                    
                                        array_push($biogrid_values, $data['Gene ID 2']);
                                        array_push($biogrid_values, $data['OFFICIAL_SYMBOL_B']);
                                        $aliases=explode("|", $data['ALIASES_FOR_B']);

                                        $counter=0;
                                        $alias_string="";
                                        foreach ($aliases as $alias) {
                                          if($counter===count($aliases)-1){
                                               //$short=explode(":", $alias);
                                               //$aliases2=explode("(", $short[1]);
                                               $alias_string.=$alias;
                                               array_push($biogrid_values, $alias_string);
                                           }
                                           else{
                                              $alias_string.=$alias.',';
                                              //$short=explode(":", $alias);
                                              //$aliases2=explode("(", $short[1]);
                                              //array_push($values, $aliases2[0]); 
                                           }

                                           $counter++;

                                        }
                                        array_push($biogrid_values, $data['EXPERIMENTAL_SYSTEM']);
                                        array_push($biogrid_values, $data['SOURCE']);
                                        $href_pmid="";
                                        $href_pmid.=' <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$data['PUBMED_ID'].'"> '.$data['PUBMED_ID'].' </a> ';  
                                        array_push($biogrid_values, $href_pmid);


                                        array_push($biogrid_values, $species);
                                    }

                                }

                            }
                            pretty_table($biogrid_headers, $biogrid_values,"pp_biogrid");


                                
                            echo'</div>';

                        echo'
                        </div></div></div>';
    
    }
    
    
    $string_array=get_string_plant_plant_interactor($transcript_id,$interactionsCollection,$species); 
    $string_headers=array('Transcript Id','Combined score','Organism');
    $string_values=array();
    
    foreach ($string_array['result'] as $value) {

        //$species= $value['species'];

        foreach ($value as $data) {
            if (is_array($data)){
//                if ($species==="Hordeum vulgare"){
//                    $transcript_list = explode("_MLOC", $data['Transcript ID list']);
//                }
//                else{
                    $transcript_list = explode("_", $data['Transcript ID list']);
                //}
                
                foreach ($transcript_list as $transcript) {
                    $combined_score = explode("-",  $transcript);
                    $score=0.0;
                    if ($species==="Hordeum vulgare"){
                        array_push($string_values, "MLOC_".$combined_score[0]);
                        //$score=get_global_score($full_mappingsCollection,"MLOC_".$combined_score[0],$species);
                    }
                    else{
                        array_push($string_values, $combined_score[0]);
                        //$score=get_global_score($full_mappingsCollection,$combined_score[0],$species);
                    }
                    //array_push($values, $combined_score[0]);
                    array_push($string_values, $combined_score[1]);
                    array_push($string_values, $species);
                    //array_push($string_values, $score);


                }



            }

        }

    }
    
    $hits_number_string= count($string_values)/3;
    
    if ($hits_number_string>0){
        echo'
                <div class="panel-group" id="accordion_documents_string">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <a class="accordion-toggle collapsed" href="#string" data-parent="#accordion_documents_string" data-toggle="collapse">
                                <strong> Plant Plant Interaction (String)</strong> ('.$hits_number_string.')
                            </a>				

                        </div>
                        <div class="panel-body panel-collapse collapse" id="string">';

                            echo'
                            <div class="pp_interaction">';
                            
                            
                            pretty_table($string_headers, $string_values,"pp_string");


                                
                            echo'</div>';

                        echo'
                        </div></div></div>';
    
    }
    
    
    
    
}
function load_and_display_pvinteractions(array $gene_id, array $proteins_id, MongoCollection $interactionsCollection,$species='null'){
    
    $result=get_hpidb_plant_virus_interactor($proteins_id,$interactionsCollection,$species); 
    
    $hits_number_hpidb= count($result['result']);
    
    if ($hits_number_hpidb>0){
        echo'
            <div class="panel-group" id="accordion_documents_hpidb">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#hpidb2" data-parent="#accordion_documents_hpidb" data-toggle="collapse">
                            <strong> Plant Virus Interaction (Host Pathogen Interaction DataBase)</strong> ('.$hits_number_hpidb.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="hpidb2">';

                        echo'
                        <div class="pv_interaction">';
                            $headers=array('Database identifier','Protein alias','Uniprot','Pubmed','Author','Pathogen','Detection_method');
                            $values=array();
                            foreach ($result['result'] as $value) {
                                
                                
                                foreach ($value as $data) {
                                    
                                    //HREF_DB_ID
                                    $href_db_id="";
                                    if (strstr($data['database_identifier'],"|")){
                                        $split_db_id=explode("|", $data['database_identifier']);
                                        foreach ($split_db_id as $db_id) {
                                            $split_id=explode(":", $db_id);
                                            $href_db_id.=' <a href="http://www.ebi.ac.uk/intact/interaction/'.$split_id[1].'">'.$split_id[1].'</a> ';
                                        }                                        
                                    }
                                    else{
                                        $split_id=explode(":", $data['database_identifier']);
                                        $href_db_id.=' <a href="http://www.ebi.ac.uk/intact/interaction/'.$split_id[1].'">'.$split_id[1].'</a> ';

                                    }
                                    array_push($values, $href_db_id);
                                    

                                    //ALIAS
                                    $alias_string="";
                                    $already_in=array();
                                    if (strstr($data['protein_alias_2'],"|")){
                                        $aliases=explode("|", $data['protein_alias_2']);
                                        $alias_counter=0;
                                        foreach ($aliases as $alias) {
                                           
                                            $short=explode(":", $alias);
                                            $name=explode("(", $short[1]);
                                            if (!in_array($name[0], $already_in)){
                                                if ($alias_counter===count($aliases)-1){
                                                    $alias_string.=$name[0];
                                                }
                                                else{
                                                    $alias_string.=$name[0].",";
                                                }                                   
                                                array_push($already_in, $name[0]);
                                            } 
                                        }
                                    }
                                    else{
                                       $short=explode(":", $data['protein_alias_2']);
                                       $name=explode("(", $short[1]);
                                       $alias_string.=$name[0]." ";
                                    }
                                    
                                    
                                    array_push($values, $alias_string);
                                    
                                    //UNIPROT
                                    $href_uniprot='<a href="http://www.uniprot.org/uniprot/'.$data['Virus Uniprot ID'].'">'.$data['Virus Uniprot ID'].'</a>';
                                    array_push($values, $href_uniprot);
                                    
                                    //PUBMED ID
                                    $href_pmid='<a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$data['pmid'].'">'.$data['pmid'].'</a>';
                                    array_push($values, $href_pmid);
                                    
                                    //AUTHOR NAME
                                    array_push($values, $data['author_name']);
                                    //VIRUS NAME
                                    array_push($values, $data['virus']);

                                    //DETECTION METHOD
                                    $id_string_method="";
                                    $split_method=explode('psi-mi:', $data['detection_method']);
                                    $split_method_bis=explode('(', $split_method[1]);
                                    $split_method_ter=explode(')', $split_method_bis[1]);
                                    $method_name=$split_method_ter[0];
                                    $id_method=$split_method_bis[0];
                                    $id_string_method.=' <a href="http://www.ebi.ac.uk/ontology-lookup/?termId='.$id_method.'"> '.$id_method.' </a> ';
                                    $id_string_method.= '('.$method_name.')';
                                    array_push($values, $id_string_method);

                                }

                            }
                            pretty_table($headers, $values, "pv_hpidb");
                            
                            
                        echo'</div>';

                    echo'
                    </div></div></div>';
    }
    $result2=get_litterature_plant_virus_interactor($gene_id,$interactionsCollection,$species); 
    $hits_number_litterature= count($result2['result']);
    if ($hits_number_litterature>0){
        echo'
                <div class="panel-group" id="accordion_documents_litterature">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <a class="accordion-toggle collapsed" href="#litterature" data-parent="#accordion_documents_litterature" data-toggle="collapse">
                                <strong> Plant Virus Interaction (litterature)</strong> ('.$hits_number_litterature.')
                            </a>				

                        </div>
                        <div class="panel-body panel-collapse collapse" id="litterature">';

                            echo'
                            <div class="pv_interaction">';

                                $headers=array('Virus_symbol','Method','Reference','Virus','Host');
                                $values=array();
                                foreach ($result2['result'] as $value) {
                                    foreach ($value as $data) {
                                        
                                        
                                       
                                       
                                       array_push($values, $data['Virus_symbol']); 
                                       array_push($values, $data['method']);
                                       array_push($values, $data['Reference']);
                                       array_push($values, $data['virus']);
                                       array_push($values, $data['species']);


                                    }

                                }
                                pretty_table($headers, $values, "pv_litterature");
                            echo'</div>';

                        echo'
                        </div>
                    </div>
                </div>';
    
    }
    
    
}
function load_and_display_sequences_data($sequencesCollection,$gene_id,$gene_id_bis){
    echo'<div id="sequences_section">
                    <h3>Sequences</h3>';
                    //$timestart=microtime(true); 
                    $transcript_id=count_transcript_for_gene($sequencesCollection,$gene_id,$gene_id_bis);
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for sequences 1  executed in " . $page_load_time . " sec"; 
              echo '<div>'
                    . ' About this gene: This gene has '.count($transcript_id).' transcripts'
                . '</div>'
                . '</br>';
               //$timestart=microtime(true); 
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
                                                    
                                                    
                                                    
                                                    echo  '<button onclick="myFunction(this)" data-id="'.str_replace(".", "__", $values['Transcript ID']).'"  data-sequence="'.$values['Transcript Sequence'].'" id="blast_button" type="button">Blast sequence</button>';
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
             
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for sequences 2 executed in " . $page_load_time . " sec"; 
//                    $timestart=microtime(true);
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
//                    $timeend=microtime(true);
//                    $time=$timeend-$timestart;
//                    //Afficher le temps d'éxecution
//                    $page_load_time = number_format($time, 3);
//                    echo "Debut du script: ".date("H:i:s", $timestart);
//                    echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                    echo "<br>Script for sequences 3 executed in " . $page_load_time . " sec"; 
          echo '</div>';
}
function load_and_display_interactions($full_mappingsCollection,$gene_id,$uniprot_id,$transcript_id,$pv_interactionsCollection,$pp_interactionsCollection,$species){
    
  
    
    load_and_display_pvinteractions($gene_id,$uniprot_id,$pv_interactionsCollection,$species);
    load_and_display_ppinteractions($full_mappingsCollection,$gene_id,$uniprot_id,$transcript_id,$pp_interactionsCollection,$species);
    
}


function load_and_display_interactions_old($gene_id,$gene_alias,$descriptions, $gene_symbol,$proteins_id,$species,$interactionsCollection){
    //get all interactor for each dataset (biogrid, intact, hipdb, etc..)
            
    $interaction_array=get_interactor($gene_id,$gene_alias,$descriptions, $gene_symbol,$proteins_id,$species,$interactionsCollection);
    $counter=0;
    //$timestart=microtime(true);
    foreach ($interaction_array as $array){
        if ($counter===0){
            $total_protein_hpidb=count($array);

        }
        if ($counter===1){

            $total_protein_intact=count($array);

        }
        else if ($counter===2){

            $total_protein_litterature=0;
            foreach ($array as $intact){
                $total_protein_litterature++;
            }
        }
        else{

            $total_protein_biogrid=0;
            $tgt="";
            $tgt_array=array();


            foreach ($array as $biogrid){
                //foreach ($biogrid as $data) {
                foreach ($biogrid as $key=>$value) {
                    //echo "key: ". $key. " and value: " . $value."<br>";
                    if( $key=="INTERACTOR B"){
                        $tgt=$value;
                    }

//                                foreach ($data as $key=>$value) {
//                                    if( $key=="tgt"){
//                                       $tgt=$value; 
//                                    }
//                                }
//                                error_log($value[0]);
//                                if ($value[0]=="tgt"){
//                                    $tgt=$value[1];
//                                }                                
                }
                if (in_array($tgt,$tgt_array)===FALSE){
                    //echo "interactor to add ".$tgt."<br>";
                   array_push($tgt_array, $tgt);
                   $total_protein_biogrid++; 
                }


            }

        }
        $counter++;
    }

    $counter=0;
    $pub_list=array();
    foreach ($interaction_array as $array){


        if ($counter==0){
            //error_log('in counter value: '.$counter);               
            echo'
            <div class="panel-group" id="accordion_documents">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#hpidb2" data-parent="#accordion_documents" data-toggle="collapse">
                            <strong> Host Pathogen Interaction (hpidb2)</strong> ('. $total_protein_hpidb.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="hpidb2">';

                        echo'
                        <div class="goProcessTerms goTerms">';

                        echo'';

                        $total_protein_hpidb=0;
                        foreach ($array as $hpidb){
                            $string_seq='<ul><span class="goTerm">';
                            foreach ($hpidb as $values){
                                foreach ($values as $key=>$value){



                                    //error_log('key: '.$key.'and value: '.$value);
                                    if ($key=='src'){

                                        $string_seq.='<li value='.$value.'> host protein: <a href="http://www.uniprot.org/uniprot/'.$value.'">'.$value.'</a></li>';

                                    }
                                    elseif ($key=='tgt') {
                                         $tgt=$value;
                                        $string_seq.='<li value='.$value.'> viral protein: <a href="http://www.uniprot.org/uniprot/'.$value.'">'.$value.'</a></li>';

                                    }
                                    elseif ($key=='method') {
                                         $string_seq.='<li value='.$value.'> method: '.$value.'</li>';

                                    }            
                                    elseif ($key=='pub') {
                                         $string_seq.='<li value='.$value.'> publication: <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$value.'">'.$value.'</a></li>';
                                         $found=FALSE;
                                         foreach ($pub_list as $pub) {
                                             if ($value==$pub){
                                                 $found=TRUE;
                                             }
                                         }
                                         if ($found==FALSE){
                                             array_push($pub_list, $value);
                                         }



                                    }
                                    elseif ($key=='src_name') {
                                        $string_seq.='<li value='.$value.'> host name: '.$value.'</li>';

                                    }
                                    elseif ($key=='tgt_name') {
                                        $string_seq.='<li value='.$value.'> virus name: '.$value.'</li>';

                                    }
                                    elseif ($key=='host_taxon') {
                                        $string_seq.='<li value='.$value.'> host taxon: '.$value.'</li>';

                                    }
                                    elseif ($key=='virus_taxon') {
                                        $string_seq.='<li value='.$value.'> virus taxon: '.$value.'</li>';

                                    }
                                    else{

                                    }
                                }


                            }
                            $string_seq.='</ul></span>';
                            add_accordion_panel($string_seq, $tgt, $tgt);
                            $total_protein_hpidb++;

                        }
                        //$counter++;
                        echo'
                        </div>';

                    echo'
                    </div></div></div>';
        }
        elseif ($counter==1){
            echo'
            <div class="panel-group" id="accordion_documents">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#intact" data-parent="#accordion_documents" data-toggle="collapse">
                            <strong> IntAct plant/plant interaction </strong> ('. $total_protein_intact.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="intact">';

                        echo'
                        <div class="goProcessTerms goTerms">';

                        echo'';

                        $total_protein_intact=0;
                        foreach ($array as $intact){
                            $string_seq='<ul><span class="goTerm">';
                            foreach ($intact as $attributes){

                                if ($attributes[0]=='src'){

                                    $string_seq.='<li value='.$attributes[1].'> Host protein A: <a href="http://www.uniprot.org/uniprot/'.$attributes[1].'">'.$attributes[1].'</a></li>';

                                }
                                elseif ($attributes[0]=='tgt') {
                                     $tgt=$attributes[1];
                                    $string_seq.='<li value='.$attributes[1].'> Host protein B: <a href="http://www.uniprot.org/uniprot/'.$attributes[1].'">'.$attributes[1].'</a></li>';

                                }
                                elseif ($attributes[0]=='method') {
                                     $string_seq.='<li value='.$attributes[1].'> method: '.$attributes[1].'</li>';

                                }

                                elseif ($attributes[0]=='pub') {
                                     $string_seq.='<li value='.$attributes[1].'> publication: <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$attributes[1].'">'.$attributes[1].'</a></li>';
                                     $found=FALSE;
                                     foreach ($pub_list as $pub) {
                                         if ($attributes[1]==$pub){
                                             $found=TRUE;
                                         }
                                     }
                                     if ($found==FALSE){
                                         array_push($pub_list, $attributes[1]);
                                     }



                                }
                                elseif ($attributes[0]=='src_name') {
                                    $string_seq.='<li value='.$attributes[1].'> Host A: '.$attributes[1].'</li>';

                                }
                                elseif ($attributes[0]=='tgt_name') {
                                    $string_seq.='<li value='.$attributes[1].'> Host B: '.$attributes[1].'</li>';

                                }
//                                            elseif ($attributes[0]=='host_taxon') {
//                                                $string_seq.='<li value='.$ $attributes[1].'> host taxon: '.$attributes[1].'</li>';
//
//                                            }
//                                            elseif ($attributes[0]=='virus_taxon') {
//                                                $string_seq.='<li value='.$ $attributes[1].'> virus taxon: '.$attributes[1].'</li>';
//
//                                            }
                                else{

                                }


                            }
                            $string_seq.='</ul></span>';
                            add_accordion_panel($string_seq, $tgt, $tgt);
                            $total_protein_intact++;

                        }
                        //$counter++;
                        echo'
                        </div>';

                    echo'
                    </div></div></div>';
        }
        elseif ($counter==2){
            echo'


            <div class="panel-group" id="accordion_documents">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#litterature" data-parent="#accordion_documents" data-toggle="collapse">
                            <strong> Litterature plant/virus </strong> ('.  $total_protein_litterature.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="litterature">
                    ';

                    echo'
                    <div class="goProcessTerms goTerms">

                    ';
                    $total_protein_litterature=0;
                    foreach ($array as $lit){

                        $string_seq='<ul><span class="goTerm">';
                        foreach ($lit as $attributes){


                            if ($attributes[0]=='src'){
                                $string_seq.='<li value='.$attributes[1].'> host protein: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='tgt') {
                                $tgt=$attributes[1];
                                $string_seq.='<li value='.$attributes[1].'> viral protein: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='method') {
                                $string_seq.='<li value='.$attributes[1].'> method: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='pub') {
                                $string_seq.='<li value='.$attributes[1].'> publication: <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$attributes[1].'">'.$attributes[1].'</a></li>';
                                $found=FALSE;
                                foreach ($pub_list as $pub) {
                                    if ($attributes[1]==$pub){
                                        $found=TRUE;
                                    }
                                }
                                if ($found==FALSE){
                                    array_push($pub_list, $attributes[1]);
                                }
                            }
                            elseif ($attributes[0]=='host_name') {
                                $string_seq.='<li value='.$attributes[1].'> host name: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='virus_name') {
                                $string_seq.='<li value='.$attributes[1].'> viral name: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='Accession_number') {
                                $string_seq.='<li value='.$attributes[1].'> Accession number: '.$attributes[1].'</li>';
                            }
                            elseif ($attributes[0]=='Putative_function') {
                                $string_seq.='<li value='.$attributes[1].'> Putative function: '.$attributes[1].'</li>';
                            }
                            else{

                            }


                        }
                        $string_seq.='</ul></span>';
                        add_accordion_panel($string_seq, $tgt, $tgt);
                        $total_protein_litterature++;

                    }
                    //$counter++;


                    echo'
                    </div>';

                echo'
                </div>
            </div></div>';
        }
        else{
            echo'


            <div class="panel-group" id="accordion_documents">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <a class="accordion-toggle collapsed" href="#biogrid" data-parent="#accordion_documents" data-toggle="collapse">
                            <strong> Biogrid plant/plant interaction </strong> ('.  $total_protein_biogrid.')
                        </a>				

                    </div>
                    <div class="panel-body panel-collapse collapse" id="biogrid">
                    ';

                    echo'
                    <div class="goProcessTerms goTerms">

                    ';
                    $total_protein_biogrid=0;
                    $tgt="";
                    $tgt_array=array();
                    foreach ($array as $biogrid){
                //foreach ($biogrid as $data) {

                    //foreach ($array as $lit){

                        $string_seq='<ul><span class="goTerm">';

                        //foreach ($lit as $attributes){

                        foreach ($biogrid as $key=>$value) {
                                if( $key=="INTERACTOR B"){
                                    $tgt=$value;
                                    $string_seq.='<li value='.$value.'> '.$key.': '.$value.'</li>';

                                }
                                elseif ($key=='publication') {
                                    $string_seq.='<li value='.$value.'> publication: <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$value.'">'.$value.'</a></li>';
                                    $found=FALSE;
                                    foreach ($pub_list as $pub) {
                                    if ($value==$pub){
                                        $found=TRUE;
                                    }
                                }
                                    if ($found==FALSE){
                                    array_push($pub_list, $value);
                                }
                                }
                                else{
                                    $string_seq.='<li value='.$value.'> '.$key.': '.$value.'</li>';

                                }
//                                    if ($key=='src'){
//                                        $string_seq.='<li value='.$value.'> protein A: '.$value.'</li>';
//                                    }
//                                    elseif ($key=='tgt') {
//                                        $tgt=$value;
//
//
//
//                                        //http://plants.ensembl.org/Arabidopsis_thaliana/Search/Results?species=Arabidopsis%20thaliana;idx=;q=FKF1;site=ensemblunit                                            if (){
//                                        //http://plants.ensembl.org/Arabidopsis_thaliana/Search/Results?species=Arabidopsis%20thaliana;idx=;q=CUL1;site=ensemblunit
//                                        $string_seq.='<li value='.$value.'> protein B: '.$value.'</li>';
//                                    }
//                                    elseif ($key=='method') {
//                                        $string_seq.='<li value='.$value.'> method: '.$value.'</li>';
//                                    }
//                                    elseif ($key=='pub') {
//                                        $string_seq.='<li value='.$value.'> publication: <a href="http://www.ncbi.nlm.nih.gov/pubmed/'.$value.'">'.$value.'</a></li>';
//                                        $found=FALSE;
//                                        foreach ($pub_list as $pub) {
//                                            if ($value==$pub){
//                                                $found=TRUE;
//                                            }
//                                        }
//                                        if ($found==FALSE){
//                                            array_push($pub_list, $value);
//                                        }
//                                    }
//                                    elseif ($key=='host A name') {
//                                        $string_seq.='<li value='.$value.'> host name A: '.$value.'</li>';
//                                    }
//                                    elseif ($key=='host B name') {
//                                        $string_seq.='<li value='.$value.'> host name B: '.$value.'</li>';
//                                    }
//                                    elseif ($key=='Accession_number') {
//                                        $string_seq.='<li value='.$value.'> Authors: '.$value.'</li>';
//                                    }
////                                        elseif ($attributes[0]=='Putative_function') {
////                                            $string_seq.='<li value='.$ $attributes[1].'> Putative function :'.$attributes[1].'</li>';
////                                        }
//                                    else{
//
//                                    }


                        }
                        $string_seq.='</ul></span>';
                        if (in_array($tgt,$tgt_array)===FALSE){
                            array_push($tgt_array, $tgt);
                            add_accordion_panel($string_seq, $tgt, $tgt);
                            $total_protein_biogrid++;
                        }


                    }

                    //$counter++;


                    echo'
                    </div>';

                echo'
                </div>
            </div></div>';
        }
        $counter++;
    }
    
    
    
}
function pretty_table(array $headers, array $values, $_id='null'){

                            //echo count($headers);
                            //echo count($values);
                            $id='pretty_table_'.$_id;
                            echo'<table class="table" id="'.$id.'"> 
                                    <thead>
                                    <tr>';
                                    foreach ($headers as $header) {

                                        echo "<th>".$header."</th>";
   
                                    }
                               echo'</tr>
                                    </thead>
                                    <tbody>';
                            
                                    //$timestart=microtime(true);
                                    $counter=0;    
                                    foreach ($values as $value) {
                                        //echo 'counter'.$counter.'</br>';
                                        if ($counter===0 ){
                                            echo "<tr><td>".$value."</td>";
                                            $counter++;
                                        }
                                        elseif ($counter===count($headers)-1) {
                                            echo "<td>".$value."</td></tr>";
                                            $counter=0;
                                        }
                                        else{
                                            echo "<td>".$value."</td>";
                                            $counter++;
                                        }
                                        
                                    
   
                                    }
                                echo'</tbody>

                                </table>';
}
function load_and_display_orthologs($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id){
    
   // if (count($var_results['result'])>0){
        echo'<div id="ortholog_section">
                <h3>Orthologs</h3>
                    <div class="panel-group" id="accordion_documents">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#ortho-table_'.$plaza_id.'" data-parent="#accordion_documents" data-toggle="collapse">
                                            <strong>Homologs table</strong>
                                    </a>				

                            </div>
                            <div class="panel-body panel-collapse collapse" id="ortho-table_'.$plaza_id.'">';

                                        //$timestart=microtime(true);
                                        if (get_ortholog_table($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id)===""){
                                            echo 'No results found';
                                        }
                                        else{
                                            echo get_ortholog_table($full_mappingsCollection,$orthologsCollection,$organism,$plaza_id);

                                        }
        //                                        $timeend=microtime(true);
        //                                        $time=$timeend-$timestart;
        //
        //                                        //Afficher le temps d'éxecution
        //                                        $page_load_time = number_format($time, 3);
        //                                        echo "Debut du script: ".date("H:i:s", $timestart);
        //                                        echo "<br>Fin du script: ".date("H:i:s", $timeend);
        //                                        echo "<br>Script aggregate and var dump execute en " . $page_load_time . " sec";
                               echo'
                            </div>

                        </div>
                    </div>
                    <div id="shift_line"></div>
                </div>';
    }
//}
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
function make_gene_id_text_list($path='null'){

echo '
    <!--<div class="tinted-box">-->
    <div id="ListSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<form action="'.$path.'/src/multi-search.php" method="get" class="clear search-form homepage-search-form">
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
function make_species_list($cursor,$path='null'){

    
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
    	<form action="'.$path.'/src/Multi-results.php" target="_blank" method="get" class="clear search-form homepage-search-form">
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
                                    if ($line!="Prunus armeniaca" && $line!="Prunus domestica"){
                                        echo '<option value="'.$line.'">'.$line.'</option>';
                                    }
                            }
                            echo '</select>
                                    <label for="search">for</label>
                            </span>
                            <wbr/>
                            <span class="inp-group">
                                    <input value="" name="search" class="_string input inactive query optional ftext" id="search" type="text" size="30" required/>
                                    <i class="fa fa-search"></i> <span><input value="Search" class="fbutton" type="submit" /></span>
                            </span>
                            <wbr/>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" target="_blank" href="'.$path.'/src/result_search_5.php?organism=Arabidopsis+thaliana&search=AT1G75950">AT1G75950</a> 
    						or 
    						<a class="nowrap" target="_blank" href="'.$path.'/src/result_search_5.php?organism=Arabidopsis+thaliana&search=ATCG01100">ATCG01100</a>
    						
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
<!--<script type="text/javascript">
$(document).ready(function() {
		$('#pretty_table').dataTable( {
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
    
</script>-->