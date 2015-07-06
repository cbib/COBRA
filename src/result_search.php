<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');
use PhpObo\LineReader;
use PhpObo\Parser;

//define("RDFAPI_INCLUDE_DIR", "/Users/benjamindartigues/COBRA/GIT/COBRA/lib/rdfapi-php/api/");
//include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");


new_cobra_header();

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary");

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

    //put the search box again...
    make_species_list(find_species_list($speciesCollection));
    
    echo '<hr>';
    
    
    if ($organism=='All species'){
        $mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true)),array('type'=>1,'description'=>1,'url'=>1,'src'=>1,'tgt'=>1,'mapping_file'=>1,'species'=>1,'src_to_tgt'=>1,'tgt_to_src'=>1,'_id'=>0));
        $query=array('$match'=>array('src_to_tgt.0'=>$search));
        $fields=array('species'=>1);
        //then get th e corresponding plaza id
        $cursor=$mappingsCollection->find($query, $fields);
        foreach ($cursor as $item){
            $new_organism=$item['species'];
            #echo $new_organism;
        }
    }
    else{
        $mappings_to_process=$mappingsCollection->find(array('src_to_tgt'=>array('$exists'=>true),'species'=>$organism),array('type'=>1,'description'=>1,'url'=>1,'src'=>1,'tgt'=>1,'species'=>1,'mapping_file'=>1,'src_to_tgt'=>1,'tgt_to_src'=>1,'_id'=>0));
        
    }
    
    
     //else
    $gene_symbol=array();
    $descriptions=array();
    $proteins_id=array();
    $est_id=array();
    $go_id_list=array();
    $go_id_full_list=array();
    $go_grid_id_list=array();
    
    
    
    
    
    
    //get the corresponding plaza id
    $plaza_id=get_plaza_id($mappingsCollection, $speciesCollection,$search,$organism);
    #echo 'plaza id'.$plaza_id;
    
    foreach ($mappings_to_process as $map_doc){

        $species= $map_doc['species'];
        $src_col = $map_doc['src'];
        $tgt_col = $map_doc['tgt'];
        $type=$map_doc['type'];
        if (array_key_exists('description', $map_doc)){
            $description=$map_doc['description'];
        }
        $url = $map_doc['url'];
        $map_file = $map_doc['mapping_file'];
        $src_to_tgt = $map_doc['src_to_tgt'];
        $tgt_to_src = $map_doc['tgt_to_src'];
        
        //echo $type."\n";
        //most of table are from plaza db
        //need to first translate into plaza id.
       // Old way to capture gene ontology
/*        if ($type=='gene_to_go' && $species==$organism){
//            echo 'url :'. $url;
//            if ($src_col=='plaza_gene_id'){
//                foreach ($src_to_tgt as $row){
//                    $found=FALSE;
//                    $tmp_array=array();
//                    foreach ($row as $column){
//
//                        if (is_array($column)){
//                            if ($found){
//                                foreach ($column as $go_tgt){
//                                    
//                                    $tmp_array['GO_ID']=$go_tgt;
//                                   // array_push($go_id_list, $go_tgt);
//                                    //echo 'tgt : '.$go_tgt;
//                                }
//
//                            }
//
//        //               foreach ($column as $value){
//        //                   echo 'tgt :'.$value;
//        //               } 
//                        }  
//                        else {
//                            if ($column==$plaza_id){
//                                $found=TRUE;
//                                //echo 'src : '.$column;    
//                            }
//                        }  
//                    }       
//                }
//                foreach ($tgt_to_src as $row){
//                    $found=FALSE;
//                    foreach ($row as $column){
//
//                        if (is_array($column)){
//                            foreach ($column as $go_src){
//                                if ($go_src==$search){
//
//                                        $found=TRUE;
//                                        //echo 'tgt : '.$go_tgt;
//                                }
//
//                            }
//
//        //               foreach ($column as $value){
//        //                   echo 'tgt :'.$value;
//        //               } 
//                        }  
//                        else {
//                            if ($found){
//                                array_push($gene_symbol, $column);
//                                //echo 'src : '.$column;    
//                            }
//                        }  
//                    }       
//                }
//            }
//        }*/
       
        foreach ($src_to_tgt as $row){
            $found=FALSE;
            foreach ($row as $column){

                if (is_array($column)){
                   if ($found){
                       
                       //echo 'tgt : '.$column[0];

                   }

    //               foreach ($column as $value){
    //                   echo 'tgt :'.$value;
    //               } 
                }  
                else {
                    if ($column==$search){
                        $found=TRUE;
                        //echo 'src : '.$column;    
                    }
                }  
            }       
        }
        foreach ($tgt_to_src as $row){
            $found=FALSE;
            foreach ($row as $column){

                if (is_array($column)){
                   if ($found){
                       //echo 'src : '.$column[0];

                   }

    //               foreach ($column as $value){
    //                   echo 'tgt :'.$value;
    //               } 
                }  
                else{
                    if ($column==$search){
                        $found=TRUE;
                        //echo 'tgt : '.$column;    
                    }
               }  
           }       
        }
            
            
            
            
            
            
    /*//	if ($type=='gene_to_prot'){
    //        echo 'gene to prot mapping\n';
    //        foreach ($src_to_tgt as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'tgt : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'src : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //        foreach ($tgt_to_src as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'src : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'tgt : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //    }
    //    else if ($type=='gene_to_gene'){
    //        foreach ($src_to_tgt as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'tgt : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'src : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //        foreach ($tgt_to_src as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'src : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'tgt : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //    }
    //    
    //    else{
    //        echo 'est to gene mapping'."\n";
    //        foreach ($src_to_tgt as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'tgt : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'src : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //        foreach ($tgt_to_src as $row){
    //            $found=FALSE;
    //            foreach ($row as $column){
    //
    //                if (is_array($column)){
    //                   if ($found){
    //                       echo 'src : '.$column[0];
    //
    //                   }
    //                   
    //    //               foreach ($column as $value){
    //    //                   echo 'tgt :'.$value;
    //    //               } 
    //                }  
    //                else {
    //                    if ($column==$search){
    //                        $found=TRUE;
    //                        echo 'tgt : '.$column;    
    //                    }
    //                }  
    //            }       
    //        }
    //	
    //	}*/
        
        //read the gene_to_go mapping file for this species or all species if the option is selected
        foreach ($map_file as $key=>$value){
            if ($type=='gene_to_go'){
                if($key=='file'){
                    if ($src_col=='plaza_gene_id'){
                        $go_id_full_list=read_grid_plaza_mapping_file($grid, $mappingsCollection,$value,$plaza_id);

                    }
                    else{
                        $go_grid_id_list=read_grid_mapping_file($grid, $mappingsCollection,$value,$search);
                    }
                    
                }
            }
        }
        




        //Search for the corresponding ID in all table
        foreach ($map_file as $doc){
            //search in the gen_to_prot mapping table
            if ($type=='gene_to_prot'){
                if ($doc[$tgt_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$tgt_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$src_col){
                            array_push($gene_symbol,$value);
                            //echo'<dt>'.$key.'</dt>
                              //    <dd>'.$value.'</dd>';
                        }
                        else{
                            
                        }
                    }
                }
                if ($doc[$src_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$src_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$tgt_col) {
                            $found =FALSE;
                            for ($i = 0; $i < count($proteins_id); $i++) {                        
                                if ($proteins_id[$i]==$value){
                                    $found=TRUE;
                                }
                                
                            } 
                            if($found==FALSE){
                                array_push($proteins_id,$value);
                            }
                           // echo'<dt>'.$key.'</dt>
                             //     <dd>'.$value.'</dd>';
                        }
                        
                        else{
                            
                        }
                    }
                }            
            }
            else if ($type=='gene_to_gene'){
                if ($doc[$tgt_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$tgt_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$src_col){
                            array_push($gene_symbol,$value);
                            if ($key=="plaza_gene_id"){
                                $plaza_id=$value;
                                //echo 'test:'.$plaza_id;
                            }
                           // echo'<dt>'.$key.'</dt>
                             //     <dd>'.$value.'</dd>';
                        }
                        else{
                            
                        }
                    }
                }
                if ($doc[$src_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$src_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$tgt_col) {
                            $found =FALSE;
                            for ($i = 0; $i < count($proteins_id); $i++) {                        
                                if ($proteins_id[$i]==$value){
                                    $found=TRUE;
                                }
                                
                            } 
                            if($found==FALSE){
                                array_push($proteins_id,$value);
                            }
                            //echo'<dt>'.$key.'</dt>
                              //    <dd>'.$value.'</dd>';
                        }
                        
                        else{
                            
                        }
                    }
                }            
            }
            else if ($type=='est_to_gene'){
                if ($doc[$tgt_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$tgt_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="full_name") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$src_col){
                            array_push($est_id,$value);
//                            echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>';
                        }
                        else{    
//                            echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>'; 
                        }
                    }
                }
                if ($doc[$src_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$src_col){
                        }
                        else if($key==$description){
                            array_push($descriptions,$value);

                        }
                        elseif ($key=="alias") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key=="symbol") {
                            array_push($gene_symbol,$value);

                        }
                        elseif ($key==$src_col){
                            array_push($gene_symbol,$value);
//                            echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>';
                        }
                        else{                         
//                            echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>';
                        }
                    }
                }            
            }
            //search in the gen_to_symbol mapping table
            else if ($type=='gene_to_symbol'){

            
                //if ($doc[$tgt_col]==$search){
                if ($doc[$src_col]==$search){
                    foreach ($doc as $key =>$value){
                        if ($key=="idx" OR $key==$src_col){
                                //echo '<li>'.$key.' : '.$value.'</li></br>';

                        }
                        else if($key==$tgt_col){
//                            echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>';
                            array_push($gene_symbol,$doc[$tgt_col]);
                        }
                        elseif ($key=="full_name") {
                            array_push($gene_symbol,$value);

                        }
                        else if($key==$description){
                            array_push($descriptions,$value);
                        }
                        else{
//                           echo'<dt>'.$key.'</dt>
//                                  <dd>'.$value.'</dd>';
                        }

                    }
                }
            


            }
            //search in the gen_to_go mapping table 
            //remember to add a protection for grid fs mapping files
            else if ($type=='gene_to_go'){
//                echo $src_col;
//                echo $tgt_col.'<br>';
//                echo $doc[$src_col];
//                echo $search.'<br>';
                if ($src_col=="plaza_gene_id"){
                    //echo'found';
                    //echo $tgt_col;
                    //echo $doc[$src_col];
                    if ($doc[$src_col]==$plaza_id){
                        
;                       foreach ($doc as $key =>$value){
                            $tmp_array=array();
                            if ($key=="idx"){
                                 
                             }
                             else if($key==$src_col){
                                echo '<li>'.$key.' : '.$value.'</li></br>';
                                
                             }
                             else if($key=="evidence"){
                                 $tmp_array['evidence']=$doc[$key];
//                                 echo'<dt>'.$key.'</dt>
//                                       <dd>'.$value.'</dd>';
                                 //array_push($gene_symbol,$doc[$tgt_col]);
                             }
                             else if($key==$tgt_col){
                                 
                                 $tmp_array['GO_ID']=$doc[$tgt_col];
                                 //array_push($go_id_list, $doc[$tgt_col]);
                                 
                                 //echo'<dt>'.$key.'</dt>
                                 //      <dd>'.$value.'</dd>';
                                 //array_push($gene_symbol,$doc[$tgt_col]);
                             }
                             else if($key==$description){
                                 array_push($descriptions,$value);
                             }
                             else{
                                 //echo'<dt> gene to go key '.$key.'</dt>
                                   //    <dd>gene to go value '.$value.'</dd>';
                             }
                             array_push($go_id_list,$tmp_array);

                         }
                     }
                }
//                else{
//                    if ($doc[$src_col]==$search){
//                         foreach ($doc as $key =>$value){
//                             if ($key=="idx" OR $key==$src_col){
//                                     //echo '<li>'.$key.' : '.$value.'</li></br>';
//
//                             }
//                             else if($key==$tgt_col){
//     //                            echo'<dt>'.$key.'</dt>
//     //                                  <dd>'.$value.'</dd>';
//                                 //array_push($gene_symbol,$doc[$tgt_col]);
//                             }
//                             else if($key==$description){
//                                 //array_push($descriptions,$value);
//                             }
//                             else{
//     //                            echo'<dt>'.$key.'</dt>
//     //                                  <dd>'.$value.'</dd>';
//                             }
//
//                         }
//                     }
//                }
            }
            //search in the gen_to_desc mapping table

            else{


            }
        }
    }
}
else{
	echo'<div class="container">
        <h2>No Results found for \''.$search.'\'</h2>'
      . '</div>';	
}



