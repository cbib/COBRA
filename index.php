<?php

require 'src/functions/html_functions.php';
require 'src/functions/php_functions.php';
require 'src/functions/mongo_functions.php';

new_cobra_header();
new_cobra_body();
$db=mongoConnector();
$usersCollection = new Mongocollection($db, "users");
session_start();
//include('connection.php');
// Déconnexion
if ((isset($_GET['act'])) && ($_GET['act'] == 'logout'))
{
	$_SESSION = array();
	session_destroy();
	echo '<p>Vous avez été correctement deconnecté(e)</p>'."\n";
	echo '<p>Nouvelle connexion ?  <a href="./index.php">cliquez ici</a></p>'."\n";

 
	// on relance une session pour une éventuelle reconnexion
	//session_start();
}
else{
	if ((!isset($_SESSION['login'])) || ($_SESSION['login'] == '')){
		if (!isset($_POST['submit']))
		{
			// c'est la première fois qu'on vient sur cette page, aucun formulaire soumis
			echo '
			<form id="connect" method="post" action="">
			<fieldset><legend>Authentication required</legend>
			
				<p>A username and password are being requested by https://cobra. The site says: "Secure Site"</p>
				<p><label for="login">Login \t: </label><input type="text" id="login" name="login" tabindex="1" value="" /></p>
				<p><label for="pwd">Password :</label><input type="password" id="pwd" name="pwd" tabindex="2" /></p>
			</fieldset>
			<div><input type="submit" name="submit" value="Connexion" tabindex="3" /></div>
			</form>';
		}
		else
		{
			// le formuaire vient d'être soumis
			$login  = (isset($_POST['login'])) ? htmlentities(trim($_POST['login'])) : '';
			$pwd   = (isset($_POST['pwd']))    ? htmlentities(trim($_POST['pwd']))   : '';
 
			if (($login != '') && ($pwd != ''))
			{
				// Login et pwd non vides, on  vérifie s'il y a quelqu'un qui correspond
				$user=$usersCollection->find(array("login"=>$login,"pwd"=>$pwd),array("lastname"=>1,"firstname"=>1));
		
				foreach ( $user as $person ) { 
					echo $person['lastname'];
				//var_dump($user);
				}
				if (count($user)==1)
		
				{
	
 
					// On  enregistre ses données dans la session
					$_SESSION['login'] = $login; // permet de vérifier que l'utilisateur est bien connecté
					$_SESSION['firstname'] = $person['firstname'];
					$_SESSION['lastname'] = $person['lastname'];
					// Maintenant que tout est enregistré dans la session, on redirige vers la page des photos
					echo '<p>Vous êtes correctement identifié(e), <a href="./src/search/search.php">cliquez ici</a></p>'."\n";
					header('Location: ./src/search/search.php');  
				}
				else
				{
					// Erreur dans le login et / ou dans le mot de passe ...
					echo '<p>Désolé, vous avez peut-être fait une erreur dans la saisie des identifiants, mais votre parcours se finit là ... </p>'."\n";
				}
			}
			else
			{
				// il n'y a personne qui répond à ces 2 identifiants
				echo '<p>Désolé, vous avez peut-être fait une erreur dans la saisie des identifiants, mais votre parcours se finit là ... </p>'."\n";
			};
		} // end of (isset($_POST['submit']))
	}
	else{

		header('Location: ./src/search/search.php');  

	}
}



new_cobra_footer();


?>