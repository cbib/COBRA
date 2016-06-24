<?php 
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'functions/SpecialMath.php'; 
require_once 'functions/ExtraMath.php'; 

/** 
* The BinomialDistribution class provides an object for encapsulating binomial distributions. 
*
* @version 1.1 
* @author Mark Hale 
* @author Paul Meagher 
*/ 
class BinomialDistribution extends ProbabilityDistribution { 

  /**
  * @int number of trials
  */
  var $n; 
  
  /**
  * @float probability of success
  */  
  var $p; 

  /** 
  * Constructs a binomial distribution. 
  * @param trials the number of trials. 
  * @param prob the probability. 
  */ 
  function BinomialDistribution($trials, $prob) { 
    if($trials <= 0) 
      return PEAR::raiseError("The number of trials should be (strictly) positive."); 
    $this->n = $trials; 
    if($prob < 0.0 || $prob > 1.0) 
      return PEAR::raiseError("The probability should be between 0 and 1."); 
    $this->p = $prob; 
  } 

  /** 
  * Returns the number of trials. 
  */ 
  function getTrialsParameter() { 
    return $this->n; 
  } 

  /** 
  * Returns the probability. 
  */ 
  function getProbabilityParameter() { 
    return $this->p; 
  } 

  /** 
  * Returns the mean. 
  */ 
  function getMean() { 
    return $this->n * $this->p; 
  } 

  /** 
  * Returns the variance. 
  */ 
  function getVariance() { 
    return $this->n * $this->p * (1.0 - $this->p); 
  } 

  /** 
  * Probability density function of a binomial distribution (equivalent to R dbinom function). 
  * @param X should be integer-valued. 
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */ 
  function _getPDF($x) { 
    $this->checkRange($x, 0.0, $this->n);       
    return binomial($this->n, $x) * pow($this->p, $x) * pow(1.0 - $this->p, $this->n - $x); 
  } 

  /** 
  * Private shared function for getting cumulant for particular x 
  * @param x should be integer-valued. 
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X). 
  */ 
  function _getCDF($x) { 
    $this->checkRange($x, 0.0, $this->n); 
    $sum = 0.0; 
    for($i=0.0; $i<=$x; $i++) { 
      $sum+= $this->PDF($i); 
    } 
    return $sum; 
  } 

  /** 
  * Inverse of the cumulative binomial distribution function (equivalent to R qbinom function). 
  * @return the value X for which P(x&lt;X). 
  */ 
  function _getICDF($prob) { 
    $this->checkRange($prob); 
    return floor( $this->findRoot($prob, $this->n/2, 0.0, $this->n) ); 
  } 

  /* 
  * Private binomial RNG function 
  * 
  * Original version of this function from Press et al. 
  * 
  * @see http://www.library.cornell.edu/nr/bookcpdf/c7-3.pdf 
  * 
  * Changed parts having to do with generating a uniformly distributed 
  * number in the 0 to 1 range.  Also using instance variables, instead 
  * of supplying function with $p and $n values.  Finally calling port   
  * of JSci's log gamma routine instead of Press et al. 
  */   
  function _getRNG() {       
    $nold = -1; 
    $pold = -1.0;   
    $p = ($this->p <= 0.5 ? $this->p : 1.0 - $this->p); 
    $am = $this->n * $p; 
    if ($this->n < 25) { 
      $bnl=0.0; 
      for ($j=1; $j<=$this->n; $j++) 
        if ( ( mt_rand() / mt_getrandmax() ) < $p ) ++$bnl; 
    } else if ($am < 1.0) { 
      $g = exp(-$am); 
      $t = 1.0; 
      for ($j=0; $j<=$this->n; $j++) { 
        $t *= ( mt_rand() / mt_getrandmax() );    
        if ($t < $g) break; 
      } 
      $bnl=($j <= $this->n ? $j : $this->n); 
    } else { 
      if ($n != $nold) { 
        $en   = $this->n; 
        $oldg = logGamma($en + 1.0); 
        $nold = $n; 
      } if ($p != $pold) { 
        $pc    = 1.0 - $p; 
        $plog  = log($p); 
        $pclog = log($pc); 
        $pold  = $p; 
      } 
      $sq = sqrt(2.0 * $am * $pc); 
      do { 
        do { 
          $angle = PI * ( mt_rand() / mt_getrandmax() ); 
          $y  = tan($angle); 
          $em = $sq * $y + $am; 
        } while ($em < 0.0 || $em >= ($en + 1.0)); 
        $em = floor($em); 
        $t  = 1.2 * $sq * (1.0 + $y * $y) * exp($oldg - logGamma($em + 1.0) - logGamma($en - $em + 1.0) + $em * $plog + ($en - $em) * $pclog); 
      } while ( ( mt_rand() / mt_getrandmax() ) > $t); 
      $bnl = $em; 
    } 
    if ($p != $this->p) $bnl = $this->n - $bnl; 
    return $bnl; 
  } 
   
} 
?> 