$total_go_biological_process=array();
$total_go_cellular_component=array();
$total_go_molecular_function=array();


//Categorize go term into function, process or component
//coming from grid fs file.
if (count($go_id_full_list)!=0){
    echo 'go id full list is not empty';
    $handle = fopen('https://services.cbib.u-bordeaux2.fr/cobra/data/mappings/gene_ontology/obo/gene_ontology.obo', 'r');
        //get all go term

    $lineReader = new LineReader($handle);
    //parse file
    $parser = new Parser($lineReader);
    $parser->retainTrailingComments(true);
    $parser->getDocument()->mergeStanzas(false); //speed tip
    $parser->parse();
    //Categorize term from plaza GO annotation
    $go_id='';
    error_log('size : '.count($go_id_full_list));
    $term_array=$parser->getDocument()->getStanzas('Term');
    $molecular_function_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'molecular_function');
        });
    $biological_process_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'biological_process');
        });
    $cellular_component_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'cellular_component');
        });
    foreach ($go_id_full_list as $go_info){
        foreach ($molecular_function_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_info['GO_ID']){
                
                
                $go_info['description']=$term['name'];
                
                array_push($total_go_molecular_function, $go_info);

            }
        }
        foreach ($biological_process_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_info['GO_ID']){

                
                $go_info['description']=$term['name'];
                array_push($total_go_biological_process, $go_info);

            }
        }
        foreach ($cellular_component_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_info['GO_ID']){

                
                $go_info['description']=$term['name'];
                array_push($total_go_cellular_component, $go_info);

            }
        }
    }
}
foreach ($go_grid_id_list as $go_info){
    
    if ($go_info['relationship']=='has'){
        
        array_push($total_go_molecular_function, $go_info);
        
    }
    else if($go_info['relationship']=='involved in'){
        
        array_push($total_go_biological_process, $go_info);

        
    }
    else if($go_info['relationship']=='located in'){
        array_push($total_go_cellular_component, $go_info);

    }
    else if($go_info['relationship']=='functions in'){
        array_push($total_go_molecular_function, $go_info);

    }
    else{
        
    }
    
}
//echo '$total_go_molecular_function'.count($total_go_molecular_function);
if (count($go_id_list)!=0){
    #echo 'go id list is not empty';
    $handle = fopen('https://services.cbib.u-bordeaux2.fr/cobra/data/mappings/gene_ontology/obo/gene_ontology.obo', 'r');
        //get all go term

    $lineReader = new LineReader($handle);
    //parse file
    $parser = new Parser($lineReader);
    $parser->retainTrailingComments(true);
    $parser->getDocument()->mergeStanzas(false); //speed tip
    $parser->parse();
    //Categorize term from plaza GO annotation
    $go_id='';
    //foreach ($go_id_list as $go_id){
    error_log('size : '.count($go_id_list));
    $term_array=$parser->getDocument()->getStanzas('Term');
    $molecular_function_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'molecular_function');
        });
    $biological_process_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'biological_process');
        });
    $cellular_component_Terms = array_filter($term_array, function($stanza) {
            return (isset($stanza['namespace']) && $stanza['namespace'] == 'cellular_component');
        });
    for($i=0;$i<count($go_id_list);$i++){    
        //loop through Term stanzas to find obsolete terms


        foreach ($molecular_function_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_id_list[$i]['G0_ID']){
                
                $go_info=array();
                
                $go_info['GO_ID']=$term['id'];
                $go_info['description']=$term['name'];
                $go_info['evidence']=$go_id_list[$i]['evidence'];
                
                array_push($total_go_molecular_function, $go_info);

            }
        }
        foreach ($biological_process_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_id_list[$i]['G0_ID']){
                
                $go_info=array();
                
                $go_info['GO_ID']=$term['id'];
                $go_info['description']=$term['name'];
                $go_info['evidence']=$go_id_list[$i]['evidence'];


                array_push($total_go_biological_process, $go_info);

            }
        }
        foreach ($cellular_component_Terms as $term){
            //echo $term['id'] . ' ' . $term['namespace'] . PHP_EOL;
            if ($term['id']==$go_id_list[$i]['G0_ID']){
                
                $go_info=array();
                
                $go_info['GO_ID']=$term['id'];
                $go_info['description']=$term['name'];
                $go_info['evidence']=$go_id_list[$i]['evidence'];


                array_push($total_go_cellular_component, $go_info);

            }
        }




    }
}
//document accordeon avec table
/*<div class="panel-group" id="accordion_documents">
//                <div class="panel panel-default">
//                    <div class="panel-heading">
//                        <h3>
//                            <a class="accordion-toggle collapsed" href="#collapse_documents" data-parent="#accordion_documents" data-toggle="collapse">
//                                Documents and Presentations
//                            </a>				
//                        </h3>
//                    </div>
//                    ';
//                         if (count($total_go_biological_process)!=0){
//                        echo'
//                    <div class="panel-body panel-collapse collapse" id="collapse_documents">
//                        <table class="table table-condensed table-hover table-striped">
//                            <thead>
//                                <tr>
//                                    <th style="width:250px;">Gene Ontology Biological Process</th>
//                                    
//                                </tr>
//                            </thead>
//                            ';
//                            foreach ($total_go_biological_process as $go_info){
//                            echo'
//                            <tbody>
//                                <tr><td><a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span></td></tr>                                
//                            </tbody>
//                            ';
//                            }
//                            echo'
//                        </table>
//                    </div>
//                    ';
//                         }
//                        echo'
//                </div>
//            </div>    
//            <br/>*/
//accordeon document with list
/*<div class="panel-group" id="accordion_documents">
//                <div class="panel panel-default">
//                    <div class="panel-heading">
//                        
//                            <a class="accordion-toggle collapsed" href="#go_process" data-parent="#accordion_documents" data-toggle="collapse">
//                                <strong>GO Process</strong>
//                            </a>				
//                       
//                    </div>
//                    <div class="panel-body panel-collapse collapse" id="go_process">
//                        ';
//                         if (count($total_go_biological_process)!=0){
//                        echo'
//                        <div class="goProcessTerms goTerms">
//                            <h3>Gene Ontology Biological Process</h3>
//                            ';
//                            foreach ($total_go_biological_process as $go_info){
//                            echo'
//                            <ul>
//                                <span class="goTerm">
//             						<li>
//                                    
//             					 		<a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span>
//             					</span>
//             				</ul>
//                            ';
//                            }
//                            echo'
//                        </div>
//                        ';
//                         }
//                        echo'
//                    </div>
//                </div>
//            </div>    
//            <br/>*/
//old code for presentong GO results
/*<div class="goSummaryBlock">
//                        <div class="goProcessSummary">
//                            <strong>GO Process</strong> ('.  count($total_go_biological_process).')
//                        </div>
//                        <div class="goNone">
//                            <strong>GO Function</strong> ('.  count($total_go_molecular_function).')
//                        </div>
//                        <div class="goComponentSummary">
//                            <strong>GO Component</strong> ('.  count($total_go_cellular_component).')
//                        </div>
//                    </div>*/



