<?php
/**
* @package PDL
* @path examples/sales_performance.php
* 
* Script to model and evaluate sales performance. 
*
* @author Paul Meagher
* @see http://www.phpmath.com/article/37?art_id=12
*/ 
require_once '../PoissonDistribution.php'; 
require_once 'make_table.php'; 

// adjust as desired
$lambda1 = 1/2;  // GREAT rate: 1 car sold every 2 days
$lambda2 = 1/4;  // GOOD rate: 1 car sold every 4 days
$lambda3 = 1/8;  // POOR rate: 1 car sold every 8 days

// adjust as desired
$days = 24;      // Number of observation days  

// adjust as desired
$X = range(5,15);

// display likelihood distribution using $lambda1 estimate
$pois1 = new PoissonDistribution($lambda1 * $days);
$L     = $pois1->PDF($X);
make_table("Great Salesperson: pois($lambda1)", "X Input", "L Output", $X, $L); 

// display likelihood distribution using $lambda2 estimate
$pois2 = new PoissonDistribution($lambda2 * $days);
$L     = $pois2->PDF($X);
make_table("Good Salesperson: pois($lambda2)", "X Input", "L Output", $X, $L); 

// display likelihood distribution using $lambda3 estimate
$pois3 = new PoissonDistribution($lambda3 * $days);
$L     = $pois3->PDF($X);
make_table("Poor Salesperson: pois($lambda3)", "X Input", "L Output", $X, $L); 

// form left column of evidence table
$L_COL[0] = "GREAT = L(X=10; &lambda;=$lambda1*$days=".($lambda1*$days).")";
$L_COL[1] = "GOOD = L(X=10; &lambda;=$lambda2*$days=".($lambda2*$days).")";
$L_COL[2] = "POOR = L(X=10; &lambda;=$lambda3*$days=".($lambda3*$days).")";

// form right column of evidence table
$R_COL[0] = $pois1->PDF(10);
$R_COL[1] = $pois2->PDF(10);
$R_COL[2] = $pois3->PDF(10);

// display the evidence table
make_table("Evidence Table", "Hypotheses", "Evidence", $L_COL, $R_COL, $width=500); 
?>