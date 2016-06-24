<?php 
/**
* @package PDL
* 
* Script to test TDistribution methods 
*/ 
require_once '../TDistribution.php'; 
require_once 'make_table.php'; 

$t = new TDistribution(10); 

$Methods    = array("getDF()","PDF(2)","CDF(3)","ICDF(0.95)","RNG(1)"); 
$Output[0] = $t->getDF(); 
$Output[1] = $t->PDF(2); 
$Output[2] = $t->CDF(3); 
$Output[3] = $t->ICDF(0.95); 
$Output[4] = $t->RNG(1); 
make_table("T Distribution(10)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(1, 5); 
$P_Vals = $t->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = range(1, 5); 
$P_Vals = $t->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $t->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a student T distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $t->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);
?> 
