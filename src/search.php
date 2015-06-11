<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');


define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


new_cobra_header();

new_cobra_body($_SESSION['login'],"Result Summary");


if (((isset($_GET['organism'])) && ($_GET['organism']!='')) && ((isset($_GET['search'])) && ($_GET['search']!=''))){


	$organism=control_post(htmlspecialchars($_GET['organism']));
	//$listID=control_post(htmlspecialchars($_GET['listID']));
	$search=control_post(htmlspecialchars($_GET['search']));
	

	$db=mongoConnector();

	$grid = $db->getGridFS();
	//Selection des collections
	$samplesCollection = new MongoCollection($db, "samples");
	$speciesCollection = new Mongocollection($db, "species");
	$mappingsCollection = new Mongocollection($db, "mappings");
	$measurementsCollection = new Mongocollection($db, "measurements");
	$virusesCollection = new Mongocollection($db, "viruses");
	$interactionsCollection = new Mongocollection($db, "interactions");
	$orthologsCollection = new Mongocollection($db, "orthologs");

	
	//get_all_results_from_samples($measurementsCollection,$samplesCollection,$search);

	
	
	
	
	// //search in measurmeent table
// 	$search_string=$search;
// 	$regex=new MongoRegex("/^$search_string/m");
// 	$cursor = find_gene_by_regex($measurementsCollection,$regex);
// 	echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
// 	//echo'<h1 style="text-align:center"> Samples informations </h1>';
// 	echo '</div>';
// 	$array = iterator_to_array($cursor);
	

// echo'<div class="container">
// 	<h2>Search Results for \''.$search.'\'</h2></div>';


//if more than one results (often the case when search by gene symbol or keywords



echo '<div class="resultsbox" id="results">
 			<div class="results-right">
 				<div class="organism">'.$organism.'</div>
 				<div class="associations"></div>
 			</div>
 			<div class="results-left">
 				<div class="officialSymbol">HB1 ('.$search.')</div>
 				<div class="associations">Matching Synonym: HEMOGLOBIN</div> 
 				<div class="definition">non-symbiotic hemoglobin 1</div>
 		
 			</div>
     	<div class="linkURL">http://thebiogrid.org/1462/summary/arabidopsis-thaliana/hb1.html</div></div>';
 //else
$mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('type'=>1,'description'=>1,'url'=>1,'src'=>1,'tgt'=>1,'mapping_file'=>1,'_id'=>0));

