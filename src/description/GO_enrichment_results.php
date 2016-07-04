<?php
require '../session/maintenance-session.php';
require '../functions/html_functions.php';
require '../functions/php_functions.php';
require '../functions/mongo_functions.php';
require '../session/control-session.php';

 
new_cobra_header("../..");
new_cobra_body($_SESSION['login'],"job GO enrichment details","section_job_go_details","../..");
if ((isset($_GET['id'])) && ((isset($_GET['id'])))){
    echo "hello";


}
new_cobra_footer();
    
    
    
   