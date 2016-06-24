<?php 
/** 
* @package PDL 
* @version 1.0
* 
* Script to test ExponentialDistribution methods. 
*/ 
require_once '../ExponentialDistribution.php'; 
require_once 'make_table.php'; 

$exp = new ExponentialDistribution(1); 

$Methods    = array("getMean()","getVariance()","PDF(2)","CDF(3)","ICDF(0.9502)", "RNG(1)"); 
$Output[0] = $exp->getMean(); 
$Output[1] = $exp->getVariance(); 
$Output[2] = $exp->PDF(2); 
$Output[3] = $exp->CDF(3); 
$Output[4] = $exp->ICDF(0.9502); 
$Output[5] = $exp->RNG(1); 
make_table("Exponential Distribution (lambda=1)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.0, 3.5); 
$P_Vals = $exp->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = array(0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.0, 3.5); 
$P_Vals = $exp->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $exp->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from an exponential distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $exp->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?>