echo   '<div id="summary">   
            <div id="protein-details">
            
                <div id="organism" class="right"><h4>'.$species.'</h4></div>';
                echo '<h1>'.$gene_symbol[0].'</h1> ';
                for ($i = 1; $i < count($descriptions); $i++) {
                    if ($i==count($descriptions)-1){
                        echo $descriptions[$i];
                    }
                   
                    else{
                        echo $descriptions[$i].', ';
                    }
                }
              
                
                echo'<div id="aliases">';
                for ($i = 1; $i < count($gene_symbol); $i++) {
                    if ($i==count($gene_symbol)-1){
                        echo $gene_symbol[$i];
                    }
                    else{
                        echo $gene_symbol[$i].', ';
                    }
                }
                
                echo '</div>';
                echo'<div id="protein aliases">';
                for ($i = 1; $i < count($proteins_id); $i++) {
                    if ($i==count($proteins_id)-1){
                        echo $proteins_id[$i];
                    }
                    else{
                        echo $proteins_id[$i].', ';
                    }
                }
                echo '</div>';
                if(count($descriptions)!=0){
                   echo'<div id="definition">definition : '.$descriptions[0].'</div> ';
                }
                echo'
               
                <div id="goTerms">
                    <div class="goTermsBlock">
                        <br/>
                        <div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle collapsed" href="#go_process" data-parent="#accordion_documents" data-toggle="collapse">
                                        <strong>Gene Ontology Biological Process </strong> ('.  count($total_go_biological_process).')
                                    </a>				
                                </div>
                                <div class="panel-body panel-collapse collapse" id="go_process">
                                ';
                                if (count($total_go_biological_process)!=0){
                                    echo'
                                    <div class="goProcessTerms goTerms">
                                    ';
                                    foreach ($total_go_biological_process as $go_info){
                                    echo'
                                        <ul>
                                            <span class="goTerm">
                                                <li>

                                                    <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info['GO_ID'].'" title="'.$go_info['description'].'">'.$go_info['description'].'</a>
                                                    <span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info['evidence'].'" title="Go Evidence Code">'.$go_info['evidence'].'</a>]
                                                    </span>
                                            </span>
                                        </ul>';
                                    }
                                    echo'
                                    </div>';
                                }
                                echo'
                                </div>
                            </div>
                        </div>    
                        <!--<br/>-->';
                        echo'
                        <div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#go_component" data-parent="#accordion_documents" data-toggle="collapse">
                                        <strong>Gene Ontology Cellular Component </strong> ('.  count($total_go_cellular_component).')
                                    </a>				

                                </div>
                                <div class="panel-body panel-collapse collapse" id="go_component">
                                ';
                                if (count($total_go_cellular_component)!=0){
                                    echo'
                                    <div class="goProcessTerms goTerms">

                                    ';
                                    foreach ($total_go_cellular_component as $go_info){
                                    echo'
                                        <ul>
                                            <span class="goTerm">
                                                <li>

                                                    <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info['GO_ID'].'" title="'.$go_info['description'].'">'.$go_info['description'].'</a>
                                                    <span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info['evidence'].'" title="Go Evidence Code">'.$go_info['evidence'].'</a>]
                                                    </span>
                                            </span>
                                        </ul>';
                                    }
                                    echo'
                                    </div>';
                                }
                                echo'
                                </div>
                            </div>
                        </div>    
                        <!--<br/>-->';
                                echo'
                        <div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#go_function" data-parent="#accordion_documents" data-toggle="collapse">
                                        <strong>Gene Ontology Molecular Function </strong> ('.  count($total_go_molecular_function).')
                                    </a>				

                                </div>
                                <div class="panel-body panel-collapse collapse" id="go_function">
                                ';
                                if (count($total_go_molecular_function)!=0){
                                    echo'
                                    <div class="goProcessTerms goTerms">

                                    ';
                                    foreach ($total_go_molecular_function as $go_info){
                                    echo'
                                        <ul>
                                            <span class="goTerm">
                                                <li>

                                                    <a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info['GO_ID'].'" title="'.$go_info['description'].'">'.$go_info['description'].'</a>
                                                    <span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info['evidence'].'" title="Go Evidence Code">'.$go_info['evidence'].'</a>]
                                                    </span>
                                            </span>
                                        </ul>';
                                    }
                                    echo'
                                    </div>';
                                }
                                echo'
                                </div>
                            </div>
                        </div>    
                        <!--<br/>-->';                      
