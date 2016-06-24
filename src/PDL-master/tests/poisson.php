<?php
/**
* @package PDL
* 
* Script to test PoissonDistribution methods 
*/ 
require_once '../PoissonDistribution.php'; 
require_once 'make_table.php'; 

$pois = new PoissonDistribution(1.2);

$Methods    = array("getMean()","getVariance()","PDF(2)","CDF(3)","ICDF(0.9662)", "RNG(1)");
$Output[0] = $pois->getMean();
$Output[1] = $pois->getVariance();
$Output[2] = $pois->PDF(2);
$Output[3] = $pois->CDF(3);
$Output[4] = $pois->ICDF(0.9662);
$Output[5] = $pois->RNG(1);
make_table("PoissonDistribution(1.2)", "Methods", "Output", $Methods, $Output);

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(0, 1, 2, 3, 4, 5); 
$P_Vals = $pois->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = array(0, 1, 2, 3, 4, 5); 
$P_Vals = $pois->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $pois->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

$Index     = range(0, 7);
$Rnd_Vals  = $pois->RNG(8);
make_table("RNG(N)", "Index", "Rnd Vals", $Index, $Rnd_Vals);
?>
