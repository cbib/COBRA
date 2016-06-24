<?php 
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
/** 
* The UniformDistribution class provides an object for encapsulating 
* continuous uniform distributions. 
*
* @version 1.0 
* @author Paul Meagher 
*/ 
class UniformDistribution extends ProbabilityDistribution { 

  /**
  * @int lower bound of uniform distribution
  */
  var $lowerBound; 
  
  /**
  * @float upper bound of uniform distribution
  */  
  var $upperBound; 

  /** 
  * Constructs a uniform distribution. 
  * @param $min the lower bound 
  * @param $max the upper bound 
  */ 
  function UniformDistribution($min, $max) { 
    if ($min >= $max)
      return PEAR::raiseError("Lower bound must be greater than upper bound.");
    else {
      $this->lowerBound = $min;
      $this->upperBound = $max;
    }
  }
  
  /** 
  * @returns the lower bound 
  */ 
  function getLowerBound() { 
    return $this->lowerBound; 
  } 

  /** 
  * @returns the upper bound 
  */ 
  function getUpperBound() { 
    return $this->upperBound; 
  } 

  /**
  * Computes mean of distribution in terms of parameters.
  * @return the mean
  */
  function getMean() { 
    return ($this->lowerBound + $this->upperBound) / 2;
  } 

  /**
  * Computes variance of distribution in terms of parameters.
  * @return the variance
  */
  function getVariance(){
    return pow(($this->upperBound - $this->lowerBound), 2) / 12;
  }

  /**
  * Computes standard deviation of distribution in terms of parameters.
  * @return the standard deviation
  */
  function getStandardDeviation(){
    return sqrt($this->getVariance);
  }

  /** 
  * Probability density function of a uniform distribution. 
  * @param $x value to be evaluated 
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */ 
  function _getPDF($x) { 
    $this->checkRange($x, $this->lowerBound, $this->upperBound);       
    return 1 / ($this->upperBound - $this->lowerBound); 
  } 

  /** 
  * Cumulative probability of particular x 
  * @param $x value to be evaluated 
  * @return the probability that a stochastic variable x is less then X, i.e. P(x < X). 
  */ 
  function _getCDF($x) {     
    if ($x < $this->lowerBound)  
      return 0;
    else if ($x >= $this->upperBound) 
      return 1;
    else return ($x - $this->lowerBound) / ($this->upperBound - $this->lowerBound);
  }

  /** 
  * Inverse of the uniform cumulative distribution function. 
  * @param $p value to be evaluated
  * @return the value X for which P(x < X). 
  */ 
  function _getICDF($p) {     
    $this->checkRange($p);
    return $this->lowerBound + ($this->upperBound - $this->lowerBound) * $p;
  } 

  /* 
  * Uniform RNG function 
  * @return single value in the range [a, b]
  */   
  function _getRNG() {
   $unit_rand = mt_rand() / mt_getrandmax();
   return $this->lowerBound + ($this->upperBound - $this->lowerBound) * $unit_rand;          
  }    
} 
?> 