 <?php
 	session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header();


	new_cobra_body($_SESSION['login'],"Users information details","section_user_details");
 	if ((isset($_GET['firstname'])) && ((isset($_GET['lastname'])))){
 		$firstname=htmlentities(trim($_GET['firstname']));
 		$lastname=htmlentities(trim($_GET['lastname']));
 	
 	}
 	else{
 		echo '<p>You are not registered </p>'."\n";
 		exit();

 	}
 	$db=mongoConnector();
	$usersCollection = new Mongocollection($db, "users");
	$user=$usersCollection->find(array("firstname"=>$firstname,"lastname"=>$lastname),array());

 	make_user_preferences($user,$usersCollection);

    
    
 	new_cobra_footer();
 	
 
 
 ?>