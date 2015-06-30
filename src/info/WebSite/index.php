<?php
//session_start();
include '../../functions/html_functions.php';
include '../../functions/php_functions.php';
include '../../functions/mongo_functions.php';
require '../../session/control-session.php';




/*
define('ROOT_PATH', realpath(dirname(__FILE__)) .'/../../');

require ROOT_PATH.'src/functions/html_functions.php';
include ROOT_PATH.'src/functions/php_functions.php';
include ROOT_PATH.'src/functions/mongo_functions.php';
*/
new_cobra_header();


new_cobra_body($_SESSION['login'], "Help","section_help");

$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$sampleCollection = new Mongocollection($db, "samples");
#find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));

echo'
<div class="container">
  <h2>COBRA Datasets</h2>
  
  
  <p>Select a species in the list :</p>
  <form role="form" action="../../resultats.php" method="post" >
    <div class="form-group">
      <!--<label for="geneID">Liste Deroulante:</label>
      <select class="form-control" id="geneID" name="geneID">
       <option value ="">----Choisir----</option>
	   <option value="gene1">Gene 1</option>
       <option value="gene2">Gene 2</option>
       <option value="gene3">Gene 3</option>
       <option value="gene4">Gene 4</option>
      </select>
      <div class="form-group">
        <label for="multipleID">Muliple Select List</label>
            <select multiple class="form-control" id="multipleID" name="multipleID">
                <option value="multiple1">Gene 1</option>
                <option value="multiple2">Gene 2</option>
                <option value="multiple3">Gene 3</option>
                <option value="multiple4">Gene 4</option>
                <option value="multiple5">Gene 5</option>
            </select>
      </div>
      <br>-->
    </div>';
    make_species_list(find_species_list($speciesCollection));
    make_viruses_list(find_viruses_list($speciesCollection));
    make_experiment_type_list(find_experiment_type_list($sampleCollection));
    #make_request_list();
    echo' 
    <br>
    <div class="form-group">
        <label for="requestID">Multiple Select List</label>
        <select multiple class="form-control" id="requestID" name="requestID">
            <option value="Request1">get all uniprot id from genes up regulated from a given species in microarray analysis of infection by a given virus</option>
            <option value="Request2">get all angiosperms infected by a given pathogen</option>
            <option value="Request3">find a gene using a regular expression</option>
            <option value="Request4">Request 4</option>
        	<option value="Request5">Request 5</option>
        </select>
    </div>
    <div class="form-group">
      <label for="textInput">choose a gene id</label>
      <input type="text" name="textInput" class ="form-control" placeholder="Tapez ici..." id="textInput">
    </div>
    <div class="form-group">
      <label for="logFCInput">choose min logFC value</label>
      <input type="number" step="0.0001" name="logFCInput" class ="form-control" placeholder="Tapez ici..." id="logFCInput">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </form>
</div>


';
new_cobra_species_container();


new_cobra_footer();


?>
