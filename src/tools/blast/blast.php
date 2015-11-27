
<?php
require '/var/www/html/COBRA/src/session/maintenance-session.php';
require '/var/www/html/COBRA/src/functions/html_functions.php';
require '/var/www/html/COBRA/src/functions/php_functions.php';
require '/var/www/html/COBRA/src/functions/mongo_functions.php';
require '/var/www/html/COBRA/src/session/control-session.php';

new_cobra_header();
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_tools");

if ((isset($_POST['search'])) && ($_POST['search']!='')){

//if (((isset($_POST['search'])) && ($_POST['search']!='')) && ((isset($_POST['sequence'])) && ($_POST['sequence']!=''))){


	$search_id=control_post(htmlspecialchars($_POST['search']));
    $species=control_post(htmlspecialchars($_POST['species']));
    //error_log('Here is the search id: '.$search_id);

    //$sequence=control_post(htmlspecialchars($_POST['sequence']));
    $db=mongoConnector();

	
    $sequencesCollection = new Mongocollection($db, "sequences");
    $mappingsCollection = new Mongocollection($db, "mappings");

    
    $jobsCollection = new Mongocollection($db, "jobs");

    
    $sequence_metadata=$sequencesCollection->find(array('mapping_file.Transcript ID'=>str_replace("__", ".",$search_id)),array('mapping_file.$'=>1));
    foreach ($sequence_metadata as $data) {
        foreach ($data as $key=>$value) {
            
            if ($key==="mapping_file"){
                foreach ($value as $values) {
                    

                    // on place le contenu dans une variable. (exemple hein ^^)

                    $contenu = '>'.str_replace("__", ".",$search_id)."\n";
                    $contenu .= $values['Transcript Sequence'];

                    // on ouvre le fichier en écriture avec l'option a
                    // il place aussi le pointeur en fin de fichier (il tentera de créer aussi le fichier si non existant)
                    $h = fopen('/data/applications/ncbi-blast-2.2.31+/tmp/tmp_'.$search_id.'.fasta', "a");
                    fwrite($h, $contenu);
                    fclose($h);
                }
            }
        }
    }
    //it works below
    //$output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt -outfmt 13');

    $output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/tmp_'.$search_id.'.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt -outfmt 13');
    $file = "/data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt_1.json";

    $json = json_decode(file_get_contents($file), true);
    
    //Here add code to populate jobs Mongo collection,
    $today = date("F j, Y, g:i a");
    $document = array("job_owner_firstname" => $_SESSION['lastname'],
                      "job_owner_lastname" => $_SESSION['firstname'],
                      "date" => $today,
                      "job_data" => $json
                     );
    $jobsCollection->insert($document);
    
    
    
    $hits=$json['BlastOutput2']['report']['results']['search']['hits'];
    
    $max_hits=0;
    if (count($hits)>0){
        echo '<div id="blast_results">results: </br><ul>';
        foreach ($hits as $result) {
            foreach ($result['description'] as $value) {

                //error_log('Here is the transcript id: '.$value['title']);
                $id_list= explode("|", $value['title']);
                $gene=$id_list[0];
                $transcript=$id_list[1];
                
                    
                if ($max_hits<10){
                    error_log('Search for transcript id: '.$transcript);
                    $species_id=$mappingsCollection->find(array('mapping_file.Transcript ID'=>$transcript, 'type'=>'full_table'),array('species'=>1));
                    if (count($species_id)!==0){
                        foreach ($species_id as $value) {
                           $species=$value['species']; 
                           error_log($species.' for transcript id: '.$transcript);
                        }
                    }
                    else{
                        $species="All+species";
                    }
                    echo '<li> <a href="https://services.cbib.u-bordeaux2.fr/cobra/src/result_search_5.php?organism='.str_replace(" ", "+", $species).'&search='.$gene.'">'.$transcript.'</a></li>';
                }
                $max_hits++;
            }
        }
        echo '</ul></div>';
    }
    else{
        echo '<p id="paragraph"> Results: No hits found </br></p>';  
    }
    unlink('/data/applications/ncbi-blast-2.2.31+/tmp/tmp_'.$search_id.'.fasta');

    
}
//echo '<p id="paragraph"> Here is the search id: '.$search_id.' </br> and the sequence: '.$sequence.'</p>';

//error_log('Here is the search id: '.$search_id.' and the sequence: '.$sequence);




//$cmd_string = $database." ".$blast_program." ".$sequence_file." 
//".$blast_output." ".$job_name." ".$cfgBlastDbDir." ".$output_format. " 
//".$options;
//
//$cmd = '/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results2.txt -outfmt 13';// .$cmd_string;









//$output=  shell_exec('ls /data/applications/ncbi-blast-2.2.31+/tmp/');
//error_log($output);



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