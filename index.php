<?php
require 'src/functions/html_functions.php';
require 'src/functions/php_functions.php';
require 'src/functions/mongo_functions.php';

new_cobra_header();
new_cobra_body();

$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));

echo'
<div class="container">
  <h2>Select examples</h2>
  <p>Select a gene ID in the list :</p>
  <form role="form" action="src/resultats.php" method="post" >
    <div class="form-group">
      <!--<label for="geneID">Liste Deroulante:</label>
      <select class="form-control" id="geneID" name="geneID">
       <option value ="">----Choisir----</option>
	   <option value="gene1">Gene 1</option>
       <option value="gene2">Gene 2</option>
       <option value="gene3">Gene 3</option>
       <option value="gene4">Gene 4</option>
      </select>-->
    ';
      makeSpecies_List($cursor);
    echo' 
    </div>
    <br>
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
    <br>
    <div class="form-group">
      <label for="textInput">Tapez votre texte</label>
      <input type="text" name="textInput" class ="form-control" placeholder="Tapez ici..." id="textInput">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Envoyez</button>
    </div>
  </form>
</div>
';



new_cobra_footer();


?>
