<?php
/**
* @package PDL
*/
require("jama/Matrix.php");


/**
* The MultinormalDistribution class provides an object for encapsulating
* multivariate normal distributions.
*
* @version 03062005
* @author Michael Bommarito
*/
class MultinormalDistribution {
  var $n = 0;
  var $mu;
  var $sigma;
  var $rho;
  
  function MultinormalDistribution( $mu = array(0), $sigma = array(1) ) {
    if (count($mu) > 0 && count($mu)==count($sigma)) {
      $this->n = count($mu);
      $this->mu = array_values($mu);
      $this->sigma = array_values($sigma);
    } else
      die("The mean and deviation vectors are not of the same dimension.");
  }
  
  //When each variate is MUTUALLY INDEPENDENT, e.g. &rho;=0
  function getPDF( $x = null ) {
    if (count($x)==$this->n) {
      $sqrt2pi = sqrt(2 * pi());
      $r = 1;
      $x = array_values($x);
      for ($i = 0; $i < count($x); $i++)
        $r *= exp( -pow($x[$i] - $this->mu[$i], 2) / ( 2 * pow($this->sigma[$i], 2))) / ($sqrt2pi * $this->sigma[$i]);
      return $r;
    } else
      die("The x-vector is not of the same dimension as the distribution.");
    
  }
  
  /*
  When the variables are (not known) mutually independent, e.g. &rho;!=0
  
  
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
  */
}
?> 
