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
    		exit();
	}
}









?>

