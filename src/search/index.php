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
                and evaluates the durability of the resistance conferred 
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
  
    echo'<div id="stats_section">
                    <br/>
                    <div class="panel-group" id="accordion_documents">
                        <div class="panel panel-default">
                            <div class="panel-heading" onclick="load_statistics(this)" >

                                    <a class="accordion-toggle collapsed" href="#stat-table" data-parent="#accordion_documents" data-toggle="collapse">
                                            <strong>Some statistics</strong>
                                    </a>				

                            </div>
                            <center>
                                <div class="statloading" style="display: none"></div>
                            </center>
                            <div class="panel-body panel-collapse collapse" id="stat-table">';

        
        
        
        
                                        echo'<div class="stat_area"> 

                                            <!--here comes the statistics  accordion div-->
                                        </div>';
                        echo'
                            </div>

                        </div>
                    </div>
                    <div class="shift_line"></div>
          </div>
        ';

        

    echo'<br/>';

    echo '</main>';
    new_cobra_footer();






?>
<script type="text/javascript" class="init">
    
    
//Variables
var stats_already_open="false";


function load_statistics(){

    
 
    
    
    if (stats_already_open==="true"){
       //alert("already open");
       //open="false";
    }
    else{
        $.ajax({

            url : '../functions/statistics_page.php', // La ressource ciblée

            type : 'POST' ,// Le type de la requête HTTP.

            //data : 'search=' + genes + '&sequence=' + clicked_sequence,
            data : 'plaza_id=blabla', 


            method: 'post',
            cache: false,
            async: true,
            dataType: "html",
            beforeSend: function() { 
                    //  alert("start");
                    $(".stat_area").hide();
                    $('.statloading').html("<img src='../../images/ajax-loader.gif' />");

                    $(".statloading").show();
                },

            success: function (data) {

                var jqObj = jQuery(data);

                var par;

                if(jqObj.find(".stats-panel").length){
                   par=jqObj.find(".stats-panel"); 
                }
                else{
                   par=jqObj.find(".no_results");
                   
                }
                
                $(".stat_area").empty().append(par);

            },
            complete:function(){  
                //   alert("stop");
                $(".statloading").fadeOut("slow");
                $(".stat_area").show("slow");
            }



        });
        stats_already_open="true";
    }
}  
</script>
