<?php
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 

/**
* The PoissonDistribution class provides an object for encapsulating 
* Poisson distributions.
*
* @version 1.2
* @author Mark Hale
* @author Paul Meagher 
* @author Thomas Lumley 
*/
class PoissonDistribution extends ProbabilityDistribution {
    
  /**
  * @float event rate
  */  
  var $lambda; 

  function PoissonDistribution($lambda=1) {
    if($lambda <= 0.0) {
      return PEAR::raiseError("Lambda parameter should be positive.");
    }    
    $this->lambda = $lambda;
  }
   
  function getMean() {
    return $this->lambda;
  }
  
  function getVariance() {
    return $this->lambda;
  }
  
  function _getPDF($x) {    
    if ($x < 0.0) {
      return PEAR::raiseError("Input value must be greater than 0.");
    }
    return pow($this->lambda, $x) * exp(-$this->lambda) / $this->getFactorial($x);        
  }

  function _getCDF($x) {
    if ($x < 0.0) {
      return PEAR::raiseError("Input value must be greater than 0.");
    }
    $cdf_val = 0.0;
    for($i=0; $i <= $x; $i++) {
      $cdf_val += $this->PDF($i);
    }
    return $cdf_val;
  }

  function _getICDF($p) {
    if ($this->checkRange($p)) { 
      return PEAR::raiseError("Probabilty value must be between 0.0 and 1.0");
    }
    return round($this->findRoot($p, $this->lambda, 0.0, MAX_FLOAT));
  }
  
  function _getRNG() {
    $temp  =  0;
    $count = -1;
    while($temp <= $this->lambda) {
      $rand_val = mt_rand() / mt_getrandmax();        
      $temp     = $temp - log($rand_val);
      $count++;
    }
    return $count; 
  }

}
?>