<?php
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 

/**
* The GeometricDistribution class provides an object for encapsulating geometric distributions.
*
* @version 0.3
* @author Mark Hale
* @author Paul Meagher
*/
class GeometricDistribution extends ProbabilityDistribution {

  /**
  * @float stores success probability
  */
  var $success;

  /**
  * @float stores failure probability
  */
  var $failure;

  /**
  * Constructs a geometric distribution.
  *
  * @param prob the probability of success.
  */
  function GeometricDistribution($prob) {
    if($prob<0.0 || $prob>1.0)
      return PEAR::raiseError("The probability should be between 0.0 and 1.0.");
     $this->success = $prob;
     $this->failure = 1.0 - $prob;
  }
  
  /**
  * Returns the success parameter.
  */
  function getSuccessParameter() {
    return $this->success;
  }
  
  /**
  * Returns the mean.
  */
  function getMean() {
    return 1.0/$this->success;
  }
  
  /**
  * Returns the variance.
  */
  function getVariance() {
    return $this->failure/($this->success*$this->success);
  }
  
  /**
  * Probability density function of a geometric distribution.
  * P(X) = p (1-p)<sup>X-1</sup>.
  * @param X should be integer-valued.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return $this->success*pow($this->failure,$x-1);
  }
  
  /**
  * Cumulative geometric distribution function.
  * @param X should be integer-valued.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return 1.0-pow($this->failure,$x);
  }
  
  /**
  * Inverse of the cumulative geometric distribution function.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    return log(1.0-$p)/log($this->failure);
  }

  /**
  * Private method implementing RNG for geometeric distribution.
  * @returns a geometric distributed non-negative integer.
  */
  function _getRNG() {
    $uni_rand = mt_rand() / mt_getrandmax();
    $exp_rand = -log(1.0 - $uni_rand);
    $lambda   = $exp_rand * ((1 - $this->success) / $this->success);    
    $temp     =  0;
    $count    = -1;
    while($temp <= $lambda) {
      $uni_rand = mt_rand() / mt_getrandmax();        
      $temp     = $temp - log($uni_rand);
      $count++;
    }
    return $count; 
  }    
  
}
?>