<?php
//session_start();
require '../session/maintenance-session.php';
include '../functions/html_functions.php';
include '../functions/php_functions.php';
include '../functions/mongo_functions.php';
require('../session/control-session.php');

/*
define('ROOT_PATH', realpath(dirname(__FILE__)) .'/../../');

require ROOT_PATH.'src/functions/html_functions.php';
include ROOT_PATH.'src/functions/php_functions.php';
include ROOT_PATH.'src/functions/mongo_functions.php';
*/

new_cobra_header("../..");


new_cobra_body(isset($_SESSION['login'])? $_SESSION['login']:False,"Datasets and statistics","section_description","../..");




$db=mongoConnector();
$speciesCollection = new Mongocollection($db, "species");
$samplesCollection = new Mongocollection($db, "samples");
$mappingsCollection = new Mongocollection($db, "mappings");
$full_mappingsCollection = new Mongocollection($db, "full_mappings");
$measurementsCollection = new Mongocollection($db, "measurements");
$publicationsCollection = new Mongocollection($db, "publications");
$interactionsCollection = new Mongocollection($db, "interactions");
$virusesCollection = new Mongocollection($db, "viruses");
#find_species_list($speciesCollection);
#$cursor = $speciesCollection->find(array(),array('_id'=>1,'full_name'=>1));



###EXPERIMENT REQUEST

make_species_list(find_species_list($speciesCollection),"../..");
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<div id="data_description">';


//$experiment_cursor=find_all_xp_name($samplesCollection);

//$experiment_cursor2=get_xp_name_by_species($samplesCollection);

$experiment_cursor=find_xp_name_group_by_species($samplesCollection);

echo'<div class="panel-group" id="accordion_documents">
        <div class="panel panel-default">
            <div class="panel-heading">  
                    <a class="accordion-toggle collapsed" href="#Experiments_lists" data-parent="#accordion_documents" data-toggle="collapse">
                        <strong>Experiments</strong>
                    </a>				
            </div>
            <div class="panel-body panel-collapse collapse" id="Experiments_lists">


                   ';
                    foreach ($experiment_cursor['result'] as $value) {
                        foreach ($value['_id'] as $species) {
                            $experiment_table_string="";
                            $experiment_table_string.='<ul>';
                            foreach ($value['xps'] as $xpName) {

                                #echo $xpName;
                                $experiment_table_string.='<li value="'.$xpName['name'].'"><a href="experiments.php?xp='.str_replace(' ','\s',$xpName['name']).'">'.$xpName['name'].'</a> ('.$xpName['type'].')</li>';

                            }
                            $experiment_table_string.='</ul>';
                            add_accordion_panel($experiment_table_string, $species,str_replace(' ','_',$species));
                            echo'<br/>';

                        }
                    }
                    echo'

            </div>

        </div>
    </div>    
<br/>
<br/>';










/*//foreach ($experiment_cursor2['result'] as $doc){
//    #print $doc['specie'];
//        foreach ($doc['_id'] as $specie){
//            #print $specie;
//        }
//        foreach ($doc['names'] as $name){
//            #print $name;
//        }
//               
//}


//$experiment_table_string="";

###DISPLAY EXPERIMENT LIST

//$table_string.='<h1>COBRA Datasets</h1>';
 
//$experiment_table_string.='<ul>';
// //$table_string.='<a href=experiments.php>test</a>';
//foreach($experiment_cursor as $line) {
// 	$title=$line['name'];
//    $species=$line['species'];
// 	//echo str_replace(' ','\s',$title);
//	$experiment_table_string.='<li value='.$title.'><a href=experiments.php?xp='.str_replace(' ','\s',$title).'>'.$title.'</a></li>';
//}
// //makeDatatableFromFind($cursor);
//$experiment_table_string.='</ul>';
//add_accordion_panel($experiment_table_string, "Experiments","Experiments_lists");
//
//echo'<br/>';*/

/*##MAPPING LIST

$table_string.='<h2> Mapping lists</h2> <div class="container"><ul>';
 //$table_string.='<a href=experiments.php>test</a>';
 foreach($cursor as $line) {
	#$table_string.='<li value='.$line['type'].'><a href=mappings.php?type='.$line['type'].'>'.$line['type'].'</a></li>';
	$table_string.='<li value='.$line['type'].'>'.$line['type'].'('.$line['species'].')</a></li>';

}
 //makeDatatableFromFind($cursor);
$table_string.='</div>';
*/

