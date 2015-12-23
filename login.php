<?php
session_start();

require 'src/functions/html_functions.php';
require 'src/functions/php_functions.php';
require 'src/functions/mongo_functions.php';

new_cobra_header(".");

$db=mongoConnector();
$usersCollection = new Mongocollection($db, "users");

//include('connection.php');
// Déconnexion

if ((isset($_GET['act'])) && ($_GET['act'] == 'logout'))
{
	new_cobra_body(False, "COBRA","section_disconnect",".");
	if ((isset($_SESSION['login'])) && (!empty($_SESSION['login']))){
		$_SESSION = array();
		
		session_destroy();
		echo '<p>You have been disconnected</p>'."\n";
		echo '<p>New connection ?  <a href="./login.php">Click here</a></p>'."\n";
		//session_start();
 	}
 	// else{
//  		echo '<p>You are not connected</p>'."\n";
// 		echo '<p>New connection ?  <a href="./login.php">Click here</a></p>'."\n";
// 		session_start();
//  	}
 	
	// on relance une session pour une éventuelle reconnexion
	
}
else{
	
	
	if ((!isset($_SESSION['login'])) || ($_SESSION['login'] == '')){
		
		if (!isset($_POST['submit']))
		{
			// first time no form submitted
			new_cobra_body(isset($_SESSION['login']),"Login form","section_login",".");
			
            
            
//            echo '
//			<form id="login_form" method="post" action="">
//                <fieldset>
//                    <legend>
//                        Authentication required
//                    </legend>			
//                    <p>
//                        A username and password are being requested by https://cobra. The site says: "Secure Site"
//                    </p>
//                    <p>
//                        <label for="login">Username : </label>
//                        <input type="text" id="login" name="login" tabindex="1" value="" />
//                    </p>
//                    <p>
//                        <label for="pwd">Password :</label>
//                        <input type="password" id="pwd" name="pwd" tabindex="2" />
//                    </p>
//                </fieldset>
//                <div>
//                    <input type="submit" name="submit" value="Connexion" tabindex="3" />
//                </div>
//			</form>';
            
            
            
            echo'<form id="login_form" class="form-horizontal" method="post" action="login.php">
                <fieldset>
		<legend>
                    Authentication required
                </legend>
                <!--<p>A username and password are being requested by https://cobra. The site says: "Secure Site"</p>-->
                <div class="form-group">
                  <label for="login" class="col-sm-2 control-label">Username </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="login" name="login" placeholder="Username">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="pwd" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password">
                  </div>
                </div>
                
                <!--<div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="checkbox_remember_me"> Remember me
                      </label>
                    </div>
                  </div>
                </div>-->
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit"  value="Connexion" class="btn btn-default">Sign in</button>
                  </div>
                </div>
		</fieldset>
              </form>';
              //<form class="form-inline">';
              
            
		}
		else
		{
				
			// Form has been submitted
			$login  = (isset($_POST['login'])) ? htmlentities(trim($_POST['login'])) : '';
			$pwd   = (isset($_POST['pwd']))    ? htmlentities(trim($_POST['pwd']))   : '';
 
			if (($login != '') && ($pwd != ''))
			{
				// Login et pwd non vides, on  vérifie s'il y a quelqu'un qui correspond
				$user=$usersCollection->find(array("login"=>$login,"pwd"=>md5($pwd)),array("lastname"=>1,"firstname"=>1));
				$userArray = iterator_to_array($user);
				if (count($userArray)!=0)
		
				{
					//echo 'here';
					foreach ( $user as $person ) { 
				//	echo $person['lastname'];
				// var_dump($user);
					//echo '<p>Désolé, vous avez peut-être fait une erreur dans la saisie des identifiants, mais votre parcours se finit là ... </p>'."\n";

					
	
 						if (($person['lastname'] != '') && ($person['firstname'] != '')){
 							session_start();
							// On  enregistre ses données dans la session
							$_SESSION['login'] = $login; // permet de vérifier que l'utilisateur est bien connecté
							$_SESSION['firstname'] = $person['firstname'];
							$_SESSION['lastname'] = $person['lastname'];
							// Maintenant que tout est enregistré dans la session, on redirige vers la page des photos
							echo '<p>Vous êtes correctement identifié(e), <a href="./src/search/index.php">cliquez ici</a></p>'."\n";
							
							//header('Location: index.php'); 
							header('Location: ./wiki/index.php'); 

						} 
						else{
							echo '<p>Sorry, these fields have not been filled... </p>'."\n";
						
						}
					}
				}
				else
				{
						// Erreur dans le login et / ou dans le mot de passe ...
                        error_log("error with login or password");
						new_cobra_body(False);
						echo '<p>Sorry, you may have made an error in the input identifiers... </p>'."\n";
						
				}
				
			}
			else
			{
				// il n'y a personne qui répond à ces 2 identifiants
				echo '<p>Sorry, you may have made an error with the input identifiers </p>'."\n";
			};
		} // end of (isset($_POST['submit']))
	}
	else{
		
		
		//header('Location: ./src/search/index.php');  
		//header('Location: index.php'); 
        header('Location: ./wiki/index.php');

	}
}



new_cobra_footer();


?>
