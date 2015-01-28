<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Notre première instruction : echo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
    <body>
        <h2>Affichage de texte avec PHP</h2>
        
        <p>
            Cette ligne a été écrite entièrement en HTML.<br />
            <!--<form action="cible.php" method="post" accept-charset=utf-8>
			<p>
    		<input type="text" name="prenom" />
    		<input type="submit" value="Valider" />
			</p>
			</form>-->
            <?php echo "Celle-ci a été écrite entièrement en PHP."; 
            //$dbhost = 'localhost';  
			$dbname = 'mydb';  
  			phpinfo();
  			
			// Connect to test database  
			$m = new Mongo();  //"mongodb://localhost"
			$db = $m->$dbname; 
			
			 
			/*$article = array("titre" => 'MongoDB exemple',"texte" => 'Ceci est un test darticle pour tester MongoDB',"date" =>  '2009-03-03',"auteur" => 'DJo',"comments" => array( array("texte" => 'Super article !!',"date" => '2009-03-04',"auteur" => 'Toto'),array("texte" => 'Je confirme, le NoSQL ça dechire !',"date" => '2009-03-04',"auteur" => 'Novaway')));
			
			
			$db->articles->insert($article);
			$collectionArticles = $db->articles;
			$query = array( "titre" => "MongoDB exemple");
			$champs = array('comments' => 0);
			$article = $collectionArticles->findOne($query, $champs);
			*/
  			//$mongoDB = new Mongo();
        	$database = $mongoDB->selectDB($db);
        	$collection = $database->createCollection('TestCollection');
        	$collection->insert(array('test' => 'Test OK'));

        	$retrieved = $collection->find();
        	foreach ($retrieved as $obj) {
          		echo($obj['test']);
        	}
			// select the collection  
			//$collection = $db->shows;  
  
			// pull a cursor query  
			//$cursor = $collection->find();
			
            
             ?>
        </p>
    </body>
</html>