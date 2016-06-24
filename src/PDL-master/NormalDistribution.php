<?php
/** 
* @package PDL
*/ 
require_once "ProbabilityDistribution.php"; 
require_once "functions/SpecialMath.php"; 

/**
* The NormalDistribution class provides an object for encapsulating 
* normal distributions.
*
* @version 1.3
* @author Jaco van Kooten
* @author Paul Meagher
*/
class NormalDistribution extends ProbabilityDistribution {
  
  var $mean;
  var $stdev;  
  var $variance;
  
  var $pdfDenominator;
  var $cdfDenominator;
  
  var $useLast = false;
  var $last;

  /**
  * Constructs a normal distribution (defaults to zero mean and unity variance).
  *
  * @param mu the mean.
  * @param sigma the standard deviation.
  */
  function NormalDistribution($mu=0.0, $sigma=1.0) {
    $this->mean = $mu;
    if ($sigma <= 0.0) 
      return PEAR::raiseError("The standard deviation should be a positive value.");
    $this->stdev    = $sigma;
    $this->variance = pow($sigma, 2);
    $this->pdfDenominator = SQRT2PI * sqrt($this->variance);
    $this->cdfDenominator = SQRT2 * sqrt($this->variance);
  }
  
  /**
  * Returns the mean.
  */
  function getMean() {
    return $this->mean;
  }

  /**
  * Returns the standard deviation..
  */
  function getStandardDeviation() {
    return $this->stdev;
  }
  
  /**
  * Returns the variance.
  */
  function getVariance() {
    return $this->variance;
  }
 
  /**
  * Private method to obtain single PDF value.
  * @param $x should be greater than 0  
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */
  function _getPDF($x) {
    return exp( -pow($x - $this->mean, 2) / ( 2 * $this->variance)) / $this->pdfDenominator;
  }

  /**
  * Private method to obtain single CDF value.
  * @param $x should be greater than 0    
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    return complementaryError( -($x - $this->mean) / $this->cdfDenominator ) / 2;
  }
  
  /**
  * Private method to obtain single inverse CDF value.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    if($p == 0.0)
      return -MAX_VALUE;
    if($p == 1.0)
      return MAX_VALUE;
    if($p == 0.5)
      return $this->mean;
    // To ensure numerical stability we need to rescale the distribution
    $meanSave = $this->mean;
    $varSave  = $this->variance;
    $pdfDSave = $this->pdfDenominator;
    $cdfDSave = $this->cdfDenominator;
    $this->mean = 0.0;
    $this->variance = 1.0;
    $this->pdfDenominator = sqrt(TWO_PI);
    $this->cdfDenominator = SQRT2;
    $x = $this->findRoot($p, 0.0, -100.0, 100.0);
    // Scale back
    $this->mean = $meanSave;
    $this->variance = $varSave;
    $this->pdfDenominator = $pdfDSave;
    $this->cdfDenominator = $cdfDSave;
    return $x * sqrt($this->variance) + $this->mean;
  }
  
  /**
  * Uses the polar form of the Box-Muller transformation which 
  * is both faster and more robust numerically than basic Box-Muller
  * transform. To speed up repeated RNG computations, two random values  
  * are computed after the while loop and the second one is saved and 
  * directly used if the method is called again.
  *
  * @see http://www.taygeta.com/random/gaussian.html
  *
  * @return single normal deviate
  */
  function _getRNG() {
    if($this->useLast) { //already calculated one, so use it
      $y1 = $this->last;
      $this->useLast = false;
    } else {
      do {
        $r1 = mt_rand() / mt_getrandmax();
        $r2 = mt_rand() / mt_getrandmax();          
        $x1 = 2.0 * $r1 - 1.0; // between -1.0 and 1.0
        $x2 = 2.0 * $r2 - 1.0; // between -1.0 and 1.0
        $w = $x1 * $x1 + $x2 * $x2;      
      } while ($w >= 1.0);    
      $w = sqrt((-2.0 * log($w)) / $w);
      $y1 = $x1 * $w;
      $this->last = $x2 * $w; 
      $this->useLast = true;
    }  
    return $this->mean + $y1 * sqrt($this->variance);
  }
  
}
?>