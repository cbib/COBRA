<?php 
/** 
* @package PDL 
* 
* Script to test LognormalDistribution methods.
* 
* Comparison of lnorm output to LognormalDistribution(0, 1) output.
*
* R>   dlnorm(.2, 0, 1)  => 0.5462679
* PHP> PDF(.2)           => 0.54626787075818 
*
* R>   plnorm(.5, 0, 1)  => 0.2441086
* PHP> CDF(.5)           => 0.24410859578558
*
* R>   qlnorm(.95, 0, 1) => 5.180252
* PHP> ICDF(0.95)        => 5.180251602233
*/ 
require_once '../LognormalDistribution.php'; 
require_once 'make_table.php'; 

$mu     = 0.0;
$sigma  = 1.0;

$lognormal = new LognormalDistribution($mu, $sigma); 

$Methods    = array("getMuParameter()","getSigmaParameter()","PDF(.2)","CDF(.50)","ICDF(0.95)"); 
$Output[0] = $lognormal->getMuParameter(); 
$Output[1] = $lognormal->getSigmaParameter(); 
$Output[2] = $lognormal->PDF(.2); 
$Output[3] = $lognormal->CDF(.50); 
$Output[4] = $lognormal->ICDF(0.95); 
make_table("LognormalDistribution($mu, $sigma)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(0.1, 0.15, 0.2, 0.25, 0.3, 0.35); 
$P_Vals = $lognormal->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = array(0.1, 0.15, 0.2, 0.25, 0.3, 0.35); 
$P_Vals = $lognormal->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $lognormal->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals);

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a lognormal distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $lognormal->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals); 
?>  