<?php 
/**
* @package PDL
* 
* Script to test Gamma Distribution methods 
*
* Comparison of R output to the output of PHP-based Gamma class.
*
* R   > dgamma(2, 10)   => 0.0001909493
* PHP > PDF(2)          => 0.0001909492532439 
*
* R   > pgamma(3, 10)   => 0.001102488
* PHP > CDF(3)          => 0.0011024881301155 
*
* R   > qgamma(.95, 10) => 15.70522
* PHP > ICDF(0.95) => 15.705216422115 
*/ 
require_once '../GammaDistribution.php'; 
require_once 'make_table.php'; 

$g = new GammaDistribution(10); 

$Methods    = array("getShapeParameter()", "PDF(2)","CDF(3)","ICDF(0.95)","RNG(1)"); 
$Output[0] = $g->getShapeParameter(); 
$Output[1] = $g->PDF(2); 
$Output[2] = $g->CDF(3); 
$Output[3] = $g->ICDF(0.95); 
$Output[4] = $g->RNG(1); 
make_table("Gamma Distribution(10)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(1, 5); 
$P_Vals = $g->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = range(1, 5); 
$P_Vals = $g->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $g->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a Fisher F distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $g->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);
?> 
