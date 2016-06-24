<?php 
/** 
* @package PDL 
* 
* Script to test ParetoDistribution methods. 
*/ 
require_once '../ParetoDistribution.php'; 
require_once 'make_table.php'; 

$shape = 3.0;
$scale = 4.0;

$pareto = new ParetoDistribution($shape, $scale); 

$Methods    = array("getShapeParameter()","getScaleParameter()","getMean()","getVariance()","PDF(5)","CDF(5)","ICDF(0.95)","RNG(1)"); 
$Output[0] = $pareto->getShapeParameter(); 
$Output[1] = $pareto->getScaleParameter(); 
$Output[2] = $pareto->getMean(); 
$Output[3] = $pareto->getVariance(); 
$Output[4] = $pareto->PDF(5); 
$Output[5] = $pareto->CDF(5); 
$Output[6] = $pareto->ICDF(0.95); 
$Output[7] = $pareto->RNG(1); 
make_table("ParetoDistribution($shape, $scale)", "Methods", "Output", $Methods, $Output); 

// Test PDF function by feeding an array of $x_vals and 
// getting a corresponding array of $p_vals. 
$X_Vals = array(5, 5.15, 5.2, 5.25, 5.3, 5.35); 
$P_Vals = $pareto->PDF($X_Vals); 
make_table("PDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test CDF function by feeding an array of $x_vals and getting 
// a corresponding array of $p_vals where each p_val corresponds 
// to p(x < $x_vals[$i]) 
$P_Vals = $pareto->CDF($X_Vals); 
make_table("CDF(X_VALS)", "X Vals Input", "P Vals Output", $X_Vals, $P_Vals); 

// Test ICDF function by feeding in P_Vals from previous 
// test. Result should be mirror of CDF output. 
$X_Vals = $pareto->ICDF($P_Vals); 
make_table("ICDF(P_VALS)", "P Vals Input", "X Vals Output", $P_Vals, $X_Vals);

$Counter = range(0, 7); 
$Rnd_Vals = $pareto->RNG(8); 
make_table("RNG(N_VALS)", "Counter", "Rnd Vals", $Counter, $Rnd_Vals);
?>  