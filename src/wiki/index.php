<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

new_cobra_header("../..");
new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Tools","section_tools","../..");


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
                <img class="displayed" id="partner_logo" src="../../images/logo-inra_w186.jpg"/>
            </div>
            <div id="image_container">
                <hr  size=0.5>                           
                <img class="displayed" id="partner_logo" src="../../images/noordsat_w186.jpg" />
            </div>
            <div id="image_container">
                <hr  size=1>
                <img class="displayed" id="partner_logo" src="../../images/jki_w186.gif"  />
            </div>
            <div id="image_container">
                <hr  size=1>
                <img class="displayed" id="partner_logo" src="../../images/ipk.png"  />
            </div>
        </div>
        <div class="col-md-6" >
            <div id="image_container">
                <hr  size=1>
                <img class="displayed" id="partner_logo" src="../../images/cgfb_w186.jpg" height="85"/>
            </div>
            <div id="image_container">
                <hr  size=1>
                <img class="displayed" id="partner_logo" src="../../images/abiopep3_w186.jpg" height="85" />
            </div>
            <div id="image_container">
                <hr  size=1>
                <img class="displayed" id="partner_logo" src="../../images/logo_csic_w186.jpg" />
            </div>

        </div>
    </div>
</div>';

 new_cobra_footer();
