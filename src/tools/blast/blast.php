
<?php
require '/var/www/html/COBRA/src/session/maintenance-session.php';
require '/var/www/html/COBRA/src/functions/html_functions.php';
require '/var/www/html/COBRA/src/functions/php_functions.php';
require '/var/www/html/COBRA/src/functions/mongo_functions.php';
require '/var/www/html/COBRA/src/session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_tools");


if ((isset($_POST['search'])) && ($_POST['search']!='')) {


	$search_id=control_post(htmlspecialchars($_POST['search']));
    
}
error_log('here is the search id: '.$search_id);


//$cmd_string = $database." ".$blast_program." ".$sequence_file." 
//".$blast_output." ".$job_name." ".$cfgBlastDbDir." ".$output_format. " 
//".$options;
//
//$cmd = "/data/applications/ncbi/bin/blastx" .$cmd_string;

    /*  Execute command */
 
$output = exec($cmd);

new_cobra_footer();	

?>