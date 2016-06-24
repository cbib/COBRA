<?php 
/** 
* @package PDL 
* @path examples/inverse_transform_method.php
* 
* Script to demonstrate how inverse transform method for generating 
* non-uniform random variates works.
*
* @author Paul Meagher
* @see http://www.phpmath.com/home?op=perm&nid=288
*/ 
require_once '../ExponentialDistribution.php'; 
require_once '../UniformDistribution.php'; 

require_once 'make_table.php'; 

$lambda = 1;

echo "<p>&lambda; = $lambda</p>";

$exp    = new ExponentialDistribution($lambda); 

$X = array(0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.0, 3.5); 
$P = $exp->CDF($X); 
echo "<b>Table 1.</b> Exponential cumulative distribution.<br/>";
make_table("CDF(X)", "X Input", "P Output", $X, $P); 

$X = $exp->ICDF($P); 
echo "<b>Table 2.</b> Exponential inverse cumulative distribution.<br/>";
make_table("ICDF(P)", "P Input", "X Output", $P, $X); 

$lo  = 0;
$hi  = 1;
$uni = new UniformDistribution($lo, $hi); 

$N = 8;
$I = range(1, $N);

$U = $uni->RNG($N);
$X = $exp->ICDF($U); 
echo "<b>Table 3.</b> Exponential variates generated using inverse cdf method.<br/>";
make_table("RNG via ICDF(U)", "Counter", "Rnd Vals", $I, $X); 

$X = $exp->RNG($N); 
echo "<b>Table 4.</b> Exponential variates generated using RNG method.<br/>";
make_table("RNG via RNG(N)", "Counter", "Rnd Vals", $I, $X); 

echo "<p><a href='http://www.phpmath.com/PDLDEV/docs/index.php?id=D4#source'>Source of ExponentialDistribution.php</a></p>";
?>
