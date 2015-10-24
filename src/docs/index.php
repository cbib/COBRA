<?php 
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
include '../../wiki/vendor/autoload.php';
require('../session/control-session.php');


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
$db=mongoConnector();
$docsCollection = new Mongocollection($db, "docs");
$nb_files = 0;
$table_string="";
###Document TABLE
echo '<button type="button" id="button" class="btn btn-info"><i class="fa fa-pencil"></i>delete selected items</button>';
$table_string.='<table id="documents" class="table ">';
//$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
$table_string.='<thead><tr>';
	
	//recupere le titre
	//$table_string.='<th>type</th>';
	$table_string.='<th>File name</th>';
	$table_string.='<th>Uploaded by</th>';
    $table_string.='<th>Actions</th>';
    
	

	
	//fin du header de la table
$table_string.='</tr></thead>';
$table_string.='<tbody>';



//$docs = $docsCollection->find(array('full_file_name'=>'COBRA_depot/a-FRIM02-Stade-Dev-Metabo.txt'),array());
$docs = $docsCollection->find();
foreach ($docs as $key) {
    $nb_files++;
    $fichier="";
    $table_string.='<tr>';
    foreach ($key as $id=>$value) {
        //echo $id.': '.$value;

        if ($id=="full_file_name"){
            
            $cobra_repository = explode("/", $value);
            $fichier=$cobra_repository[1];
            $table_string.='<td>'.$fichier.'</td>';
        }
        if ($id=="author"){
            $table_string.='<td>'.$value.'</td>';
        }
        //echo '<li><a href="./mondossier/' . $fichier . '">' . $fichier . '</a></li>';
        
    }
    $table_string.='<td><div class="btn-group">
                <!--<button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>-->
                

                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">

                  <li><a href="./COBRA_depot/'.$fichier.'" download>Download file</a></li>
                  <li><a href="./COBRA_depot/'.$fichier.'">Show file</a></li>
                  <li><a href="#" id="myHrefbuttonremove">Remove file</a></li>


                  <!--<li><a href="#">Remove</a></li>-->
                  <!--<li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>-->
                </ul>
              </div></td>';
        
    $table_string.='</tr>';
    
}
$table_string.='</tbody></table>';

echo $table_string;
//var_dump($docs);
//$docs = $docsCollection->find();

//var_dump($docs);


/*if($dossier = opendir('./COBRA_depot/'))
//{
//    while(false !== ($fichier = readdir($dossier)))
//    {
//        if($fichier != '.' && $fichier != '..' && $fichier != 'index.php'){
//            $nb_files++; // On incrémente le compteur de 1
//            $table_string.='<tr>';
//            $table_string.='<td>'.$fichier.'</td>';
//            $table_string.='<td>'.$_SESSION['firstname'].$_SESSION['lastname'].'</td>';
//            //echo '<li><a href="./mondossier/' . $fichier . '">' . $fichier . '</a></li>';
//            $table_string.='<td><div class="btn-group">
//                    <!--<button type="button" class="btn btn-info"><i class="fa fa-pencil"></i></button>-->
//                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//                      <span class="caret"></span>
//                      <span class="sr-only">Toggle Dropdown</span>
//                    </button>
//                    <ul class="dropdown-menu">
//                      
//                      <li><a href="./COBRA_depot/'.$fichier.'" download>Download file</a></li>
//                      <li><a href="#">Remove</a></li>
//                      <li><a href="#" id="myHrefbuttonremove">Remove file</a></li>
//                      
//                      <!--<li role="separator" class="divider"></li>
//                      <li><a href="#">Separated link</a></li>-->
//                    </ul>
//                  </div></td>';
//            $table_string.='</tr>';
//        }
//       
//    }
//    $table_string.='</tbody></table>';
//    echo '<button type="button" id="button" class="btn btn-info"><i class="fa fa-pencil"></i>delete seletcted items</button>';
//
//    echo $table_string;
//    
//}
//
//else{
//     echo 'Le dossier n\' a pas pu être ouvert';
//}*/


echo'</div>'
. '</div>';


new_cobra_footer(); 
  

?>
<script type="text/javascript" class="init">



//$("#myHrefbuttonremove").on('click', function() {
//   alert ("inside onclick");
//   
//});
$(document).ready(function() {
    var table = $('#documents').DataTable();
 
    $('#documents tbody').on( 'click', 'tr', function () {
        //$(this).toggleClass('selected');
        //alert(table.row( this ).d);
        //alert(table.$('tr.selected')["File name"]);
        var oCells = $(this).cells;
        var cellLength = oCells.length;

       //loops through each cell in current row
        for(var j = 0; j < cellLength; j++){

              // get your cell info here

              var cellVal = oCells.item(j).innerHTML;
              alert(cellVal);
        }
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        //table.$('tr.selected').remove().draw( false );
        
        //table.row('.selected').
        table.row('.selected').remove().draw( false );
        
    } );
} );
//$(document).ready(function() {
//		$('#documents').dataTable( {
//			"scrollX": true,
//			"jQueryUI": true,
//			"pagingType": "full_numbers",
//			"oLanguage": { 
//				"sProcessing":   "Processing...",
//				"sLengthMenu":   "display _MENU_ items",
//				"sZeroRecords":  "No item found",
//				"sInfo": "Showing item _START_ to _END_ on  _TOTAL_ items",
//				"sInfoEmpty": "Displaying item 0 to 0 on 0 items",
//				"sInfoFiltered": "(filtered from _MAX_ items in total)",
//				"sInfoPostFix":  "",
//				"sSearch":       "Search: ",
//				"sUrl":          "",
//				"oPaginate": {
//					"sFirst":    "First",
//					"sPrevious": "Previous",
//					"sNext":     "Next",
//					"sLast":     "Last"
//				}
//			},
//			"language": {
//							"decimal": ",",
//							"thousands": "."
//				}
//		});
//	});


</script>
