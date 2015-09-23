<?php

include 'simple_html_dom.php';
### Connexion
function mongoConnector() {

	try
	{
		$m = new Mongo(); // connect
    		$db = $m->selectDB("cobra_db");
	}
	catch ( MongoConnectionException $e )
	{
    		echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
    		exit();
	}
	return $db;	
}
function mongoPersistantConnector() {

	try
	{
		//$m = new Mongo(); // connect
		$m = new MongoClient("localhost:27017", array("persist" => "x"));
    		$db = $m->selectDB("cobra_db");
	}
	catch ( MongoConnectionException $e )
	{
    		echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
    		echo $e->getMessage();
		exit();
	}
}
function make_orthologs_page($gene_list_attributes,$species='null'){
    foreach ($gene_list_attributes as $attributes) {



            $cpt=0;
            foreach ($attributes as $key => $value) {
                if ($cpt==0){

                    echo '<div style="cursor: pointer;" onclick="window.location=\'/src/result_search_5.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['search'].'\';" class="resultsbox" id="results">
                            <div class="results-right">
                                <div class="organism"> Organism:'.$species.'</div>
                                <div class="infection agent"> Infection agent: '.$attributes['infection_agent'].'</div>

                            </div>
                            <div class="results-left">
                                <div class="officialSymbol"> Gene identifier: '.$attributes['search'].'</div>
                                <div class="logFC"> Log fold change: '.$attributes['logFC'].'</div>

                            </div>

                    </div>';
                }




                if ($value != "NA"){


                    if ($key=="plaza_id"){
                        echo 'key: '.$value;

                        echo'<div class="panel-group" id="accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3>
                                            <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-toggle="collapse">
                                                    Ortholog table 
                                                    <div id="organism" class="right"><h4>THALIANA</h4></div>
                                            </a>				
                                        </h3>
                                    </div>
                                    <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">

                                        <table class="table table-hover">                                                                
                                            <thead>
                                            <tr>';
                                                //echo "<th>Mapping type</th>";
                                                echo "<th>Gene ID</th>";
                                                echo "<th>Source</th>";
                                                //echo "<th>tgt ID</th>";
                                                echo "<th>Transcript/protein ID</th>";
                                                echo "<th>Source</th>";
                                                echo "<th>Species</th>";
                                                echo'
                                            </tr>
                                            </thead>

                                            <tbody>';
                                                echo 'before entering into table_ortholog';
                                                echo table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,$species,$value);

                                       echo'</tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>';    
                        
                        echo '<div id="shift_line"></div>';

                    }
                    
                }
                
                $cpt++;

            }

        }
}
function table_ortholog_string(MongoGridFS $grid,MongoCollection $mappingsCollection,Mongocollection $orthologsCollection,$species='null',$plaza_id='null'){
    //echo 'in ortholog table function';
    $cursor_array=get_all_orthologs($grid,$mappingsCollection,$orthologsCollection,$species,$plaza_id);
    return $cursor_array;
}
function get_n_top_diff_expressed_genes(Mongocollection $me, $species='null',$top_value=10,$type='null'){
    //echo $type;
    //echo $top_value;
    //echo $species;
    //$cursor=$me->find(array('direction'=>$type,'species' => $species,'gene'=>array('$ne'=>'')),array('_id'=>0,'gene' => 1,'logFC'=>1,'infection_agent'=>1));
    if ($type=="up"){
        $cursor=$me->find(array('direction'=>$type,'species' => $species,'gene'=>array('$ne'=>'')),array('_id'=>0,'gene' => 1,'logFC'=>1,'infection_agent'=>1))->sort(array('logFC'=>-1));
       //$cursor->sort(array('logFC'=>-1)); 
    }
    else{
       //$cursor->sort(array('logFC'=>1)); 
       $cursor=$me->find(array('direction'=>$type,'species' => $species,'gene'=>array('$ne'=>'')),array('_id'=>0,'gene' => 1,'logFC'=>1,'infection_agent'=>1))->sort(array('logFC'=>1));

    }
    
    $cursor->limit($top_value);
    return $cursor;
}
function get_ortholog_list_2(Mongocollection $ma,Mongocollection $me,Mongocollection $sp,$species,$type='null',$top_value=10){
    $gene_list=array();
    $timestart=microtime(true);
    $cursor=get_n_top_diff_expressed_genes($me,$species,$top_value,$type);
    $timeend=microtime(true);
    $time=$timeend-$timestart;

    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Script starting at: ".date("H:i:s", $timestart);
    echo "<br>Script ending at: ".date("H:i:s", $timeend);
    echo "<br>Script for top diff expressed genes executed in " . $page_load_time . " sec";
    foreach ($cursor as $value) {
        
        $gene_name=split('[.]', $value['gene']);
        //echo $gene_name[0];
        $value['gene']=$gene_name[0];
        echo 'gene to found : '.$value['gene'].'</br>';
        //$timestart=microtime(true);
        
        
        
        
//        $cursor2=$ma->aggregate(array(
//        array('$match' => array('type'=>'full_table')),  
//        //array('$match' => array('$and'=>array(array('type'=>'full_table'),array('species'=>$species)))),  
//        array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
//        array('$unwind'=>'$mapping_file'),
//        array('$match' => array('$or'=> array(array('mapping_file.Plaza ID'=>$value['gene']),array('mapping_file.Uniprot ID'=>$value['gene']),array('mapping_file.Protein ID 2'=>$value['gene']),array('mapping_file.Protein ID'=>$value['gene']),array('mapping_file.Alias'=>$value['gene']),array('mapping_file.Probe ID'=>$value['gene']),array('mapping_file.Gene ID'=>$value['gene']),array('mapping_file.Gene ID 2'=>$value['gene'])))),
//        array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0))));
        
        
        $cursor2=$ma->find(array('mapping_file.Protein ID'=>$value['gene']),array('mapping_file.$'=>1,'_id'=>0));
        foreach ($cursor2 as $data){
                $species=$data['species'];
                foreach ($data['mapping_file'] as $values){
                    array_push($gene_list,array('plaza_id'=>$values['Plaza ID'],'search'=>$value['gene'],'logFC'=>$value['logFC'],'infection_agent'=>$value['infection_agent']));

                }
        }
        
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Script starting at: ".date("H:i:s", $timestart);
//        echo "<br>Script ending at:".date("H:i:s", $timeend);
//        echo "<br>Script aggregate  executed in " . $page_load_time . " sec";

//        
//        foreach ($cursor2['result'] as $result) {
//            //echo 'result plaza id:'.$result['mapping_file']['Plaza ID'];
//            $plaza_id=$result['mapping_file']['Plaza ID'];
//            array_push($gene_list,array('plaza_id'=>$plaza_id,'search'=>$value['gene'],'logFC'=>$value['logFC'],'infection_agent'=>$value['infection_agent']));
//
//            
//            
//        }
    }
    
    return $gene_list;
    
}
function get_ortholog_list(Mongocollection $ma,Mongocollection $me,Mongocollection $sp,$species,$type='null',$top_value=10){
    //echo 'get the preferred id for this species : '.$species;
    $species_id_type=$sp->find(array('full_name'=>$species),array('preferred_id'=>1));
    foreach ($species_id_type as $value) {
        $favourite_id=$value['preferred_id'];
        //echo $value['preferred_id'].'</br>';
    
    }
    //get the target id for this species of the plza mapping table
    $plaza_favorite_tgt_id=$ma->find(array('type'=>array('$nin'=>array('gene_to_go')),'src'=>'plaza_gene_id','species'=>$species),array('tgt'=>1));
    //only one value is possible
    foreach ($plaza_favorite_tgt_id as $value) {
        $intermediary_id=$value['tgt'];
        //echo $value['tgt'].'</br>';
    
    }
    //get the n top genes in the transcriptomics data
    $cursor=get_n_top_diff_expressed_genes($me,$species,$top_value,$type);
    //$cursor=$measurementsCollection->find(array('species'=>'Solanum lycopersicum'),array('logFC'=>1));
    #$cursor=$measurementsCollection->find(array('direction'=>'up','species' => 'Solanum lycopersicum','gene'=>array('$ne'=>'')),array('gene' => 1,'logFC'=>1,'infection_agent'=>1));
    $gene_list=array();
    foreach ($cursor as $value) {
    //echo $value['logFC']."\n";
        //echo 'gene to found : '.$value['gene'].'</br>';
        array_push($gene_list,array('search'=>$value['gene'],'logFC'=>$value['logFC'],'infection_agent'=>$value['infection_agent']));
        
    //echo $value['infection_agent']."\n";
    }
    // At this point we have a list of n top-genes id,
    // we need to check if the species favourite id is equal
    // to the id needed to convert into plaza id
    
    
    //Same : direct conversion using plaza mapping table
    if ($favourite_id==$intermediary_id){
        //echo "same id";
        $gene_list_attributes=convert_without_intermediary_id_into_plaza_id_list($ma,$gene_list,$favourite_id,$species);

    }
    // here we need to first translate into intermediary id before translate into plaza id
    else{
        $transformed_list=convert_into_specific_id($ma,$gene_list,$favourite_id,$intermediary_id,$species);
        if (count($transformed_list)!=0){
            $gene_list_attributes=convert_with_intermediary_id_into_plaza_id_list($ma,$transformed_list,$intermediary_id,$species);
        }
               
        
    }
    return $gene_list_attributes;
}
function convert_into_specific_id(Mongocollection $ma,$gene_list,$favourite_id='null',$intermediary_id='null',$species='null'){
   
    //echo $favourite_id.'----'.$intermediary_id.'</br>';
    $query=array('species'=>$species,'src_to_tgt'=>array('$exists'=>true),'src'=>$favourite_id,'tgt'=>$intermediary_id);
    $fields=array('src_to_tgt'=>1);
    $mapping=$ma->find($query, $fields);
    
    $transformed_list=array();
    foreach ($mapping as $map_doc){
        
        $src_to_tgt = $map_doc['src_to_tgt'];
        foreach ($gene_list as $value) {
            //echo 'search: '.$value['search'].'</br>';
            array_push($transformed_list, get_target_from_source($src_to_tgt,$value,$value['search'],$favourite_id,$intermediary_id));
            
        }
       
    }
    return $transformed_list;
        
}
function get_gene_ontology_details(Mongocollection $ma,$species='null',$gene_id='null'){
    $query=array('species'=>$species,'src_to_tgt'=>array('$exists'=>true),'type'=>'gene_to_go');
    $fields=array('src_to_tgt'=>1);
    $mapping=$ma->find($query, $fields);
    $cursor=array();
    foreach ($mapping as $map_doc){
        
        $src_to_tgt = $map_doc['src_to_tgt'];
        
        
    }
    return $mapping; 
}
function get_plaza_id(Mongocollection $ma,Mongocollection $sp,$id='null',$species='null'){
    //first get the species
    if ($species=='All species'){
       $query=array($match=>array('src_to_tgt.0'=>$id));
        $fields=array('species'=>1);
        //then get th e corresponding plaza id
        $cursor=$ma->find($query, $fields);
        foreach ($cursor as $item){
            $species=$item['species'];
        } 
    }
    
    
    $species_id_type=$sp->find(array('full_name'=>$species),array('preferred_id'=>1));
    foreach ($species_id_type as $value) {
        $preferred_src_id=$value['preferred_id'];
        //echo $value['preferred_id'].'<br/>';
    
    }
    //get the target id for this species in the plaza mapping table
    $plaza_favourite_tgt_id=$ma->find(array('src'=>'plaza_gene_id','type'=>array('$nin'=>array('gene_to_go')),'species'=>$species),array('tgt'=>1));
    //only one value is possible
    
    foreach ($plaza_favourite_tgt_id as $value) {
        $plaza_tgt_id=$value['tgt'];
        //echo $value['tgt'].'<br/>';
    
    }
    $gene_list=array();
    echo 'id : '.$id.'<br/>';
    //$gene_list['gene']=$id;
    $gene_list=array(array('search'=>$id));
    
    $transformed_list=array();
    $plaza_id=array();
    if ($preferred_src_id==$plaza_tgt_id){
        //echo "same id";
        $plaza_id=convert_without_intermediary_id_into_plaza_id_list($ma,$gene_list,$plaza_tgt_id,$species);
        foreach ($plaza_id as $value) {
            //echo 'plaza id :'.$value['plaza_id'];
            $plaza_id_string=$value['plaza_id'];
        }

    }
    
    // here we need to first translate into intermediary id before translate into plaza id
    else{
        //echo 'intermediary id needed<br/>';
        $transformed_list=convert_into_specific_id($ma,$gene_list,$preferred_src_id,$plaza_tgt_id,$species);
        
        if (count($transformed_list)!=0){
            //echo 'id translated successfully:'.$transformed_list[0][$plaza_tgt_id];
            $plaza_id=convert_with_intermediary_id_into_plaza_id_list($ma,$transformed_list,$plaza_tgt_id,$species);
        }
        foreach ($plaza_id as $value) {
            //echo 'plaza id :'.$value['plaza_id'];
            $plaza_id_string=$value['plaza_id'];
        }
        
        
        
    }
    return $plaza_id_string;
    
    
	

}
function convert_with_intermediary_id_into_plaza_id_list(Mongocollection $ma,$gene_list_attributes,$plaza_tgt_id,$species='null'){
    //echo $plaza_tgt_id.'----'.$plaza_tgt_id;
    $cursor=array();
    foreach ($gene_list_attributes as $value) {
        //echo $value['search'];
        $plaza_id=$ma->aggregate(array(
            array('$match' => array('key'=>'PLAZA_conversion','src'=>'plaza_gene_id','species'=>$species)),   
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.'.$plaza_tgt_id=>$value['tgt'])), 
            array('$project' => array('mapping_file.plaza_gene_id'=>1,'_id'=>0))
            ));
        $cpt=0;
        foreach ($plaza_id['result'] as $result) {
            
            if ($cpt<1){
                //echo 'result : '.$result['mapping_file']['plaza_gene_id']; 
                $value['plaza_id']=$result['mapping_file']['plaza_gene_id'];
                array_push($cursor,$value);
                $cpt++;
            }
            
        }
        
    }
    return $cursor;
}
function convert_without_intermediary_id_into_plaza_id_list(Mongocollection $ma,$gene_list_attributes,$plaza_tgt_id,$species='null'){
    //echo $plaza_tgt_id.'----'.$plaza_tgt_id;
    $cursor=array();
    foreach ($gene_list_attributes as $value) {
        //echo $value['search'];
        $plaza_id=$ma->aggregate(array(
            array('$match' => array('key'=>'PLAZA_conversion','src'=>'plaza_gene_id','species'=>$species)),   
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.'.$plaza_tgt_id=>$value['search'])), 
            array('$project' => array('mapping_file.plaza_gene_id'=>1,'_id'=>0))
            ));
        $cpt=0;
        foreach ($plaza_id['result'] as $result) {
            
            if ($cpt<1){
                //echo 'result : '.$result['mapping_file']['plaza_gene_id']; 
                $value['plaza_id']=$result['mapping_file']['plaza_gene_id'];
                array_push($cursor,$value);
                $cpt++;
            }
            
        }
        
    }
    return $cursor;
}
function get_source_from_target($tgt_to_src,$value,$plaza_tgt_id='null'){
    //$tgt_and_src=array();
    //echo 'entering  get source from target'.$value['search'];
    //echo 'tgt from  src size : '.count($tgt_to_src);
    foreach ($tgt_to_src as $row){
        $found=FALSE;
        foreach ($row as $column){
            if (is_array($column)){                      
                if ($found){
                    $src=$column[0];
                    $value['plaza_id']=$column[0];
                    //echo 'found : '.$column[0];
                    
                }
            }  
            else {                         
                if ($column==$value['search'] || strstr($column, $value['search'])){
                    $found=TRUE;
                    $tgt=$column;
                    
                    //echo 'src : '.$column;    
                }
            }  
        }       
    }
    return $value;
}
function get_target_from_source($src_to_tgt,$value_array,$value='null',$favourite_id='null',$intermediary_id='null'){
    //$src_and_tgt=array();
    //echo 'entering get target from source'.$value;
    foreach ($src_to_tgt as $row){
        $found=FALSE;
        foreach ($row as $column){
            if (is_array($column)){                      
                if ($found){
                    $tgt=$column[0];
                    
                    //if (($tgt!="" )&& ($tgt!="NA")){
                        $value_array[$favourite_id]=$value;
                        $value_array['tgt']=$tgt;                           
                        //echo 'tgt : '.$column[0].'</br>';  
                    //}
                    
                }
            }  
            else {                         
                if ($column==$value){
                    $found=TRUE;                                               
                    //echo 'src : '.$column.'</br>';    
                }
            }  
        }       
    }
    return $value_array;
}

