<?php

function new_cobra_header(){
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>COBRA - Database</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- bootstrap 3.0.2 -->
<link href="../../database/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- font Awesome -->
<link href="../../database/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<!-- Ionicons -->
<link href="../../database/css/ionicons.min.css" rel="stylesheet" type="text/css" />

<!-- Theme style -->
<link href="../../database/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../database/css/dataTables.bootstrap.css">	

<!-- jQuery 2.0.2 -->
<script src="../../database/js/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="../../database/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../../database/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../database/js/dataTables.bootstrap.js"></script>

<!-- AdminLTE App -->
<script src="../../database/js/app.js" type="text/javascript"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
<!--[if lt IE 9]>
<!--  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> -->
<!--  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> -->
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
                            <img src="../../database/images/cobra-icon.png" />
                            <p>COBRA</p>
                        </div>

                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li>
                                <a href="/">
                                    <i class="fa fa-info"></i> <span>About COBRA</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="/database">
                                    <i class="fa fa-search"></i> <span>Query database</span>
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

    <hr />
    <div class="row">
        <!-- Left col -->

        <section class="col-lg-12 connectedSortable">
            <p class="text-muted" style="text-align: right;">
                Original template <a href="http://almsaeedstudio.com/AdminLTE/">AdminLTE Dashboard and Control Panel Template</a> by <a href="http://almsaeedstudio.com">Almaseed Studio</a>
            </p>
            <p class="text-muted" style="text-align: right;">
                Database and website created by the <a href="http://www.cbib.u-bordeaux2.fr/">CBiB</a>
            </p>
        </section><!-- right col -->
    </div><!-- /.row (main row) -->

                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->
        </body>
    </html>

    
    ';

}























?>
