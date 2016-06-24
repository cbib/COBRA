<?php 
/** 
* @package PDL 
* @version 1.0
* 
* Script to test WeibullDistribution methods. 
* 
* Comparison of R output (www.r-project.org) to output of PHP-based 
* Weibull class instantiated with shape=0.4.
* 
* R   > dweibull(.2, .4)  => 0.6213048
* PHP > PDF(.2)           => 0.6213047695011 
* 
* R   > pweibull(.5, .4)  => 0.5313309
* PHP > CDF(.5)           => 0.53133089062485  
* 
* R   > qweibull(.95, .4) => 15.53308
* PHP > ICDF(0.95)        => 15.533077011354 
*
* Todo: Would eventually like to add unit testing.
*/ 
require_once '../WeibullDistribution.php'; 
require_once 'make_table.php'; 

$shape = 0.4;

$weibull = new WeibullDistribution($shape); 

$Methods  = array("getMean()","getVariance()","PDF(.2)","CDF(.50)","ICDF(0.95)", "RNG()"); 
$Output[0] = $weibull->getMean(); 
$Output[1] = $weibull->getVariance(); 
$Output[2] = $weibull->PDF(.2); 
$Output[3] = $weibull->CDF(.50); 
$Output[4] = $weibull->ICDF(0.95); 
$Output[5] = $weibull->RNG(); 
make_table("WeibullDistribution($shape)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $X_Vals and 
// getting a corresponding array of $P_Vals. 
$X_Vals = range(1, 5); 
$P_Vals = $weibull->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $X_Vals and getting 
// a corresponding array of $P_Vals where each P_Val corresponds 
// to p(x < $X_Vals[$i]) 
$X_Vals = range(1, 5); 
$P_Vals = $weibull->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test inverseCDF function by feeding in $P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $weibull->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals); 

// Test of Weibull random number generator.  
$n = 8;
$Index    = range(0, $n-1);
$Rnd_Vals = $weibull->RNG($n);
make_table("RNG(8)", "Index", "Rnd Vals", $Index, $Rnd_Vals);
?>  
