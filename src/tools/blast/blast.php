
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
$output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt -outfmt 13');
//$output=  shell_exec('ls /data/applications/ncbi-blast-2.2.31+/tmp/');
//error_log($output);


$file = "/data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt_1.json";

$json = json_decode(file_get_contents($file), true);
$hits=$json['BlastOutput2']['report']['results']['search']['hits'];
$max_hits=0;
foreach ($hits as $result) {
    foreach ($result['description'] as $value) {
        
    
        if ($max_hits<10){
            echo '<p id="paragraph">results: </br>  '.$value['title'].'</p>';
        }
        $max_hits++;
    }
}
//
//echo '<p id="paragraph">results: </br>  '.$hits[0]['description'][0]['title'].'</p>';
//
//
//echo '<p id="paragraph">results: </br>  '.$json['BlastOutput2']['report']['results']['search']['query_id'].'</p>';

//$max_hits=0;
//foreach ($hits as $result) {
//    
//    if ($max_hits<10){
//        echo '<p id="paragraph">results: </br>  '.$result['description']['title'].'</p>';
//    }
//    else{
//        break;
//    }
//    $max_hits++;
//}


//here populate jobs collections with




//echo '<p id="paragraph">results: </br>  '.var_dump($json).'</p>';




//$Json_file =fopen("/data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt_1.json", "r");
//while (!feof($Json_file)) {
//
//    $line_of_text = fgets($Json_file);
//    $json = json_decode($line_of_text, true);
//
//    //print $json['key']. "<BR>";
//    echo '<p id="paragraph">results: </br>  '.$json['results'].'</p>';
//
//}
//fclose($handle);



//echo '<p id="paragraph">results: </br>  '.$handle.'</p>';
//$output=  shell_exec('ls /data/applications/ncbi-blast-2.2.31+/tmp/');
//error_log($output);
//./blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results.txt -outfmt 13

        
        
        /*  Execute command */
 


new_cobra_footer();	

?>