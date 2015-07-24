<?php
//session_start();
include './functions/html_functions.php';
include './functions/php_functions.php';
include './functions/mongo_functions.php';
include '../wiki/vendor/autoload.php';
require('./session/control-session.php');





new_cobra_header();

new_cobra_body($_SESSION['login'],"Result Summary","section_result_summary");

if (((isset($_GET['organism'])) && ($_GET['organism']!='')) && ((isset($_GET['search'])) && ($_GET['search']!=''))){


	$organism=control_post(htmlspecialchars($_GET['organism']));
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
    $GOCollection = new Mongocollection($db, "gene_ontology");

	
	//get_all_results_from_samples($measurementsCollection,$samplesCollection,$search);

    //if more than one results (often the case when search by gene symbol or keywords

    //put the search box again...
    make_species_list(find_species_list($speciesCollection));
    
    
    /*
    echo '<hr>'; 
    $timestart=microtime(true);
    $cursor=$mappingsCollection->aggregate(array( 
        array('$match' => array('type'=>'gene_to_prot')),  
        array('$project' => array('tgt_to_src'=>1,'species'=>1,'_id'=>0)),    
        array('$unwind'=>'$tgt_to_src'),    
        array('$match' => array('tgt_to_src.0'=>'Q9SHJ5')),  
        array('$project' => array('tgt_to_src'=>1,'_id'=>0))
    ));
    foreach ($cursor as $key => $value) {
        //echo 'tgt'.$value[0];
        var_dump($value);
        foreach ($value as $row){
            foreach ($row as $column){
                if(is_array($column)){
                    echo $column[0];

                }  
            }
        }
    }
    $timeend=microtime(true);
    $time=$timeend-$timestart;
    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Debut du script: ".date("H:i:s", $timestart);
    echo "<br>Fin du script: ".date("H:i:s", $timeend);
    echo "<br>Script aggregation recherche prot id execute en " . $page_load_time . " sec";
    echo '<hr>';
      
    $timestart=microtime(true);
    
    
    
    $mappings_to_process=$mappingsCollection->find(array('tgt_to_src'=>array('$exists'=>true)),array('type'=>1,'species'=>1,'tgt_to_src'=>1,'_id'=>0));
    foreach ($mappings_to_process as $map_doc){
        $tgt_to_src = $map_doc['tgt_to_src'];
        $type=$map_doc['type'];
        
        //echo $type."\n";
        //most of table are from plaza db
        //need to first translate into plaza id.
       // Old way to capture gene ontology
     
     
//        if ($type=='gene_to_go' && $species==$organism){
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
//        }
        if ($type=='gene_to_prot'){
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
                        if ($column=='Q9SHJ5'){
                            $found=TRUE;
                            echo 'tgt : '.$column;    
                        }
                   } 
                }
            }
        }
        
    }
    $timeend=microtime(true);
    $time=$timeend-$timestart;
    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Debut du script: ".date("H:i:s", $timestart);
    echo "<br>Fin du script: ".date("H:i:s", $timeend);
    echo "<br>Script find foreach loop prot id execute en " . $page_load_time . " sec";
    
    echo '<hr>';
    
    $timestart=microtime(true);
    $cursor=$mappingsCollection->aggregate(array( 
            array('$match' => array('type'=>'gene_to_prot')),  
            array('$project' => array('mapping_file'=>1,'src'=>1,'species'=>1,'_id'=>0)),    
            array('$unwind'=>'$mapping_file'),    
            array('$match' => array('mapping_file.$'=>'AT1G06520')),  
            array('$project' => array('species'=>1,'mapping_file'=>1,'_id'=>0))
        ));
    
    $timeend=microtime(true);
    $time=$timeend-$timestart;
 
    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Debut du script: ".date("H:i:s", $timestart);
    echo "<br>Fin du script: ".date("H:i:s", $timeend);
    echo "<br>Script aggregate and direct src execute en " . $page_load_time . " sec";
    
    echo '<hr>';
    
    $timestart=microtime(true);
    $srccol=$mappingsCollection->find(array('type'=>'gene_to_prot','species'=>'Arabidopsis thaliana'),array('src'=>1,'tgt'=>1));
    foreach ($srccol as $values) {
        echo $values['src'];
        $cursor=$mappingsCollection->aggregate(array( 
            array('$match' => array('type'=>'gene_to_prot','src'=>$values['src'])),  
            array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
            array('$unwind'=>'$mapping_file'),    
            array('$match' => array('mapping_file.'.$values['src']=>'AT1G06520')),  
            array('$project' => array('species'=>1,'mapping_file'=>1,'_id'=>0))
        ));
        var_dump($cursor);
    }
    
    
    $timeend=microtime(true);
    $time=$timeend-$timestart;
 
    //Afficher le temps d'éxecution
    $page_load_time = number_format($time, 3);
    echo "Debut du script: ".date("H:i:s", $timestart);
    echo "<br>Fin du script: ".date("H:i:s", $timeend);
    echo "<br>Script aggregate and var dump execute en " . $page_load_time . " sec";
    
    echo '<hr>';
    */
    $go_id_list=array();
    $go_grid_plaza_id_list=array();
    $go_grid_id_list=array();
    
    $gene_symbol=array();
    $descriptions=array();
    $proteins_id=array();
    $est_id=array();
    echo '<hr>';
     //get the corresponding plaza id
    
    
    // try to convert into preferred id 
    
    
    
    $plaza_id=get_plaza_id($mappingsCollection, $speciesCollection,$search,$organism);
    
    
    
    $srccol=$mappingsCollection->find(array('type'=>'gene_to_prot','species'=>$organism),array('src'=>1,'tgt'=>1,'description'=>1));
    foreach ($srccol as $values) {
        
        if ($values['src']=='plaza_gene_id'){
            
            $cursor=$mappingsCollection->aggregate(array( 
                array('$match' => array('type'=>'gene_to_prot','src'=>$values['src'])),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
                array('$unwind'=>'$mapping_file'),    
                array('$match' => array('mapping_file.'.$values['src']=>$plaza_id)),  
                array('$project' => array('description'=> '$mapping_file.'.$values['description'],'species'=>1,'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
            ));
            foreach ($cursor['result'] as $result) {
                array_push($proteins_id,$result['tgt_id']);
                array_push($descriptions,$result['description']);
            
            }
        }
        else{
            $cursor=$mappingsCollection->aggregate(array( 
                array('$match' => array('type'=>'gene_to_prot','src'=>$values['src'])),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
                array('$unwind'=>'$mapping_file'),    
                array('$match' => array('mapping_file.'.$values['src']=>$search)),  
                array('$project' => array('description'=> '$mapping_file.'.$values['description'],'species'=>1,'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
            )); 
            foreach ($cursor['result'] as $result) {
                array_push($proteins_id,$result['tgt_id']);
                array_push($descriptions,$result['description']);
            
            }
        }
        //var_dump($cursor);
        
    }  
    $srccol=$mappingsCollection->find(array('type'=>'gene_to_symbol','species'=>$organism),array('src'=>1,'tgt'=>1,'description'=>1));
    foreach ($srccol as $values) {
        $cursor=$mappingsCollection->aggregate(array( 
            array('$match' => array('type'=>'gene_to_symbol','src'=>$values['src'])),  
            array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
            array('$unwind'=>'$mapping_file'),    
            array('$match' => array('mapping_file.'.$values['src']=>$search)),  
            array('$project' => array('description'=> '$mapping_file.'.$values['description'],'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
        ));
        //var_dump($cursor);
        foreach ($cursor['result'] as $result) {
            array_push($descriptions,$result['tgt_id']);
            array_push($descriptions,$result['description']);

            
        }
    }
    $srccol=$mappingsCollection->find(array('type'=>'gene_to_gene','species'=>$organism),array('src'=>1,'tgt'=>1,'description'=>1));
    foreach ($srccol as $values) {
        $cursor=$mappingsCollection->aggregate(array( 
            array('$match' => array('type'=>'gene_to_gene','src'=>$values['src'])),  
            array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
            array('$unwind'=>'$mapping_file'),    
            array('$match' => array('mapping_file.'.$values['src']=>$search)),  
            array('$project' => array('species'=>1,'description'=> '$mapping_file.'.$values['description'],'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
        ));
        //var_dump($cursor);
        foreach ($cursor['result'] as $result) {
            array_push($gene_symbol,$result['tgt_id']);
            array_push($descriptions,$result['description']);
            
        }
    }
    $srccol=$mappingsCollection->find(array('type'=>'gene_to_go','species'=>$organism),array('src'=>1,'tgt'=>1));
    foreach ($srccol as $values) {
        $go_id_added_list=array();
        if ($values['src']=='plaza_gene_id'){
            $cursor=$mappingsCollection->aggregate(array( 
                array('$match' => array('type'=>'gene_to_go','key'=>'plaza gene id to go id list','species'=>$organism,'src'=>$values['src'])),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
                array('$unwind'=>'$mapping_file'),    
                array('$match' => array('mapping_file.'.$values['src']=>$plaza_id)),  
                array('$project' => array('species'=>1,'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
            ));
            //var_dump($cursor);

            foreach ($cursor['result'] as $result) {
                $go_id_evidence = explode("_", $result['tgt_id']);
                foreach ($go_id_evidence as $duo) {
                    $tmp_array=array();
                    $duo_id=explode("-", $duo);
                    $tmp_array['evidence']=$duo_id[1];
                    $tmp_array['GO_ID']=$duo_id[0];
                    
                    array_push($go_id_list,$tmp_array);

                }


                //array_push($gene_symbol,$result['tgt_id']);

            }
        }
        else{
            $cursor=$mappingsCollection->aggregate(array( 
                array('$match' => array('type'=>'gene_to_go','key'=>'plaza gene id to go id list','species'=>$organism,'src'=>$values['src'])),  
                array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
                array('$unwind'=>'$mapping_file'),    
                array('$match' => array('mapping_file.'.$values['src']=>$search)),  
                array('$project' => array('species'=>1,'tgt_id'=>'$mapping_file.'.$values['tgt'],'_id'=>0))
            ));
            //var_dump($cursor);

            foreach ($cursor['result'] as $result) {
                $go_id_evidence = explode("_", $result['tgt_id']);
                foreach ($go_id_evidence as $duo) {
                    $tmp_array=array();
                    $duo_id=explode("-", $duo);
                    $tmp_array['evidence']=$duo_id[1];
                    $tmp_array['GO_ID']=$duo_id[0];
                    array_push($go_id_list,$tmp_array);

                }


                //array_push($gene_symbol,$result['tgt_id']);

            }
        }
    }
    $tgtcol=$mappingsCollection->find(array('type'=>'est_to_gene','species'=>$organism),array('src'=>1,'tgt'=>1));
    foreach ($tgtcol as $values) {
        $cursor=$mappingsCollection->aggregate(array( 
            array('$match' => array('type'=>'est_to_gene','tgt'=>$values['tgt'])),  
            array('$project' => array('mapping_file'=>1,'species'=>1,'_id'=>0)),    
            array('$unwind'=>'$mapping_file'),    
            array('$match' => array('mapping_file.'.$values['tgt']=>$search)),  
            array('$project' => array('species'=>1,'src_id'=>'$mapping_file.'.$values['src'],'_id'=>0))
        ));
        //var_dump($cursor);
        foreach ($cursor['result'] as $result) {
            array_push($est_id,$result['src_id']);
            
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


echo '<hr>';


//if (count($go_grid_plaza_id_list)!=0){
//    
//    
//    
//    echo 'go id full list is not empty';
//    foreach ($go_grid_plaza_id_list as $go_info){
//        $go_term=$GOCollection->aggregate(array( 
//            array('$project' => array('GO_collections'=>1,'_id'=>0)),    
//            array('$unwind'=>'$GO_collections'),    
//            array('$match' => array('GO_collections.id'=>$go_info['GO_ID'])),  
//            array('$project' => array('namespace'=>'$GO_collections.namespace','name'=>'$GO_collections.name','_id'=>0)) 
//        ));
//        //echo $go_info['GO_ID'];
//        //$timestart1=microtime(true);
//        foreach ($go_term as $GO_collection) {
//           
//            foreach ($GO_collection as $value) {
//            //var_dump($value);   
//            
//                if ($value['namespace']=='molecular_function'){
//                    $go_info['description']=$value['name'];                
//                    array_push($total_go_molecular_function, $go_info);
//                }
//                if ($value['namespace']=='biological_process') {
//                    $go_info['description']=$value['name'];                
//                    array_push($total_go_biological_process, $go_info);
//
//                }
//                if ($value['namespace']=='cellular_component'){
//                    $go_info['description']=$value['name'];                
//                    array_push($total_go_cellular_component, $go_info);
//                }
//            }
//        }
//    }
//}
//
//foreach ($go_grid_id_list as $go_info){
//    
//    if ($go_info['relationship']=='has'){
//        
//        array_push($total_go_molecular_function, $go_info);
//        
//    }
//    else if($go_info['relationship']=='involved in'){
//        
//        array_push($total_go_biological_process, $go_info);
//
//        
//    }
//    else if($go_info['relationship']=='located in'){
//        array_push($total_go_cellular_component, $go_info);
//
//    }
//    else if($go_info['relationship']=='functions in'){
//        array_push($total_go_molecular_function, $go_info);
//
//    }
//    else{
//        
//    }
//    
//}
//echo '$total_go_molecular_function'.count($total_go_molecular_function);
if (count($go_id_list)!=0){
    
    foreach ($go_id_list as $go_info){
  
        
        $go_term=$GOCollection->aggregate(array( 
                array('$project' => array('GO_collections'=>1,'_id'=>0)),    
                array('$unwind'=>'$GO_collections'),    
                array('$match' => array('GO_collections.id'=>$go_info['GO_ID'])),  
                array('$project' => array('GO_collections.namespace'=>1,'GO_collections.name'=>1,'_id'=>0)) 
        ));
        foreach ($go_term as $GO_collection) {
            foreach ($GO_collection as $values) {
                foreach ($values as $value) {
                    if ($value['namespace']=='molecular_function'){


                    //$go_info['GO_ID']=$value['id'];
                    $go_info['description']=$value['name'];
                    //echo $value['name'];
                    //$go_info['evidence']=$go_id_list[$i]['evidence'];
                    array_push($total_go_molecular_function, $go_info);
                    }
                    if ($value['namespace']=='biological_process') {
                        $go_info['description']=$value['name'];                      
                        array_push($total_go_biological_process, $go_info);

                    }
                    if ($value['namespace']=='cellular_component'){
                        $go_info['description']=$value['name']; 
                        array_push($total_go_cellular_component, $go_info);
                    }   
                }
                
            }
        }
        
    }
}


//HTML OUTPUT
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
			
            ';
            echo'<div class="panel-group" id="accordion_documents">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>
                                    <a class="accordion-toggle collapsed" href="#ortho-table" data-parent="#accordion_documents" data-toggle="collapse">
                                            Paralogs and Orthologs table
                                    </a>				
                                </h3>
                            </div>
                            <div class="panel-body panel-collapse collapse" id="ortho-table">

                                <table class="table table-condensed table-hover table-striped">                                                                <thead>
                                    <tr>';
                                        echo "<th>ID</th>";
                                        echo "<th>ID type</th>";
                                        echo "<th>species</th>";
                                        echo'
                                    </tr>
                                    </thead>

                                    <tbody>';
                                        //$timestart=microtime(true);
                                        echo small_table_ortholog_string($grid,$mappingsCollection,$orthologsCollection,$organism,$plaza_id);
//                                        $timeend=microtime(true);
//                                        $time=$timeend-$timestart;
//
//                                        //Afficher le temps d'éxecution
//                                        $page_load_time = number_format($time, 3);
//                                        echo "Debut du script: ".date("H:i:s", $timestart);
//                                        echo "<br>Fin du script: ".date("H:i:s", $timeend);
//                                        echo "<br>Script aggregate and var dump execute en " . $page_load_time . " sec";
                               echo'</tbody>

                                </table>
                            </div>

                        </div>
                    </div>';
                  //$protein="Q39255";   
                  
                    echo'</div>
            
            
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



