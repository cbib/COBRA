<?php 
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
include '../../wiki/vendor/autoload.php';
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
//$GOCollection = new Mongocollection($db, "gene_ontology");

//$docsCollection = $db->createCollection("docs");
new_cobra_header();

new_cobra_body($_SESSION['login'],"Upload files Page","section_upload_file");
echo '<div id="doc_pages">';
echo '<div id="section_upload">';
echo '<form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000">

        Select file to upload: <input type="file" name="fileToUpload" id="fileToUpload">
    
        <input type="submit" value="Upload File" name="submit">
      </form>
      </div>';


echo '<div id="section_documents">';
$docsCollection = new Mongocollection($db, "docs");
$nb_files = 0;
$table_string="";
###Document TABLE

$table_string.='<table id="documents" class="table table-hover">';
//$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
$table_string.='<thead><tr>';
	
	//recupere le titre
	//$table_string.='<th>type</th>';
	$table_string.='<th>File name</th>';
	$table_string.='<th>From</th>';
    $table_string.='<th></th>';
    
	

	
	//fin du header de la table
$table_string.='</tr></thead>';
$table_string.='<tbody>';



$docs = $docsCollection->find(array('full_file_name'=>'COBRA_depot/a-FRIM02-Stade-Dev-Metabo.txt'));
var_dump($docs);


if($dossier = opendir('./COBRA_depot/'))
{
    while(false !== ($fichier = readdir($dossier)))
    {
        if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'){
            $nb_files++; // On incrémente le compteur de 1
            $table_string.='<tr>';
            $table_string.='<td>'.$fichier.'</td>';
            $table_string.='<td>'.$_SESSION['firstname'].$_SESSION['lastname'].'</td>';
            //echo '<li><a href="./mondossier/' . $fichier . '">' . $fichier . '</a></li>';
            $table_string.='<td><div class="btn-group">
                    <button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="#download" download="./COBRA_depot/'.$fichier.'">Download</a></li>
                      <li><a href="#remove">Remove</a></li>
                      <!--<li role="separator" class="divider"></li>
                      <li><a href="#">Separated link</a></li>-->
                    </ul>
                  </div></td>';
            $table_string.='</tr>';
        }
       
    }
    $table_string.='</tbody></table>';
    echo $table_string;
    
}

else{
     echo 'Le dossier n\' a pas pu être ouvert';
}


echo'</div>'
. '</div>';


new_cobra_footer(); 
  

?>

