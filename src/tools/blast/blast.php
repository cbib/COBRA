
<?php
require '../../session/maintenance-session.php';
require '../../functions/html_functions.php';
require '../../functions/php_functions.php';
require '../../functions/mongo_functions.php';
require '../../session/control-session.php';

new_cobra_header("../../..");
new_cobra_body(is_logged($_SESSION['login']),"Tools","section_tools","../../..");

if ((isset($_POST['search'])) && ($_POST['search']!='')){

//if (((isset($_POST['search'])) && ($_POST['search']!='')) && ((isset($_POST['sequence'])) && ($_POST['sequence']!=''))){


    $search_id=control_post(htmlspecialchars($_POST['search']));
    $species=control_post(htmlspecialchars($_POST['species']));
    //error_log('Here is the search id: '.$search_id);

    //$sequence=control_post(htmlspecialchars($_POST['sequence']));
    $db=mongoConnector();

	
    $sequencesCollection = new Mongocollection($db, "sequences");
    $mappingsCollection = new Mongocollection($db, "mappings");
    $full_mappingsCollection = new Mongocollection($db, "full_mappings");

    
    $jobsCollection = new Mongocollection($db, "jobs");

    
    $sequence_metadata=$sequencesCollection->find(array('mapping_file.Transcript ID'=>str_replace("__", ".",$search_id)),array('mapping_file.$'=>1));
    $uid=substr(str_shuffle(MD5(microtime())), 0, 20);
    foreach ($sequence_metadata as $data) {
        foreach ($data as $key=>$value) {
            
            if ($key==="mapping_file"){
                foreach ($value as $values) {
                    

                    // on place le contenu dans une variable. (exemple hein ^^)

                    $contenu = '>'.str_replace("__", ".",$search_id)."\n";
                    $contenu .= $values['Transcript Sequence'];

                    // on ouvre le fichier en écriture avec l'option a
                    // il place aussi le pointeur en fin de fichier (il tentera de créer aussi le fichier si non existant)
                    $h = fopen('/data/applications/ncbi-blast-2.2.31+/tmp/'.$uid.'.fasta', "a");
                    fwrite($h, $contenu);
                    fclose($h);
                }
            }
        }
    }
    //it works below
    //$output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/test.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/blast_results4.txt -outfmt 13');
    
    //error_log($uid) ;
    
    //$output = shell_exec('/data/applications/ncbi-blast-2.2.31+/bin/blastx -query /data/applications/ncbi-blast-2.2.31+/tmp/'.$uid.'_'.$search_id.'.fasta -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out /data/applications/ncbi-blast-2.2.31+/tmp/'.$uid.'_blast_results.txt -outfmt 13');
    
    //BLAST REQUEST WITH JSON OUTPUT
    //$mode="json";
    $mode="html";
    $data=run_blast($uid,$mode);
    error_log($data);
    
//    $query_file="/data/applications/ncbi-blast-2.2.31+/tmp/$uid.fasta";
//    $result_file = "/data/applications/ncbi-blast-2.2.31+/tmp/$uid.txt";
//    $output = shell_exec("/data/applications/ncbi-blast-2.2.31+/bin/blastx -query $query_file -db /data/applications/ncbi-blast-2.2.31+/db/cobra_blast_proteome_db -out $result_file -outfmt 13");
//    date_default_timezone_set("Europe/Paris");
//    $json = json_decode(file_get_contents($result_file.'_1.json'), true);
    
    
    
    
    //Here add code to populate jobs Mongo collection,
    date_default_timezone_set("Europe/Paris");
    $today = date("F j, Y, g:i a");
    $document = array("job_owner_firstname" => $_SESSION['lastname'],
                      "job_owner_lastname" => $_SESSION['firstname'],
                      "date" => $today,
                      "query_id"=> str_replace("__", ".",$search_id),
                      "job_data" => $data
                     );
    $jobsCollection->insert($document);
    
    $dom = new DOMDocument;
    $dom->loadHTML($data);
    //$targets = $dom->getElementsByTagName('a');
    # Iterate over all the <a> tags
    foreach($dom->getElementsByTagName('a') as $link) {
        # Show the <a href>
        error_log($link->getAttribute('name'));
    }
    
    
    
    $hits=$data['BlastOutput2']['report']['results']['search']['hits'];
    $max_hits=0;
    if (count($hits)>0){
        
        
        
        echo '<table id="blast_results" class="table table-hover dataTable no-footer"><thead><tr><th>Gene ID</th><th>Name</th></tr></thead><tbody>';
        foreach ($hits as $result) {
            foreach ($result['description'] as $value) {

                //error_log('Here is the transcript id: '.$value['title']);
                $id_list= explode("|", $value['title']);
                $gene=$id_list[0];
                $transcript=$id_list[1];
                
                    
                if ($max_hits<10){
                    echo '<tr>';
                    //error_log('Search for transcript id: '.$transcript);
                    
                    $cursor=$full_mappingsCollection->aggregate(array( 
                        array('$project' => array('mapping_file'=>1,'_id'=>0)),
                        array('$unwind'=>'$mapping_file'),
                        array('$match' => array('mapping_file.Transcript ID'=>$transcript)),
                        array('$project' => array("mapping_file"=>1,'_id'=>0))
                    ));
                    //echo '<td>'.$transcript.'</td>';
                    echo '<td> <a href="./Multi-results.php?organism=All+species&search='.$gene.'">'.$transcript.'</a></td>';// </li><a href="./tools/blast/blast_result.php?id='.$transcript.'"> [View results]</a>';
                    if (count($cursor['result'])>=1){
                        foreach ($cursor['result'] as $result) {
                            //echo '<td>'.$result['mapping_file']['Gene ID'].'</td>';
                            echo '<td>'.$result['mapping_file']['Description'].'</td>';

                        }
                    }
                    else{
                        echo '<td>NA</td>';
                    }
                   
                    echo '</tr>';
                }
                $max_hits++;
            }
        }
        echo '</tbody></table>';
    }
    else{
        echo '<p id="paragraph"> Results: No hits found </br></p>';  
    }
}
new_cobra_footer();	

