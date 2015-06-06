<?php
 <?php
 	session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header();


	new_cobra_body($_SESSION['login']);
	$db=mongoConnector();
	$usersCollection = new Mongocollection($db, "users");
	if ((isset($_GET['password'])) && (($_GET['password']!=''))){
		//here update new password using md5 command
		$pwd=md5($_GET['password']);
		$usersCollection->update();
	}

	
	
	new_cobra_footer();

?>