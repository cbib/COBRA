<?php

require '/var/www/html/COBRA/src/functions/html_functions.php';
require '/var/www/html/COBRA/src/functions/php_functions.php';
require '/var/www/html/COBRA/src/functions/mongo_functions.php';
require '/var/www/html/COBRA/src/session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_tools");


$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$measurementsCollection = new Mongocollection($db, "measurements");
$mappingsCollection = new Mongocollection($db, "mappings");
$orthologsCollection = new Mongocollection($db, "orthologs");


  
/*    $cursor=find_species_list($speciesCollection);
//    echo '
//    <div id="SpeciesSearch" class="js_panel">
//    	<input type="hidden" class="panel_type" value="SearchBox" />
//    	<form action="/src/result_search.php" method="get" class="clear search-form homepage-search-form">
//            <fieldset>
//                <div class="form-field ff-multi">
//                    <div align="center" class="ff-inline ff-right" >
//                        <!--<label for="species" class="ff-label">Search:</label>-->
//                            <span class="inp-group">
//                                <select name="organism" class="fselect input" id="organism">
//                                        <option selected="selected" value="All species">All species</option>
//                                        <option disabled="disabled" value="">---</option>';   
//                                //Parcours de chaque ligne du curseur
//                            foreach($cursor as $line) {
//                                    echo '<option value="'.$line.'">'.$line.'</option>';
//                            }
//                            echo 
//                               '</select>
//                                <label for="search">for</label>
//                            </span>
//                            <wbr></wbr>
//                            <span class="inp-group">
//                                    <input value="" name="search" class="input_search" id="search" type="text" size="30" />
//                                    <i class="fa fa-search"></i> <span><input value="Search" class="fbutton" type="submit" /></span>
//                            </span>
//                            <wbr></wbr>
//    				</div>
//    				<div class="ff-notes">
//    					<p class="search-example " style="padding : 6px">e.g. 
//    						<a class="nowrap" href="/src/result_search.php?organism=Arabidopsis+thaliana&search=AT1G06520">AT1G06520</a> 
//    						or 
//    						<a class="nowrap" href="/src/result_search.php?organism=Solanum+lycopersicum&search=SGN-U603893">SGN-U603893</a>
//    						
//    					</p>
//    				</div>
//    			</div>
//    		</fieldset>
//    	</form>
//    </div>';*/







//    make_species_list(find_species_list($speciesCollection));

    

//    <input id="topQuery" type="hidden" value=""></input>
//
//    <input id="query" class="ui-autocomplete-input" type="search" name="query" accesskey="4" value="" autocomplete="off"></input>
//
//    <span class="ui-helper-hidden-accessible" role="status" aria-live="polite"></span>
//
//    <a id="advanced-search-toggle" class="caret_grey" href="#">Advanced</a>
//    <input type="hidden" name="sort" value="score"></input>
//
//    <a id="search-button" class="icon icon-functional button" href="" onclick="return false" data-icon="1" title="Search">Search</a>
//    </main>';
 
      
      
//    'gene'=>array('$ne'=>'')

        
//    $species='Arabidopsis thaliana';
//    //$species='Hordeum vulgare';
//    $gene_list_attributes=ben_function($mappingsCollection,$measurementsCollection,$speciesCollection,$species);
//    foreach ($gene_list_attributes as $attributes) {
//        foreach ($attributes as $key => $value) {
//            echo $key."\r\t";
//            echo $value."\r\n";
//            echo "</br>";
//        }      
//        //echo $attributes['gene'];
//        //$attributes['gene'];
//    }
//
//    echo "</br>";
//$gene_list_attributes=array();
//$species='Hordeum vulgare';
////$species='Hordeum vulgare';
//$gene_list_attributes=ben_function($mappingsCollection,$measurementsCollection,$speciesCollection,$species);
//foreach ($gene_list_attributes as $attributes) {
//    foreach ($attributes as $key => $value) {
//        echo $key."\r\t";
//        echo $value."\r\n";
//        echo "</br>";
//    }      
//        //echo $attributes['gene'];
//        //$attributes['gene'];
//}
///////////////////////////////////////////////////
$table_string="";
$table_string.='
<form id="icheckForm" method="post" class="form-horizontal" action="https://services.cbib.u-bordeaux2.fr/cobra/src/orthology/ortholog_search.php">
    
    <div class=col-md-6>
        <div class="form-group">
            <label class="col-xs-3 control-label"> Favourites Species</label>
            <div class="col-xs-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="species[]" value="Arabidopsis thaliana" /> Arabidopsis thaliana
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="species[]" value="Cucumis melo" /> Cucumis melo
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="species[]" value="Hordeum vulgare" /> Hordeum vulgare
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="species[]" value="Prunus persica" /> Prunus persica
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="species[]" value="Solanum lycopersicum" /> Solanum lycopersicum
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-5 col-xs-offset-3">
                <button type="submit" class="btn btn-default">Validate</button>
            </div>
        </div>
    </div>
    <div class=col-md-6>
        <div class="form-group">
            <label class="col-xs-3 control-label"> Expression level</label>
            <div class="col-xs-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="regulation" value="Down" /> Down Expressed
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="regulation" value="Up" /> Up Expressed
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="logFCInput">choose numbers of genes</label>
            <input type="number" step="1" name="Topgene" class ="form-control" placeholder="" id="top_gene">
         </div>
    </div>
</form>';



add_accordion_panel($table_string, "Perform Orthologs search on high expressed genes","ortholog_search"); 









?>


<script>

$(document).ready(function () {
$('#icheckForm').validate({
    rules: {
        "species[]": {
               required: true,
               minlength: 1,
               maxlength: 3,
               message:'Please choose 1 - 3 species'
             
        }
       
    },
    highlight: function (element) {
        $(element).closest('.form-group').removeClass('success').addClass('error');
    },
    success: function (element) {
        element.text('OK!').addClass('valid')
            .closest('.form-group').removeClass('error').addClass('success');
    }
});
});

</script>