foreach ($mappings_to_process as $map_doc){
		
	$src_col = $map_doc['src'];
	$tgt_col = $map_doc['tgt'];
	$type=$map_doc['type'];
	$description=$map_doc['description'];
	$url = $map_doc['url'];
	$map_file = $map_doc['mapping_file'];
	
	if ($type=='gene_to_prot'){
		foreach ($map_file as $doc){
			if ($doc[$tgt_col]==$search){
			
				foreach ($doc as $key =>$value){
		
					if ($key=="idx" OR $key==$tgt_col){
				
					}
					else{
						echo'<dt>'.$key.'</dt>
							  <dd>'.$value.'</dd>';
					}
		
	
				}
		

			}
			if ($doc[$src_col]==$search){
				foreach ($doc as $key =>$value){
					
					if ($key=="idx" OR $key==$src_col){
					
					}
					else if($key==$description){
				
					}
					else{
					
						echo'<dt>'.$key.'</dt>
							  <dd>'.$value.'</dd>';
					

					}
					
				
				}
			}
		}
	}
		
		
	else if ($type=='gene_to_symbol'){
		
		foreach ($map_file as $doc){
			//if ($doc[$tgt_col]==$search){
			if ($doc[$src_col]==$search){
				foreach ($doc as $key =>$value){
					if ($key=="idx" OR $key==$src_col){
							//echo '<li>'.$key.' : '.$value.'</li></br>';
							
					}
					else if($key==$tgt_col){
						echo'<dt>'.$key.'</dt>
							  <dd>'.$value.'</dd>';
						//array_push($gene_symbol,$doc[$tgt_col]);
					}
					else if($key==$description){
						array_push($descriptions,$value);
					}
					else{
						echo'<dt>'.$key.'</dt>
							  <dd>'.$value.'</dd>';
					}

				}
			}
		}
			
		
	}
	else{
	
	
	}
}
echo '<div id="summary-header">
         <div id="protein-details">
         	<div id="organism" class="right"><h4>'.$organism.'</h4></div>
         	 <h1>P58IPK</h1>
             <div id="aliases">ATP58IPK, F15A17.190, F15A17_190, homolog of mamallian P58IPK, AT5G03160</div>
             <div id="definition">mamallian P58IPK-like protein</div> 
             
             
             <div id="goTerms">
             	<div class="goSummaryBlock">
             		<div class="goProcessSummary">
             			<strong>GO Process</strong> (1)
             		</div>
             		<div class="goNone">
             			<strong>GO Function</strong> (0)
             		</div>
             		<div class="goComponentSummary">
             			<strong>GO Component</strong> (3)
             		</div>
             	</div>
             	<div class="goTermsBlock">
             		<div class="goProcessTerms goTerms">
             			<h3>Gene Ontology Biological Process</h3>
             				<ul>
             				 	<span class="goTerm">
             						<li>
             					 		<a target="_blank" href="http://amigo.geneontology.org/amigo/term/GO:0006457" title="protein folding">protein folding</a>
             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#iss" title="Go Evidence Code">ISS</a>]
             					 		</span>
             					</span>
             				</ul>
             		</div>
             		<div class="goComponentTerms goTerms">
             			<h3>Gene Ontology Cellular Component</h3>
             				<ul>
             					<span class="goTerm">
             						<li>
             							<a target="_blank" href="http://amigo.geneontology.org/amigo/term/GO:0005783" title="endoplasmic reticulum">endoplasmic reticulum</a> 
             							<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#ida" title="Go Evidence Code">IDA</a>]
             							</span
             					</span>
             					<span class="goTerm">
             						<li>
             							<a target="_blank" href="http://amigo.geneontology.org/amigo/term/GO:0005788" title="endoplasmic reticulum lumen">endoplasmic reticulum lumen</a>
             							<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#ida" title="Go Evidence Code">IDA</a>]
             							</span>
             					</span><
             					span class="goTerm">
             						<li>
             							<a target="_blank" href="http://amigo.geneontology.org/amigo/term/GO:0005886" title="plasma membrane">plasma membrane</a> 
             							<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#ida" title="Go Evidence Code">IDA</a>]
             							</span>
             					</span>
             				</ul>
             		</div>
             	</div>
             </div>
             <div id="linkouts">
             	<h3>External Database Linkouts</h3>
             		<a target="_BLANK" href="http://arabidopsis.org/servlets/TairObject?type=locus&name=AT5G03160" title="TAIR AT5G03160 LinkOut">TAIR</a>
             	 | <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/gene/831917" title="Entrez-Gene 831917 LinkOut">Entrez Gene</a> 
             	 | <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/sites/entrez?db=protein&cmd=DetailsSearch&term=NP_195936" title="NCBI RefSeq Sequences">RefSeq</a> 
             	 | <a target="_BLANK" href="http://www.uniprot.org/uniprot/Q9LYW9" title="UniprotKB Swissprot and Trembl Sequences">UniprotKB</a></div>
             <div class="bottomSpacer"></div> 
             <div id="geneID">17193</div>
             <div id="organismID">3702</div>
         </div>
         
         <input type="hidden" id="displayView" value="summary" />
 		 	<input type="hidden" id="displaySort" value="" />
         
         <div id="stat-details">
 				<div id="interaction-tabs">
               <ul>
                  <li title="stats" id="statsTab" class="noClickTab">Stats & Options</li>
               </ul>
            </div>
         	
     
     	
				<div id="statsAndFilters">

					<div id="pubStats" class="right">
						<strong>Publications:</strong>0
					</div>
					<h3>Current Statistics</h3>
					<div class="right">
						Low Throughput
					</div>
					<div>
						 High Throughput
					</div>
				
					<div class="physical-ltp statisticRow">
						<div class="physical colorFill" style="width: 0%;"></div>
						<div class="statDetails">
							<div class="left"></div>
							<div class="right"></div>
							0 Physical Interactions

						</div>
					</div>
					<div class="genetic-ltp statisticRow">
						<div class="genetic colorFill" style="width: 0%;"></div>
						<div class="statDetails"></div>
					</div>
					<br></br>
					<div class="right" style="margin-top: 3px">

						Customize how your results are displayed...
					</div>
					<h3>Search Filters</h3>
					<a id="filterLink" href="http://thebiogrid.org/scripts/displayFilterList.php">

						<div id="filterButton" class="noFilter" style="background-color: rgb(238, 238, 238); color: rgb(51, 51, 51);"></div>

					</a>
				</div>
			</div>

     	';
     	
 
 





}
else{



	echo'<div class="container">
	<h2>No Results found for \''.$search.'\'</h2></div>';
	
}
// echo '</div>';
?>






	<script type="text/javascript" class="init">
	$(document).ready(function() {
		$('#example').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
	$(document).ready(function() {
		$('#samplestable').dataTable( {
			"scrollX": true,
			"jQueryUI": true,
			"pagingType": "full_numbers",
			"oLanguage": { 
				"sProcessing":   "Processing...",
				"sLengthMenu":   "display _MENU_ items",
				"sZeroRecords":  "No item found",
				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
				"sInfoFiltered": "(filtered from _MAX_ items in total)",
				"sInfoPostFix":  "",
				"sSearch":       "Search: ",
				"sUrl":          "",
				"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Previous",
					"sNext":     "Next",
					"sLast":     "Last"
				}
			},
			"language": {
							"decimal": ",",
							"thousands": "."
				}
		});
	});
	</script>
<?php
	new_cobra_footer();



?>
