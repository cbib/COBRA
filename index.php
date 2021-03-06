<?php
//error_log("entering index.php ");
require('./src/functions/html_functions.php');
require('./src/functions/php_functions.php');
require('./src/functions/mongo_functions.php');
require('./src/session/control-session.php');

date_default_timezone_set('Europe/Paris');


$_SESSION['maintenance'] = "no"; 
require('src/session/maintenance-session.php');



//define('CONTENT_EXT', '.md');


new_cobra_header(".");
new_cobra_body(is_logged($_SESSION['login']), "Home","section_home",".");
$db=mongoConnector();
$grid = $db->getGridFS();
$speciesCollection = new Mongocollection($db, "species");
$samplesCollection = new MongoCollection($db, "samples");
$full_mappingsCollection = new Mongocollection($db, "full_mappings");
$mappingsCollection = new Mongocollection($db, "mappings");
$measurementsCollection = new Mongocollection($db, "measurements");
$virusesCollection = new Mongocollection($db, "viruses");
$interactionsCollection = new Mongocollection($db, "interactions");
$sequencesCollection = new Mongocollection($db, "sequences");
$orthologsCollection = new Mongocollection($db, "orthologs");
$GOCollection = new Mongocollection($db, "gene_ontology");

    echo '<div class="col-md-12" >		
        <div class="col-md-6" >
                <div class="column-padding no-right-margin">
                        <div class="plain-box"><h2 id="features">A <b><font color="green">CO</font></b>mbination of systems <b><font color="green">B</font></b>iology and experimental high-throughput approaches to engineer durable <b><font color="green">R</font></b>esistance against pl<b><font color="green">A</font></b>nt viruses in crops</h2>
                        </div>
                                <p>(PLANT-KBBE) 2013 Projet COBRA</p>
                                <p>COBRA plant virus interaction database is developed in coordination with other plant genomics and bioinformatics groups via the  consortium. The Plant KBBE project is funded by the European Commission within its 7th Framework Programme, under the thematic area.</p>
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
                    <a href="http://www.inra.fr/"><img class="displayed" id="partner_logo" src="./images/logo-inra_w186.jpg"/></a>
                </div>
                <div id="image_container">
                    <hr  size=0.5>     
                    
                    <a href="http://www.nordsaat.de/"><img class="displayed" id="partner_logo" src="./images/noordsat_w186.jpg" /></a>
                </div>
                <div id="image_container">
                    <hr  size=1>
                    
                    <a href="http://www.jki.bund.de/en/startseite/home.html"><img class="displayed" id="partner_logo" src="./images/jki_w186.gif"  /></a>
                </div>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.ipk-gatersleben.de/"><img class="displayed" id="partner_logo" src="./images/ipk.png"  /></a>
                </div>
            </div>
            <div class="col-md-6" >
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cbib.u-bordeaux.fr/en"><img class="displayed" id="partner_logo" src="./images/cgfb_w186.jpg" height="85"/></a>
                </div>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.abiopep.com/"><img class="displayed" id="partner_logo" src="./images/abiopep3_w186.jpg" height="85" /></a>
                </div>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cebas.csic.es/"><img class="displayed" id="partner_logo" src="./images/logo_csic_w186.jpg" height="85" width="165"/></a>
                </div>
                <div id="image_container">
                    <hr  size=1>
                    <a href="http://www.cnb.csic.es/index.php/en/"><img class="displayed" id="partner_logo" src="./images/cnb.jpg" height="85"/></a>
                </div>

            </div>
        </div>
    </div>';


        

            //make_CrossCompare_list(find_species_list($speciesCollection));
            //make_viruses_list(find_viruses_list($virusCollection));



//        $stat_string="";
//        $today = date("F j, Y, g:i a");
//        //$stat_string.='<h4>Last update : '.getlastmod().'</h4>
//
//        $stat_string.='<h4>Last update : '.$today.'</h4>
//                    <h4>Number of samples : '.$samplesCollection->count().'</h4>
//                    <h4>Number of normalized measures : '.$measurementsCollection->count().'</h4>
//
//                    <h4>Number of species : '.$speciesCollection->count().'</h4>';
//
//                    $cursor=$speciesCollection->aggregate(array(
//                    array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
//                    ));
//                    $stat_string.='<h4>Species per top_level</h4>';
//                    foreach ($cursor['result'] as $doc){
//                            $stat_string.='<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
//                    }
//                    $cursor=$virusesCollection->aggregate(array(
//                    array('$group'=>array('_id'=>'$classification.top_level','count'=>array('$sum'=>1)))
//                    ));
//                    $stat_string.='<h4> Pathogens per top_level</h4>';
//                    foreach ($cursor['result'] as $doc){
//                            $stat_string.='<p>a/ '.$doc['_id'].' count: '.$doc['count'].'</p>';
//                    }
//
//
//
//                    
//        echo' 
//        </div>
//        <div class="col-md-6" id="right_col">';
//        add_accordion_panel($stat_string, "Some statistics", "stat_panel");
//
//        echo' </div>';


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






    echo '</main>';




new_cobra_footer(true);


