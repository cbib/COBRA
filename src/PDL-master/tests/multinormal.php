<?php
/**
  Multinormal Distribution - Unit Testing
  @author Michael Bommarito
  @version 03062005
*/

require_once '../MultinormalDistribution.php';

class MultinormalDistributionUnit {
  var $dist; 
  
  function testPDF( $mu = null, $sigma = null, $range = array(0, 1), $delta = 0.1) {
    $this->dist = new MultinormalDistribution($mu, $sigma);
    for($i = $range[0]; $i < $range[1]; $i += $delta )
      echo $i . " -> " . $this->dist->getPDF(array_fill(0, count($mu), $i)) . "<br />";      
  }
}


$m = new MultinormalDistributionUnit();
echo '<b>Method #1: &rho;=0</b><br />';
$m->testPDF(array(0, 0), array(2, 2), array(0, 1));

echo '<b>Method #2: &rho;!=0, |A|>0</b><br />';
$a = new Matrix(array(array(4, 0), array(0, 4)));
$ai = $a->inverse();
$sqadet = sqrt(pow(2*pi(), 2) * $a->det());
$mu = new Matrix(1, 2, 0);
for($i = 0; $i < 1; $i += 0.1) {
  $y = new Matrix(array(array_fill(0, 2, $i)));
  $y->minusEquals($mu);
  $yt = $y->transpose();
  $y = $y->times($ai);
  $y = $y->times($yt);
  $Q = -$y->get(0, 0) / 2;
  echo exp($Q)/$sqadet . '<br />';
}
?>