$mapping_table_string="";
###MAPPING REQUEST

$mapping_cursor=find_all_mappings($mappingsCollection);


###MAPPING TABLE

$mapping_table_string.='<table id="mapping" class="table table-hover dataTable no-footer">';
//$table_string.='<table id="mappingtable" class="table table-bordered table-hover" cellspacing="0" width="100%">';
$mapping_table_string.='<thead><tr>';
	
	//recupere le titre
	//$table_string.='<th>type</th>';
	$mapping_table_string.='<th>Source type</th>';
	$mapping_table_string.='<th>Version</th>';
	$mapping_table_string.='<th>Target Type</th>';
	$mapping_table_string.='<th>Version</th>';
	$mapping_table_string.='<th>Organism</th>';

	
	//fin du header de la table
$mapping_table_string.='</tr></thead>';
	
//Debut du corps de la table
$mapping_table_string.='<tbody>';

foreach($mapping_cursor as $line) {
$mapping_table_string.='<tr>';
	//$table_string.='<td>'.$line['type'].'</td>';
	$mapping_table_string.='<td>'.$line['src'].'</td>';
	$mapping_table_string.='<td>'.$line['src_version'].'</td>';
	$mapping_table_string.='<td>'.$line['tgt'].'</td>';
	$mapping_table_string.='<td>'.$line['tgt_version'].'</td>';
	$mapping_table_string.='<td>'.$line['species'].'</td>';
$mapping_table_string.='</tr>';

}
$mapping_table_string.='</tbody></table>';


add_accordion_panel($mapping_table_string, "Mappings", "mapping_table");
echo'<br/>';







$species_table_string="";

###SPECIES REQUEST

$species_cursor=find_all_species($speciesCollection);


###SPECIES TABLE



$species_table_string.='<table id="species" class="table table-hover dataTable no-footer">';
$species_table_string.='<thead><tr>';
	
	//recupere le titre
	$species_table_string.='<th>Full name</th>';
	$species_table_string.='<th>Species</th>';
	$species_table_string.='<th>Aliases</th>';
	$species_table_string.='<th>Top level</th>';
	//$table_string.='<th>tgt</th>';
	//$table_string.='<th>tgt_version</th>';
	//$table_string.='<th>species</th>';

	
	//fin du header de la table
$species_table_string.='</tr></thead>';
	
//Debut du corps de la table
$species_table_string.='<tbody>';

foreach($species_cursor['result'] as $line) {
$species_table_string.='<tr>';
	$species_table_string.='<td>'.$line['full_name'].'</td>';
	$species_table_string.='<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		$species_table_string.='<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				$species_table_string.=$line['aliases'][$i];
			}
			else{
				$species_table_string.=$line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		$species_table_string.='</td>';
		
	}
	else{
		$species_table_string.='<td>'.$line['aliases'].'</td>';
		}
	$species_table_string.='<td>'.$line['top'].'</td>';
	//$table_string.='<td>'.$line['tgt'].'</td>';
	//$table_string.='<td>'.$line['tgt_version'].'</td>';
	//$table_string.='<td>'.$line['species'].'</td>';
$species_table_string.='</tr>';

}
$species_table_string.='</tbody></table>';
add_accordion_panel($species_table_string, "Species", "Species_table");
echo'<br/>';



###VIRUSES TABLE

$virus_table_string="";

$virus_cursor=find_all_viruses($virusesCollection);
$virus_table_string.='<table id="virus" class="table table-hover dataTable no-footer">';

//$table_string.='<table id="virus" class="table table-bordered" cellspacing="0" width="100%">';
$virus_table_string.='<thead><tr>';
	
	//recupere le titre
	$virus_table_string.='<th>full name</th>';
	$virus_table_string.='<th>species</th>';
	$virus_table_string.='<th>Aliases</th>';
	$virus_table_string.='<th>top level</th>';
    $virus_table_string.='<th>Genus</th>';
	//$table_string.='<th>tgt</th>';
	//$table_string.='<th>tgt_version</th>';
	//$table_string.='<th>species</th>';

	
	//fin du header de la table
$virus_table_string.='</tr></thead>';
	
//Debut du corps de la table
$virus_table_string.='<tbody>';

