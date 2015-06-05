<?php

// on teste si le visiteur a soumis le formulaire de connexion
//if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
//	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {




require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require('../session/control-session.php');

new_cobra_header();
new_cobra_body();


//include('connection.php');



$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$sampleCollection = new Mongocollection($db, "samples");
$virusCollection = new Mongocollection($db, "viruses");
$measurementsCollection = new Mongocollection($db, "measurements");
$publicationsCollection = new Mongocollection($db, "publications");
$interactionsCollection = new Mongocollection($db, "interactions");

#find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));
#<div class="container">
#	<div class="col-xs-6">
echo'


			<!--<div class="column-padding no-left-margin"><div class="container"><div class="col-xs-6"><h2>Select examples</h2><p>Select a species in the list :</p>-->
			<!--<form role="form" action="src/resultats.php" method="post" >-->

			<div class="container">
				<div class="col-xs-6">';
					make_species_list(find_species_list($speciesCollection));
					echo '<h2> Using list of genes ids</h2>';
					
					echo '</hr>';
					make_gene_id_text_list();
					echo '<h2> Cross compare datasets</h2>';
					
					echo '</hr>';
					make_CrossCompare_list(find_species_list($speciesCollection));
					make_viruses_list(find_viruses_list($virusCollection));
					
					#make_plaza_orthologs(get_plaza_orthologs($grid,"plaza_gene_identifier",));
					
					

					//make_species_list_2();
					//make_viruses_list(find_viruses_list($speciesCollection));
					//make_experiment_type_list(find_experiment_type_list($sampleCollection));
					#make_request_list();
					//style="padding : 5px" 
				echo' 
				</div>
					
					
												<!--
												<div class="plain-box">
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
												-->
				
				
				<div class="col-xs-6"  style="border: 2px solid grey">
					<div class="col-xs-12" >
						<div class="column-padding no-right-margin">
				';
				//make_whats_new();
				// 'A/ report_date':datetime.datetime.now(),
// 		'B/ Number of samples':samples_col.count(),
// 		'C/ Number of normalized measures':measurements_col.count(),
// 		'C_a/ Tally of normalized measures':measurements_col.aggregate([{"$group":{"_id":"$type", "count": { "$sum": 1 }}}])['result'],
// 		'D/ Number of species':species_col.count(),
// 		'D_a/ Number of species per top_level':species_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result'],
// 		'D_b/ Number of viruses per top_level':viruses_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result']

//<!--<p><h4>Last update : '.date().'</h4></p>-->
					  echo '<!--<div class="plain-box">
									<h2 id="features">
									Some statistics...
									</h2>
					  			</div>-->
								<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">
								<h1 style="text-align:center">	Some statistics...</h1>
								</div>
								<p><h4>Last update : '.getlastmod().'</h4></p> 
								<p><h4>Number of samples : '.$sampleCollection->count().'</h4></p>
								<p><h4>Number of normalized measures : '.$measurementsCollection->count().'</h4></p>
								
								<p><h4>Number of species : '.$speciesCollection->count().'</h4></p>';
								
								$cursor=$speciesCollection->aggregate(array(
								array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
								));
								echo '<p> <h4>Species per top_level</h4>';
								foreach ($cursor['result'] as $doc){
									echo '<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
								}
								$cursor=$virusCollection->aggregate(array(
								array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
								));
								echo '<p><h4> Pathogens per top_level</h4>';
								foreach ($cursor['result'] as $doc){
									echo '<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
								}
								echo '
								
						</div>
					</div>
				</div>
				
				<!--<div class="container">
					<div class="form-field ff-multi">
						<div class=ff-inline ff-right">
							<img src="images/NINSAR_LOGO.jpg" />
							<img src="images/LOGO_CSIC.jpg" />
							<img src="images/abiopep.jpg" />
							<img src="images/INRA.jpg" />
							<img src="images/GAFL.jpg" />
						</div>
					</div>
				</div>-->
			</div>
		



';
//new_cobra_species_container();


new_cobra_footer();


?>
