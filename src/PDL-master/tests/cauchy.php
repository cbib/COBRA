<?php 
/** 
* @package PDL 
* 
* Script to test CauchyDistribution methods. 
*/ 
require_once '../CauchyDistribution.php'; 
require_once 'make_table.php'; 

$location = 0.0;
$scale    = 1.0;

$cauchy = new CauchyDistribution($location, $scale); 

$Methods    = array("getLocationParameter()","getScaleParameter()","PDF(.2)","CDF(.50)","RNG(1)"); 
$Output[0] = $cauchy->getLocationParameter(); 
$Output[1] = $cauchy->getScaleParameter(); 
$Output[2] = $cauchy->PDF(.2); 
$Output[3] = $cauchy->CDF(.50); 
$Output[4] = $cauchy->ICDF(0.95); 
$Output[5] = $cauchy->RNG(1); 
make_table("CauchyDistribution($location, $scale)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(0.1, 0.15, 0.2, 0.25, 0.3, 0.35); 
$P_Vals = $cauchy->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = array(0.1, 0.15, 0.2, 0.25, 0.3, 0.35); 
$P_Vals = $cauchy->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $cauchy->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals);

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a Cauchy distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $cauchy->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?>  