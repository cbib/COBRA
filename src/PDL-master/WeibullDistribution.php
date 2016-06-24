<?php 
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 
require_once "functions/SpecialMath.php"; 

/** 
* The WeibullDistribution class provides an object for encapsulating 
* Weibull distributions. 
*
* @version 0.4 
* @author Mark Hale 
* @author Paul Meagher 
*/ 
class WeibullDistribution extends ProbabilityDistribution { 

  /**
  * @float share parameter
  */
  var $shape;  

  /**
  * Constructs a Weibull distribution.
  * @param sh the shape.
  */
  function WeibullDistribution($sh) {
    if($sh<=0.0)
      return PEAR::raiseError("The shape parameter should be positive.");
    $this->shape=$sh;
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
    return gamma(1.0+1.0/$this->shape);
  }
  
  /**
  * Returns the variance.
  */
  function getVariance() {
    return gamma(1.0+2.0/$this->shape)-pow($this->getMean(),2);
  }

  /**
  * Private method to obtain single PDF value.
  *
  * P(X) = s X<sup>s-1</sup> exp(-X<sup>s</sup>).
  *
  * @param $x should be integer-valued.  
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */
  function _getPDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    $XpowShape = pow($x, $this->shape);
    return $this->shape*$XpowShape/$x*exp(-$XpowShape);
  }
   
  /**
  * Private method to obtain single CDF value.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x,0.0,MAX_VALUE);
    return 1.0-exp(-pow($x,$this->shape));
  }
  
  /**
  * Private method to obtain single inverse CDF value.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    return pow(-log(1.0-$p),1.0/$this->shape);
  }
  
  /**
  * Private method to obtain single RNG value.
  * @see http://www.taygeta.com/random/weibull.xml
  * @return Weibull random deviate
  */
  function _getRNG() {  
    $rand = mt_rand() / mt_getrandmax();
    return pow(-log(1-$rand),1/$this->shape);
  }
    
}
?>