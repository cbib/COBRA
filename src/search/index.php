<?php
//session_start();
// on teste si le visiteur a soumis le formulaire de connexion
//if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
//	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';


/*debut du cache*/



//$expire = time() - 84400 ; // valable une minute

//$timestart=microtime(true);             


//if(file_exists($cache) && filemtime($cache) > $expire)



    

    new_cobra_header("../..");
    new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Quick search","section_quick_search","../..");


    echo '
    <main id="content" class="searchpage">
        <div id="mission-objectives"><p>COBRA database provides knowledges on the viral factor(s) that determine(s) the breaking of the resistance 
                provided by candidate genes identified in the above WPs and to evaluate the durability of the resistance conferred 
                by the new candidate genes prior to transfer to crop species</p>
        </div> 
        ';




    $db=mongoConnector();
    $grid = $db->getGridFS();
    $speciesCollection = new Mongocollection($db, "species");
    $sampleCollection = new Mongocollection($db, "samples");
    $virusCollection = new Mongocollection($db, "viruses");
    $measurementsCollection = new Mongocollection($db, "measurements");
    $publicationsCollection = new Mongocollection($db, "publications");
    $interactionsCollection = new Mongocollection($db, "interactions");


    make_species_list(find_species_list($speciesCollection),"../..");
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
   


    

   
    echo '<div class="col-md-12" >		
        <div class="col-md-6" >
                <div class="column-padding no-right-margin">
                        <div class="plain-box"><h2 id="features">A COmbination of systems Biology and experimental high-throughput approaches to engIneer durable Resistance against plAnt viruses in crops</h2>
                        </div>
                                <p>(PLANT-KBBE) 2013 										Projet COBRA</p>
                                <p>COBRA plant virus interaction database is developed in coordination with other plant genomics and 										bioinformatics groups via the  consortium. The Plant KBBE project is funded by the 										European Commission within its 7th Framework Programme, under the thematic area 						</p>
                                <p>ANR Programme: <a href="http://www.agence-nationale-recherche.fr/en/funded-projects/?tx_lwmsuivibilan_pi1[Programme]=843">Food & Feed: crop yields and nutrition security in the context of climate change (PLANT-KBBE) 2013</a></p>

                                <p>Project ID: <a href="http://www.agence-nationale-recherche.fr/?Project=ANR-13-KBBE-0006" >ANR-13-KBBE-0006</a></p>

                                <p>Project coordinator: Veronique DECROOCQ (UMR 1332 Biologie et Pathologie du Fruit)</p>


                        <div class="plain-box"><h2 id="features">Project overview</h2>
                        </div>
                        <div class="span" >
                                <p>Plant viruses cause an estimated 50 billion € loss worldwide per year. Viral diseases represent one of the most
                                limiting factors in European crop production having negative effects on the quantity and quality of foodstuffs. 
                                The recent identification of plant factors required for the virus infection cycle, together with the development 
                                of functional genomic tools in several economically important crops, offer novel opportunities to protect crop plants 
                                against viral diseases. However, current candidate genes are few, and in the better-studied case (i.e. eIF4E, 
                                eIF4G) their proteins interact mainly with the same viral factor. This is a major limitation that compromises 
                                the durability of resistances, because resistance depends on the introduction of a single trait implicating one 
                                single viral counterpart. The scope of COBRA is to intensify applied and fundamental research on plant/virus 
                                interactions in order to diversify targets for resistance gene pyramiding strategies and to match the research 
                                outputs with industry and breeding applications.</p>

                                <!--<p>COBRA benefits from multidisciplinary research teams involving genomics, bio-informatics, population genetics, 
                                molecular biology, virology and plant breeding. It focuses on three major crops, barley for cereals, tomato for 
                                vegetables and Prunus species for fruit trees. The originality of COBRA is to test the generic mode of interference 
                                of plant viruses, from annual plants to perennials and from dicotyledons to monocotyledons and use this information 
                                to implement complex and durable resistance in any crop species.</p>


                                <p>The purpose here is to provide knowledge on the viral factor(s) that determine(s) the breaking of the resistance 
                                provided by candidate genes identified in the above WPs and to evaluate the durability of the resistance conferred by the new candidate genes prior to transfer to crop species.
                                In conclusion, COBRA is expected to provide new targets for resistance to plant viruses, distinct from the well- 
                                described mechanism related to translation initiation factors eIF4E and eIF4G. This will allow the selection of 
                                new cultivars in tomato, barley and stone fruit trees combining different mechanisms of resistance for sustainable 
                                virus protection. COBRA will also establish high throughput platforms of transfer to crop species based on the 
                                construction of a non-exhaustive database of plant-virus interactors and the use of next generation sequencing 
                                approaches.</p>-->
                        </div>

                </div>
        </div>
        <!---#COBRA Funding And Partners-->




        <div class="col-md-6" >
            <div class="col-md-6" >
                <div id="image_container">
                    <hr  size=0.5>
                    <a href="http://www.inra.fr/"><img class="displayed" id="partner_logo" src="../../images/logo-inra_w186.jpg"/></a>
                </div>
                </br>
                </br>
                <div id="image_container">
                    <hr  size=0.5>                           
                    <a href="http://www.nordsaat.de/"><img class="displayed" id="partner_logo" src="../../images/noordsat_w186.jpg" /></a>
                </div>
                </br>
                </br>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.jki.bund.de/en/startseite/home.html"><img class="displayed" id="partner_logo" src="../../images/jki_w186.gif"  /></a>
                </div>
                </br>
                </br>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.ipk-gatersleben.de/"><img class="displayed" id="partner_logo" src="../../images/ipk.png"  /></a>
                </div>
                </br>
                </br>
            </div>
            <div class="col-md-6" >
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cgfb.u-bordeaux2.fr/"><img class="displayed" id="partner_logo" src="../../images/cgfb_w186.jpg" height="85"/></a>
                </div>
                </br>
                </br>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.abiopep.com/en"><img class="displayed" id="partner_logo" src="../../images/abiopep3_w186.jpg" height="85" /></a>
                </div>
                </br>
                </br>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cebas.csic.es/"><img class="displayed" id="partner_logo" src="../../images/logo_csic_w186.jpg" height="85" width="165"/></a>
                </div>
                </br>
                </br>
                 <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cnb.csic.es/index.php/en/"><img class="displayed" id="partner_logo" src="../../images/cnb.jpg" height="85"/></a>
                </div>
                </br>
                </br>

            </div>
        </div>
    </div>';
    

        //make_gene_id_text_list("../..");

            //make_CrossCompare_list(find_species_list($speciesCollection));
            //make_viruses_list(find_viruses_list($virusCollection));



        



                    
        


    //        echo'<div class="col-md-12" >
    //            <div class="column-padding no-right-margin">
    //                <div class="tinted-box no-top-margin" style="border:1px solid grey ">
    //                    <h1 style="text-align:center">	Some statistics...</h1>
    //                </div>
    //                
    //
    //                <p><h4>Last update : '.getlastmod().'</h4></p> 
    //                <p><h4>Number of samples : '.$sampleCollection->count().'</h4></p>
    //                <p><h4>Number of normalized measures : '.$measurementsCollection->count().'</h4></p>
    //
    //                <p><h4>Number of species : '.$speciesCollection->count().'</h4></p>';
    //
    //                $cursor=$speciesCollection->aggregate(array(
    //                array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
    //                ));
    //                echo '<p> <h4>Species per top_level</h4>';
    //                foreach ($cursor['result'] as $doc){
    //                        echo '<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
    //                }
    //                $cursor=$virusCollection->aggregate(array(
    //                array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
    //                ));
    //                echo '<p><h4> Pathogens per top_level</h4>';
    //                foreach ($cursor['result'] as $doc){
    //                        echo '<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p></p>';
    //                }
    //                echo '
    //
    //            </div>
    //        </div>
    //    </div>      
    display_statistics();
        
    
    echo'<br/>';

    echo '</main>';
    new_cobra_footer();


