<?php



function MongoConnector() {

	try
	{
		$m = new Mongo(); // connect
    		$db = $m->selectDB("mydb");
	}
	catch ( MongoConnectionException $e )
	{
    		echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
    		exit();
	}
	return $db;	
}










?>

