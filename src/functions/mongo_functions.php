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





//* Find all angiosperms
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
        array('$project'=>array('species'=>1,'name'=>1,'material'=> '$experimental_results.material','variety'=> '$experimental_results.variety','agent'=>'$experimental_results.conditions.infection_agent'))
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

