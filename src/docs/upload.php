<?php 
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
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

new_cobra_header();
new_cobra_body($_SESSION['login'],"Upload files Page","section_upload_file");

echo htmlspecialchars($_POST['Upload File']);

new_cobra_footer(); 
  

?>

