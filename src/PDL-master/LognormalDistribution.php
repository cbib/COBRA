<?php
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'NormalDistribution.php'; 

/**
* The LognormalDistribution class provides an object for encapsulating 
* lognormal distributions.
*
* @version 0.2
* @author Mark Hale
* @author Paul Meagher
*/
class LognormalDistribution extends ProbabilityDistribution {

  /**
  * @object holds the normal distribution object
  */
  var $normal;
  
  /**
  * Constructs a lognormal distribution.
  *
  * @param mu the mu parameter.
  * @param sigma the sigma parameter.
  */
  function LognormalDistribution($mu=0.0,$sigma=1.0) {
    $this->normal = new NormalDistribution($mu, $sigma * $sigma);
  }
  
  /**
  * Returns the mu parameter.
  */
  function getMuParameter() {
    return $this->normal->getMean();
  }
  
  /**
  * Returns the sigma parameter.
  */
  function getSigmaParameter() {
    return sqrt($this->normal->getVariance());
  }

  /**
  * Private method to obtain single PDF value.
  *
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return $this->normal->PDF(log($x))/$x;
  }
  
  /**
  * Private method to obtain single CDF value.
  *
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return $this->normal->CDF(log($x));
  }
  
  /**
  * Private method to obtain single inverse CDF value.
  *
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    return exp($this->normal->ICDF($p));
  }

  
  /**
  * Private method to obtain single random deviate.
  *
  * @return single normal deviate
  */
  function _getRNG() {
     return exp($this->normal->RNG());
  }
  
}
?>
