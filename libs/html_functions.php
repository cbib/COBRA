<?php

function header_datatables(){
echo  '<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>COBRA Main Page</title>

<!-- Bootstrap Core CSS -->
<link href="../css/modern-business.css" rel="stylesheet">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">

<!-- Custom CSS -->

<!--Datatables -->
<script type="text/javascript" language="javascript" src="../js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.bootstrap.js"></script>';
}

function header_datatables2(){
echo'
 <!DOCTYPE html>
 <html>
 <head>
 <meta http-equiv="Content-type" content="text/html; charset=us-ascii">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>COBRA Main Page</title>

 <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
 <style type="text/css" class="init">
 </style>
 <script type="text/javascript" language="javascript" src="../js/jquery-1.11.2.min.js"></script>
 <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
';

}





function header_navbar() {
echo'<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../main.php">COBRA</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="about.html">About</a>
            </li>
            <li>
                <a href="services.html">Libre</a>
            </li>
            <li>
                <a href="contact.html">Contact</a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu Deroulant<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="portfolio-1-col.html">Sous menu 1</a>
                    </li>
                    <li>
                        <a href="portfolio-2-col.html">Sous menu 1</a>
                    </li>
                    <li>
                        <a href="portfolio-3-col.html">Sous menu 1</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>';
}


function header_cobra (){


echo  '<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>COBRA Main Page</title>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">

<!-- Custom CSS -->
<link href="../css/modern-business.css" rel="stylesheet">

<!--Datatables -->
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.bootstrap.js"></script>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="../main.php">COBRA</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav navbar-right">
	    <li>
		<a href="about.html">About</a>
	    </li>
	    <li>
		<a href="services.html">Libre</a>
	    </li>
	    <li>
		<a href="contact.html">Contact</a>
	    </li>
	    <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu Deroulant<b class="caret"></b></a>
		<ul class="dropdown-menu">
		    <li>
			<a href="portfolio-1-col.html">Sous menu 1</a>
		    </li>
		    <li>
			<a href="portfolio-2-col.html">Sous menu 1</a>
		    </li>
		    <li>
			<a href="portfolio-3-col.html">Sous menu 1</a>
		    </li>
		</ul>
	    </li>
	</ul>
    </div>
    <!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>
';
}


function new_cobra_header(){
echo'
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>COBRA Sandbox</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
       
	<!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">	
	<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        
	<!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"></script>

	<!-- AdminLTE App -->
        <script src="js/app.js" type="text/javascript"></script>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
';
}


function new_cobra_body(){
echo'
</head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="cobra-logo">
						<img src="images/cobra-icon.png" />
                        <p>COBRA</p>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="">
                                <i class="fa fa-info"></i> <span>About COBRA</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="">
                                <i class="fa fa-search"></i> <span>Query database</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa fa-folder"></i> <span>Random extra tab</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Query database
                        <small>Random small text</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                        <li class="active">Blank page</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
';
}




function new_cobra_footer(){
echo'
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>
';

}























?>