//remove old method to display GO term                       
/*                        if (count($total_go_biological_process)!=0){
//                            
//                         
//                        echo'
//                        <div class="goProcessTerms goTerms">
//                            <h3>Gene Ontology Biological Process</h3>
//                            ';
//                            foreach ($total_go_biological_process as $go_info){
//                            echo'
//                            <ul>
//                                <span class="goTerm">
//             						<li>
//                                    
//             					 		<a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span>
//             					</span>
//             				</ul>
//                            ';
//                            }
//                            echo'
//                        </div>
//                        ';
//                         }
//                        if (count($total_go_cellular_component)!=0){
//                             
//                         
//                        echo'
//                        <div class="goComponentTerms goTerms">
//                            <h3>Gene Ontology Cellular Component</h3>
//                            
//             				<ul>
//                            ';
//                            foreach ($total_go_cellular_component as $go_info){
//                            echo'
//             					<span class="goTerm">
//             						<li>
//             							<a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span>
//             					</span>
//                                ';
//                            }
//                            echo'
//             				</ul>
//                            
//                        </div>
//                        ';
//                         }
//                        if (count($total_go_molecular_function)!=0){
//                             
//                         
//                        echo'
//                        <div class="goFunctionTerms goTerms">
//                            <h3>Gene Ontology Molecular Function</h3>
//                            
//             				<ul>
//                            ';
//                            foreach ($total_go_molecular_function as $go_info){
//                            echo'
//             					<span class="goTerm">
//             						<li>
//             							<a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span>
//             					</span>
//                                ';
//                            }
//                            echo'
//             				</ul>
//                            
//                        </div>
//                        ';
//                            }*/            
                        echo'
                    </div>
                </div>
                <div id="linkouts">
                    <h3>External Database Linkouts</h3>
             		<a target="_BLANK" href="http://arabidopsis.org/servlets/TairObject?type=locus&name='.$search.'" title="TAIR AT5G03160 LinkOut">TAIR</a>
             	  <!--| <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/gene/831917" title="Entrez-Gene 831917 LinkOut">Entrez Gene</a> 
             	  | <a target="_BLANK" href="http://www.ncbi.nlm.nih.gov/sites/entrez?db=protein&cmd=DetailsSearch&term=NP_195936" title="NCBI RefSeq Sequences">RefSeq</a> -->
             	  ';
                    
                    
                    for ($i = 0; $i < count($proteins_id); $i++) {                        
                        echo'| <a target="_BLANK" href="http://www.uniprot.org/uniprot/'.$proteins_id[$i].'" title="UniprotKB Swissprot and Trembl Sequences">UniprotKB</a>';   
                    } 
                    echo'
                </div>
                <div class="bottomSpacer"></div>    
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
				';
