<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
function new_cobra_header($path='null'){
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- bootstrap 3.0.2 -->
<link href="'.$path.'/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- font Awesome -->
<link href="'.$path.'/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<!-- Ionicons -->
<link href="'.$path.'/css/ionicons.min.css" rel="stylesheet" type="text/css" />

<!-- Theme style -->
<link href="'.$path.'/css/AdminLTE.css" rel="stylesheet" type="text/css" />

<!-- Datatable style -->
<link rel="stylesheet" type="text/css" href="'.$path.'/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="'.$path.'/js/Buttons-1.0.3/css/buttons.dataTables.css">


<!-- Cobra style -->
<link rel="stylesheet" type="text/css" href="'.$path.'/css/cobra_styles2.css">	

<!-- tab icon style -->
<!-- <link rel="shortcut icon" href="http://www.votresite.com/favicon.ico"> -->

<!-- Include iCheck skin -->
<link rel="stylesheet" href="'.$path.'/css/iCheck/all.css" />

<!-- jQuery 2.0.2 -->
<script src="'.$path.'/js/jquery.min.js"></script>
<script src="'.$path.'/js/jquery.js"></script>

<!-- Bootstrap -->
<script src="'.$path.'/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" src="'.$path.'/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="'.$path.'/js/dataTables.bootstrap.js"></script>

<!--Datatable-->
<script type="text/javascript" src="'.$path.'/js/Buttons-1.0.3/js/dataTables.buttons.js"></script>

<!--Require-->
<script type="text/javascript" src="'.$path.'/js/require.js"></script>

<!--highcharts-->
<script src="'.$path.'/css/Highcharts-4.1.8/js/highcharts.js"></script>
<!--<script src="'.$path.'/css/Highcharts-4.1.8/js/modules/exporting.js"></script>-->
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->



<!-- AdminLTE App -->
<script src="'.$path.'/js/app.js" type="text/javascript"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
<!--[if lt IE 9]>-->
<!--  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> -->
<!--  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> -->
<!--[endif]-->
<title>COBRA</title>

';
include($path."/src/functions/piwik.php");

echo '</head>';
}

