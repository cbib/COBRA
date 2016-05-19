<?php

 	session_start();
 	include '../functions/html_functions.php';
 	include '../functions/php_functions.php';
 	include '../functions/mongo_functions.php';
 	require '../session/control-session.php';
 
	new_cobra_header("../..");



	$db=mongoConnector();
	$usersCollection = new Mongocollection($db, "users");
	if (((isset($_GET['pwd1'])) && ($_GET['pwd1']!='')) && ((isset($_GET['pwd2'])) && (($_GET['pwd2']!='')))){
		
		//here update new password using md5 command
		if ($_GET['pwd1']==$_GET['pwd2']){
            $error=check_password($_GET['pwd1']);
            if ($error!=""){
                
                new_cobra_body($_SESSION['login'],"Password Error","section_password_failure","../..");
                
                $error_message="Password validation failure(your choise is weak): $error";
                //echo "<script>alert($error_message);</script>"; 
                echo "<p> $error_message</p>";
                echo '<a href=""></a>';
                $firstname=$_SESSION['firstname'];
                $lastname=$_SESSION['lastname'];
                echo '<p>Back to Cobra?  <a href="./user.php?firstname='.$firstname.'&lastname='.$lastname.'">Click here</a></p>'."\n";
                //header ('Location: ../search/index.php');
            }
            else{
                new_cobra_body($_SESSION['login'],"Password Details","section_reset_password","../..");
                $pwd=md5($_GET['pwd1']);
                $usersCollection->update(array('firstname'=>$_SESSION['firstname'],'lastname'=>$_SESSION['lastname']), array('$set' => array('pwd' => $pwd)));
                echo "<p> your new password has been successfully saved </p>";
                header ('Location: ../search/index.php');
                
            }
            
            
			
		}
		else{
			//alert("you need to confirm with the same password !!! ");
			echo "<script>alert('you need to confirm with the same password');</script>"; 

			
			header ('Location: ../search/index.php');
		}
		
	}
	new_cobra_footer();

?>