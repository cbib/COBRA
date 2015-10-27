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
$db=mongoConnector();
$docsCollection = new Mongocollection($db, "docs");

$dossier = 'COBRA_depot/';



if ((isset($_FILES['fileToUpload'])) && ($_FILES['fileToUpload']!='')){
    $fichier = basename($_FILES['fileToUpload']['name']);
    $max_size = 100000000;
    $size = filesize($_FILES['fileToUpload']['tmp_name']);
    echo $size;
    $extensions = array('.doc','.txt','.png', '.gif', '.jpg', '.jpeg','.pdf','.xls','.xlsx');
    $extension = strrchr($_FILES['fileToUpload']['name'], '.'); 
    //Début des vérifications de sécurité...
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
         $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
        //testing if file has been moved
        if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
             //echo 'Your file '.$fichier.' was upload successfully !';
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
               
             }








        }
        else //Sinon (la fonction renvoie FALSE).
        {
             //echo 'Upload failed, please check repertory permission!';
        }
    }
    else
    {
         echo $erreur;
    }
}




if ((isset($_GET['action'])) && ($_GET['action']!='')){
    if ($_GET['action']=="Remove"){
       $criteria=array('full_file_name'=>$dossier.$_GET['full_path']);
       $doc = $docsCollection->findOne($criteria);
       if(!empty($doc) ){
            
            $docsCollection->remove($criteria);
            unlink('./'.$dossier.$_GET['full_path']);
       }
       else{
           //echo 'document doesnt exist';
       }
    }  
}

new_cobra_header();

new_cobra_body($_SESSION['login'],"Upload files Page","section_upload_file");
echo '<div id="doc_pages">';
echo '<div id="section_upload">';
//echo '<div id="bar_blank">
//   <div id="bar_color"></div>
//  </div>';

//<!--<input type="hidden" value="myForm" name="-->'
        //.ini_get("session.upload_progress.name")
        //.'">
echo '<form action="#" id="myForm" method="post" enctype="multipart/form-data">
         
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000">

        Select file to upload: <input type="file" name="fileToUpload" id="fileToUpload">
    
        <input type="submit" value="Upload File" name="submit">
      </form>
       <!--<iframe id="hidden_iframe" name="hidden_iframe" src="about:blank"></iframe>-->
  </div>';


echo '<div id="section_documents">';
$db=mongoConnector();
//$docsCollection = new Mongocollection($db, "docs");
$nb_files = 0;
$table_string="";
###Document TABLE
echo '<button type="button" id="button" class="btn btn-info"><i class="fa fa-pencil"></i>delete selected items</button>';
$table_string.='<table id="documents" class="table dataTable">';
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
                  <!--<li><a href="#" id="myHrefbuttonremove">Remove file</a></li>-->


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
//phpinfo();

new_cobra_footer(); 
  

?>
<script type="text/javascript" class="init">



//$("#myHrefbuttonremove").on('click', function() {
//   alert ("inside onclick");
//   
//});
//ANother way to loop into the table
//var table = document.getElementById('documents');
//
//var rowLength = table.rows.length;
////loops through rows
//
//for (i = 0; i < rowLength; i++){
//    var oCells = table.rows.item(i).cells;
//    
//
//    var cellLength = oCells.length;
//   //loops through each cell in current row
//    for(var j = 0; j < cellLength; j++){
//          // get your cell info here
//          var cellVal = oCells.item(j).innerHTML;
//          //alert(cellVal);
//    }
//}
//db = db.getSiblingDB('<cobra_db>');

$(document).ready(function() {
    var table = $('#documents').DataTable();

    //new $.fn.dataTable.Buttons( table, { buttons: ['copy', 'excel', 'pdf']} );
    //table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
    
        
        
    $('#documents tbody').on( 'click', 'td', function () {
        //alert('Data: '+$(this).html().trim());
    }); 
    
    $('#documents tbody').on( 'click', 'tr', function () {
        //alert('Data: '+$('#documents tbody tr th').html().trim());
        //alert(cell('#row-0','#column-0').toString());
        
        
        //var test=$(this).find('td').eq(0);
        //alert(test.html().trim());
        
        //$('#table tr').eq(rowIndex).find('td').eq(columnIndex)
        //alert($(this).html().trim());
        //var $row = $(this);
        //alert($row.data().toString());
        //alert('Column:'+$('#documents thead tr th').eq($(this).index()).html().trim());
        //var t1 = $row.find('File name').text();
        //var t1 = $row.find(':nth-child(1)').text();
        //var t1 = $row[0].toString();
        //alert(t1);
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $(this).css( "background-color", "white" );
        }
        else {
//            table.$('tr.selected').removeClass('selected');
//            $(this).addClass('selected');
//            $(this).css( "background-color", "#04B4AE" );
            $(this).toggleClass('selected');
            $(this).css( "background-color", "#A9F5BC" );
            
        }
        
        
        
        
    } );
 
    $('#button').click( function () {
        //table.$('tr.selected').remove().draw( false );
        
        //table.row('.selected').
        var full_path=table.$('tr.selected').find('td').eq(0);
        
        //alert(full_path);
        table.row('.selected').remove().draw( false );
        
        window.location.replace("https://services.cbib.u-bordeaux2.fr/cobra/src/docs/index.php?action=Remove&full_path=".concat(full_path.html().trim()));
        
    } );
} );

//
//function toggleBarVisibility() {
//    var e = document.getElementById("bar_blank");
//    e.style.display = (e.style.display === "block") ? "none" : "block";
//}
//
//function createRequestObject() {
//    var http;
//    if (navigator.appName === "Microsoft Internet Explorer") {
//        http = new ActiveXObject("Microsoft.XMLHTTP");
//    }
//    else {
//        http = new XMLHttpRequest();
//    }
//    return http;
//}
//
//function sendRequest() {
//    var http = createRequestObject();
//    http.open("GET", "progress.php");
//    http.onreadystatechange = function () { handleResponse(http); };
//    http.send(null);
//}
//
//function handleResponse(http) {
//    var response;
//    if (http.readyState === 4) {
//        response = http.responseText;
//        document.getElementById("bar_color").style.width = response + "%";
//        document.getElementById("status").innerHTML = response + "%";
//
//        if (response < 100) {
//            setTimeout("sendRequest()", 1000);
//        }
//        else {
//            toggleBarVisibility();
//            document.getElementById("status").innerHTML = "Done.";
//        }
//    }
//}
//
//function startUpload() {
//    toggleBarVisibility();
//    setTimeout("sendRequest()", 1000);
//}
//
//(function () {
//    document.getElementById("myForm").onsubmit = startUpload;
//})();


//var mongoclient = new MongoClient(new Server("localhost", 27017), {native_parser: true});
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
