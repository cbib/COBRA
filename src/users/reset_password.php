<?php

 	session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header();



	$db=mongoConnector();
	$usersCollection = new Mongocollection($db, "users");
	if (((isset($_GET['pwd1'])) && ($_GET['pwd1']!='')) && ((isset($_GET['pwd2'])) && (($_GET['pwd2']!='')))){
		
		//here update new password using md5 command
		if ($_GET['pwd1']==$_GET['pwd2']){
			new_cobra_body($_SESSION['login'],"");
			$pwd=md5($_GET['pwd1']);
			$usersCollection->update(array('firstname'=>$_SESSION['firstname'],'lastname'=>$_SESSION['lastname']), array('$set' => array('pwd' => $pwd)));
            echo "<p> your new password has been successfully saved";
		}
		else{
			//alert("you need to confirm with the same password !!! ");
			echo "<script>alert('you need to confirm with the same password');</script>"; 

			
			header ('Location: ../search/index.php');
		}
		
	}
	new_cobra_footer();

?>