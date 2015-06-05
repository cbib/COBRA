 <?php
 session_start(); // ici on continue la session
 if ((!isset($_SESSION['login'])) || ($_SESSION['login'] == ''))
 {
	// La variable $_SESSION['login'] n'existe pas, ou bien elle est vide
	// <=> la personne ne s'est PAS connectée
	echo '<p>You have to be <a href="/database/index.php"> logged</a>.</p>'."\n";
	exit();
 }
 
 ?>