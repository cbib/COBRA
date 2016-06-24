<?php 
/** 
* @package PDL 
* 
* Script to test NegativeBinomialDistribution methods 
*/ 
require_once '../NegativeBinomialDistribution.php'; 
require_once 'make_table.php'; 

$n = 5; 
$p = .2; 

$nbin = new NegativeBinomialDistribution($n, $p); 
$Output[0] = $nbin->getMean(); 
$Output[1] = $nbin->getVariance(); 
$Output[2] = $nbin->PDF(15); 
$Output[3] = $nbin->CDF(7); 
$Output[4] = $nbin->ICDF(.072); 
$Output[5] = $nbin->RNG(1); 
$Methods    = array("getMean()","getVariance()","PDF(15)","CDF(7)","ICDF(.072)","RNG(1)"); 
make_table("NegativeBinomialDistribution($n, $p)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(1, 2, 3, 4, 5, 6); 
$P_Vals = $nbin->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(X < $X_Vals[$i]) 
$X_Vals = array(1, 2, 3, 4, 5, 6, 7); 
$P_Vals = $nbin->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $nbin->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from an exponential distribution 
$Counter = range(0, 7);
$Rnd_Vals = $nbin->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?>   
