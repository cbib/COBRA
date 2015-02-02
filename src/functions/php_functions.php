<?php 


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


function makeSpecies_List ($cursor){

    
    $array = iterator_to_array($cursor);
    $keys =array();
    
    foreach ($array as $k => $v) {
            foreach ($v as $a => $b) {
                $keys[] = $a;
            }
    }
    $keys = array_values(array_unique($keys));

    //Debut du corps de la liste
    echo '<select class="form-control" id="species" name="species">';
    echo '<option value ="">----Choose species----</option>';   
    //Parcours de chaque ligne du curseur
    foreach($cursor as $line) {
        //Slice de lid Mongo
            foreach(array_slice($keys,1) as $key => $value) {
                    if(is_array($line[$value])){;
                                echo '<option value="species">'.show_array($line[$value]).'</option>';        
                    }
                    else {
                                echo '<option value="species">'.$line[$value].'</option>';
        
                    }
            }
    }
    echo '</select>';
}


function makeDatatableFromAggregate($cursor){

    
    echo'<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
    echo'<thead><tr>';
    foreach ( $cursor as $id => $value )
    {
        

        foreach ( $value as $ids => $values )
        {
            

            $keys =array();
            
            
            foreach ($values as $idss => $valuess )

            {

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
	        foreach(array_slice($keys,1) as $key => $value) {
        	        if(is_array($line[$value])){;
                	        echo"<td>".show_array($line[$value])."</td>";
	                }
        	        else {
                	        echo "<td>".$line[$value]."</td>";
               		}
	        }
        	echo "</tr>";
	}
	echo'</tbody></table>';
}



























?>
