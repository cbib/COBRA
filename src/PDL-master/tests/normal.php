<?php 
/**
* @package PDL 
* 
* Script to test NormalDistribution methods. 
* 
* Comparison of norm output to NormalDistribution(10, 2) output.
*
* R>   dnorm(9, 10, 2)   => 0.1760327
* PHP> PDF(9)            => 0.17603266338215 
*
* R>   pnorm(11, 10, 2)  => 0.6914625
* PHP> CDF(11)           => 0.69146246127401
*
* R>   qnorm(.95, 10, 2) => 13.28971
* PHP> ICDF(0.95)        => 13.289707253903
*/ 
require_once '../NormalDistribution.php'; 
require_once 'make_table.php'; 

$norm = new NormalDistribution(10, 2); 

$Methods   = array("getMean()","getStandardDeviation()","getVariance()","PDF(9)","CDF(11)","ICDF(0.95)", "RNG(1)"); 
$Output[0] = $norm->getMean(); 
$Output[1] = $norm->getStandardDeviation(); 
$Output[2] = $norm->getVariance(); 
$Output[3] = $norm->PDF(9); 
$Output[4] = $norm->CDF(11); 
$Output[5] = $norm->ICDF(0.95); 
$Output[6] = $norm->RNG(1); 
make_table("Normal Distribution(10, 2)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(8, 12); 
$P_Vals = $norm->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = range(8, 12); 
$P_Vals = $norm->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test InverseCDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $norm->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a normal distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $norm->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?> 