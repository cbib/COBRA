<?php

require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools");


$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$measurementsCollection = new Mongocollection($db, "measurements");
$mappingsCollection = new Mongocollection($db, "mappings");
$orthologsCollection = new Mongocollection($db, "orthologs");


  
    $cursor=find_species_list($speciesCollection);
    echo '
    <div id="SpeciesSearch" class="js_panel">
    	<input type="hidden" class="panel_type" value="SearchBox" />
    	<div class="checkbox">
        <form action="ortholog_search_result.php">
            <input type="hidden" name="envoi" value="yes">
            
            ';   
                            //Parcours de chaque ligne du curseur
                            foreach($cursor as $line) {
                                    echo '<input tabindex="10" type="checkbox" id="square-checkbox-2" checked>
                  <label for="square-checkbox-2">CSS3 Expert</label>';
                                    echo '<input type="checkbox" name="options[]" value="'.$line.'">&nbsp;'.$line.'<br>';
                                    
                            }
                            echo '
            
            <input type="submit">
        </form>
        </div>
        <form action="/database/src/result_search.php" method="get" class="clear search-form homepage-search-form">
            <fieldset>
                <div class="form-field ff-multi">
                    <div align="center" class="ff-inline ff-right" >
                        <!--<label for="species" class="ff-label">Search:</label>-->
                            <span class="inp-group">
                                <select name="organism" class="fselect input" id="organism">
                                        <option selected="selected" value="All species">All species</option>
                                        <option disabled="disabled" value="">---</option>';   
                                //Parcours de chaque ligne du curseur
                            foreach($cursor as $line) {
                                    echo '<option value="'.$line.'">'.$line.'</option>';
                            }
                            echo 
                               '</select>
                                <label for="search">for</label>
                            </span>
                            <wbr></wbr>
                            <span class="inp-group">
                                    <input value="" name="search" class="input_search" id="search" type="text" size="30" />
                                    <i class="fa fa-search"></i> <span><input value="Search" class="fbutton" type="submit" /></span>
                            </span>
                            <wbr></wbr>
    				</div>
    				<div class="ff-notes">
    					<p class="search-example " style="padding : 6px">e.g. 
    						<a class="nowrap" href="/database/src/result_search.php?organism=Arabidopsis+thaliana&search=AT1G06520">AT1G06520</a> 
    						or 
    						<a class="nowrap" href="/database/src/result_search.php?organism=Solanum+lycopersicum&search=SGN-U603893">SGN-U603893</a>
    						
    					</p>
    				</div>
    			</div>
    		</fieldset>
    	</form>
    </div>';







        //make_species_list(find_species_list($speciesCollection));

    

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
//</main>';
 
      
      
      //'gene'=>array('$ne'=>'')

        
//$species='Arabidopsis thaliana';
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
//
//echo "</br>";
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


//$species='Cucumis melo';


    

new_cobra_footer();
////////////////////////////////////////////////////
//echo "</br>";
//$gene_list_attributes=array();
//$species='Solanum lycopersicum';
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







?>