function add_accordion_panel($table_string,$panel_title='null',$unique_id='null'){
    
    echo'<div class="panel-group" id="accordion_documents">
                <div class="panel panel-default">
                    <div class="panel-heading">  
                            <a class="accordion-toggle collapsed" href="#'.$unique_id.'" data-parent="#accordion_documents" data-toggle="collapse">
                                '.$panel_title.'
                            </a>				
                    </div>
                    <div class="panel-body panel-collapse collapse" id="'.$unique_id.'">
                        
                            
                           ';
                            echo  $table_string;
                            echo'
                        
                    </div>
                    
                </div>
            </div>    
     <br/>';
    
    
    
    
    
/*   echo'<table id="example3" class="table table-bordered" cellspacing="0" width="100%">';
//    echo'<thead><tr>';
//
//    //recupere le titre
//    #echo "<th>type</th>";
//    echo "<th>Mapping type</th>";
//    echo "<th>src ID</th>";
//    echo "<th>src type</th>";
//    echo "<th>src_version</th>";
//    echo "<th>tgt ID</th>";
//    echo "<th>tgt type</th>";
//    echo "<th>tgt_version</th>";
//    echo "<th>species</th>";
//
//    echo'</tr></thead>';
//
//    //Debut du corps de la table
//    echo'<tbody>';
//    foreach($cursor['result'] as $line) {
//
//        //echo $line['src_to_tgt'];
//        for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//            echo "<tr>";
//
//            echo '<td>'.$line['type'].'</td>';
//
//            echo '<td>'.$line['src_to_tgt'][0].'</td>';
//            echo '<td>'.$line['src'].'</td>';
//            echo '<td>'.$line['src_version'].'</td>';
//
//            //for ($i = 0; $i < count($line['src_to_tgt'][1]); $i++) {
//
//            echo '<td>'.$line['src_to_tgt'][1][$i].'</td>';
//
//
//            //}
//            echo '<td>'.$line['tgt'].'</td>';
//            echo '<td>'.$line['tgt_version'].'</td>';
//            echo '<td>'.$line['species'].'</td>';
//            echo "</tr>";
//        }
//
//    }
//    echo'</tbody></table></div>';
//    
//    echo'<div class="panel-group" id="accordion_documents">
//                <div class="panel panel-default">
//                    <div class="panel-heading">
//                        <h3>
//                            <a class="accordion-toggle collapsed" href="#collapse_documents" data-parent="#accordion_documents" data-toggle="collapse">
//                                Documents and Presentations
//                            </a>				
//                        </h3>
//                    </div>
//                    <div class="panel-body panel-collapse collapse" id="collapse_documents">
//                        
//                        <table class="table table-condensed table-hover table-striped">
//                            <thead>
//                                <tr>
//                                    <th style="width:250px;">Gene Ontology Biological Process</th>
//                                    
//                                </tr>
//                            </thead>
//                            
//                            <tbody>
//                                <tr><td><a target="_blank" href="http://amigo.geneontology.org/amigo/term/'.$go_info[3].'" title="'.$go_info[2].'">'.$go_info[2].'</a>
//             					 		<span class="goEvidence">[<a href="http://www.geneontology.org/GO.evidence.shtml#'.$go_info[4].'" title="Go Evidence Code">'.$go_info[4].'</a>]
//             					 		</span></td></tr>                                
//                            </tbody>
//                            
//                        </table>
//                    </div>
//                    
//                </div>
//            </div>    
//            <br/>';*/
}
function new_cobra_body($IsLogged='null', $type='null',$section_id='null',$path='null'){
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    //<li';if($uri == "/src/wiki"){ echo 'class="active"'; } echo '>
    echo'

    

    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
        	<aside class="left-side sidebar-offcanvas">     
            <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                <!-- Sidebar user panel -->';
    if ($IsLogged){
    
                echo'<a href="'.$path.'/src/search/">
                         <div class="cobra-logo">
                             <img src="'.$path.'/images/cobra-icon.png" alt="COBRA logo" />
                             <p>COBRA</p>
                         </div>
                      </a>

                     <!-- sidebar menu: : style can be found in sidebar.less -->
                     <ul class="sidebar-menu">
                         <li';if($uri == "/" || $uri == "/index.php"){ echo ' class="active"'; } echo '>
                             <a href="'.$path.'/">
                                <i class="fa fa-home"></i> 
                                <span>Home</span>
                             </a>
                         </li>
                         <li';if($uri == "/src/search" || $uri == "/"){ echo ' class="active"'; } echo '>
                             <a href="'.$path.'/src/search/">
                                <i class="fa fa-search"></i> 
                                <span>Search</span>
                             </a>
                         </li>
                         <li>
                             <a href="'.$path.'/src/description/">
                                 <i class="fa fa-leaf"></i> <span>Data</span>
                             </a>
                         </li>
                         <li >
                             <a href="'.$path.'/src/tools/">
                                 <i class="fa fa-cogs"></i> <span>Tools</span>
                             </a>
                         </li>
                         <li >
                             <a href="'.$path.'/src/docs/">
                                <i class="fa fa-upload"></i> <span>Uploads</span>
                             </a>
                         </li>
                     </ul>
                </section>
            <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">     
                <!-- Content Header (Page header) -->
                <section class="content-header">';
            	
            	
                echo '<h1>'.$type.'<small>COBRA a plant virus interaction database</small></h1>';
            	
            	
            	
            	echo '<ol class="breadcrumb">
                        <!--<li><a href="https://services.cbib.u-bordeaux2.fr/cobra/"><i class="fa fa-dashboard"></i> Home</a></li>-->
                        <!--<li><a href="https://services.cbib.u-bordeaux2.fr/cobra/src/description/">description</a></li>-->
                        <!--<li><a href="https://services.cbib.u-bordeaux2.fr/cobra/wiki/">wiki home</a></li>-->
                        <li><a href="'.$path.'/">Home page</a></li>
                        <li><a href="'.$path.'/src/users/user.php?firstname='.$_SESSION['firstname'].'&lastname='.$_SESSION['lastname'].'">'.$_SESSION['firstname'].' '.$_SESSION['lastname'].'</a></li>
                        <li><a href="'.$path.'/login.php?act=logout">Logout</a></li>
                        </ol>';
                
                echo '
                  
               	</section>

                <!-- Main content -->
                <div id="shift_line"></div>
                <section class="container" id="'.$section_id.'">';
    }
    else{
        echo'    <a href="'.$path.'/src/search/">
                <div class="cobra-logo">
                    <img src="'.$path.'/images/cobra-icon.png" alt="COBRA logo" />
                    <p>COBRA</p>
                </div></a>

                <!-- sidebar menu: : style can be found in sidebar.less -->
            	<ul class="sidebar-menu">
                  <li';if($uri == "/login.php"){ echo ' class="active"'; } echo '>
                    <a href="'.$path.'/login.php">
                       <i class="fa fa-home"></i> 
                       <span>Login</span>
                    </a>
               	</li>
                  
               </ul>
            </section>
            <!-- /.sidebar -->
         </aside>

      	<!-- Right side column. Contains the navbar and content of the page -->
 	<aside class="right-side">     
            <!-- Content Header (Page header) -->
            <section class="content-header">';
            	
            	
            echo '<h1>'.$type.'<small>COBRA a plant virus interaction database</small></h1>';
            echo '<ol class="breadcrumb">';
                echo '<li><a href="'.$path.'/login.php">Login</a></li>

                  </ol>
            </section>

            <!-- Main content -->
            <div id="shift_line"></div>
            <section class="container" id="'.$section_id.'">';
    }
                  //$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                //echo $uri;
                  //';if($uri == "/src/wiki"){ echo 'class="active"'; } echo '

}



