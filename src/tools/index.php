<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Tools","section_tools","../..");


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
make_species_list(find_species_list($speciesCollection),"../..");
 echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';

$ortholog_form_string="";
$ortholog_form_string.='
<form id="icheckForm" method="post" class="form-horizontal" action="../orthology/new_ortholog_search.php">
    
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
                        <input type="checkbox" name="species[]" value="Prunus species" />Prunus species</label>
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
                        <input type="checkbox" name="regulation" value="down" /> Down Expressed
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="regulation" value="up" /> Up Expressed
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="logFCInput">choose numbers of genes</label>
            <input type="number" step="1" name="Topgene" class ="form-control" min="1" max="50" placeholder="" id="top_gene">
         </div>
    </div>
</form>';


$CG_form_string="";



add_accordion_panel($ortholog_form_string, "Perform Orthologs search on differentially expressed genes","ortholog_search"); 
echo '</br>';
//add_accordion_panel($CG_form_string, "Search high confidence susceptibility genes using COBRA scoring function","ortholog_search"); 





 new_cobra_footer();


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
