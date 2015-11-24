
<?php
require '/var/www/html/COBRA/src/session/maintenance-session.php';
require '/var/www/html/COBRA/src/functions/html_functions.php';
require '/var/www/html/COBRA/src/functions/php_functions.php';
require '/var/www/html/COBRA/src/functions/mongo_functions.php';
require '/var/www/html/COBRA/src/session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_tools");

if (((isset($_POST['search'])) && ($_POST['search']!='')) && ((isset($_POST['sequence'])) && ($_POST['sequence']!=''))){


	$search_id=control_post(htmlspecialchars($_POST['search']));
    $sequence=control_post(htmlspecialchars($_POST['sequence']));
    
}
echo '<p id="paragraph"> Here is the search id: '.$search_id.' </br> and the sequence: '.$sequence.'</p>';

error_log("Here is the search id: '.$search_id.' </br> and the sequence: '.$sequence);



//$cmd_string = $database." ".$blast_program." ".$sequence_file." 
//".$blast_output." ".$job_name." ".$cfgBlastDbDir." ".$output_format. " 
//".$options;
//
//$cmd = "/data/applications/ncbi/bin/blastx" .$cmd_string;



//./blastx -query ../tmp/test.fasta -db ../db/cobra_blast_proteome_db -out ../tmp/blast_results.txt -outfmt 13

        
        
        /*  Execute command */
 
//$output = exec($cmd);

new_cobra_footer();	

?>