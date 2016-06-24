<?php 
/** 
* @package PDL 
* @version 1.0
* 
* Script to test UniformDistribution methods. 
*/ 
require_once '../UniformDistribution.php'; 
require_once 'make_table.php'; 

$a = 1;
$b = 8;

$unif = new UniformDistribution($a, $b); 

$Methods    = array("getMean()","getVariance()","PDF(2)","CDF(3)","ICDF(0.2857)", "RNG(1)"); 
$Output[0] = $unif->getMean(); 
$Output[1] = $unif->getVariance(); 
$Output[2] = $unif->PDF(2); 
$Output[3] = $unif->CDF(3); 
$Output[4] = $unif->ICDF(0.2857); 
$Output[5] = $unif->RNG(1); 
make_table("Uniform Distribution (a=$a, b=$b)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(1.0, 1.5, 2.0, 2.5, 3.0, 3.5, 4.0, 4.5); 
$P_Vals = $unif->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$P_Vals = $unif->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $unif->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from an exponential distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $unif->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 

?>