##Get all orthologs src to tgt : 
function get_interactor(array $gene_alias,array $descriptions,array $gene_symbol, array $protein_id,$species, MongoCollection $interactionsCollection){

    //need to have a list of symbol and a list of uniprot id to search in interactions table
    $global_intact_array=array();
    $pro_int_array=array();
    $lit_int_array=array();
    $biogrid_int_array=array();
    $intact_int_array=array();
    //$timestart=microtime(true);
    foreach ($protein_id as $id){
        
        $search=array("type"=>"prot_to_prot");
        $select=array('mapping_file'=>1,'pub'=>1,"method"=>1,"host_name"=>1,"virus_name"=>1,"src"=>1,"tgt"=>1,"host_taxon"=>1,"virus_taxon"=>1);
        $query=$interactionsCollection->find($search,$select);
        foreach ($query as $value) {
            
            
            //$src_to_tgt=$value['src_to_tgt'];
            $mapping_file=$value['mapping_file'];
//            echo 'from_mapping_file prot id :'.$id.'<br/>';
            foreach ($mapping_file as $mapping_doc) {
                
                
                $host_prot_id=$mapping_doc[$value['src']];
                $virus_prot_id=$mapping_doc[$value['tgt']];
                $method=$mapping_doc[$value['method']];
                $pub=$mapping_doc[$value['pub']];
                $hostname=$mapping_doc[$value['host_name']];
                $virusname=$mapping_doc[$value['virus_name']];
                $host_taxon=$mapping_doc[$value['host_taxon']];
                $virus_taxon=$mapping_doc[$value['virus_taxon']];
   
                if ($host_prot_id == $id){
                    $tmp_array=array();
//                    echo 'prot id mapped !!!!!:'.$id.'<br/>';
//                    echo $mapping_doc[$value['src']];
//                    echo $mapping_doc[$value['tgt']];
                    $src_array=array();
                    array_push($src_array, 'src');
                    array_push($src_array, $mapping_doc[$value['src']]);
                    array_push($tmp_array, $src_array);
                    $tgt_array=array();
                    array_push($tgt_array, 'tgt');
                    array_push($tgt_array, $mapping_doc[$value['tgt']]);
                    array_push($tmp_array, $tgt_array);
                    $method_array=array();
                    array_push($method_array, 'method');
                    array_push($method_array, $mapping_doc[$value['method']]);
                    array_push($tmp_array, $method_array);
                    $pub_array=array();
                    array_push($pub_array, 'pub');
                    array_push($pub_array, $mapping_doc[$value['pub']]);
                    array_push($tmp_array, $pub_array);
                    $host_name_array=array();
                    array_push($host_name_array, 'host_name');
                    array_push($host_name_array, $mapping_doc[$value['host_name']]);
                    array_push($tmp_array, $host_name_array);
                    $virus_name_array=array();
                    array_push($virus_name_array, 'virus_name');
                    array_push($virus_name_array, $mapping_doc[$value['virus_name']]);
                    array_push($tmp_array, $virus_name_array);
                    $host_taxon_array=array();                  
                    array_push($host_taxon_array, 'host_taxon');
                    array_push($host_taxon_array, $mapping_doc[$value['host_taxon']]);
                    array_push($tmp_array, $host_taxon_array);
                    $virus_taxon_array=array();
                    array_push($virus_taxon_array, 'virus_taxon');
                    array_push($virus_taxon_array, $mapping_doc[$value['virus_taxon']]);
                    array_push($tmp_array, $virus_taxon_array);
                    
                    array_push($pro_int_array, $tmp_array);

                    /*echo 'from_mapping_file host protein'.$host_prot_id.'<br/>';
                    echo 'from_mapping_file virus protein'.$virus_prot_id.'<br/>';
                    echo 'from_mapping_file method :'.$method.'<br/>';
                    echo 'from_mapping_file publication pmid : '.$pub.'<br/>';
                    echo 'from_mapping_file host name  :'.$hostname.'<br/>';
                    echo 'from_mapping_file virus name : '.$virusname.'<br/>';
                    echo 'from_mapping_file host taxon :'.$host_taxon.'<br/>';
                    echo 'from_mapping_file virus taxon :'.$virus_taxon.'<br/>'; 
                       */        
                }
            }     
        }
    }
    array_push($global_intact_array, $pro_int_array);
    foreach ($gene_symbol as $symbol){
        //echo $symbol;
        //$symbol='P58IPK';
        
		$cursor=$interactionsCollection->aggregate(array( 
			array('$unwind'=>'$mapping_file'), 
			array('$match'=> array('$or'=> array(array('mapping_file.Host_symbol'=>$symbol),array('mapping_file.Host_symbol'=>$gene_alias[0]),array('mapping_file.Host_symbol'=>$descriptions[0])))),
			array('$project' => array('mapping_file.Host_symbol'=>1,'mapping_file.Virus_symbol'=>1,'mapping_file.Putative_function'=>1,'mapping_file.host'=>1,'mapping_file.Accession_number'=>1,'mapping_file.Reference'=>1,'mapping_file.virus'=>1,'mapping_file.method'=>1,'_id'=>0)), 
		));
		if (count($cursor['result'])!=0){
			//echo '<h2> interactions was found for this gene '.$symbol.'</h2>';
			//var_dump($cursor);
			//echo '<dl class="dl-horizontal">';
			for ($i = 0; $i < count($cursor['result']); $i++) {
				$mapping_file=$cursor['result'][$i]['mapping_file'];
				
				//echo $mapping_file['Reference'];
//                echo'<dt>Host</dt>
//                <dd>'.$mapping_file['host'].'</dd>';
//                echo'<dt>Virus</dt>
//                <dd>'.$mapping_file['virus'].'</dd>';
//                echo'<dt>Viral Protein</dt>
//                <dd>'.$mapping_file['Virus_symbol'].'</dd>';
//                echo'<dt>Putative function</dt>
//                <dd>'.$mapping_file['Putative_function'].'</dd>';
//                echo'<dt>Reference</dt>
//                <dd>'.$mapping_file['Reference'].'</dd>';
//                echo'<dt>Accession number</dt>
//                <dd>'.$mapping_file['Accession_number'].'</dd>';
//                echo'<dt>Method</dt>
//                <dd>'.$mapping_file['method'].'</dd>';
                $tmp_array=array();

                $src_array=array();
                array_push($src_array, 'src');
                array_push($src_array, $symbol);
                array_push($tmp_array, $src_array);
                $tgt_array=array();
                array_push($tgt_array, 'tgt');
                array_push($tgt_array, $mapping_file['Virus_symbol']);
                array_push($tmp_array, $tgt_array);
                $method_array=array();
                array_push($method_array, 'method');
                array_push($method_array, $mapping_file['method']);
                array_push($tmp_array, $method_array);
                $pub_array=array();
                array_push($pub_array, 'pub');
                array_push($pub_array, $mapping_file['Reference']);
                array_push($tmp_array, $pub_array);
                $host_name_array=array();
                array_push($host_name_array, 'host_name');
                array_push($host_name_array, $mapping_file['host']);
                array_push($tmp_array, $host_name_array);
                $virus_name_array=array();
                array_push($virus_name_array, 'virus_name');
                array_push($virus_name_array, $mapping_file['virus']);
                array_push($tmp_array, $virus_name_array);
                $host_taxon_array=array();                  
                array_push($host_taxon_array, 'Accession_number');
                array_push($host_taxon_array, $mapping_file['Accession_number']);
                array_push($tmp_array, $host_taxon_array);
                $virus_taxon_array=array();
                array_push($virus_taxon_array, 'Putative_function');
                array_push($virus_taxon_array, $mapping_file['Putative_function']);
                array_push($tmp_array, $virus_taxon_array);
                    
                array_push($lit_int_array, $tmp_array);				  
			}
			//echo' </dl>';
		}
        
        
        //biogrid interaction data
        /*$interaction_data=$interactionsCollection->find(array('mapping_file.OFFICIAL_SYMBOL_A'=>$symbol),array('mapping_file.$'=>1,'species'=>1,'_id'=>0));
        foreach ($interaction_data as $data){
            $species=$data['species'];
            foreach ($data['mapping_file'] as $mapping_file){
                $tmp_array=array();

                $src_array=array();
                array_push($src_array, 'src');
                array_push($src_array, $symbol);
                array_push($tmp_array, $src_array);
                $tgt_array=array();
                array_push($tgt_array, 'tgt');
                array_push($tgt_array, $mapping_file['OFFICIAL_SYMBOL_B']);
                array_push($tmp_array, $tgt_array);
                $method_array=array();
                array_push($method_array, 'method');
                array_push($method_array, $mapping_file['EXPERIMENTAL_SYSTEM']);
                array_push($tmp_array, $method_array);
                $pub_array=array();
                array_push($pub_array, 'pub');
                array_push($pub_array, $mapping_file['PUBMED_ID']);
                array_push($tmp_array, $pub_array);
                $host_name_array=array();
                array_push($host_name_array, 'host A name');
                array_push($host_name_array, $species);
                array_push($tmp_array, $host_name_array);
                $virus_name_array=array();
                array_push($virus_name_array, 'host B name');
                array_push($virus_name_array, $species);
                array_push($tmp_array, $virus_name_array);
                $host_taxon_array=array();                  
                array_push($host_taxon_array, 'Accession_number');
                array_push($host_taxon_array, $mapping_file['SOURCE']);
                array_push($tmp_array, $host_taxon_array);
//                $virus_taxon_array=array();
//                array_push($virus_taxon_array, 'Putative_function');
//                array_push($virus_taxon_array, $mapping_file['Putative_function']);
//                array_push($tmp_array, $virus_taxon_array);
                    
                array_push($biogrid_int_array, $tmp_array);		
            }
            
        }*/
        //$timestart=microtime(true);
        $cursor=$interactionsCollection->aggregate(array( 
			array('$unwind'=>'$mapping_file'), 
			array('$match'=> array('$or'=> array(array('mapping_file.OFFICIAL_SYMBOL_A'=>$symbol),array('mapping_file.OFFICIAL_SYMBOL_A'=>$gene_alias[0]),array('mapping_file.OFFICIAL_SYMBOL_A'=>$descriptions[0])))),
			array('$project' => array('mapping_file.OFFICIAL_SYMBOL_A'=>1,'mapping_file.OFFICIAL_SYMBOL_B'=>1,'species'=>1,'mapping_file.SOURCE'=>1,'mapping_file.PUBMED_ID'=>1,'mapping_file.EXPERIMENTAL_SYSTEM'=>1,'_id'=>0)), 
		));
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Script starting at: ".date("H:i:s", $timestart);
//        echo "<br>Script ending at: ".date("H:i:s", $timeend);
//        echo "<br>Script for aggregation function executed in " . $page_load_time . " sec";
        //$timestart=microtime(true);
        if (count($cursor['result'])!=0){
			//echo '<h2> interactions was found for this gene '.$symbol.'</h2>';
			//var_dump($cursor);
			//echo '<dl class="dl-horizontal">';
			for ($i = 0; $i < count($cursor['result']); $i++) {
				$mapping_file=$cursor['result'][$i]['mapping_file'];
                $species=$cursor['result'][$i]['species'];
                $tmp_array=array();

                $src_array=array();
                array_push($src_array, 'src');
                array_push($src_array, $symbol);
                array_push($tmp_array, $src_array);
                $tgt_array=array();
                array_push($tgt_array, 'tgt');
                array_push($tgt_array, $mapping_file['OFFICIAL_SYMBOL_B']);
                array_push($tmp_array, $tgt_array);
                $method_array=array();
                array_push($method_array, 'method');
                array_push($method_array, $mapping_file['EXPERIMENTAL_SYSTEM']);
                array_push($tmp_array, $method_array);
                $pub_array=array();
                array_push($pub_array, 'pub');
                array_push($pub_array, $mapping_file['PUBMED_ID']);
                array_push($tmp_array, $pub_array);
                $host_name_array=array();
                array_push($host_name_array, 'host A name');
                array_push($host_name_array, $species);
                array_push($tmp_array, $host_name_array);
                $virus_name_array=array();
                array_push($virus_name_array, 'host B name');
                array_push($virus_name_array, $species);
                array_push($tmp_array, $virus_name_array);
                $host_taxon_array=array();                  
                array_push($host_taxon_array, 'Accession_number');
                array_push($host_taxon_array, $mapping_file['SOURCE']);
                array_push($tmp_array, $host_taxon_array);
//                $virus_taxon_array=array();
//                array_push($virus_taxon_array, 'Putative_function');
//                array_push($virus_taxon_array, $mapping_file['Putative_function']);
//                array_push($tmp_array, $virus_taxon_array);
                    
                array_push($biogrid_int_array, $tmp_array);				
                
            }
        }
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Script starting at: ".date("H:i:s", $timestart);
//        echo "<br>Script ending at: ".date("H:i:s", $timeend);
//        echo "<br>Script for building array function executed in " . $page_load_time . " sec";
		
	}
    array_push($global_intact_array, $lit_int_array);
    array_push($global_intact_array, $biogrid_int_array);
//    $timeend=microtime(true);
//    $time=$timeend-$timestart;
//    //Afficher le temps d'éxecution
//    $page_load_time = number_format($time, 3);
//    echo "Script starting at: ".date("H:i:s", $timestart);
//    echo "<br>Script ending at: ".date("H:i:s", $timeend);
//    echo "<br>Script for get_interactor function executed in " . $page_load_time . " sec";
    return $global_intact_array;
}
function get_plaza_orthologs(MongoGridFS $grid,Mongocollection $or, $species='null', $gene_id='null',$key='null'){
	
	#ask for the right species files
	
	$cursor=$or->find(array('mapping_file.species' => $species ),array('_id'=>0, 'mapping_file'=>array('$elemMatch'=> array('species' => $species))));
    $file_path='';
	foreach ( $cursor as $array ){
		foreach ($array['mapping_file'] as $key=>$value ){
			
			
			foreach ($value as $type=>$filename ){
				if ($type=="file"){
                  $file_path=$filename;
                    //echo $filename;
				}
			#foreach ($value as $filename ){
			#		echo $filename;
			
			
		
			// foreach ($value as $keys=>$values ){
// 				echo $keys;
// 				echo $values;
// 				$filename=$keys;
// 				#if ($keys=="file"){
// 				#	$filename=$values;
// 				#	echo $values;
// 				#}
			}
		}
	}
	#echo "this is the corresponding orthology file : ".$filename;
	
	
	//$MongoGridFSCursor=array();
	$MongoGridFSCursor= $grid->find(array('data_file'=>$file_path));
	
    ##function to retrieve 

    return $MongoGridFSCursor;

}
### Find all synonyms
function get_all_synonyms(Mongocollection $sp, $key='null', $value='null'){
    #echo "entering get all synonyms";
    $cursor=array();
    try
    {
        $cursor=$sp->aggregate(array(
        array('$match' => array($key => $value)),
        array('$unwind' => '$aliases'),
        array('$project' => array('aliases' => 1,'full_name' => 1,'name' => 1,'abbrev_name' => 1, '_id' => 0))
        ));
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\t get any synonyms, Check your key and value?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function get_grid_file(MongoGridFS $grid,Mongocollection $collection,$species='null',$src='null'){
   	$cursor=$collection->find(array('mapping_file.species' => $species ),array('_id'=>0, 'mapping_file'=>array('$elemMatch'=> array('species' => $species))));
    
    $file_path='';
	foreach ( $cursor as $array ){
		foreach ($array['mapping_file'] as $key=>$value ){
			
			
			foreach ($value as $type=>$filename ){
				if ($type=="file"){
                  $file_path=$filename;
                    //echo $filename;
				}
			#foreach ($value as $filename ){
			#		echo $filename;
			
			
			
			// foreach ($value as $keys=>$values ){
// 				echo $keys;
// 				echo $values;
// 				$filename=$keys;
// 				#if ($keys=="file"){
// 				#	$filename=$values;
// 				#	echo $values;
// 				#}
			}
		}
	}
    $MongoGridFSCursor= $grid->find(array('data_file'=>$file_path));
	
    ##function to retrieve 

    return $MongoGridFSCursor;
   
}
function small_table_ortholog_string(MongoCollection $mappingsCollection,Mongocollection $orthologsCollection,$species='null',$plaza_id='null'){
    $cursor_array=get_ortholog($mappingsCollection,$orthologsCollection,$species,$plaza_id);
    return $cursor_array;
}
function read_grid_plaza_mapping_file(MongoGridFS $grid, MongoCollection $mappingsCollection,$filename='null',$src='null'){
   	echo 'entering read grid plaza file : '.$filename.$src;
    $go_list_term=array();
    $already_added_go_terms=array();
    $timestart1=microtime(true);
    //$MongoGridFSCursor=  get_grid_file($grid, $mappingsCollection,$speciesID,$src);
    $MongoGridFSCursor= $grid->find(array('data_file'=>$filename));
    $species=$mappingsCollection->find(array('mapping_file.file'=>$filename),array('mapping_file.species'=>1));
    foreach ($species as $array){  
        foreach ($array['mapping_file'] as $key=>$value ){
            if ($key=='species'){
                $species_name=$value;
            }
        }
    }
    $timeend1=microtime(true);
    $time=$timeend1-$timestart1;
    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Debut du script: ".date("H:i:s", $timestart1);
    echo "<br>Fin du script: ".date("H:i:s", $timeend1);
    echo "<br>Script read grid plaza file search species execute en " . $page_load_time . " sec";
    echo '<hr>';
       
       
            
                                   
             
    foreach($MongoGridFSCursor as $MongoGridFSFile) {
        echo 'reading grid file';
        $stream = $MongoGridFSFile->getResource();
        if ($stream) {
            #while (($buffer = fgets($stream, 4096)) !== false) {
            $cpt=0;
            $timestart2=microtime(true);
            while (($buffer = stream_get_line($stream, 1024, "\n")) !== false) {
                //echo $buffer.'<br>';
                $row=preg_split('/\t+/', $buffer);
                //echo $row[0].'<br>';

                if ($src==str_replace("\"", "", $row[2])){//specific to tomato file
                    $tmp_array=array();
                    $found=FALSE;
                    foreach($already_added_go_terms as $term){
                        if ($term==str_replace("\"", "", $row[3])){
                            $found=TRUE;
                        }
                    }
                    if($found==FALSE){
                        $tmp_array['plaza id']=str_replace("\"", "", $row[2]);                                                     
                        $tmp_array['species']=$species_name;                               
                        $tmp_array['GO_ID']=str_replace("\"", "", $row[3]);
                        $tmp_array['evidence']=str_replace("\"", "", $row[4]);
                        
//                        array_push($tmp_array, str_replace("\"", "", $row[2]));
//                        array_push($tmp_array, str_replace("\"", "", $row[3]));
//                        array_push($tmp_array, str_replace("\"", "", $row[4]));
//                        array_push($tmp_array, $species_name);
                        array_push($go_list_term,$tmp_array); 
                        array_push($already_added_go_terms, str_replace("\"", "", $row[3]));

                    }



                    //echo 'test'.$row[0].'-'.$row[3].'-'.$row[4].'-'.$row[5].'<br>';

                }
                $cpt++;
            }
            $timeend2=microtime(true);
            $time=$timeend2-$timestart2;
            //Afficher le temps d'éxecution
            $page_load_time = number_format($time, 3);
            echo "Debut du script: ".date("H:i:s", $timestart2);
            echo "<br>Fin du script: ".date("H:i:s", $timeend2);
            echo "<br>Script read grid plaza file in while loop executed in " . $page_load_time . " sec";
            echo '<hr>';
        }
    } 
    
        
    
    return $go_list_term;


}
function read_grid_mapping_file(MongoGridFS $grid, MongoCollection $mappingsCollection,$filename='null',$src='null'){
   	echo 'entering read grid file : '.$filename;
    $go_list_term=array();
    $already_added_go_terms=array();

    //$MongoGridFSCursor=  get_grid_file($grid, $mappingsCollection,$speciesID,$src);
    $MongoGridFSCursor= $grid->find(array('data_file'=>$filename));
    $species=$mappingsCollection->find(array('mapping_file.file'=>$filename),array('mapping_file.species'=>1));
    
    foreach ($species as $array){       
        foreach ($array['mapping_file'] as $key=>$value ){
            foreach($MongoGridFSCursor as $MongoGridFSFile) {
                $stream = $MongoGridFSFile->getResource();
                if ($stream) {
                    #while (($buffer = fgets($stream, 4096)) !== false) {
                    $cpt=0;
                    while (($buffer = stream_get_line($stream, 1024, "\n")) !== false) {
                        //echo $buffer.'<br>';
                        $row=preg_split('/\t+/', $buffer);
                        //echo $row[0].'<br>';

                        if ($src==$row[0]){
                            $tmp_array=array();
                            $found=FALSE;
                            foreach($already_added_go_terms as $term){
                                if ($term==$row[5]){
                                    $found=TRUE;
                                }
                            }
                            if($found==FALSE){
                               
                                //array_push($tmp_array, $row[0]);
                                $tmp_array['gene_name']=$row[0];
                                //array_push($tmp_array, $row[3]);
                                $tmp_array['relationship']=$row[3];
                                
                                //array_push($tmp_array, $row[4]);
                                $tmp_array['description']=$row[4];
                                //array_push($tmp_array, $row[5]);
                                $tmp_array['GO_ID']=$row[5];
                                $tmp_array['evidence']=$row[9];
                                //array_push($tmp_array, $row[9]);
                                if ($key=='species'){
                                    array_push($tmp_array, $value);
                                }

                                array_push($go_list_term,$tmp_array); 
                                array_push($already_added_go_terms, $row[5]);

                            }
                            
                            
                            
                            //echo 'test'.$row[0].'-'.$row[3].'-'.$row[4].'-'.$row[5].'<br>';

                        }
                        $cpt++;
                    }
                }
            } 
        }
    }
    return $go_list_term;


}
function get_ortholog(MongoCollection $mappingsCollection, Mongocollection $orthologsCollection,$speciesID='null',$current_plaza_id='null'){
//	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
//	echo'<h1 style="text-align:center"> Orthology informations </h1>';
//	echo '</div>';
   
	#$current_plaza_id="AT1G01060";
    //echo "test plaza id ".$current_plaza_id;
    //$initial_species=array('Arabidopsis thaliana' => 'AT','Cucumis melo' => 'CM','Hordeum vulgare' => 'HV','Solanum lycopersicum' => 'SL','Prunus persica' => 'PP');
    $table_string="";
    if ($current_plaza_id!=""){
        //$timestart=microtime(true);
        $cursors=$orthologsCollection->find(array('mapping_file.plaza_gene_identifier'=>$current_plaza_id),array('mapping_file.$'=>1,'_id'=>0));
        foreach ($cursors as $cursor){
            foreach ($cursor as $mapping_file){
                foreach ($mapping_file as $value){
                    //$ortholog_list_id=$value['orthologs_list_identifier'];
                    $ortholog_list_id=split('[,]', $value['orthologs_list_identifier']);
                }
            }
        }

//        $cursors=$orthologsCollection->aggregate(array(
//            array('$project' => array('mapping_file'=>1,'_id'=>0)),
//            array('$unwind'=>'$mapping_file'),
//            array('$match' => array('mapping_file.plaza_gene_identifier'=>$current_plaza_id)),
//            array('$project' => array('mapping_file.orthologs_list_identifier'=>1,'_id'=>0))
//        ));

                
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Debut du script: ".date("H:i:s", $timestart);
//        echo "<br>Fin du script: ".date("H:i:s", $timeend);
//        echo "<br>Script aggregate and var dump execute en " . $page_load_time . " sec";
          //var_dump($cursors);
        
        
        
        //$timestart=microtime(true);
//        foreach ($cursors['result'] as $values) {
//            $ortholog_list_id=$values['mapping_file']['orthologs_list_identifier'];
//            //echo $ortholog_list_id;
//            $ortholog_list_id=split('[,]', $ortholog_list_id);
        foreach ($ortholog_list_id as $ortholog){
            //echo 'ortholog'.$ortholog;
         //   foreach ($initial_species as $key => $value) {
         //       if ($value==$ortholog[0].$ortholog[1] && $ortholog[2]!='R'){
                    #echo "start line : ".$buffer."\n";
            $ortholog_data=$mappingsCollection->find(array('mapping_file.Plaza ID'=>$ortholog),array('mapping_file.$'=>1,'species'=>1,'_id'=>0));
            foreach ($ortholog_data as $data){
                $species=$data['species'];
                foreach ($data['mapping_file'] as $value){

                //echo $value['Gene ID'];
                    $table_string.="<tr>";

                    $table_string.='<td><a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$species.'&search='.$value['Gene ID'].'">'.$value['Gene ID'].'</a></td>';
                    //$table_string.='<td>'.$line['mapping_file']['Gene ID'].'</td>';
                    //echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
                    $table_string.='<td><a class="nowrap" href="http://www.uniprot.org/uniprot/'.$value['Uniprot ID'].'">'.$value['Uniprot ID'].'</a></td>';

                    //$table_string.='<td>'.$line['mapping_file']['Uniprot ID'].'</td>';

                    $table_string.='<td>'.$data['species'].'</td>';
                    //echo '<td>'.$line['species'].'</td>';
                    $table_string.="</tr>";
                }
//                    $table_string.="<tr>";
//                    
//                    $table_string.='<td><a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$value['species'].'&search='.$value['mapping_file']['Gene ID'].'">'.$value['mapping_file']['Gene ID'].'</a></td>';
//                    //$table_string.='<td>'.$line['mapping_file']['Gene ID'].'</td>';
//                    //echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//                    $table_string.='<td><a class="nowrap" href="http://www.uniprot.org/uniprot/'.$value['mapping_file']['Uniprot ID'].'">'.$value['mapping_file']['Uniprot ID'].'</a></td>';
//
//                    //$table_string.='<td>'.$line['mapping_file']['Uniprot ID'].'</td>';
//
//                    $table_string.='<td>'.$line['species'].'</td>';
//                    //echo '<td>'.$line['species'].'</td>';
//                    $table_string.="</tr>";


            }


//                $tgt=$mappingsCollection->aggregate(array(
//                array('$match' => array('type'=>'full_table')),  
//                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),
//                array('$unwind'=>'$mapping_file'),
//                array('$match' => array('$or'=> array(array('mapping_file.Plaza ID'=>$ortholog),array('mapping_file.Protein ID'=>$ortholog),array('mapping_file.Alias'=>$ortholog),array('mapping_file.Probe ID'=>$ortholog),array('mapping_file.Gene ID'=>$ortholog),array('mapping_file.Gene ID 2'=>$ortholog)))),
//                array('$project' => array("mapping_file"=>1,'species'=>1,'_id'=>0)))); 
//
//                foreach($tgt['result'] as $line) {
//
//                    //echo $line['species'];
//                    $table_string.="<tr>";
//                    
//                    $table_string.='<td><a class="nowrap" href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.$line['species'].'&search='.$line['mapping_file']['Gene ID'].'">'.$line['mapping_file']['Gene ID'].'</a></td>';
//                    //$table_string.='<td>'.$line['mapping_file']['Gene ID'].'</td>';
//                    //echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//                    $table_string.='<td><a class="nowrap" href="http://www.uniprot.org/uniprot/'.$line['mapping_file']['Uniprot ID'].'">'.$line['mapping_file']['Uniprot ID'].'</a></td>';
//
//                    //$table_string.='<td>'.$line['mapping_file']['Uniprot ID'].'</td>';
//
//                    $table_string.='<td>'.$line['species'].'</td>';
//                    //echo '<td>'.$line['species'].'</td>';
//                    $table_string.="</tr>";
//
//
//
//                }                         
        }
        //}
//        $timeend=microtime(true);
//        $time=$timeend-$timestart;
//
//        //Afficher le temps d'éxecution
//        $page_load_time = number_format($time, 3);
//        echo "Debut du script dans get_orthologs: ".date("H:i:s", $timestart);
//        echo "<br>Fin du script: ".date("H:i:s", $timeend);
//        echo "<br>Script  execute en " . $page_load_time . " sec";
    }
    return $table_string; 
    
        
                              
}
function get_all_orthologs(MongoGridFS $grid, MongoCollection $mappingsCollection, Mongocollection $orthologsCollection,$speciesID='null',$current_plaza_id='null'){
//	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
//	echo'<h1 style="text-align:center"> Orthology informations </h1>';
//	echo '</div>';
     //echo "test plaza id ".$current_plaza_id;
    //$initial_species=array('Arabidopsis thaliana' => 'AT','Cucumis melo' => 'CM','Hordeum vulgare' => 'HV','Solanum lycopersicum' => 'SL');
    $table_string="";
    echo 'current_plaza_id: '.$current_plaza_id;
    if ($current_plaza_id!=""){
        
//        $cursors=$orthologsCollection->find(array('mapping_file.plaza_gene_identifier'=>$current_plaza_id),array('mapping_file.$'=>1,'_id'=>0));
//        foreach ($cursors as $cursor){
//            foreach ($cursor as $mapping_file){
//                foreach ($mapping_file as $value){
//                    //$ortholog_list_id=$value['orthologs_list_identifier'];
//                    $ortholog_list_id=split('[,]', $value['orthologs_list_identifier']);
//                }
//            }
//        }
        echo 'current_plaza_id: '.$current_plaza_id;
        
        $cursors=$orthologsCollection->aggregate(array(
            array('$match'=>array('species'=>$speciesID)),
            array('$project' => array('mapping_file'=>1,'_id'=>0)),
            array('$unwind'=>'$mapping_file'),
            array('$match' => array('mapping_file.plaza_gene_identifier'=>$current_plaza_id)),
            array('$project' => array('mapping_file.orthologs_list_identifier'=>1,'_id'=>0))
        ));
        //var_dump($cursors);
        foreach ($cursors['result'] as $values) {
            $ortholog_list_id=$values['mapping_file']['orthologs_list_identifier'];
            echo 'ortholog list : '.$ortholog_list_id;
            $ortholog_list_id=split('[,]', $ortholog_list_id);
            foreach ($ortholog_list_id as $ortholog){
                //echo 'ortholog'.$ortholog;
                //foreach ($initial_species as $key => $value) {
                    //if ($value==$ortholog[0].$ortholog[1] && $ortholog[2]!='R'){
                        #echo "start line : ".$buffer."\n";
                        $cursor=$mappingsCollection->aggregate(array( 
                            array('$match' => array('key'=>'PLAZA_conversion')),  
                            array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'_id'=>0)),    
                            array('$match' => array('src'=>"plaza_gene_id")),  
                            array('$unwind'=>'$src_to_tgt'),    
                            array('$match' => array('src_to_tgt.0'=>$ortholog)),  
                            array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'_id'=>0))
                        ));

                        if (count($cursor['result'])!=0){


                            foreach($cursor['result'] as $line) {

                                //echo $line['src_to_tgt'];
                                for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
                                    $table_string.="<tr>";
                                    $table_string.='<td>'.$line['src_to_tgt'][0].'</td>';
                                    $table_string.='<td>'.$line['src_version'].'</td>';
                                    if ($line['species']=="Arabidopsis thaliana"){
                                        
                                        //$table_string.='<td>'.$line['src_to_tgt'][1][$i].'</td>';
                                        $table_string.='<td><a href=http://www.uniprot.org/uniprot/'.$line['src_to_tgt'][1][$i].'>'.$line['src_to_tgt'][1][$i].'</a></td>';

                                    }
                                    else if ($line['species']=="Cucumis melo"){
                                        $table_string.='<td><a href=https://melonomics.net/feature/'.$line['src_to_tgt'][1][$i].'>'.$line['src_to_tgt'][1][$i].'</a></td>';
                                        
                                    }
                                    else if ($line['species']=="Solanum lycopersicum"){
                                        //$table_string.='<td>'.$line['src_to_tgt'][1][$i].'</td>';
                                        $table_string.='<td><a href=http://solcyc.solgenomics.net/LYCO/NEW-IMAGE?type=GENE-IN-MAP&object='.$line['src_to_tgt'][1][$i].'>'.$line['src_to_tgt'][1][$i].'</a></td>';

                                  
                                    }
                                    else{
                                        $table_string.='<td>'.$line['src_to_tgt'][1][$i].'</td>';
                                    }
                                    $table_string.='<td>'.$line['tgt'].'</td>';
                                    $table_string.='<td>'.$line['species'].'</td>';
                                    $table_string.="<tr>";

                                }
                            }                                                                                                                                                                            
//                                        echo '<h2> orthologs table </h2> <div class="container">';
//                                        echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
//                                        echo'<thead><tr>';
//
//                                        //recupere le titre
//                                        #echo "<th>type</th>";
//                                        echo "<th>Mapping type</th>";
//                                        echo "<th>src ID</th>";
//                                        echo "<th>src type</th>";
//                                        echo "<th>src_version</th>";
//                                        echo "<th>tgt ID</th>";
//                                        echo "<th>tgt type</th>";
//                                        echo "<th>tgt_version</th>";
//                                        echo "<th>species</th>";
//
//                                        echo'</tr></thead>';
//
//                                        //Debut du corps de la table
//                                        echo'<tbody>';
//
//                                        foreach($cursor['result'] as $line) {
//
//                                            //echo $line['src_to_tgt'];
//                                            for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//                                                echo "<tr>";
//
//                                                echo '<td>'.$line['type'].'</td>';
//
//                                                echo '<td>'.$line['src_to_tgt'][0].'</td>';
//                                                echo '<td>'.$line['src'].'</td>';
//                                                echo '<td>'.$line['src_version'].'</td>';
//
//                                                //for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//
//                                                echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//
//
//                                                //}
//                                                echo '<td>'.$line['tgt'].'</td>';
//                                                echo '<td>'.$line['tgt_version'].'</td>';
//                                                echo '<td>'.$line['species'].'</td>';
//                                                echo "</tr>";
//                                            }
//
//                                        }
//                                        echo'</tbody></table></div>'; 
                        }                                   														
                    //}

                //}                          
 			}
        }
    }
    
    
    
    
    #old way to perform research
	#$current_plaza_id="AT1G01060";
    /*$initial_species=array('AT','CM','HV','SL');
    $table_string="";
	if ($current_plaza_id!=""){

		$MongoGridFSCursor=get_plaza_orthologs($grid, $orthologsCollection,$speciesID,$current_plaza_id,'plaza_gene_identifier');
		#$MongoGridFSCursor->skip(3)->limit(8);
		foreach($MongoGridFSCursor as $MongoGridFSFile) {
			#error_log($MongoGridFSFile->getBytes(), 0);
			$stream = $MongoGridFSFile->getResource();
 			if ($stream) {
     			#while (($buffer = fgets($stream, 4096)) !== false) {
	     		
	     		while (($buffer = stream_get_line($stream, 1024, "\n")) !== false) {
         			#echo "start line : ".$buffer."\n";
					#$row=split('[\t]', $buffer);
					$row=preg_split('/\s+/', $buffer);
					if ($current_plaza_id==$row[0]){
						#echo "start line : ".$buffer."\n";
						$ortholog_list_id=split('[,]', $row[1]);
						foreach ($ortholog_list_id as $ortholog){
                            foreach ($initial_species as $value) {
                                if ($value==$ortholog[0].$ortholog[1] && $ortholog[2]!='R'){
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
                                          
                               
                                        foreach($cursor['result'] as $line) {

                                            //echo $line['src_to_tgt'];
                                            for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
                                                $table_string.="<tr>";
                                                //echo "<tr>";
                                                $table_string.='<td>'.$line['type'].'</td>';
                                                //echo '<td>'.$line['type'].'</td>';
                                                $table_string.='<td>'.$line['src_to_tgt'][0].'</td>';
                                                //echo '<td>'.$line['src_to_tgt'][0].'</td>';
                                                $table_string.='<td>'.$line['src'].'</td>';
                                                //echo '<td>'.$line['src'].'</td>';
                                                $table_string.='<td>'.$line['src_version'].'</td>';
                                                //echo '<td>'.$line['src_version'].'</td>';
                                                $table_string.='<td>'.$line['src_to_tgt'][1][$i].'</td>';
                                                //echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
                                                $table_string.='<td>'.$line['tgt'].'</td>';
                                                //echo '<td>'.$line['tgt'].'</td>';
                                                $table_string.='<td>'.$line['tgt_version'].'</td>';
                                                //echo '<td>'.$line['tgt_version'].'</td>';
                                                $table_string.='<td>'.$line['species'].'</td>';
                                                //echo '<td>'.$line['species'].'</td>';
                                                $table_string.="<tr>";
                                                //echo "</tr>";
                                              
                                            }
                                        }                                                                                                                                                                            
//                                        echo '<h2> orthologs table </h2> <div class="container">';
//                                        echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
//                                        echo'<thead><tr>';
//
//                                        //recupere le titre
//                                        #echo "<th>type</th>";
//                                        echo "<th>Mapping type</th>";
//                                        echo "<th>src ID</th>";
//                                        echo "<th>src type</th>";
//                                        echo "<th>src_version</th>";
//                                        echo "<th>tgt ID</th>";
//                                        echo "<th>tgt type</th>";
//                                        echo "<th>tgt_version</th>";
//                                        echo "<th>species</th>";
//
//                                        echo'</tr></thead>';
//
//                                        //Debut du corps de la table
//                                        echo'<tbody>';
//
//                                        foreach($cursor['result'] as $line) {
//
//                                            //echo $line['src_to_tgt'];
//                                            for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//                                                echo "<tr>";
//
//                                                echo '<td>'.$line['type'].'</td>';
//
//                                                echo '<td>'.$line['src_to_tgt'][0].'</td>';
//                                                echo '<td>'.$line['src'].'</td>';
//                                                echo '<td>'.$line['src_version'].'</td>';
//
//                                                //for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//
//                                                echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//
//
//                                                //}
//                                                echo '<td>'.$line['tgt'].'</td>';
//                                                echo '<td>'.$line['tgt_version'].'</td>';
//                                                echo '<td>'.$line['species'].'</td>';
//                                                echo "</tr>";
//                                            }
//
//                                        }
//                                        echo'</tbody></table></div>'; 
                                    }                                   														
                                }
                            }                          
 						}
					}
				}
			}
		}
	}*/
    return $table_string;                           
