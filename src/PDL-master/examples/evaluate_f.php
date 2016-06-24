<?php
/**
* @package PDL
*
* Demonstrates how to obtain a tail probability.  Also
* a test of what happens when extreme F scores are passed
* into the method. In this case a 0 is returned which 
* makes sense; it means there is effectively a 0 probability
* of obtaining an F score this extreme by chance.
*
* @author Paul Meagher
*/
require_once '../FDistribution.php';

$f_score = 5679.47;
$df1 = 2;
$df2 = 14;

$f = new FDistribution($df1, $df2);
$p = 1 - $f->CDF($f_score);
echo "P(F | df1, df2) = P($f_score | $df1, $df2) = $p";
?>