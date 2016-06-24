<?php
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 

/**
* The ExponentialDistribution class provides an object for encapsulating 
* exponential distributions.
*
* @version 0.5
* @author Mark Hale
* @author Paul Meagher
*/
class ExponentialDistribution extends ProbabilityDistribution {
  
  /**
  * @float decay rate
  */  
  var $rate; 

  function ExponentialDistribution($decay=1) {
    if($decay < 0.0) 
      return PEAR::raiseError("Decay parameter should be positive.");
    $this->rate = $decay;
  }
   
  function getMean() {
    return $this->rate;
  }
  
  function getVariance() {
    return $this->rate * $this->rate;
  }

  /**
  * Private method to obtain single PDF value.
  * @param $x should be greater than 0  
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */
  function _getPDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    return $this->rate * exp(-$this->rate * $x);
  }
   
  /**
  * Private method to obtain single CDF value.
  * @param $x should be greater than 0    
  * @return the probability that a stochastic variable x is less then X, i.e. P(x<X).
  */
  function _getCDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return 1.0 - exp(-$this->rate * $x);    
  }
  
  /**
  * Private method to obtain single inverse CDF value.
  * @return the value X for which P(x<X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    return -log(1.0 - $p) / $this->rate;    
  }
  
  /**
  * Private method to obtain single RNG value.
  * @return exponential random deviate
  */
  function _getRNG() {  
    $u = mt_rand() / mt_getrandmax();
    return -log($u) / $this->rate;
  }
    
}
?>