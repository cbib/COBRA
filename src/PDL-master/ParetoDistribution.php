<?php 
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php";  

/**
* The ParetoDistribution class provides an object for encapsulating 
* Pareto distributions.
*
* @version 0.3
* @author Mark Hale
* @author Paul Meagher
*/
class ParetoDistribution extends ProbabilityDistribution {

  /**
  * @float holds shape parameter value
  */
  var $shape;

  /**
  * @float holds scale parameter value
  */
  var $scale;

  /**
  * Constructs a Pareto distribution.
  *
  * @param sh the shape.
  * @param sc the scale.
  */
  function ParetoDistribution($sh, $sc) {
    if($sh < 0.0)
      return PEAR::raiseError("The shape parameter should be positive.");
    $this->shape=$sh;
    if($sc < 0.0)
      return PEAR::raiseError("The scale paremeter should be positive.");
    $this->scale=$sc;
  }

  /**
  * Returns the shape parameter.
  */
  function getShapeParameter() {
    return $this->shape;
  }

  /**
  * Returns the scale parameter.
  */
  function getScaleParameter() {
    return $this->scale;
  }

  /**
  * Returns the mean.
  */
  function getMean() {
    return $this->shape*$this->scale/($this->shape-1.0);
  }

  /**
  * Returns the variance.
  */
  function getVariance() {
    return $this->shape*$this->scale*$this->scale/(($this->shape-2.0)*($this->shape-1.0)*($this->shape-1.0));
  }
    
  /**
  * Probability density function of a Pareto distribution.
  * P(X) = (a/X) (s/X)<sup>a</sup>.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    if($x < $this->scale)
      return PEAR::raiseError("X should be greater than or equal to the scale.");
    return $this->shape*pow($this->scale/$x,$this->shape)/$x;
  }
  
  /**
  * Cumulative Pareto distribution function.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    if($x < $this->scale)
      return PEAR::raiseError("X should be greater than or equal to the scale.");
    return 1.0-pow($this->scale/$x,$this->shape);
  }
  
  /**
  * Inverse of the cumulative Pareto distribution function.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    return $this->scale/pow(1.0-$p,1.0/$this->shape);
  }
    
  /**
  * Private method to obtain single random deviate.
  * @see http://www.xycoon.com/par_random.htm
  * @return simulated value from Pareto distribution.
  */
  function _getRNG() {
    $urand = mt_rand() / mt_getrandmax(); 
    return $this->shape * pow(1/(1 - $urand), 1/$this->scale);
  }        
}
?>