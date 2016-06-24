<?php 
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'GammaDistribution.php';
require_once 'BetaDistribution.php';
require_once 'functions/SpecialMath.php'; 
require_once 'functions/ExtraMath.php'; 
/** 
* The NegativeBinomialDistribution class provides an object for encapsulating 
* negative binomial distributions.
*
* @version 0.1 
* @author Paul Meagher 
*/ 
class NegativeBinomialDistribution extends ProbabilityDistribution { 

  /**
  * @int number of successes
  */
  var $n; 
  
  /**
  * @float probability of success
  */  
  var $p; 

  /**
  * @object gamma distribution
  */
  var $gamma;

  /**
  * Instantiates a new negative binomial distribution with supplied 
  * parameter values.
  * @param int $n the number of successes
  * @param float $p the probability of success
  */
  function NegativeBinomialDistribution($n, $p) { 
    if (($n <= 0) OR (!is_int($n))) 
      die("The number of successes should be a positive integer."); 
    if($p < 0.0 || $p > 1.0) 
      die("The probability of success should be between 0 and 1."); 
    $this->n = $n;       
    $this->p = $p; 
    $this->gamma = new GammaDistribution($this->n);    
  } 

  /** 
  * Method returns the number of successes.
  * @return the number of successes
  */ 
  function getN() { 
    return $this->n; 
  } 

  /** 
  * Method returns the probability of success.  
  * @return the probability
  */ 
  function getP() { 
    return $this->p; 
  } 

  /** 
  * This method computes the mean of the distribution.  
  * @return the mean 
  */ 
  function getMean() { 
    return $this->n / $this->p; 
  } 

  /** 
  * This method computes the variance of the distribution.  
  * @return the variance
  */ 
  function getVariance() { 
    return ($this->n * (1.0 - $this->p)) / ($this->p * $this->p); 
  } 

  /**
  * This method computes the probability density function.
  * @param x a number in the domain of the distribution
  * @return the probability density at x
  */
  function _getPDF($x) { 
    if (!is_int($x))
      die("Value of x must be a positive integer");
    else {      
      $combo = gamma($x + $this->n) / (gamma($this->n) * $this->getFactorial($x));
      return $combo * pow($this->p, $this->n) * pow(1 - $this->p, $x);
    }
  }

  /** 
  * Private shared function for getting cumulant for particular x 
  * @param int x positive integer
  * @return the probability that a stochastic variable x is less then X, i.e. P(x < X). 
  */ 
  function _getCDF($x) { 
    if ($x < 0) 
      die("x must be a positive value");
    $beta = new BetaDistribution($this->n, $x + 1); 
    return $beta->CDF($this->p);   
  } 

  /** 
  * Inverse of the cumulative negative binomial distribution function.
  * @param float $p value to be evaluated
  * @return the value X for which P(x < X) = $p. 
  */ 
  function _getICDF($p) { 
    $x = 1;    
    if ($this->CDF($x) > $p) 
      return 0;      
    while ($this->CDF($x) < $p)
      $x++;    
    return $x;
  }

  /** 
  * Private negative binomial RNG function 
  * Generate lambda as gamma with shape parameter n multiplied by 
  * scale parameter p/(1-p).  Return a poisson deviate using the 
  * generated lambda.
  * @return a negative binomial variate 
  */   
  function _getRNG() {             
    $scale  = (1.0 - $this->p) / $this->p ;
    $lambda = $scale * $this->gamma->RNG();
    $temp   =  0; 
    $count  = -1;     
    while($temp <= $lambda) { 
      $urand = mt_rand() / mt_getrandmax();         
      $temp  = $temp - log($urand); 
      $count++; 
    } 
    return $count; 
  }      
} 
?> 