function new_content_header(){

}
function new_href($link='null'){
	echo '<a href=\"'.$link.'\">'.$link.'</a>';
}
function new_cobra_footer(){
echo'

                    </section>
                    <!--<div class="row">-->
                        
                        <section class="col-md-12" id="footer">
                             <p class="text-muted" style="text-align: left">
                                <br/>
                                Database and website created by the <a href="http://www.cbib.u-bordeaux2.fr/">CBiB</a>
                            </p>
                            <p class="text-muted" style="text-align: right">
                                Original template <a href="http://almsaeedstudio.com/AdminLTE/">AdminLTE Dashboard and Control Panel Template</a> by <a href="http://almsaeedstudio.com">Almaseed Studio</a>
                            </p>
                            
                        </section>
                    <!--</div>-->

                

            </aside>

        </div>

    </body>
</html>

    
    ';

}


function new_input_file(){
	echo '
			<div class="form-group bg-gray" ;style="border: 2px solid grey">
				<label for="exampleInputFile">File input</label>
				<input type="file" id="exampleInputFile">
				<p class="help-block">enter list of Ids.</p>
			</div>';

}
function new_cobra_species_container(){
echo'

	<div class="full_species">
        <div class="static_favourite_species">
        	<h2>Popular species</h2>
        	<div class="species_list_container species-list">
      		<div class="form-field ff-multi">
					<div class=ff-inline ff-right">
      
      			<div class="col-xs-6">
      			<div class="species-box">
        			<a href="Arabidopsis_thaliana/Info/Index">
          				<span class="sp-img"><img src="/images/A_thaliana.jpg" alt="Arabidopsis thaliana" title="Browse Arabidopsis thaliana" height="48" width="48" /></span>
          				<span>Arabidopsis thaliana</span>
         
        			</a>
        			
      			</div>
      			</br>
      			<div class="species-box">
        			<a href="Arabidopsis_thaliana/Info/Index">
          				<span class="sp-img"><img src="/images/barley.jpg" alt="Arabidopsis thaliana" title="Browse Arabidopsis thaliana" height="48" width="48" /></span>
          				<span>Hordeum vulgare</span>
        			</a>
        			
      			</div>
      			</br>
      			<div class="species-box">
        			<a href="Arabidopsis_thaliana/Info/Index">
          				<span class="sp-img"><img src="/images/tomato.jpg" alt="Arabidopsis thaliana" title="Browse Arabidopsis thaliana" height="48" width="48" /></span>
          				<span>Solanum lycopersicum</span>
        			</a>
        			
      			</div>
      			</div>
      			<div class="col-xs-6">
      			</br>
      			<div class="species-box">
        			<a href="Arabidopsis_thaliana/Info/Index">
          				<span class="sp-img"><img src="/images/melon.jpg" alt="Arabidopsis thaliana" title="Browse Arabidopsis thaliana" height="48" width="48" /></span>
          				<span>Cucumis melo</span>
        			</a>
        			
      			</div>
      			</br>
      			<div class="species-box">
        			<a href="Arabidopsis_thaliana/Info/Index">
          				<span class="sp-img"><img src="/images/prunus.jpg" alt="Arabidopsis thaliana" title="Browse Arabidopsis thaliana" height="48" width="48" /></span>
          				<span>Prunus domestica</span>
        			</a>
        			
      			</div>
      			</div>
      			</div>
      		</div>	
      			
    		</div>
    	</div>
    </div>



';
}



















?>
