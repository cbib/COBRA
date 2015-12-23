<?php
session_start(); // ici on continue la session

error_log("into control session and in directory".$_SERVER["PHP_SELF"]);

 
if ((!isset($_SESSION['login'])) || ($_SESSION['login'] === ''))
{
    header('Location: ./login.php'); 
//    new_cobra_header();
//    new_cobra_body(False, "Login form");
//	echo '<p>You have to be <a href="/login.php"> logged</a>.</p>'."\n";
//	new_cobra_footer();
//    exit();
}
 
?>
