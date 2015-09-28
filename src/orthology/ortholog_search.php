<?php

require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"differently expressed genes","section_diff_exp_genes");


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
$data = $_POST['species'];
$genes=$_POST['regulation'];
$Topgene=$_POST['Topgene'];


//$species='Cucumis melo';
//$species='Arabidopsis thaliana';
//$type="down";
//$species='Hordeum vulgare';

foreach ($data as $species){
    //echo 'species: '.$species;
    if ($species=="Prunus species"){
        echo '<H1>Results for Prunus species</H1>';
        $species_id_type=$speciesCollection->find(array('classification.genus'=>'Prunus'),array('preferred_id'=>1,'full_name'=>1));
        foreach ($species_id_type as $species_value) {
            //echo 'full name: '.$species_value['full_name'];
            $timestart=microtime(true);
            $gene_list_attributes=get_ortholog_list_2($mappingsCollection,$measurementsCollection,$speciesCollection,$species_value['full_name'],$genes,$Topgene);
            //$gene_list_attributes=get_ortholog_list($mappingsCollection,$measurementsCollection,$speciesCollection,$value['full_name'],$genes,$Topgene);
            
            
            //make_orthologs_page($gene_list_attributes,'Prunus persica');
            foreach ($gene_list_attributes as $attributes) {



                $cpt=0;
                foreach ($attributes as $key => $value) {
                    if ($cpt==0){

                        echo '<div style="cursor: pointer;" onclick="window.location=\'/src/result_search_6.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['search'].'\';" class="resultsbox" id="results">
                                <div class="results-right">
                                    <div class="organism"> Organism:'.$species_value['full_name'].'</div>
                                    <div class="infection agent"> Infection agent: '.$attributes['infection_agent'].'</div>

                                </div>
                                <div class="results-left">
                                    <div class="officialSymbol"> Gene identifier: '.$attributes['search'].'</div>
                                    <div class="logFC"> Log fold change: '.$attributes['logFC'].'</div>

                                </div>

                        </div>';
                    }




                    if ($value != "NA"){


                        if ($key=="plaza_id"){
                            //echo 'key: '.$value;

                            echo'<div class="panel-group" id="accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3>
                                                <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-toggle="collapse">
                                                        Ortholog table 
                                                        <!--<div id="organism" class="right"><h4>Prunus species</h4></div>-->
                                                </a>				
                                            </h3>
                                        </div>
                                        <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">

                                            <table class="table table-hover">                                                                
                                                <thead>
                                                <tr>';
                                                    //echo "<th>Mapping type</th>";
                                                    echo "<th>Gene ID</th>";
                                                    echo "<th>Source</th>";
                                                    //echo "<th>tgt ID</th>";
                                                    echo "<th>Transcript/protein ID</th>";
                                                    echo "<th>Source</th>";
                                                    echo "<th>Species</th>";
                                                    echo'
                                                </tr>
                                                </thead>

                                                <tbody>';
                                                    //echo 'before entering into table_ortholog';
                                                    echo table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,'Prunus persica',$value);

                                           echo'</tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>';    

                            echo '<div id="shift_line"></div>';

                        }

                    }

                    $cpt++;

                }

            }
        }
        
    }
    else{
        echo '<H1>Results for '.$species.'</H1>';

        //$type=$genes;

        $gene_list_attributes=get_ortholog_list($mappingsCollection,$measurementsCollection,$speciesCollection,$species,$genes,$Topgene);


        foreach ($gene_list_attributes as $attributes) {



            $cpt=0;
            foreach ($attributes as $key => $value) {
                if ($cpt==0){

                    echo '<div style="cursor: pointer;" onclick="window.location=\'/src/result_search_5.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['search'].'\';" class="resultsbox" id="results">
                            <div class="results-right">
                                <div class="organism"> Organism:'.$species.'</div>
                                <div class="infection agent"> Infection agent: '.$attributes['infection_agent'].'</div>

                            </div>
                            <div class="results-left">
                                <div class="officialSymbol"> Gene identifier: '.$attributes['search'].'</div>
                                <div class="logFC"> Log fold change: '.$attributes['logFC'].'</div>

                            </div>

                    </div>';
                }




                if ($value != "NA"){


                    if ($key=="plaza_id"){

                        echo'<div class="panel-group" id="accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3>
                                            <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-toggle="collapse">
                                                    Ortholog table 
                                                    <!--<div id="organism" class="right"><h4></h4></div>-->
                                            </a>				
                                        </h3>
                                    </div>
                                    <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">

                                        <table class="table table-hover">                                                                
                                            <thead>
                                            <tr>';
                                                //echo "<th>Mapping type</th>";
                                                echo "<th>Gene ID</th>";
                                                //echo "<th>Source</th>";
                                                //echo "<th>tgt ID</th>";
                                                echo "<th>Transcript/protein ID</th>";
                                                //echo "<th>Source</th>";
                                                echo "<th>Species</th>";
                                                echo'
                                            </tr>
                                            </thead>

                                            <tbody>';
                                                echo table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,$species,$value);

                                       echo'</tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>    
                     <div id="shift_line"></div>';

                    }
                    else{

                    }
                }
                else{

                }
                $cpt++;

            }

        }
    }
}

    

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