foreach($virus_cursor['result'] as $line) {
$virus_table_string.='<tr>';
	$virus_table_string.='<td>'.$line['full_name'].'</td>';
	$virus_table_string.='<td>'.$line['species'].'</td>';
	if (is_array($line['aliases'])){
		$virus_table_string.='<td>';
		for ($i=0;$i<count($line['aliases']);$i++){
		//foreach ($line['aliases'] as $alias){
			if ($i==count($line['aliases'])-1){
				$virus_table_string.=$line['aliases'][$i];
			}
			else{
				$virus_table_string.=$line['aliases'][$i].', ';
			}
			
			//echo $alias.' ';
		}
		$virus_table_string.='</td>';
		
	}
	else{
		$virus_table_string.='<td>'.$line['aliases'].'</td>';
		}
	$virus_table_string.='<td>'.$line['top'].'</td>';
    $virus_table_string.='<td>'.$line['genus'].'</td>';
	//$table_string.='<td>'.$line['tgt'].'</td>';
	//$table_string.='<td>'.$line['tgt_version'].'</td>';
	//$table_string.='<td>'.$line['species'].'</td>';
$virus_table_string.='</tr>';

}
$virus_table_string.='</tbody></table>';
add_accordion_panel($virus_table_string, "Viruses", "virus_table");
echo'<br/>';



add_ajax_accordion_panel("load_top_scored_genes()","Top-Ranking-Sgenes", "table_Top-Ranking-Sgenes","TopScoredloading","top_score_area");


//echo '<div class="panel-group" id="accordion_documents_Top-Ranking-Sgenes">
//            <div class="panel panel-default">
//                <div class="panel-heading" onclick="load_top_scored_genes()">
//
//                        <a class="accordion-toggle collapsed" href="#table_Top-Ranking-Sgenes" data-parent="#accordion_documents_Top-Ranking-Sgenes" data-toggle="collapse">
//                                <strong>Top Ranking susceptibility genes using COBRA scoring function</strong>
//                        </a>				
//
//                </div>
//                <center>
//                    <div class="TopScoredloading" style="display: none"></div>
//                </center>
//                <div class="panel-body panel-collapse collapse" id="table_Top-Ranking-Sgenes">
//                    <div class="top_score_area"> 
//
//                    <!--here comes the top scored genes table div-->
//                    </div>';
//           echo'</div>
//
//            </div>
//        </div>
//    <div class="shift_line"></div>';

//add_accordion_panel($CG_form_string, "Top Ranking susceptibility genes using COBRA scoring function","Top-Ranking-Sgenes"); 

