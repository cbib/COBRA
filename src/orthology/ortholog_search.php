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
foreach ($data as $species){
    //$species='Arabidopsis thaliana';
    $type=$genes;
    //$species='Hordeum vulgare';
    $gene_list_attributes=get_ortholog_list($mappingsCollection,$measurementsCollection,$speciesCollection,$species,$type,$Topgene);

    //$species_id_type=$speciesCollection->find(array('full_name'=>$species),array('preferred_id'=>1));
    //foreach ($species_id_type as $value) {
    //    $favourite_id=$value['preferred_id'];
    //    //echo $value['preferred_id'];    
    //}
    //$plaza_favorite_tgt_id=$mappingsCollection->find(array('src'=>'plaza_gene_id','species'=>$species),array('tgt'=>1));
    ////only one value is possible
    //foreach ($plaza_favorite_tgt_id as $value) {
    // $intermediary_id=$value['tgt'];
    //    //echo $value['tgt'];
    //
    //}




    foreach ($gene_list_attributes as $attributes) {


    //    echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
    //    echo'<thead><tr>';
    //    echo "<th>Gene id</th>";
    //    echo "<th>Gene preferred Id</th>";
    //    echo "<th>Protein uniprot id</th>";
    //    echo "<th>Plaza id</th>";
    //    echo "<th>logFC</th>";
    //    echo "<th>infection agent</th>";
    //    echo "<th>species</th>";
    //    echo'</tr></thead><tbody>';
        $cpt=0;
        foreach ($attributes as $key => $value) {
            if ($cpt==0){
    //            echo "<tr>";
    //            echo '<td>'.$attributes['gene'].'</td>';
    //            echo '<td>'.$attributes[$favourite_id].'</td>';
    //            echo '<td>'.$attributes[$intermediary_id].'</td>'; 
    //            echo '<td>'.$attributes['plaza_id'].'</td>';
    //            echo '<td>'.$attributes['logFC'].'</td>';
    //            echo '<td>'.$attributes['infection_agent'].'</td>';
    //            echo '<td>'.$species.'</td>';
    //            echo "</tr>";
    //            echo'</tbody></table>';
                echo '<div style="cursor: pointer;" onclick="window.location=\'https://services.cbib.u-bordeaux2.fr/cobra/src/result_search.php?organism='.str_replace(" ", "+", $species).'&search='.$attributes['gene'].'\';" class="resultsbox" id="results">
                        <div class="results-right">
                            <div class="organism"> '.$species.'</div>
                            <div class="infection agent"> '.$attributes['infection_agent'].'</div>
                            <div class="logFC"> Log FC: '.$attributes['logFC'].'</div>
                        </div>
                        <div class="results-left">
                            <div class="officialSymbol"> <h1><strong>'.$attributes['gene'].'</strong></h1></div>

                        </div>

                </div>';
            }




            if ($value != "NA"){
                //echo $key."\r\t";
                //echo $value."\r\n";

                if ($key=="plaza_id"){
                    //echo $key."\r\t";
                    //echo $value."\r\n";
                    //echo "</br>";
                    echo'<div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3>
                                        <a class="accordion-toggle collapsed" href="#ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'" data-parent="#accordion_documents" data-toggle="collapse">
                                                Ortholog table
                                        </a>				
                                    </h3>
                                </div>
                                <div class="panel-body panel-collapse collapse" id="ortho-'.$value.str_replace(".", "_", $attributes['logFC']).'">

                                    <table class="table table-condensed table-hover table-striped">                                                                <thead>
                                        <tr>';
                                            echo "<th>Mapping type</th>";
                                            echo "<th>src ID</th>";
                                            echo "<th>src type</th>";
                                            echo "<th>src_version</th>";
                                            echo "<th>tgt ID</th>";
                                            echo "<th>tgt type</th>";
                                            echo "<th>tgt_version</th>";
                                            echo "<th>species</th>";
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
                 <br/>';

    //                echo '<div class="tinted-box no-top-margin bg-gray" style="border:2px solid grey text-align: center">';
    //                echo'<h1 style="text-align:center"> Orthology informations </h1>';
    //                echo '</div>';
    //                #$current_plaza_id="AT1G01060";
    //                $initial_species=array('AT','CM','HV','SL');
    //                //echo "test plaza id ".$current_plaza_id;
    //                $cursor_array=array();
    //                if ($value!=""){
    //
    //                    $MongoGridFSCursor=get_plaza_orthologs($grid, $orthologsCollection,$species,$value,'plaza_gene_identifier');
    //                    #$MongoGridFSCursor->skip(3)->limit(8);
    //                    foreach($MongoGridFSCursor as $MongoGridFSFile) {
    //                        #error_log($MongoGridFSFile->getBytes(), 0);
    //                        $stream = $MongoGridFSFile->getResource();
    //                        if ($stream) {
    //                            #while (($buffer = fgets($stream, 4096)) !== false) {
    //                            $cpt=0;
    //                            while (($buffer = stream_get_line($stream, 1024, "\n")) !== false) {
    //                                #echo "start line : ".$buffer."\n";
    //                                #$row=split('[\t]', $buffer);
    //                                $row=preg_split('/\s+/', $buffer);
    //                                if ($value==$row[0]){
    //                                    #echo "start line : ".$buffer."\n";
    //                                    $ortholog_list_id=split('[,]', $row[1]);
    //                                    foreach ($ortholog_list_id as $ortholog){
    //                                        foreach ($initial_species as $first_two_letters) {
    //                                            if ($first_two_letters==$ortholog[0].$ortholog[1] && $ortholog[2]!='R'){
    //                                                #echo "start line : ".$buffer."\n";
    //                                                $cursor=$mappingsCollection->aggregate(array( 
    //                                                    array('$match' => array('type'=>'gene_to_prot')),  
    //                                                    array('$project' => array('src_to_tgt'=>1,'species'=>1,'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0)),    
    //                                                    array('$match' => array('src'=>"plaza_gene_id")),  
    //                                                    array('$unwind'=>'$src_to_tgt'),    
    //                                                    array('$match' => array('src_to_tgt.0'=>$ortholog)),  
    //                                                    array('$project' => array('src_to_tgt'=>1,'species'=>1, 'src'=>1, 'src_version'=>1,'tgt'=>1,'tgt_version'=>1,'type'=>1,'_id'=>0))
    //                                                ));
    //
    //                                                if (count($cursor['result'])!=0){
    //                                                      //add_accordion_panel($cursor);
    //                                                      //array_push($cursor_array, $cursor);
    //                                                    echo '<h2> orthologs table </h2>';
    //                                                      echo'<div class="panel-group" id="accordion_documents">
    //                                                                <div class="panel panel-default">
    //                                                                    <div class="panel-heading">
    //                                                                        <h3>
    //                                                                            <a class="accordion-toggle collapsed" href="#collapse_documents" data-parent="#accordion_documents" data-toggle="collapse">
    //                                                                                 Documents and Presentations
    //                                                                            </a>				
    //                                                                        </h3>
    //                                                                    </div>
    //                                                                    <div class="panel-body panel-collapse collapse" id="collapse_documents">
    //
    //                                                                        <table class="table table-condensed table-hover table-striped">                                                                <thead>
    //                                                                                <tr>';
    //                                                                                        echo "<th>Mapping type</th>";
    //                                                                                        echo "<th>src ID</th>";
    //                                                                                        echo "<th>src type</th>";
    //                                                                                        echo "<th>src_version</th>";
    //                                                                                        echo "<th>tgt ID</th>";
    //                                                                                        echo "<th>tgt type</th>";
    //                                                                                        echo "<th>tgt_version</th>";
    //                                                                                        echo "<th>species</th>";
    //                                                                                echo'</tr>
    //                                                                            </thead>
    //
    //                                                                            <tbody>';
    //                                                                                foreach($cursor['result'] as $line) {
    //
    //                                                                                    //echo $line['src_to_tgt'];
    //                                                                                    for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
    //                                                                                        echo "<tr>";
    //
    //                                                                                        echo '<td>'.$line['type'].'</td>';
    //
    //                                                                                        echo '<td>'.$line['src_to_tgt'][0].'</td>';
    //                                                                                        echo '<td>'.$line['src'].'</td>';
    //                                                                                        echo '<td>'.$line['src_version'].'</td>';
    //
    //                                                                                        //for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
    //
    //                                                                                        echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
    //
    //
    //                                                                                        //}
    //                                                                                        echo '<td>'.$line['tgt'].'</td>';
    //                                                                                        echo '<td>'.$line['tgt_version'].'</td>';
    //                                                                                        echo '<td>'.$line['species'].'</td>';
    //                                                                                        echo "</tr>";
    //                                                                                    }
    //
    //                                                                                }                             
    //                                                                            echo'</tbody>
    //
    //                                                                        </table>
    //                                                                    </div>
    //
    //                                                                </div>
    //                                                            </div>    
    //                                                     <br/>';
    //
    //
    //                                                    echo '<h2> orthologs table </h2> <div class="container">';
    //                                                    echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
    //                                                    echo'<thead><tr>';
    //
    //                                                    //recupere le titre
    //                                                    #echo "<th>type</th>";
    //                                                    echo "<th>Mapping type</th>";
    //                                                    echo "<th>src ID</th>";
    //                                                    echo "<th>src type</th>";
    //                                                    echo "<th>src_version</th>";
    //                                                    echo "<th>tgt ID</th>";
    //                                                    echo "<th>tgt type</th>";
    //                                                    echo "<th>tgt_version</th>";
    //                                                    echo "<th>species</th>";
    //
    //                                                    echo'</tr></thead>';
    //
    //                                                    //Debut du corps de la table
    //                                                    echo'<tbody>';
    //
    //                                                    foreach($cursor['result'] as $line) {
    //
    //                                                        //echo $line['src_to_tgt'];
    //                                                        for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
    //                                                            echo "<tr>";
    //
    //                                                            echo '<td>'.$line['type'].'</td>';
    //
    //                                                            echo '<td>'.$line['src_to_tgt'][0].'</td>';
    //                                                            echo '<td>'.$line['src'].'</td>';
    //                                                            echo '<td>'.$line['src_version'].'</td>';
    //
    //                                                            //for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
    //
    //                                                            echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
    //
    //
    //                                                            //}
    //                                                            echo '<td>'.$line['tgt'].'</td>';
    //                                                            echo '<td>'.$line['tgt_version'].'</td>';
    //                                                            echo '<td>'.$line['species'].'</td>';
    //                                                            echo "</tr>";
    //                                                        }
    //
    //                                                    }
    //                                                    echo'</tbody></table></div>';
    //
    //                                                    #echo $ortholog."\n";
    //                                                    #var_dump($cursor);
    //                                                    #echo "\n";
    //                                                }                                   														
    //                                            }
    //                                        }
    //                                    }
    //                                }
    //                            }
    //                        }
    //                    }
    //                }


                }
                else{
    //                echo $key."\r\t";
    //                echo $value."\r\n";
    //                echo "</br>";
                      echo '<div> No Orthologs found for this gene</div>';
                }
            }
            else{
                    

            }
            $cpt++;

        }

            //echo $attributes['gene'];
            //$attributes['gene'];
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





