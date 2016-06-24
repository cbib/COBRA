<?php
/**
* @package PDL
* @path examples/chisqr_range_testing.php
*
* Script to test how ChiSqrDistribution handles range of 
* parameter and argument values.  Might want to consider 
* putting this code in loop with say a 100 unit 
* step size to explore outer limit behavior.
*
* @author Paul Meagher
* @see http://www.phpmath.com/home?op=perm&nid=293
*/
require_once '../ChiSqrDistribution.php';
require_once 'make_table.php';

$df = 10000;

$chi = new ChiSqrDistribution($df);

$Methods    = array("getDF()", "PDF($df)", "CDF($df)", "ICDF(0.95)","RNG(1)");
$Output[0] = $chi->getDF();
$Output[1] = $chi->PDF($df);
$Output[2] = $chi->CDF($df);
$Output[3] = $chi->ICDF(0.95);
$Output[4] = $chi->RNG(1);
make_table("ChiSqrDistribution($df)", "Methods", "Output", $Methods, $Output);
?>