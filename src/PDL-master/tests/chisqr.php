<?php 
/**
* @package PDL 
* 
* Script to test Chi Square Distribution methods. 
*
* Comparison of chisq output to ChiSqrDistribution(10) output.
*
* R>   dchisq(2, 10) => 0.007664155
* PHP> PDF(2)        => 0.0076641550244051 
*
* R>   pchisq(3, 10) => 0.01857594
* PHP> CDF(3)        => 0.018575936222141 
*
* R>   qchisq(.95, 10)  => 18.30704
* PHP> ICDF(0.95)       => 18.307038053275 
*/ 
require_once '../ChiSqrDistribution.php'; 
require_once 'make_table.php'; 

$chi = new ChiSqrDistribution(10); 

$Methods    = array("getDF()", "PDF(2)", "CDF(3)", "ICDF(0.95)","RNG(1)"); 
$Output[0] = $chi->getDF(); 
$Output[1] = $chi->PDF(2); 
$Output[2] = $chi->CDF(3); 
$Output[3] = $chi->ICDF(0.95); 
$Output[4] = $chi->RNG(1); 
make_table("Chi Distribution(10)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(1, 5); 
$P_Vals = $chi->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = range(1, 5); 
$P_Vals = $chi->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $chi->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a chi square distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $chi->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);

?>