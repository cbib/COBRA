<?php 
/** 
* @package PDL 
* 
* Script to test BinomialDistribution methods 
*/ 
require_once '../BinomialDistribution.php'; 
require_once 'make_table.php'; 

$trials = 20; 
$p = .20; 

$bin = new BinomialDistribution($trials, $p); 
$Output[0] = $bin->getMean(); 
$Output[1] = $bin->getVariance(); 
$Output[2] = $bin->PDF(2); 
$Output[3] = $bin->CDF(2); 
$Output[4] = $bin->ICDF(0.95); 
$Output[5] = $bin->RNG(1); 
$Methods    = array("getMean()","getVariance()","PDF(2)","CDF(2)","ICDF(0.95)", "RNG(1)"); 
make_table("BinomialDistribution($trials, $p)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(1, 2, 3, 4, 5, 6); 
$P_Vals = $bin->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(X < $X_Vals[$i]) 
$X_Vals = array(1, 2, 3, 4, 5, 6); 
$P_Vals = $bin->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $bin->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from an exponential distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $bin->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?>   
