<?php



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
    	#$cursor = $sp->distinct('full_name',array('$and'=>array(array('classification.top_level'=>'Eukaryotes'),array('classification.kingdom'=>'Plantae'))));

		$cursor = $sp->find(array(),array('_id'=>1,'full_name'=>1));
		
    
    
    }
    catch ( MongoConnectionException $e )
    {
            echo '<p>Couldn\'t get any species, Do you have data processed?</p>';
            echo $e->getMessage();
        exit();
    }
    return $cursor;


}





//* Find all synonyms
function get_all_synonyms(Mongocollection $sp, $key='null', $value='null'){
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


// Find all aliases
// Find all genes up-regulated in the melon when infected with CMV
function get_all_genes_up_regulated(MongoCollection $me,Mongocollection $sp,Mongocollection $sa, $species='null', $virus='null',$est_id='null'){
	
	#echo 'entering get all gens up regulated for : species:'.$species;
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
		array('$match'=>array('experimental_results.values.logFC'=> array('$gt'=> 4))), 
		array('$project'=>array('id'=>'$experimental_results.values.est_unigen','FC'=>'$experimental_results.values.logFC','species'=>1,'name'=>1,'src_pub'=>1,'infection_agent'=>'$experimental_results.conditions.infection_agent'))
		));
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
    
    }
    
    
    for ($i = 0; $i < count($cursor['result']); $i++) {
    	$text=$cursor['result'][$i][0];
    	echo 'text :'.$text;
    	$test=$cursor['result'][$i]['id'];
    	$FC=$cursor['result'][$i]['FC'];
    
    	$cursor2=$me->find(array('gene_original_id'=>$test,'logFC'=>$FC),array('gene_original_id'=>1,'gene'=>1,'xp'=>1));
    	foreach ( $cursor2 as $doc ){

			$gene=$doc['gene'];
    		$cursor['result'][$i]['species preferred id']=$doc['gene'];
    	
    	 
		}

    	 
	}
	
    return $cursor;
    
  
}

// Find all plant variety infected
function get_tgt_id_from_src_id(Mongocollection $me,$src_id='null'){

	$tgt_id='';
	//$cursor = $ma->findOne(array());
	$cursor=$me->find(array('gene_original_id'=>$src_id),array('gene'=>1));
	$tgt_id=$cursor['result']['gene'];
	
	
	
	

	return $tgt_id;
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

//* Find all pathogens experimentally infecting any angiosperm
function get_all_pathogens_infecting_angiosperm(Mongocollection $sp,Mongocollection $sa){

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
    
    return $cursor;

}







?>

