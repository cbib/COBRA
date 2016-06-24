<?php 
/**
* @package ProbabilityDistribution 
* 
* Script to test Triangle distribution methods 
*/ 
require_once "../TriangleDistribution.php"; 
require_once "make_table.php"; 

$a = 0;
$b = 6;
$c = 3;

$tri = new TriangleDistribution($a, $b, $c); 

$Methods    = array("getLowerBound", "getUpperBound", "getMode",
                    "getQuartileMode","getMean","getVariance",
                    "PDF(2)", "CDF(2.75)","ICDF(0.42)","RNG(1)"); 
$Output[0] = $tri->getLowerBound();
$Output[1] = $tri->getUpperBound();
$Output[2] = $tri->getMode(); 
$Output[3] = $tri->getQuartileMode(); 
$Output[4] = $tri->getMean(); 
$Output[5] = $tri->getVariance(); 
$Output[6] = $tri->PDF(2); 
$Output[7] = $tri->CDF(2.75); 
$Output[8] = $tri->ICDF(0.42); 
$Output[9] = $tri->RNG(1); 
make_table("Triangle Distribution($a, $b, $c)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = range(1, 5); 
$P_Vals = $tri->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$X_Vals = array(2.8, 2.9, 3.0, 3.1, 3.2, 3.3); 
$P_Vals = $tri->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $tri->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test RNG function by passing the number of values you want generated. 
// Result is an array of random numbers from a triangle distribution 
$Counter = range(0, 7); 
$Rnd_Vals = $tri->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);
?> 