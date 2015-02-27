<?php 

class ftp{
    public $conn;

    public function __construct($url){
        $this->conn = ftp_connect($url);
    }
   
    public function __call($func,$a){
        if(strstr($func,'ftp_') !== false && function_exists($func)){
            array_unshift($a,$this->conn);
            return call_user_func_array($func,$a);
        }else{
            // replace with your own error handler.
            die("$func is not a valid FTP function");
        }
    }
}

// Example

function control_post ($value) {

	$return;
	if(isset($value)){
        	$return = $value;
	}else {
        	$return="";
		echo "Missing post value ";
	}
	return $return;
}

function show_array($array){
	echo"<pre>";
		print_r($array);
	echo"</pre>";
}
function make_request_list($cursor){




}

function make_experiment_type_list($cursor){


	/*
	$array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    */
    echo '<label for="species">experiment type</label>';

    echo '<select class="form-control" id="exp_typeID" name="exp_typeID">';
    echo '<option value ="">----Choose type----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            //foreach(array_slice($keys,1) as $key => $value) {
              //      if(is_array($line[$value])){;
                             //   echo '<option value="type">'.show_array($line[$value]).'</option>';        
                   // }
                    //else {
                                echo '<option value="'.$line.'">'.$line.'</option>';
        
                    //}
            //  }
    }
    echo '</select>';
    
}
function make_viruses_list($cursor){


	/*
	$array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    */
    echo '<label for="viruses">viruses</label>';

    echo '<select class="form-control" id="virusID" name="virusID">';
    echo '<option value ="">----Choose type----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            //foreach(array_slice($keys,1) as $key => $value) {
              //      if(is_array($line[$value])){;
                             //   echo '<option value="type">'.show_array($line[$value]).'</option>';        
                   // }
                    //else {
                                echo '<option value="'.$line.'">'.$line.'</option>';
        
                    //}
            //  }
    }
    echo '</select>';
    
}
function make_species_list($cursor){

    
    $array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    echo '<label for="species">Species</label>';

    echo '<select class="form-control" id="speciesID" name="speciesID">';
    echo '<option value ="">----Choose species----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            foreach(array_slice($keys,1) as $key => $value) {
                  if(is_array($line[$value])){;
                                echo '<option value="speciess">'.show_array($line[$value]).'</option>';        
    	            }
        	           else {
                                echo '<option value="'.$line[$value].'">'.$line[$value].'</option>';
        
          	         }
           }
    }
    echo '</select>';
}


function makeDatatableFromAggregate($cursor){

    
    //foreach($cursor as $doc){
    //print_r(count($cursor['result']));
    //print_r($cursor['result']['0']);
    //for ($i = 0; $i < count($cursor['result']); $i++) {
    //	 print_r($cursor['result'][$i]['id']);
    	 
	//}
    //}
    if (count($cursor['result'])==0){
    	echo'No results found';
    
    }
    else{
		echo'<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
		echo'<thead><tr>';
		foreach ( $cursor as $id => $value )
		{
		
			//echo "level 1 key : ".$id."=> value:".$value."<br/";
		
			foreach ( $value as $ids => $values )
			{
			
				//echo "level 2 key : ".$ids."=>value:".$values."<br/>";
				$keys =array();
			
			
				foreach ($values as $idss => $valuess )

				{

					//echo "level 3 key : ".$idss."=>".$valuess."<br/>";
					$keys[] = $idss;
				
				
				}
			
			
			}
		
		}

	
	
		$keys = array_values(array_unique($keys));
	
	
		//recupere le titre
		foreach ($keys as $key => $value) {

				echo "<th>" . $value . "</th>";
			
	
		}
		echo'</tr></thead>';
	
		//fill the table
		echo'<tbody>';
		foreach ( $cursor as $id => $value )
		{
			foreach ( $value as $ids => $values )
			{
				echo "<tr>";
				foreach ($values as $idss => $valuess )
				{
					echo "<td>" . $valuess . "</td>";
				}
				echo "</tr>";
			}   
		}
		echo'</tbody></table>'; 
	}
}


function makeDatatableFromFind($cursor) {

	$array = iterator_to_array($cursor);
	$keys =array();
	
	foreach ($array as $k => $v) {
        	foreach ($v as $a => $b) {
        		$keys[] = $a;
	        }
	}
	$keys = array_values(array_unique($keys));


	echo'<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
	echo'<thead><tr>';
	
	//recupere le titre
	foreach (array_slice($keys,1) as $key => $value) {
			
       		echo "<th>" . $value . "</th>";
	}
	//fin du header de la table
	echo'</tr></thead>';
	
	//Debut du corps de la table
	echo'<tbody>';
	//Parcour de chaque ligne du curseur
	foreach($cursor as $line) {
        	echo "<tr>";
		
		//Slice de l'id Mongo
			#echo $line->count();
	        foreach(array_slice($keys,1) as $key => $value) {
	        	
	        	
	        	#http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=MU60682&searchtype=unigene&organism=melon
	        	
	        	if ($value=='gene'){
	        		if (stristr($line[$value],"MU")) {
						if(is_array($line[$value])){;
					
								echo"<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".show_array($line[$value])."&searchtype=unigene&organism=melon\">".show_array($line[$value])."</a></td>";
							
						}
						else {
								echo"<td><a href=\"http://www.icugi.org/cgi-bin/ICuGI/EST/search.cgi?unigene=".$line[$value]."&searchtype=unigene&organism=melon\">".$line[$value]."</a></td>";

								#echo "<td>".$line[$value]."</td>";
						}
					}
					else{
						if(is_array($line[$value])){;
					
								echo"<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".show_array($line[$value])."\">".show_array($line[$value])."</a></td>";
							
						}
						else {
								echo"<td><a href=\"http://solgenomics.net/search/unigene.pl?unigene_id=".$line[$value]."\">".$line[$value]."</a></td>";

								#echo "<td>".$line[$value]."</td>";
						}
					}
               	}
               	else{
               		if(is_array($line[$value])){;
                	        echo"<td>".show_array($line[$value])."</td>";
	                }
        	        else {
                	        echo "<td>".$line[$value]."</td>";
               		}
               	
               	}
	        }
        	echo "</tr>";
	}
	echo'</tbody></table>';
}



























?>