//$timeend=microtime(true);
//$time=$timeend-$timestart;
////Afficher le temps d'éxecution
//$page_load_time = number_format($time, 3);
//error_log ("starting script at: ".date("H:i:s", $timestart));
//error_log ("<br>Ending script at: ".date("H:i:s", $timeend));
//error_log ("<br>Script for interaction data executed in " . $page_load_time . " sec"); 
// 
 
 
 /*obsolet code
 //
 //
 //
 //
//new_cobra_species_container();
//echo '
//    <!--<div class="container">
//                <div class="form-field ff-multi">
//                        <div class=ff-inline ff-right">
//                                <img src="images/NINSAR_LOGO.jpg" />
//                                <img src="images/LOGO_CSIC.jpg" />
//                                <img src="images/abiopep.jpg" />
//                                <img src="images/INRA.jpg" />
//                                <img src="images/GAFL.jpg" />
//                        </div>
//                </div>
//        </div>-->
//    <!--<div class="plain-box">
//        <div class="form-group">
//            <label for="requestID">Multiple Select List</label>
//            <select multiple class="form-control" id="requestID" name="requestID">
//                <option value="Request1">get all uniprot id from genes up regulated from a given species in microarray analysis of infection by a given virus</option>
//                <option value="Request2">get all angiosperms infected by a given pathogen</option>
//                <option value="Request3">find a gene using a regular expression</option>
//                <option value="Request4">Request 4</option>
//                <option value="Request5">Request 5</option>
//            </select>
//            </div>
//        </div>
//
//        <div class="form-group">
//            <label for="textInput">choose a gene id</label>
//            <input type="text" name="textInput" class ="form-control" placeholder="Tapez ici..." id="textInput">
//        </div>
//        <div class="form-group">
//            <label for="logFCInput">choose min logFC value</label>
//            <input type="number" step="0.0001" name="logFCInput" class ="form-control" placeholder="Tapez ici..." id="logFCInput">
//        </div>
//        <div class="form-group">
//            <button type="submit" class="btn btn-default">Submit</button>
//        </div>
//        </form>
//        </div>
//        -->';                                
//
//
// echo '<!--<div class="plain-box">
//                        <h2 id="features">
//                        Some statistics...
//                        </h2>
//                </div>-->';
// echo'
//<!--<div class="column-padding no-left-margin"><div class="container"><div class="col-xs-6"><h2>Select examples</h2><p>Select a species in the list :</p>-->
//<!--<form role="form" action="../../src/resultats.php" method="post" >-->';
 
        #make_plaza_orthologs(get_plaza_orthologs($grid,"plaza_gene_identifier",));
        //make_species_list_2();
        //make_viruses_list(find_viruses_list($speciesCollection));
        //make_experiment_type_list(find_experiment_type_list($sampleCollection));
        #make_request_list();
        //style="padding : 5px" 
        
//        make_whats_new();
//         'A/ report_date':datetime.datetime.now(),
// 		'B/ Number of samples':samples_col.count(),
// 		'C/ Number of normalized measures':measurements_col.count(),
// 		'C_a/ Tally of normalized measures':measurements_col.aggregate([{"$group":{"_id":"$type", "count": { "$sum": 1 }}}])['result'],
// 		'D/ Number of species':species_col.count(),
// 		'D_a/ Number of species per top_level':species_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result'],
// 		'D_b/ Number of viruses per top_level':viruses_col.aggregate([{"$group":{"_id":"$classification.top_level","count":{"$sum":1}}}])['result']

//<!--<p><h4>Last update : '.date().'</h4></p>-->
 #find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));
#<div class="container">
#	<div class="col-xs-6">*/



?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

