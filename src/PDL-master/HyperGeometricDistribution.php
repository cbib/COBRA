<?php 
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'functions/SpecialMath.php'; 
require_once 'functions/ExtraMath.php'; 

/** 
* The HyperGeometricDistribution class provides an object for encapsulating 
* HyperGeometric distributions.  Uses R terminology to describe paramters.
*
* @version 0.1 
* @author Paul Meagher 
*/ 
class HyperGeometricDistribution extends ProbabilityDistribution { 

  /**
  * @int the number of white balls in the urn. 
  */
  var $m; 
  
  /**
  * @n the number of black balls in the urn.
  */  
  var $n; 

  /**
  * @k the number of balls drawn from the urn.
  */
  var $k;

  /**
  * This method set the parameters of the distribution. 
  * @param int $m the number of white balls in the urn.
  * @param int $n the number of black balls in the urn.
  * @param int $k the number of balls drawn from the urn.
  */
  function HyperGeometricDistribution($m, $n, $k){
    $this->m = $m;
    $this->n = $n;
    $this->k = $k;
  } 

  /** 
  * Method returns the number of successes.
  * @return the number of successes
  */ 
  function getM() { 
    return $this->m; 
  } 

  /** 
  * Method returns the probability of success.  
  * @return the probability
  */ 
  function getN() { 
    return $this->n; 
  } 

  /** 
  * Method returns the probability of success.  
  * @return the probability
  */ 
  function getK() { 
    return $this->k; 
  } 

  /** 
  * This method computes the mean of the distribution.  
  * @return the mean 
  */ 
  function getMean() { 
    return "NA";
  } 

  /**
  * This method computes the variance, which
  * is given by n (r/m) (1 - r/m)(m - n) / (m - 1).
  * @return the variance
  */
  function getVariance(){
    return "NA";
  }

  /**
  * This method computes the probability density function.
  * @param x a number in the domain of the distribution
  * @return the probability density at x
  */
  function _getPDF($x) { 
    if (!is_int($x))
      die("Value of x must be a positive integer");
    return binomial($this->m, $x) * 
           binomial($this->n, $this->k - $x) / 
           binomial($this->m + $this->n, $this->k);
  }

  /** 
  * Private shared function for getting cumulant for particular x 
  * @param x should be integer-valued. 
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X). 
  */ 
  function _getCDF($x) { 
    if (!is_int($x))
      die("Value of x must be a positive integer");
    for ($l=0; $l<=$x; $l++) 
      $sum += $this->PDF($l);
    return $sum;  
  } 

  /** 
  * Inverse of the cumulative hypergeometric distribution function.
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
  * Private hypergeometric RNG method.  
  * Implements the "hyp" algorithm described in:
  * George Fishman (2001) Discrete-event simulation: modeling, 
  * programming, and analysis. New York : Springer.
  * @returns single hypergeometric deviate 
  */   
  function _getRNG() {     
    $d1 = $this->m + $this->n - $this->k;
    $d2 = min($this->m, $this->n);
    $y  = $d2;
    $i  = $this->n;
    while (($y * $i) > 0) {
      $u = mt_rand() / mt_getrandmax();
      $y = $y - (int) ( $u + ($y / ($d1 + $i)) );
      $i = $i - 1;
    }
    $z = $d2 - $y;
    if ($this->m <= $this->n)
      return $z;
    else 
      return $this->k - $z;
  }
        
} 
?> 