//							#echo "start line : ".$buffer."\n";
//							$cursor=$mappingsCollection->aggregate(array( 
//								array('$match' => array('type'=>'gene_to_prot')),  
//								array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),    
//								array('$match' => array('src'=>"plaza_gene_id")),  
//								array('$unwind'=>'$src_to_tgt'),    
//								array('$match' => array('src_to_tgt.0'=>$ortholog)),  
//								array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))
//							));
//							
//							if (count($cursor['result'])!=0){
//								echo '<h2> orthologs table </h2> <div class="container">';
//								echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
//								echo'<thead><tr>';
//
//								//recupere le titre
//								#echo "<th>type</th>";
//								echo "<th>Mapping type</th>";
//								echo "<th>src ID</th>";
//								echo "<th>src type</th>";
//								echo "<th>src_version</th>";
//								echo "<th>tgt ID</th>";
//								echo "<th>tgt type</th>";
//								echo "<th>tgt_version</th>";
//								echo "<th>species</th>";
//								
//								echo'</tr></thead>';
//
//								//Debut du corps de la table
//								echo'<tbody>';
//
//								foreach($cursor['result'] as $line) {
//
//									//echo $line['src_to_tgt'];
//									for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//										echo "<tr>";
//										
//										echo '<td>'.$line['type'].'</td>';
//
//										echo '<td>'.$line['src_to_tgt'][0].'</td>';
//										echo '<td>'.$line['src'].'</td>';
//										echo '<td>'.$line['src_version'].'</td>';
//
//										//for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//
//										echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//		
//	
//										//}
//										echo '<td>'.$line['tgt'].'</td>';
//										echo '<td>'.$line['tgt_version'].'</td>';
//										echo '<td>'.$line['species'].'</td>';
//										echo "</tr>";
//									}
//
//								}
//								echo'</tbody></table></div>';
//								
//								#echo $ortholog."\n";
//								#var_dump($cursor);
//								#echo "\n";
//							}
							
							

}
### Find all aliases
function find_description_by_regex(MongoCollection $sa,MongoRegex $re){


	$searchQuery = array('gene'=>array('$regex'=> $re));

	$cursor = $sa->find($searchQuery);
	$cursor->sort(array('logFC'=> -1));
	$cursor->limit(1000);
	
	return $cursor;
	#$cursor = $measurementsCollection->find($searchQuery,array('direction'=>1));

}
function get_all_results_from_samples(MongoCollection $measurementsCollection,MongoCollection $samplesCollection,$search_string='null'){
	//$search_string=$textID;
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
	
	echo'<table id="samplestable" class="table table-bordered" cellspacing="0" width="100%">';
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
					
					echo "<td><a href=description/experiments.php?xp=".str_replace(' ','\s',$xp_name['name']).">".$xp_name['name']."(Sample file ".$file_number.")</a></td>";
					//echo"<td>".$line[$value]."</td>";
					
				}
			}
		}
	
	
		echo "</tr>";
	}
	echo'</tbody></table>';





}
//function find_protein_by_gene()
function find_gene_by_regex(MongoCollection $me,MongoRegex $re){


	$searchQuery = array('gene'=>array('$regex'=> $re));

	$cursor = $me->find($searchQuery);
	$cursor->sort(array('logFC'=> -1));
	$cursor->limit(1000);
	
	return $cursor;
	#$cursor = $measurementsCollection->find($searchQuery,array('direction'=>1));

}
function get_all_GO_information(MongoCollection $me,Mongocollection $sp,Mongocollection $sa, Mongocollection $ma,MongoCollection $vi,$species='null'){



}
### Find all genes up-regulated in a given species when infected with given virus
function get_all_genes_regulated(MongoCollection $me,Mongocollection $sp,Mongocollection $sa, Mongocollection $ma,MongoCollection $vi,$species='null'){
	$cursor=array();
	$gene_prot=array();
	$list_gene_prot=array();
	
	$id_type_results=$ma->find(array("species"=>$species,"type"=>"est_to_gene"),array("src"=>1));
	
	foreach ( $id_type_results as $id_type ){
		echo $id_type['src'];
		$species_cursor=array();
		$cursor_id=find_species_doc($sp,$species);
		$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
		$species_val =array();
		$result=$species_cursor['result'];
		//var_dump($result);
		foreach ( $result as $value ){
			//echo $value;
			foreach ( $value as $values ){
				//echo $values;
				array_push($species_val,$values);				
			}
		}
		
		// $virus_cursor=array();
// 		$cursor_id=find_species_doc($sp,$virus);
// 		$virus_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
// 		$virus_val =array();
// 		$result=$virus_cursor['result'];
// 		//var_dump($result);
// 		foreach ( $result as $value ){
// 			//echo $value;
// 			foreach ( $value as $values ){
// 				//echo $values;
// 				array_push($virus_val,$values);				
// 			}
// 		}
		//echo count($species_val);
		$log_threshold=5;
		$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infected'=>true)),  
			   #array('$match'=>array('$and'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.CATMA_ID'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> $log_threshold))), 
				array('$project'=>array('id'=>'$experimental_results.values.'.$id_type['src'],'FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
		));
		echo '<br>';
		echo count($cursor['result']).' genes has been found with logFC upper than '.$log_threshold;

		//var_dump($cursor);
		for ($i = 0; $i < count($cursor['result']); $i++) {
		
			$test=$cursor['result'][$i]['id'];
			$FC=$cursor['result'][$i]['FC'];
			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
			
			foreach ( $cursor2 as $doc ){
			
					$cursor['result'][$i]['gene']=$doc['gene'];

			
			}
		

		 
		}
	
		$cursorprot=$ma->find(array('type'=>'gene_to_prot','species'=>$species),array('src_to_tgt'=>1,'_id'=>0));
		$result = $cursorprot->getNext();
		//var_dump($result);
		$src_to_tgt=$result['src_to_tgt'];
		//echo count($src_to_tgt);
		for ($i = 0; $i < count($cursor['result']); $i++) {
			$gene=$cursor['result'][$i]['gene'];
			echo $gene;
			foreach ( $src_to_tgt as $array){
				
				//echo $src.' and '.$tgt[0];
				//foreach ($array as $key=>$value){
				
				if ($array[0]==$gene){
							
					//echo 'test='.$array[1][0];	
					$cursor['result'][$i]['prot preferred id']=$array[1][0];
					array_push($gene_prot,$cursor['result'][$i]['gene']);
					array_push($gene_prot,$cursor['result'][$i]['prot preferred id']);	
					array_push($list_gene_prot,$gene_prot);	
				}
					
				//}			
				
				/*
				foreach ( $docs as $array => $src_to_tgt ){
					
					foreach ( $src_to_tgt as $src => $tgt){
						
						if ($src==$gene){
							echo $tgt;
							$cursor['result'][$i]['prot preferred id']=$tgt[0];

						}
					}
				}
				*/

			}
		
		}
		
	}
	makeDatatableFromAggregate($cursor);
	//datatableFromAggregate($cursor1);
	//makeDatatableFromAggregate($cursor2);
	return $list_gene_prot;
	//return $cursor;

	
	
	
	
	
	
	
	
	
	
	
	
	
	// if ($species=='Arabidopsis thaliana'){
// 		$species_cursor=array();
// 		$cursor_id=find_species_doc($sp,$species);
// 		$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
// 		$species_val =array();
// 		$result=$species_cursor['result'];
// 		//var_dump($result);
// 		foreach ( $result as $value ){
// 			//echo $value;
// 			foreach ( $value as $values ){
// 				//echo $values;
// 				array_push($species_val,$values);				
// 			}
// 		}
// 		
// 		// $virus_cursor=array();
// // 		$cursor_id=find_species_doc($sp,$virus);
// // 		$virus_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
// // 		$virus_val =array();
// // 		$result=$virus_cursor['result'];
// // 		//var_dump($result);
// // 		foreach ( $result as $value ){
// // 			//echo $value;
// // 			foreach ( $value as $values ){
// // 				//echo $values;
// // 				array_push($virus_val,$values);				
// // 			}
// // 		}
// 		//echo count($species_val);
// 		$test_id="CATMA_ID";
// 		$cursor=$sa->aggregate(array( 
// 				array('$match' => array('species' => array('$in'=>$species_val))), 
// 				array('$unwind'=>'$experimental_results'),  
// 				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
// 				array('$unwind'=>'$experimental_results.conditions'),  
// 				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
// 				array('$match'=>array('experimental_results.conditions.infected'=>true)),  
// 			   #array('$match'=>array('$and'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
// 				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.CATMA_ID'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
// 				array('$unwind'=>'$experimental_results.values'), 
// 				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 0.4))), 
// 				array('$project'=>array('id'=>'$experimental_results.values.'.$test_id,'FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
// 		));
// 		echo '<br>';
// 		echo count($cursor['result']).' genes has been found with logFC upper than 0.4';
// 
// 		//var_dump($cursor);
// 		for ($i = 0; $i < count($cursor['result']); $i++) {
// 		
// 			$test=$cursor['result'][$i]['id'];
// 			$FC=$cursor['result'][$i]['FC'];
// 			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
// 			
// 			foreach ( $cursor2 as $doc ){
// 			
// 					$cursor['result'][$i]['gene']=$doc['gene'];
// 
// 			
// 			}
// 		
// 
// 		 
// 		}
// 	
// 		$cursorprot=$ma->find(array('type'=>'gene_to_prot','species'=>$species),array('src_to_tgt'=>1,'_id'=>0));
// 		$result = $cursorprot->getNext();
// 		//var_dump($result);
// 		$src_to_tgt=$result['src_to_tgt'];
// 		//echo count($src_to_tgt);
// 		for ($i = 0; $i < count($cursor['result']); $i++) {
// 			$gene=$cursor['result'][$i]['gene'];
// 			//echo $gene;
// 			foreach ( $src_to_tgt as $array){
// 				
// 				//echo $src.' and '.$tgt[0];
// 				//foreach ($array as $key=>$value){
// 				
// 				if ($array[0]==$gene){
// 							
// 					//echo 'test='.$array[1][0];	
// 					$cursor['result'][$i]['prot preferred id']=$array[1][0];
// 					array_push($gene_prot,$cursor['result'][$i]['gene']);
// 					array_push($gene_prot,$cursor['result'][$i]['prot preferred id']);	
// 					array_push($list_gene_prot,$gene_prot);	
// 				}
// 					
// 				//}			
// 				
// 				/*
// 				foreach ( $docs as $array => $src_to_tgt ){
// 					
// 					foreach ( $src_to_tgt as $src => $tgt){
// 						
// 						if ($src==$gene){
// 							echo $tgt;
// 							$cursor['result'][$i]['prot preferred id']=$tgt[0];
// 
// 						}
// 					}
// 				}
// 				*/
// 
// 			}
// 		
// 		}
// 		
// 	
// 	}
// 	else if($species=='Cucumis Melo'){
// 	}
// 	else if($species=='Solanum lycopersicum'){
// 		$species_cursor=array();
// 		
// 		$cursor_id=find_species_doc($sp,$species);
// 		$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
// 		$species_val =array();
// 		$result=$species_cursor['result'];
// 		//var_dump($result);
// 		foreach ( $result as $value ){
// 			//echo $value;
// 			foreach ( $value as $values ){
// 				//echo $values;
// 				array_push($species_val,$values);				
// 			}
// 		}
// 		// $virus_cursor=array();
// // 		$cursor_id=find_species_doc($sp,$virus);
// // 		$virus_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
// // 		$virus_val =array();
// // 		$result=$virus_cursor['result'];
// // 		//var_dump($result);
// // 		foreach ( $result as $value ){
// // 			//echo $value;
// // 			foreach ( $value as $values ){
// // 				//echo $values;
// // 				array_push($virus_val,$values);				
// // 			}
// // 		}
// 		//echo count($species_val);
// 		
// 		$cursor=$sa->aggregate(array( 
// 				array('$match' => array('species' => array('$in'=>$species_val))), 
// 				array('$unwind'=>'$experimental_results'),  
// 				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
// 				array('$unwind'=>'$experimental_results.conditions'),  
// 				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
// 				array('$match'=>array('experimental_results.conditions.infected'=>true)),  
// 			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
// 				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.SGN_S'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
// 				array('$unwind'=>'$experimental_results.values'), 
// 				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 5))),
// 				#array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 0,'$lt'=> 0.2))), 
//  
// 				array('$project'=>array('id'=>'$experimental_results.values.SGN_S','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
// 		));
// 		//var_dump($cursor);
// 		echo '<br>';
// 		echo '<strong>'.count($cursor['result']).'</strong> genes has been found with logFC upper than requested';
// 		for ($i = 0; $i < count($cursor['result']); $i++) {
// 		
// 			$test=$cursor['result'][$i]['id'];
// 			$FC=$cursor['result'][$i]['FC'];
// 			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
// 			
// 			foreach ( $cursor2 as $doc ){
// 			
// 					$cursor['result'][$i]['gene']=$doc['gene'];
// 
// 			
// 			}
// 		
// 
// 		 
// 		}
// 	
// 		$cursorprot=$ma->find(array('type'=>'gene_to_prot','species'=>'Solanum lycopersicum'),array('src_to_tgt'=>1,'_id'=>0));
// 		$result = $cursorprot->getNext();
// 		//var_dump($result);
// 		$src_to_tgt=$result['src_to_tgt'];
// 		//echo count($src_to_tgt);
// 		for ($i = 0; $i < count($cursor['result']); $i++) {
// 			$gene=$cursor['result'][$i]['gene'];
// 			//echo $gene;
// 			foreach ( $src_to_tgt as $array){
// 				
// 				//echo $src.' and '.$tgt[0];
// 				//foreach ($array as $key=>$value){
// 				
// 				if ($array[0]==$gene){
// 							
// 					//echo 'test='.$array[1][0];	
// 					$cursor['result'][$i]['prot preferred id']=$array[1][0];
// 					array_push($gene_prot,$cursor['result'][$i]['gene']);
// 					array_push($gene_prot,$cursor['result'][$i]['prot preferred id']);	
// 					array_push($list_gene_prot,$gene_prot);	
// 
// 
// 					
// 					//need to map gene and prot id
// 				}
// 					
// 				//}			
// 				
// 				/*
// 				foreach ( $docs as $array => $src_to_tgt ){
// 					
// 					foreach ( $src_to_tgt as $src => $tgt){
// 						
// 						if ($src==$gene){
// 							echo $tgt;
// 							$cursor['result'][$i]['prot preferred id']=$tgt[0];
// 
// 						}
// 					}
// 				}
// 				*/
// 
// 			}
// 		
// 		}
// 	}
// 	else{
// 	}

}
function get_all_genes_up_regulated(MongoCollection $me,Mongocollection $sp,Mongocollection $sa, Mongocollection $ma,MongoCollection $vi,$logFCInput='null',$species='null', $virus='null',$est_id='null'){
	
	
	#'experimental_results.values.$type'=>array('$exist'=>1)
	#array('experimental_results.values.$xls_parsing.id_type' => array('$exists' => true))
	#'experimental_results.values.$xls_parsing.id_type' => array('$exists' => true)
	#'experimental_results.values.est_unigen'=>1,
	#,'type'=>'$xls_parsing.id_type'
	$cursor;
	#echo 'entering get all gens up regulated for : species:'.$species;
	if ($species=='Arabidopsis thaliana'){
		if ($species =='null' AND $virus == 'null'){
		 echo "species null and virus null";
			$cursor=$sa->aggregate(array( 
				array('$match'=> array('experimental_results.conditions.infected'=>true)),
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'xls_parsing.id_type'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				#array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

				#array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'xls_parsing.id_type'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'),
				#array('$match'=>array('experimental_results.values'=>array("$elemMatch"=>array("$xls_parsing.id_type"=>array("$exists":True))))), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 7))), 
				array('$project'=>array('id'=>'$experimental_results.values.CATMA_ID'."$xls_parsing.id_type",'FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
		}
		else{
	
	
			$species_cursor=array();
			$cursor_id=find_species_doc($sp,$species);
			$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
			#for ($i = 0; $i < count($speciescursor['result']); $i++) {
				#$test=get_tgt_id_from_src_id($me,$cursor['result'][$i]['id']);
			#	print_r($cursor['result'][$i]);
		 
			#}
			$virus_cursor=array();
			$cursor_id=find_species_doc($sp,$virus);
			$virus_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
	
			#echo 'est id:'.$est_id;
	
			$species_val =array();
			foreach ( $species_cursor as $id => $value )
			{
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$species_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
			$virus_val =array();
			foreach ( $virus_cursor as $id => $value )
			{
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$virus_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
   
			if ($est_id==''){
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.CATMA_ID'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 0.4))), 
				array('$project'=>array('id'=>'$experimental_results.values.CATMA_ID','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				#$cursor->limit(1000);
			
				#$cursor->timeout(10);
			}
			else{
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.CATMA_ID'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 4),'experimental_results.values.CATMA_ID'=>$est_id)), 
				array('$project'=>array('id'=>'$experimental_results.values.CATMA_ID','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				$cursor->limit(1000);
				#$cursor->timeout(1000000);
	
			}
		}
		#$cursor->maxTimeMS(30000000);
		#$cursor->maxTimeMS(10);
	   # $cursor->limit(1000);
		#$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->limit(100);
				#$array=iterator_to_array($cursorprot);
		#print_r(iterator_to_array($cursorprot));
		#$array_gene_to_prot=iterator_to_array($cursorprot[0]['src_to_tgt']);
	
	
	
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->maxTimeMS(300000);

		#$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
		
			#$text=$cursor['result'][$i][0];
			#echo 'text :'.$text;
			$test=$cursor['result'][$i]['id'];
			$FC=$cursor['result'][$i]['FC'];
			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
			#$cursor2->timeout(340000);
			#$cursor2->maxTimeMS(3000);

			foreach ( $cursor2 as $doc ){
			

				#$gene=$doc['gene'];
			
			
				$cursor['result'][$i]['gene']=$doc['gene'];
			
			
				/*
			
				foreach ( $result as $docs){
					#echo $docs;
					foreach ( $docs as $array => $src_to_tgt ){

						foreach ( $src_to_tgt as $src => $tgt){
							#echo "src_to_tgt---".$src_to_tgt[0];
							#echo "tgt[0]---".$tgt[0];
							#foreach ( $tgt as $srcs => $tgts){
								if ($src_to_tgt[0]==$gene){
									#echo $gene;
									$cursor['result'][$i]['uniprot preferred id']=$tgt[0];

								}
							#}
					
						}
					}
			

				}
				*/
			
				//echo $result;
				/*
				foreach ( $result as $id => $value ){
					echo "$id: ";
					#var_dump( $value );
				
					$src_to_tgt=array();
					$src_to_tgt=$value;
				
					foreach ( $src_to_tgt as $array => $src_to_tgt){
					
					
						foreach ( $source as $array => $src_to_tgt ){
						
							foreach ( $src_to_tgt as $src => $tgt ){
								if ($tgt[0]==$gene){
									//echo $tgt[0]."-----";
									echo $tgt[1][0];
							
									$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
								}
							}
						}
					
					}
				
				}
			
			
			
				#foreach ( $src_to_tgt as $docs){
		
				#}*/
			
			}
		

		 
		}
	
		#echo "end";
	
	
		#$cursor->limit(1000);
		$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
			#echo "entering search gene for results".$i;
		
			$gene=$cursor['result'][$i]['gene'];
			//$cursor1=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
			//$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
				#print_r($cursorprot);
				//var_dump($cursorprot->getNext());
				#$result=array();
		
			foreach ( $result as $docs){
				#echo $docs;
				foreach ( $docs as $array => $src_to_tgt ){

					foreach ( $src_to_tgt as $src => $tgt){
						#echo "src_to_tgt---".$src_to_tgt[0];
						#echo "tgt[0]---".$tgt[0];
						#foreach ( $tgt as $srcs => $tgts){
							if ($src_to_tgt[0]==$gene){
								#echo $gene;
								$cursor['result'][$i]['prot preferred id']=$tgt[0];

							}
						#}
					
					}
				}

			}
		
		}
    
    	/*
    	#$text=$cursor['result'][$i][0];
    	#echo 'text :'.$text;
    	$gene=$cursor['result'][$i]['species preferred gene id'];
    	$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		echo "count".count($cursor_prot);
    	foreach ( $cursor_prot as $results){
    			#for ($j = 0; $j < count($docs['src_to_tgt']); $j++) {

    				#echo "entering search prot";
    				#$results=$docs['src_to_tgt'][$j];
    		
    		foreach ( $results as $docs => $source){
    				
    			foreach ( $source as $array => $src_to_tgt ){
						
					foreach ( $src_to_tgt as $src => $tgt ){
						#echo $tgt[0]."-----";
						if ($tgt[0]==$gene){
							echo $tgt[0]."-----";
							echo $tgt[1][0];
							
							$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
						}
					
					}
						
				}
			}
				
					
		}

				
				
	}
*/
    	
    	
	}
	else if($species=='Cucumis Melo'){
		if ($species =='null' && $virus == 'null'){
		 echo "species null and virus null";
			$cursor=$sa->aggregate(array( 
				array('$match'=> array('experimental_results.conditions.infected'=>true)),
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'xls_parsing.id_type'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				#array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

				#array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'xls_parsing.id_type'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'),
				#array('$match'=>array('experimental_results.values'=>array("$elemMatch"=>array("$xls_parsing.id_type"=>array("$exists":True))))), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 7))), 
				array('$project'=>array('id'=>'$experimental_results.values.'."$xls_parsing.id_type",'FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
		}
		else{
	
	
			$species_cursor=array();
			$cursor_id=find_species_doc($sp,$species);
			$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
			#for ($i = 0; $i < count($speciescursor['result']); $i++) {
				#$test=get_tgt_id_from_src_id($me,$cursor['result'][$i]['id']);
			#	print_r($cursor['result'][$i]);
		 
			#}
			$virus_cursor=array();
			$cursor_id=find_species_doc($sp,$virus);
			$virus_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
	
			#echo 'est id:'.$est_id;
	
			$species_val =array();
			foreach ( $species_cursor as $id => $value )
			{
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$species_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
			$virus_val =array();
			foreach ( $virus_cursor as $id => $value )
			{
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$virus_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
   
			if ($est_id==''){
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.est_unigen'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> floatval($logFCInput)))), 
				array('$project'=>array('id'=>'$experimental_results.values.est_unigen','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				#$cursor->limit(1000);
			
				#$cursor->timeout(10);
			}
			else{
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.est_unigen'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 4),'experimental_results.values.est_unigen'=>$est_id)), 
				array('$project'=>array('id'=>'$experimental_results.values.est_unigen','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				$cursor->limit(1000);
				#$cursor->timeout(1000000);
	
			}
		}
		#$cursor->maxTimeMS(30000000);
		#$cursor->maxTimeMS(10);
	   # $cursor->limit(1000);
		#$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->limit(100);
				#$array=iterator_to_array($cursorprot);
		#print_r(iterator_to_array($cursorprot));
		#$array_gene_to_prot=iterator_to_array($cursorprot[0]['src_to_tgt']);
	
	
	
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->maxTimeMS(300000);

		#$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
		
			#$text=$cursor['result'][$i][0];
			#echo 'text :'.$text;
			$test=$cursor['result'][$i]['id'];
			$FC=$cursor['result'][$i]['FC'];
			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
			#$cursor2->timeout(340000);
			#$cursor2->maxTimeMS(3000);

			foreach ( $cursor2 as $doc ){
			

				#$gene=$doc['gene'];
			
			
				$cursor['result'][$i]['gene']=$doc['gene'];
			
			
				/*
			
				foreach ( $result as $docs){
					#echo $docs;
					foreach ( $docs as $array => $src_to_tgt ){

						foreach ( $src_to_tgt as $src => $tgt){
							#echo "src_to_tgt---".$src_to_tgt[0];
							#echo "tgt[0]---".$tgt[0];
							#foreach ( $tgt as $srcs => $tgts){
								if ($src_to_tgt[0]==$gene){
									#echo $gene;
									$cursor['result'][$i]['uniprot preferred id']=$tgt[0];

								}
							#}
					
						}
					}
			

				}
				*/
			
				//echo $result;
				/*
				foreach ( $result as $id => $value ){
					echo "$id: ";
					#var_dump( $value );
				
					$src_to_tgt=array();
					$src_to_tgt=$value;
				
					foreach ( $src_to_tgt as $array => $src_to_tgt){
					
					
						foreach ( $source as $array => $src_to_tgt ){
						
							foreach ( $src_to_tgt as $src => $tgt ){
								if ($tgt[0]==$gene){
									//echo $tgt[0]."-----";
									echo $tgt[1][0];
							
									$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
								}
							}
						}
					
					}
				
				}
			
			
			
				#foreach ( $src_to_tgt as $docs){
		
				#}*/
			
			}
		

		 
		}
	
		#echo "end";
	
	
		#$cursor->limit(1000);
		$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
			#echo "entering search gene for results".$i;
		
			$gene=$cursor['result'][$i]['gene'];
			//$cursor1=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
			//$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
				#print_r($cursorprot);
				//var_dump($cursorprot->getNext());
				#$result=array();
		
			foreach ( $result as $docs){
				#echo $docs;
				foreach ( $docs as $array => $src_to_tgt ){

					foreach ( $src_to_tgt as $src => $tgt){
						#echo "src_to_tgt---".$src_to_tgt[0];
						#echo "tgt[0]---".$tgt[0];
						#foreach ( $tgt as $srcs => $tgts){
							if ($src_to_tgt[0]==$gene){
								#echo $gene;
								$cursor['result'][$i]['prot preferred id']=$tgt[0];

							}
						#}
					
					}
				}

			}
		
		}
    
    	/*
    	#$text=$cursor['result'][$i][0];
    	#echo 'text :'.$text;
    	$gene=$cursor['result'][$i]['species preferred gene id'];
    	$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		echo "count".count($cursor_prot);
    	foreach ( $cursor_prot as $results){
    			#for ($j = 0; $j < count($docs['src_to_tgt']); $j++) {

    				#echo "entering search prot";
    				#$results=$docs['src_to_tgt'][$j];
    		
    		foreach ( $results as $docs => $source){
    				
    			foreach ( $source as $array => $src_to_tgt ){
						
					foreach ( $src_to_tgt as $src => $tgt ){
						#echo $tgt[0]."-----";
						if ($tgt[0]==$gene){
							echo $tgt[0]."-----";
							echo $tgt[1][0];
							
							$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
						}
					
					}
						
				}
			}
				
					
		}

				
				
	}
*/
	}
	else if($species=='Solanum lycopersicum'){
		if ($species =='null' && $virus == 'null'){
		 echo "species null and virus null";
			$cursor=$sa->aggregate(array( 
				array('$match'=> array('experimental_results.conditions.infected'=>true)),
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'xls_parsing.id_type'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				#array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

				#array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'xls_parsing.id_type'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'),
				#array('$match'=>array('experimental_results.values'=>array("$elemMatch"=>array("$xls_parsing.id_type"=>array("$exists":True))))), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 7))), 
				array('$project'=>array('id'=>'$experimental_results.values.'."$xls_parsing.id_type",'FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
		}
		else{
	
	
			$species_cursor=array();
			$cursor_id=find_species_doc($sp,$species);
			$species_cursor=get_all_synonyms($sp,'_id',$cursor_id['_id']);
			#for ($i = 0; $i < count($speciescursor['result']); $i++) {
				#$test=get_tgt_id_from_src_id($me,$cursor['result'][$i]['id']);
			#	print_r($cursor['result'][$i]);
		 
			#}
			$virus_cursor=array();
			$cursor_id=find_viruses_doc($vi,$virus);
			$virus_cursor=get_all_synonyms($vi,'_id',$cursor_id['_id']);
	
			#echo 'est id:'.$est_id;
	
			$species_val =array();
			foreach ( $species_cursor as $id => $value )
			{
			
				echo $value;
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$species_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
			$virus_val =array();
			foreach ( $virus_cursor as $id => $value )
			{
				foreach ( $value as $ids => $values )
				{
				   foreach ($values as $idss => $valuess )
					{
				
				
						$virus_val[] = $valuess;
				
					}
			
			
				}
		
			}
	
   
			if ($est_id==''){
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.SGN_S'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 4))), 
				array('$project'=>array('id'=>'$experimental_results.values.SGN_S','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				#$cursor->limit(1000);
			
				#$cursor->timeout(10);
			}
			else{
				$cursor=$sa->aggregate(array( 
				array('$match' => array('species' => array('$in'=>$species_val))), 
				array('$unwind'=>'$experimental_results'),  
				array('$project' => array('species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.values'=>1,'experimental_results.conditions'=>1,'_id'=>0)), 
				array('$unwind'=>'$experimental_results.conditions'),  
				#array('$match'=>array('experimental_results.conditions.infected'=>true)), 
				array('$match'=>array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val))),  
 

			   #array('$match'=>array('or'=>array('experimental_results.conditions.infected'=>true),array('experimental_results.conditions.infection_agent'=>array('$in'=>$virus_val)))),  
				array('$project'=>array('experimental_results.values.logFC'=>1,'experimental_results.values.SGN_S'=>1,'species'=>1,'name'=>1,'src_pub'=>1,'experimental_results.data_file'=>1,'experimental_results.conditions.infection_agent'=>1)), 
				array('$unwind'=>'$experimental_results.values'), 
				array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 4),'experimental_results.values.SGN_S'=>$est_id)), 
				array('$project'=>array('id'=>'$experimental_results.values.SGN_S','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
				));
				$cursor->limit(1000);
				#$cursor->timeout(1000000);
	
			}
		}
		#$cursor->maxTimeMS(30000000);
		#$cursor->maxTimeMS(10);
	   # $cursor->limit(1000);
		#$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->limit(100);
				#$array=iterator_to_array($cursorprot);
		#print_r(iterator_to_array($cursorprot));
		#$array_gene_to_prot=iterator_to_array($cursorprot[0]['src_to_tgt']);
	
	
	
		#$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		#$cursorprot->maxTimeMS(300000);

		#$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
		
			#$text=$cursor['result'][$i][0];
			#echo 'text :'.$text;
			$test=$cursor['result'][$i]['id'];
			$FC=$cursor['result'][$i]['FC'];
			$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene'=>1));
			#$cursor2->timeout(340000);
			#$cursor2->maxTimeMS(3000);

			foreach ( $cursor2 as $doc ){
			

				#$gene=$doc['gene'];
			
			
				$cursor['result'][$i]['gene']=$doc['gene'];
			
			
				/*
			
				foreach ( $result as $docs){
					#echo $docs;
					foreach ( $docs as $array => $src_to_tgt ){

						foreach ( $src_to_tgt as $src => $tgt){
							#echo "src_to_tgt---".$src_to_tgt[0];
							#echo "tgt[0]---".$tgt[0];
							#foreach ( $tgt as $srcs => $tgts){
								if ($src_to_tgt[0]==$gene){
									#echo $gene;
									$cursor['result'][$i]['uniprot preferred id']=$tgt[0];

								}
							#}
					
						}
					}
			

				}
				*/
			
				//echo $result;
				/*
				foreach ( $result as $id => $value ){
					echo "$id: ";
					#var_dump( $value );
				
					$src_to_tgt=array();
					$src_to_tgt=$value;
				
					foreach ( $src_to_tgt as $array => $src_to_tgt){
					
					
						foreach ( $source as $array => $src_to_tgt ){
						
							foreach ( $src_to_tgt as $src => $tgt ){
								if ($tgt[0]==$gene){
									//echo $tgt[0]."-----";
									echo $tgt[1][0];
							
									$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
								}
							}
						}
					
					}
				
				}
			
			
			
				#foreach ( $src_to_tgt as $docs){
		
				#}*/
			
			}
		

		 
		}
	
		#echo "end";
	
	
		#$cursor->limit(1000);
		$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		$result = $cursorprot->getNext();
		for ($i = 0; $i < count($cursor['result']); $i++) {
		#for ($i = 0; $i < 1000; $i++) {
			
			#echo "entering search gene for results".$i;
		
			$gene=$cursor['result'][$i]['gene'];
			//$cursor1=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
			//$cursorprot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
				#print_r($cursorprot);
				//var_dump($cursorprot->getNext());
				#$result=array();
		
			foreach ( $result as $docs){
				#echo $docs;
				foreach ( $docs as $array => $src_to_tgt ){

					foreach ( $src_to_tgt as $src => $tgt){
						#echo "src_to_tgt---".$src_to_tgt[0];
						#echo "tgt[0]---".$tgt[0];
						#foreach ( $tgt as $srcs => $tgts){
							if ($src_to_tgt[0]==$gene){
								#echo $gene;
								$cursor['result'][$i]['prot preferred id']=$tgt[0];

							}
						#}
					
					}
				}

			}
		
		}
    
    	/*
    	#$text=$cursor['result'][$i][0];
    	#echo 'text :'.$text;
    	$gene=$cursor['result'][$i]['species preferred gene id'];
    	$cursor_prot=$ma->find(array('type'=>'gene_to_prot'),array('src_to_tgt'=>1,'_id'=>0));
		echo "count".count($cursor_prot);
    	foreach ( $cursor_prot as $results){
    			#for ($j = 0; $j < count($docs['src_to_tgt']); $j++) {

    				#echo "entering search prot";
    				#$results=$docs['src_to_tgt'][$j];
    		
    		foreach ( $results as $docs => $source){
    				
    			foreach ( $source as $array => $src_to_tgt ){
						
					foreach ( $src_to_tgt as $src => $tgt ){
						#echo $tgt[0]."-----";
						if ($tgt[0]==$gene){
							echo $tgt[0]."-----";
							echo $tgt[1][0];
							
							$cursor['result'][$i]['prot preferred id']=$tgt[1][0];

							
					
						}
					
					}
						
				}
			}
				
					
		}

				
				
	}
*/
	}
	else{
	}
    return $cursor;
    
  
}
### Find all pathogens experimentally infecting any angiosperm
function get_all_pathogens_infecting_angiosperm(Mongocollection $sp,Mongocollection $sa){

	#echo 'Entering get all pathogens function';
    $cursor=array();
    try
    {
        $cursors=get_all_synonyms($sp,'classification.unranked','Angiosperms');
        
        $keys =array();
        $val =array();
        foreach ( $cursors as $id => $value )
        {
            foreach ( $value as $ids => $values )
            {
                foreach ($values as $idss => $valuess )
                {
                    $keys[] = $idss;
                    #echo 'value:'.$valuess;
                    $val[] = $valuess;
                }
            
            
            }
        
        }
        $cursor=$sa->aggregate(array(
        array('$match' => array('species' => array('$in'=>$val),'experimental_results.conditions.infected'=>true)),
        array('$unwind'=>'$experimental_results'),
        array('$project' => array('species'=>1,'name'=>1,'experimental_results.conditions'=>1,'_id'=>0)),
        array('$unwind'=>'$experimental_results.conditions'),
        array('$match'=>array('experimental_results.conditions.infected'=>true)),
        array('$project'=>array('species'=>1,'name'=>1,'agent'=>'$experimental_results.conditions.infection_agent'))
        ));
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any Angiosperms, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    /*
    for ($i = 0; $i < count($cursor['result']); $i++) {
		$test=$cursor['result'][$i]['name'];
		
		if(is_array($test)){
			foreach ( $test as $id => $doc ){
			
				echo $id."=".$doc."<br/>";

			}
		}
		else{
			echo $test."<br/>";

		}
		
	}
	*/
	datatableFromAggregate($cursor);
    #var_dump($cursor);
    return $cursor;

}


### mapping table Request
function find_all_mappings_by_species(MongoCollection $ma,$species='null'){
	try
   {	
		$cursor=$ma->find(array('species'=>$species),array('type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any mapping doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function find_all_mappings_by_type(MongoCollection $ma,$type='null'){
	try
   {	
		$cursor=$ma->find(array('type'=>$type),array('type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any mapping doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function find_all_mappings_by_src(MongoCollection $ma,$src='null'){
	try
   {	
		$cursor=$ma->find(array('src'=>$src),array('type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any mapping doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function find_all_mappings(MongoCollection $ma){
	try
   {	
		$cursor=$ma->find(array(),array('type'=>1,'species'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any mapping doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}


function find_all_species(MongoCollection $sp){
	try
   {	
		//$cursor=$vi->find(array(),array('type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
		
		$cursor=$sp->aggregate(array( 
			array('$project' => 
						array('full_name' => 1,
								'species' => '$classification.species',
								'aliases' => 1,
								'top' => '$classification.top_level',
								'_id'=>0
								)
					)
				));	
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any viruses doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}



###viruses table request

function find_all_viruses(MongoCollection $vi){
	try
   {	
		//$cursor=$vi->find(array(),array('type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1));
		
		$cursor=$vi->aggregate(array( 
			array('$project' => 
						array('full_name' => 1,
								'species' => '$classification.species',
								'aliases' => 1,
								'top' => '$classification.top_level',
								'_id'=>0
								)
					)
				));	
	}
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any viruses doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}

### sample table requests

function find_all_xp_name(Mongocollection $sa){
	$cursor=$sa->find(array(),array('name'=>1));
    
	return $cursor;
}
function get_all_variety(Mongocollection $sa){
	$cursor=array();
    try
    {
        
        $cursor=$sa->aggregate(array(
        array('$match'=> array('experimental_results.conditions.infected'=>true)),
        array('$unwind'=>'$experimental_results'),
        array('$project'=>array('species'=>1,'name'=>1,'experimental_results.variety'=>1,'experimental_results.conditions'=>1,'_id'=>0)),
        array('$unwind'=>'$experimental_results.conditions'),
        array('$match'=>array('experimental_results.conditions.infected'=>true)),
        array('$project'=>array('species'=>1,'name'=>1,'type'=>'$experimental_results.variety','agent'=>'$experimental_results.conditions.infection_agent'))
        ));
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any Angiosperms, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    
    return $cursor;


}
function find_experiment_type_list(Mongocollection $sa){
	$cursor=array();
    try
    {
		#$cursor = $sa->find(array(),array('assay.type'=>1));
		$cursor = $sa->distinct('assay.type');

		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;


}


### species table requests

function find_species_doc(Mongocollection $sp,$txt='null'){
    $cursor=array();
    try
    {
        $cursor = $sp->findOne(array('$or'=>array(array('full_name'=>$txt),array('aliases'=>$txt),array('abbrev_name'=>$txt))));
		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function find_viruses_doc(Mongocollection $vi,$txt='null'){
    $cursor=array();
    try
    {
        $cursor = $vi->findOne(array('$or'=>array(array('full_name'=>$txt),array('aliases'=>$txt),array('abbrev_name'=>$txt))));
		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species doc, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;
}
function find_viruses_list(Mongocollection $sp){
	$cursor=array();
    try
    {
    	#$cursor = $sp->distinct('full_name',array('classification.top_level'=>'viruses'));
		$cursor = $sp->distinct('full_name',array('$or'=>array(array('classification.top_level'=>'viruses'),array('classification.kingdom'=>'Fungi'))));

		#$cursor = $sp->find(array('classification.top_level'=>'viruses'),array('full_name'=>1));
		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;


}
function find_species_list(Mongocollection $sp){
	$cursor=array();
    try
    {
    	$cursor = $sp->distinct('full_name',array('$and'=>array(array('classification.top_level'=>'Eukaryotes'),array('classification.kingdom'=>'Plantae'))));

		#$cursor = $sp->find(array(),array('_id'=>1,'full_name'=>1));
		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;


}

### measurements table requests
function get_tgt_id_from_src_id(Mongocollection $me,$src_id='null'){

	$tgt_id='';
	//$cursor = $ma->findOne(array());
	$cursor=$me->find(array('gene_original_id'=>$src_id),array('gene'=>1));
	$tgt_id=$cursor['result']['gene'];

	return $tgt_id;
}










?>

