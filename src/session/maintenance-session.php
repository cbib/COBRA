<?php
//session_start(); // ici on continue la session

 
 
if ((isset($_SESSION['maintenance'])) && ($_SESSION['maintenance'] == 'yes') && (($_SESSION['firstname'] != 'Dartigues') && ($_SESSION['firstname'] != 'Benaben')))
{
    //header('Location: ../../maintenance.php'); 
//    new_cobra_header();
//    new_cobra_body(False, "Login form");
//	echo '<p>You have to be <a href="/login.php"> logged</a>.</p>'."\n";
//	new_cobra_footer();
//    exit();
    $host  = $_SERVER['HTTP_HOST'];
    //$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $uri="cobra";
    $extra = 'maintenance.php';
    if ($host==="127.0.0.1"){
        //error_log("into control session and in directory ". $host ."/".$extra);
        header("Location: http://$host/$extra"); 
    }
    else{
        //error_log("into control session and in directory ". $host ."/".$uri."/".$extra);
        header("Location: http://$host/$uri/$extra"); 
    }
}
 
?>
