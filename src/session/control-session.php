<?php
session_start(); // ici on continue la session



 
if ((!isset($_SESSION['login'])) || ($_SESSION['login'] === ''))
{
    error_log("into control session and in directory ". MAINDIR);
    //header('Location: /var/www/html/COBRA/login.php'); 
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'login.php';
    header("Location: http://$host$uri/$extra");
    //http://127.0.0.1/Users/benjamindartigues/COBRA/GIT/COBRA/login.php
//    new_cobra_header();
//    new_cobra_body(False, "Login form");
//	echo '<p>You have to be <a href="/login.php"> logged</a>.</p>'."\n";
//	new_cobra_footer();
//    exit();
}
 
?>
