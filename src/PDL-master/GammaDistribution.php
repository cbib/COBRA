<?php
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 
require_once "functions/SpecialMath.php"; 

/**
* The GammaDistribution class provides an object for encapsulating gamma distributions.
*
* @version 1.0
* @author Jaco van Kooten
* @author Paul Meagher
*/
class GammaDistribution extends ProbabilityDistribution {

  /**
  * @float stores the shape parameter
  */
  var $shape;

  /**
  * Constructs a gamma distribution.
  * @param s the shape parameter.
  */
  function GammaDistribution($s) {
    if($s<=0.0)
      return PEAR::raiseError("The shape parameter should be (strictly) positive.");
    $this->shape = $s;
  }

  /**
  * Returns the shape parameter.
  */
  function getShapeParameter() {
    return $this->shape;
  }

  /**
  * Returns the mean.
  */
  function getMean() {
    return $this->shape;
  }

  /**
  * Returns the variance.
  */
  function getVariance() {
    return $this->shape;
  }

  /**
  * Private method to obtain single PDF value.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    if($x == 0.0)
      return 0.0;
    else
      return exp(-logGamma($this->shape)-$x+($this->shape-1)*log($x));
  }
  
  /**
  * Private method to obtain single CDF value.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    return incompleteGamma($this->shape, $x);
  }
  
  /**
  * Private method to obtain single inverse CDF value.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {      
    $this->checkRange($p);
    if($p==0.0)
      return 0.0;
    if($p==1.0)
      return MAX_VALUE;
    return $this->findRoot($p, $this->shape, 0.0, MAX_VALUE);
  }
  
  /**
  * @return random normal deviate.
  */
  function RNOR($mean=0, $variance=1) {
    static $use_last;
    static $last;    
    //already calculated one, so use it
    if($use_last) { 
      $y1       = $last;
      $use_last = false;
    } else {
      do {
        $r1 = mt_rand() / mt_getrandmax();
        $r2 = mt_rand() / mt_getrandmax();          
        $x1 = 2.0 * $r1 - 1.0; // between -1.0 and 1.0
        $x2 = 2.0 * $r2 - 1.0; // between -1.0 and 1.0
        $w  = $x1 * $x1 + $x2 * $x2;      
      } while ($w >= 1.0);    
      $w    = sqrt((-2.0 * log($w)) / $w);
      $y1   = $x1 * $w;
      $last = $x2 * $w; 
      $use_last = true;
    }  
    return $mean + $y1 * sqrt($variance);
  }

  /**
  * @return uniform normal deviate.
  */
  function UNI() {  
    return mt_rand() / mt_getrandmax();  
  }
  
  /**
  * Implements Marsaglia algorithm for simulating gamma variates.
  * @see http://finmath.uchicago.edu/~wilder/Code/random/Papers/Marsaglia_00_SMGGV.pdf
  * @see http://finmath.uchicago.edu/~wilder/Code/random/
  * @return single random deviate from gamma distribution.
  */  
  function _getRNG($scale=1) {
    if ($this->shape < 1) 
      return _getRNG($this->shape + 1, $scale) * pow($this->UNI(), 1.0 / $this->shape);
    $d = $this->shape - 1.0 / 3.0;
    $c = 1.0 / sqrt(9.0 * $d);
    for (;;) {
      do {
        $x = $this->RNOR();
        $v = 1.0 + $c * $x;
      } while ($v <= 0.0);
      $v = $v * $v * $v;
      $u = $this->UNI();
      if ($u < 1.0 - 0.0331 * $x * $x * $x * $x)
        return ($d * $v / $scale);
      if (log($u) < 0.5 * $x * $x + $d * (1.0 - $v + log($v)))
        return ($d * $v / $scale);
    }
  } 
  
}
?>