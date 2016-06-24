<?php 
/**
* @package ProbabilityDistribution 
* 
* Script to test FDistribution methods 
*/ 
require_once "../FDistribution.php"; 
require_once "make_table.php"; 

$f = new FDistribution(2, 27); 

$Methods    = array("getNumeratorDF", "getDenominatorDF", "PDF(2.05)","CDF(2.05)","ICDF(0.95)","RNG(1)"); 
$Output[0] = $f->getNumeratorDF();
$Output[1] = $f->getDenominatorDF();
$Output[2] = $f->PDF(2.05); 
$Output[3] = $f->CDF(2.05); 
$Output[4] = $f->ICDF(0.95); 
$Output[5] = $f->RNG(1); 
make_table("F Distribution(2, 27)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(1, 5); 
$P_Vals = $f->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = range(1, 5); 
$P_Vals = $f->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $f->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a Fisher F distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $f->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);
?> 