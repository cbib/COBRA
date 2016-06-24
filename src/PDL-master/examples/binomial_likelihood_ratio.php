<?php 
/** 
* @package PDL 
* @path examples/binomial_likelihood_ratio.php
*
* Implements binomial likelihood ratio test. 
*
* @author Paul Meagher
* @see http://www.phpmath.com/article/37?art_id=12 
*/ 
require_once '../BinomialDistribution.php'; 
require_once 'make_table.php'; 

// Number of trials. 
$n       = 10;

// Parameter estimate representing fair coin. 
$p1      = .5; 

// Parameter estimate representing "success" biased coin.
$p2      = .8;

// Number of "success" events observed in n trials. 
$obs     = 8; 

// Distribution values to be evalued by PDF method.
$X       = range(0, $n);

// Compute and display likelihood distribution for HYP 1: bin(n, p1).
$bin1    = new BinomialDistribution($n, $p1); 
$L1      = $bin1->PDF($X); 
make_table("L = bin1($n, $p1)->PDF[0:$n]", "X Input", "L Output", $X, $L1); 

// Compute and display likelihood distribution for HYP 2: bin(n, p2).
$bin2    = new BinomialDistribution($n, $p2); 
$L2      = $bin2->PDF($X); 
make_table("L = bin2($n, $p2)->PDF[0:$n]", "X Input", "L Output", $X, $L2); 

// Compute and display likelihood ratio for hypothesis 1
$LR_HYP_1 = $bin1->PDF($obs)/$bin2->PDF($obs);
echo "<p>Evidence for HYPOTHESIS 1: $LR_HYP_1</p>";

// Compute and display likelihood ratio for hypothesis 2
$LR_HYP_2 = $bin2->PDF($obs)/$bin1->PDF($obs);
echo "<p>Evidence for HYPOTHESIS 2: $LR_HYP_2</p>"; 
?>   