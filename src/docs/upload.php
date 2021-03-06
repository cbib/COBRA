<?php 
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
//include '../../wiki/vendor/autoload.php';
require('../session/control-session.php');
$db=mongoConnector();

//$grid = $db->getGridFS();
////Selection des collections
//$samplesCollection = new MongoCollection($db, "samples");
//$speciesCollection = new Mongocollection($db, "species");
//$mappingsCollection = new Mongocollection($db, "mappings");
//$measurementsCollection = new Mongocollection($db, "measurements");
//$virusesCollection = new Mongocollection($db, "viruses");
//$interactionsCollection = new Mongocollection($db, "interactions");
//$orthologsCollection = new Mongocollection($db, "orthologs");
$docsCollection = new Mongocollection($db, "docs");

new_cobra_header("../..");
new_cobra_body($_SESSION['login'],"Upload files Page","section_upload_file","../..");
//$docsCollection = $db->createCollection("docs");


$dossier = 'COBRA_depot/';
$fichier = basename($_FILES['fileToUpload']['name']);

$max_size = 100000000;
$size = filesize($_FILES['fileToUpload']['tmp_name']);
$extensions = array('.doc','.docx','.txt','.png', '.gif', '.jpg', '.jpeg','.pdf','.xls','.xlsx','ppt','pptx');
$extension = strrchr($_FILES['fileToUpload']['name'], '.'); 
//Début des vérifications de sécurité...
echo $extension; 
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Upload valid only for type png, gif, jpg, jpeg, txt or doc...';
}
if($size>$max_size)
{
     $erreur = 'File is over 100 Mo';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //Formatting file
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     //testing if file has been moved
     if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Your file '.$fichier.' was upload successfully !';
          $full_path=$dossier.$fichier;
          $author_full_name=$_SESSION['firstname'].' '.$_SESSION['lastname'];
          
          //tester l'existence du document
          
          // retrieve existing document
          $criteria = array('full_file_name' => $full_path);
          $doc = $docsCollection->findOne($criteria);

          if(!empty($doc) ){
            echo 'Data Already Exist';
          } 
          else {
            $document = array( 
                "full_file_name" => $full_path, 
                "description" => "database document from partners", 
                "author" => $author_full_name 
            );
            $docsCollection->insert($document);
            header('Location: ./index.php');
          }
          
          
          
          
          
          
          
          
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Upload failed, please check repertory permission!';
     }
}
else
{
     echo "<div>".$erreur."</div>";
     error_log($erreur);
}














//$target_dir = "../COBRA_repository/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
////$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
//    
//    echo $_POST["submit"];
////    $check = getimagesize($_FILES["fileToUpload"]["name"]);
////    if($check !== false) {
////        echo "File is an image - " . $check["mime"] . ".";
////        $uploadOk = 1;
////    } else {
////        echo "File is not an image.";
////        $uploadOk = 0;
////    }
//}

new_cobra_footer(); 
  

?>