//                echo 'gene symbol  : '.count($gene_symbol);
                $interaction_array=get_interactor($gene_symbol,$proteins_id,$species,$interactionsCollection);
                $counter=0;
//                echo 'interaction_array   : '.count($interaction_array );
                
                foreach ($interaction_array as $array){
                    if ($counter==0){
                        $total_protein_intact=count($array);
//                        foreach ($array as $intact){
//                            $total_protein_intact++;
//                        }
                    }
                    else{
                        $total_protein_litterature=0;
                        foreach ($array as $intact){
                            $total_protein_litterature++;
                        }
                    }
                    $counter++;
                }
//                foreach ($interaction_array as $array){
//                    if ($counter==0){
//                        echo 'global intact protein array <br/>';
//                        $total_protein_intact=0;
//                        foreach ($array as $intact){
//                            echo 'protein array <br/>';
//                            foreach ($intact as $attributes){
//                                
//                                if ($attributes[0]=='src'){
//                                    //echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='tgt') {
//                                    
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='method') {
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                
//                                }
//                                elseif ($attributes[0]=='pub') {
//                                
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='host_name') {
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='virus_name') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='host_taxon') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='virus_taxon') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                else{
//                                    
//                                }
//                                
//                                
//                            }
//                            $total_protein_intact++;
//                            
//                        }
//                        $counter++;
//                    }
//                    else{
//                        echo 'global litterature protein array <br/>';
//
//                        $total_protein_litterature=0;
//                        foreach ($array as $lit){
//                            echo 'litterature array <br/>';
//                            foreach ($lit as $attributes){
//                                
//                                if ($attributes[0]=='src'){
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='tgt') {
//                                    
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='method') {
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                
//                                }
//                                elseif ($attributes[0]=='pub') {
//                                
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='host_name') {
//                                     echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='virus_name') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='Accession_number') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                elseif ($attributes[0]=='Putative_function') {
//                                    echo $attributes[0].' - '.$attributes[1].'<br/>';
//                                }
//                                else{
//                                    
//                                }
//                                
//                                
//                            }
//                            $total_protein_litterature++;
//                            
//                        }
//                        $counter++;
//                    }
//                    
//                }
                $counter=0;
                foreach ($interaction_array as $array){
                    if ($counter==0){
                        echo'
                        <div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#lit_interact" data-parent="#accordion_documents" data-toggle="collapse">
                                        <strong> Intact Database </strong> ('. $total_protein_intact.')
                                    </a>				

                                </div>
                                <div class="panel-body panel-collapse collapse" id="lit_interact">';

                                    echo'
                                    <div class="goProcessTerms goTerms">';

                                    echo'';

                                                

         //$table_string.='<a href=experiments.php>test</a>';


                                    //echo 'global intact protein array <br/>';
                                    $total_protein_intact=0;
                                    foreach ($array as $intact){
                                        //echo 'protein array <br/>';
                                        $string_seq='<ul><span class="goTerm">';
                                        foreach ($intact as $attributes){

                                            if ($attributes[0]=='src'){

                                                $string_seq.='<li value='.$ $attributes[1].'> host protein :'.$attributes[1].'</li>';

                                                //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='tgt') {
                                                 $tgt=$attributes[1];
                                                $string_seq.='<li value='.$ $attributes[1].'> viral protein :'.$attributes[1].'</li>';

                                                 //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='method') {
                                                 $string_seq.='<li value='.$ $attributes[1].'> method :'.$attributes[1].'</li>';


                                                 //echo $attributes[0].' - '.$attributes[1].'<br/>';

                                            }
                                            elseif ($attributes[0]=='pub') {
                                                 $string_seq.='<li value='.$ $attributes[1].'> publication :'.$attributes[1].'</li>';

                                                 //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='host_name') {
                                                $string_seq.='<li value='.$ $attributes[1].'> host name :'.$attributes[1].'</li>';

                                                //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='virus_name') {
                                                $string_seq.='<li value='.$ $attributes[1].'> virus name :'.$attributes[1].'</li>';

                                                //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='host_taxon') {
                                                $string_seq.='<li value='.$ $attributes[1].'> host taxon :'.$attributes[1].'</li>';

                                                //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            elseif ($attributes[0]=='virus_taxon') {
                                                $string_seq.='<li value='.$ $attributes[1].'> virus taxon :'.$attributes[1].'</li>';

                                                //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                            }
                                            else{

                                            }


                                        }
                                        $string_seq.='</ul></span>';
                                        add_accordion_panel($string_seq, $tgt, $tgt);
                                        $total_protein_intact++;

                                    }
                                    $counter++;
                                    echo'
                                    </div>';

                                echo'
                                </div></div></div>';
                    }
                    else{
                        echo'
                               
                            
                        <div class="panel-group" id="accordion_documents">
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                    <a class="accordion-toggle collapsed" href="#database_interact" data-parent="#accordion_documents" data-toggle="collapse">
                                        <strong> Litterature database </strong> ('.  $total_protein_litterature.')
                                    </a>				

                                </div>
                                <div class="panel-body panel-collapse collapse" id="database_interact">
                                ';

                                echo'
                                <div class="goProcessTerms goTerms">

                                ';
                                $total_protein_litterature=0;
                                foreach ($array as $lit){
                                    
                                    $string_seq='<ul><span class="goTerm">';
                                    foreach ($lit as $attributes){
                                        

                                        if ($attributes[0]=='src'){
                                            $string_seq.='<li value='.$ $attributes[1].'> host protein :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='tgt') {
                                            $tgt=$attributes[1];
                                            $string_seq.='<li value='.$ $attributes[1].'> viral protein :'.$attributes[1].'</li>';
                                             //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='method') {
                                            $string_seq.='<li value='.$ $attributes[1].'> method :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';

                                        }
                                        elseif ($attributes[0]=='pub') {
                                            $string_seq.='<li value='.$ $attributes[1].'> publication :'.$attributes[1].'</li>';
                                             //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='host_name') {
                                            $string_seq.='<li value='.$ $attributes[1].'> host name :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='virus_name') {
                                            $string_seq.='<li value='.$ $attributes[1].'> viral name :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='Accession_number') {
                                            $string_seq.='<li value='.$ $attributes[1].'> Accession number :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        elseif ($attributes[0]=='Putative_function') {
                                            $string_seq.='<li value='.$ $attributes[1].'> Putative function :'.$attributes[1].'</li>';
                                            //echo $attributes[0].' - '.$attributes[1].'<br/>';
                                        }
                                        else{

                                        }


                                    }
                                    $string_seq.='</ul></span>';
                                    add_accordion_panel($string_seq, $tgt, $tgt);
                                    $total_protein_litterature++;

                                }
                                $counter++;
                                

                                echo'
                                </div>';

                            echo'
                            </div>
                        </div></div>';
                    }
                }
                        echo'
                           

                                

                        <div class="physical-ltp statisticRow">
                            <div class="physical colorFill" style="width: 0%;"></div>
                            <div class="statDetails">
                                <div class="left"></div>
                                <div class="right"></div>
                                    '; 
                                $total=$total_protein_litterature+$total_protein_intact;
                        
                                echo $total.' Physical Interactions
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
                  //$protein="Q39255";   
                  
                    echo'
            
            
        </div>
     	';
                          
         //$cursor = find_gene_by_regex($measurementsCollection,new MongoRegex("/^$search/m"));
         //add_accordion_panel(get_sample_table_in_string($cursor,$samplesCollection)); 
         //display_sample_table($cursor,$samplesCollection);                   
          //echo'            
      
//     	<div class="sample_info">';
//       
//                $cursor = find_gene_by_regex($measurementsCollection,new MongoRegex("/^$search/m"));
//                add_accordion_panel(get_sample_table_in_string($cursor,$samplesCollection),"Sample details","ortholog_search"); 
//                //display_sample_table($cursor,$samplesCollection);                   
//                 echo'</div>
 
 





	new_cobra_footer();






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


