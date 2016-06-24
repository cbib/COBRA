<?php
/**
* @package PDL
*/
require_once "ProbabilityDistribution.php";
/**
* Encapsulates the Gumbel Type 1 distribution.
*/
class GumbelDistribution extends ProbabilityDistribution {
  
  var $mu;  
  var $sigma;

  /**
  * @param  $mu     double  location parameter 
  * @param  $sigma  double  scale parameter
  */
  function GumbelDistribution($mu, $sigma) {
    $this->mu    = $mu;
    $this->sigma = $sigma;
  }    
  
  function _getPDF($x) {
    $z = ($x-$this->mu)/$this->sigma;
    return (1/$this->sigma) * exp(-$z) * exp(-exp(-$z));
  }
  
  /**
  * Returns a maximal Gumbel (Type I EVD) random deviate
  * @see http://www.ee.ucl.ac.uk/~mflanaga/java/PsRandom.java
  */
  function _getRNG() {
    $u = mt_rand() / mt_getmaxrand();
    return $this->mu - log(log(1.0/(1.0-$u))) * $this->sigma;
  }

}
?>