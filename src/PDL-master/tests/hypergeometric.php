<?php 
/** 
* @package PDL 
* 
* Script to test HyperGeometricDistribution methods 
*/ 
require_once '../HyperGeometricDistribution.php'; 
require_once 'make_table.php'; 

$m = 10; 
$n = 7; 
$k = 8;

$hyp = new HyperGeometricDistribution($m, $n, $k); 

$output[0] = $hyp->getM(); 
$output[1] = $hyp->getN(); 
$output[2] = $hyp->getK(); 
$output[3] = $hyp->getMean(); 
$output[4] = $hyp->getVariance(); 
$output[5] = $hyp->PDF(1); 
$output[6] = $hyp->CDF(5); 
$output[7] = $hyp->ICDF(0.782); 
$output[8] = $hyp->RNG(1); 

$methods   = array("getM()","getN()","getK()","getMean()","getVariance()","PDF(1)","CDF(5)","CDF(0.782)","RNG(1)"); 
make_table("HyperGeometricDistribution($m, $n, $k)", "Methods", "Output", $methods, $output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X = range(1,6);
$P = $hyp->PDF($X); 
make_table("PDF(X)", "X Vals Input", "P Vals Output", $X, $P); 

// Test CDF function by feeding an array of $X vals and getting 
// a corresponding array of $P vals where each p val corresponds 
// to p(x < $X[$i]) 
$X = range(1,6);
$P = $hyp->CDF($X); 
make_table("CDF(X)", "X Vals Input", "P Vals Output", $X, $P); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X = $hyp->ICDF($P); 
make_table("ICDF(P)", "P Vals Input", "X Vals Output", $P, $X); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from an exponential distribution 
$C = range(1, 8);
$R = $hyp->RNG(8); 
make_table("RNG(8)", "Counter", "Rnd Vals", $C, $R); 
?>   