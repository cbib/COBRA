<?php

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
<!--	<link href="css/demo_table.css" rel="stylesheet" type="text/css" />-->
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
