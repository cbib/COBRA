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































?>
