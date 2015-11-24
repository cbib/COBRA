
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
//echo '<p id="paragraph"> Here is the search id: '.$search_id.' </br> and the sequence: '.$sequence.'</p>';

//error_log('Here is the search id: '.$search_id.' and the sequence: '.$sequence);



//$cmd_string = $database." ".$blast_program." ".$sequence_file." 
//".$blast_output." ".$job_name." ".$cfgBlastDbDir." ".$output_format. " 
//".$options;
//
//$cmd = '/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results2.txt -outfmt 13';// .$cmd_string;
$output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results3.txt -outfmt 13');
//$output=  shell_exec('ls /data/applications/ncbi-blast-2.2.31+/tmp/');
//error_log($output);
$handle =fopen("/data/applications/ncbi-blast-2.2.31+/tmp/blast_results3.txt", "r");
echo '<p id="paragraph">results: </br>  '.$handle.'</p>';
//$output=  shell_exec('ls /data/applications/ncbi-blast-2.2.31+/tmp/');
//error_log($output);
//./blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results.txt -outfmt 13

        
        
        /*  Execute command */
 


new_cobra_footer();	

?>