echo'<br/>';
echo '<table id="example" class="display nowrap" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012/12/02</td>
                <td>$372,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012/08/06</td>
                <td>$137,500</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010/10/14</td>
                <td>$327,900</td>
            </tr>
            <tr>
                <td>Colleen Hurst</td>
                <td>Javascript Developer</td>
                <td>San Francisco</td>
                <td>39</td>
                <td>2009/09/15</td>
                <td>$205,500</td>
            </tr>
            <tr>
                <td>Sonya Frost</td>
                <td>Software Engineer</td>
                <td>Edinburgh</td>
                <td>23</td>
                <td>2008/12/13</td>
                <td>$103,600</td>
            </tr>
            <tr>
                <td>Jena Gaines</td>
                <td>Office Manager</td>
                <td>London</td>
                <td>30</td>
                <td>2008/12/19</td>
                <td>$90,560</td>
            </tr>
            <tr>
                <td>Quinn Flynn</td>
                <td>Support Lead</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2013/03/03</td>
                <td>$342,000</td>
            </tr>
            <tr>
                <td>Charde Marshall</td>
                <td>Regional Director</td>
                <td>San Francisco</td>
                <td>36</td>
                <td>2008/10/16</td>
                <td>$470,600</td>
            </tr>
            <tr>
                <td>Haley Kennedy</td>
                <td>Senior Marketing Designer</td>
                <td>London</td>
                <td>43</td>
                <td>2012/12/18</td>
                <td>$313,500</td>
            </tr>
            <tr>
                <td>Tatyana Fitzpatrick</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>19</td>
                <td>2010/03/17</td>
                <td>$385,750</td>
            </tr>
            <tr>
                <td>Michael Silva</td>
                <td>Marketing Designer</td>
                <td>London</td>
                <td>66</td>
                <td>2012/11/27</td>
                <td>$198,500</td>
            </tr>
            <tr>
                <td>Paul Byrd</td>
                <td>Chief Financial Officer (CFO)</td>
                <td>New York</td>
                <td>64</td>
                <td>2010/06/09</td>
                <td>$725,000</td>
            </tr>
            <tr>
                <td>Gloria Little</td>
                <td>Systems Administrator</td>
                <td>New York</td>
                <td>59</td>
                <td>2009/04/10</td>
                <td>$237,500</td>
            </tr>
            <tr>
                <td>Bradley Greer</td>
                <td>Software Engineer</td>
                <td>London</td>
                <td>41</td>
                <td>2012/10/13</td>
                <td>$132,000</td>
            </tr>
            <tr>
                <td>Dai Rios</td>
                <td>Personnel Lead</td>
                <td>Edinburgh</td>
                <td>35</td>
                <td>2012/09/26</td>
                <td>$217,500</td>
            </tr>
            <tr>
                <td>Jenette Caldwell</td>
                <td>Development Lead</td>
                <td>New York</td>
                <td>30</td>
                <td>2011/09/03</td>
                <td>$345,000</td>
            </tr>
            <tr>
                <td>Yuri Berry</td>
                <td>Chief Marketing Officer (CMO)</td>
                <td>New York</td>
                <td>40</td>
                <td>2009/06/25</td>
                <td>$675,000</td>
            </tr>
            <tr>
                <td>Caesar Vance</td>
                <td>Pre-Sales Support</td>
                <td>New York</td>
                <td>21</td>
                <td>2011/12/12</td>
                <td>$106,450</td>
            </tr>
            <tr>
                <td>Doris Wilder</td>
                <td>Sales Assistant</td>
                <td>Sidney</td>
                <td>23</td>
                <td>2010/09/20</td>
                <td>$85,600</td>
            </tr>
            <tr>
                <td>Angelica Ramos</td>
                <td>Chief Executive Officer (CEO)</td>
                <td>London</td>
                <td>47</td>
                <td>2009/10/09</td>
                <td>$1,200,000</td>
            </tr>
            <tr>
                <td>Gavin Joyce</td>
                <td>Developer</td>
                <td>Edinburgh</td>
                <td>42</td>
                <td>2010/12/22</td>
                <td>$92,575</td>
            </tr>
            <tr>
                <td>Jennifer Chang</td>
                <td>Regional Director</td>
                <td>Singapore</td>
                <td>28</td>
                <td>2010/11/14</td>
                <td>$357,650</td>
            </tr>
            <tr>
                <td>Brenden Wagner</td>
                <td>Software Engineer</td>
                <td>San Francisco</td>
                <td>28</td>
                <td>2011/06/07</td>
                <td>$206,850</td>
            </tr>
            <tr>
                <td>Fiona Green</td>
                <td>Chief Operating Officer (COO)</td>
                <td>San Francisco</td>
                <td>48</td>
                <td>2010/03/11</td>
                <td>$850,000</td>
            </tr>
            <tr>
                <td>Shou Itou</td>
                <td>Regional Marketing</td>
                <td>Tokyo</td>
                <td>20</td>
                <td>2011/08/14</td>
                <td>$163,000</td>
            </tr>
            <tr>
                <td>Michelle House</td>
                <td>Integration Specialist</td>
                <td>Sidney</td>
                <td>37</td>
                <td>2011/06/02</td>
                <td>$95,400</td>
            </tr>
            <tr>
                <td>Suki Burks</td>
                <td>Developer</td>
                <td>London</td>
                <td>53</td>
                <td>2009/10/22</td>
                <td>$114,500</td>
            </tr>
            <tr>
                <td>Prescott Bartlett</td>
                <td>Technical Author</td>
                <td>London</td>
                <td>27</td>
                <td>2011/05/07</td>
                <td>$145,000</td>
            </tr>
            <tr>
                <td>Gavin Cortez</td>
                <td>Team Leader</td>
                <td>San Francisco</td>
                <td>22</td>
                <td>2008/10/26</td>
                <td>$235,500</td>
            </tr>
            <tr>
                <td>Martena Mccray</td>
                <td>Post-Sales support</td>
                <td>Edinburgh</td>
                <td>46</td>
                <td>2011/03/09</td>
                <td>$324,050</td>
            </tr>
            <tr>
                <td>Unity Butler</td>
                <td>Marketing Designer</td>
                <td>San Francisco</td>
                <td>47</td>
                <td>2009/12/09</td>
                <td>$85,675</td>
            </tr>
            <tr>
                <td>Howard Hatfield</td>
                <td>Office Manager</td>
                <td>San Francisco</td>
                <td>51</td>
                <td>2008/12/16</td>
                <td>$164,500</td>
            </tr>
            <tr>
                <td>Hope Fuentes</td>
                <td>Secretary</td>
                <td>San Francisco</td>
                <td>41</td>
                <td>2010/02/12</td>
                <td>$109,850</td>
            </tr>
            <tr>
                <td>Vivian Harrell</td>
                <td>Financial Controller</td>
                <td>San Francisco</td>
                <td>62</td>
                <td>2009/02/14</td>
                <td>$452,500</td>
            </tr>
            <tr>
                <td>Timothy Mooney</td>
                <td>Office Manager</td>
                <td>London</td>
                <td>37</td>
                <td>2008/12/11</td>
                <td>$136,200</td>
            </tr>
            <tr>
                <td>Jackson Bradshaw</td>
                <td>Director</td>
                <td>New York</td>
                <td>65</td>
                <td>2008/09/26</td>
                <td>$645,750</td>
            </tr>
            <tr>
                <td>Olivia Liang</td>
                <td>Support Engineer</td>
                <td>Singapore</td>
                <td>64</td>
                <td>2011/02/03</td>
                <td>$234,500</td>
            </tr>
            <tr>
                <td>Bruno Nash</td>
                <td>Software Engineer</td>
                <td>London</td>
                <td>38</td>
                <td>2011/05/03</td>
                <td>$163,500</td>
            </tr>
            <tr>
                <td>Sakura Yamamoto</td>
                <td>Support Engineer</td>
                <td>Tokyo</td>
                <td>37</td>
                <td>2009/08/19</td>
                <td>$139,575</td>
            </tr>
            <tr>
                <td>Thor Walton</td>
                <td>Developer</td>
                <td>New York</td>
                <td>61</td>
                <td>2013/08/11</td>
                <td>$98,540</td>
            </tr>
            <tr>
                <td>Finn Camacho</td>
                <td>Support Engineer</td>
                <td>San Francisco</td>
                <td>47</td>
                <td>2009/07/07</td>
                <td>$87,500</td>
            </tr>
            <tr>
                <td>Serge Baldwin</td>
                <td>Data Coordinator</td>
                <td>Singapore</td>
                <td>64</td>
                <td>2012/04/09</td>
                <td>$138,575</td>
            </tr>
            <tr>
                <td>Zenaida Frank</td>
                <td>Software Engineer</td>
                <td>New York</td>
                <td>63</td>
                <td>2010/01/04</td>
                <td>$125,250</td>
            </tr>
            <tr>
                <td>Zorita Serrano</td>
                <td>Software Engineer</td>
                <td>San Francisco</td>
                <td>56</td>
                <td>2012/06/01</td>
                <td>$115,000</td>
            </tr>
            <tr>
                <td>Jennifer Acosta</td>
                <td>Junior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>43</td>
                <td>2013/02/01</td>
                <td>$75,650</td>
            </tr>
            <tr>
                <td>Cara Stevens</td>
                <td>Sales Assistant</td>
                <td>New York</td>
                <td>46</td>
                <td>2011/12/06</td>
                <td>$145,600</td>
            </tr>
            <tr>
                <td>Hermione Butler</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>47</td>
                <td>2011/03/21</td>
                <td>$356,250</td>
            </tr>
            <tr>
                <td>Lael Greer</td>
                <td>Systems Administrator</td>
                <td>London</td>
                <td>21</td>
                <td>2009/02/27</td>
                <td>$103,500</td>
            </tr>
            <tr>
                <td>Jonas Alexander</td>
                <td>Developer</td>
                <td>San Francisco</td>
                <td>30</td>
                <td>2010/07/14</td>
                <td>$86,500</td>
            </tr>
            <tr>
                <td>Shad Decker</td>
                <td>Regional Director</td>
                <td>Edinburgh</td>
                <td>51</td>
                <td>2008/11/13</td>
                <td>$183,000</td>
            </tr>
            <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
                <td>2011/06/27</td>
                <td>$183,000</td>
            </tr>
            <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011/01/25</td>
                <td>$112,000</td>
            </tr>
        </tbody>
    </table>';

echo'</div>';





#'type'=>1,'src'=>1,'tgt'=>1,'src_version'=>1,'tgt_version'=>1)
#new_cobra_species_container();


new_cobra_footer();





