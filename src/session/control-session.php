<?php
session_start(); // ici on continue la session



 
if ((!isset($_SESSION['login'])) || ($_SESSION['login'] === ''))
{
    error_log("into control session and in directory".$_SERVER['DOCUMENT_ROOT']);
    header('Location: /login.php'); 
//    new_cobra_header();
//    new_cobra_body(False, "Login form");
//	echo '<p>You have to be <a href="/login.php"> logged</a>.</p>'."\n";
//	new_cobra_footer();
//    exit();
}
 
?>
