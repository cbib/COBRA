<?php
include './functions/simple_html_dom.php';


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


// Find all aliases
// Find all genes up-regulated in the melon when infected with CMV

function find_gene_by_regex(MongoCollection $me,MongoRegex $re){


	$searchQuery = array('gene'=>array('$regex'=> $re));

	$cursor = $me->find($searchQuery);
	$cursor->sort(array('logFC'=> -1));
	$cursor->limit(1000);
	
	return $cursor;
	#$cursor = $measurementsCollection->find($searchQuery,array('direction'=>1));

}
function get_all_genes_up_regulated(MongoCollection $me,Mongocollection $sp,Mongocollection $sa, Mongocollection $ma,$logFCInput='null',$species='null', $virus='null',$est_id='null'){
	
	
	#'experimental_results.values.$type'=>array('$exist'=>1)
	#array('experimental_results.values.$xls_parsing.id_type' => array('$exists' => true))
	#'experimental_results.values.$xls_parsing.id_type' => array('$exists' => true)
	#'experimental_results.values.est_unigen'=>1,
	#,'type'=>'$xls_parsing.id_type'
	
	#echo 'entering get all gens up regulated for : species:'.$species;
	if ($species=='Arabidopsis thaliana'){
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
    
    return $cursor;

}







?>

