<?php
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 

/**
* The CauchyDistribution class provides an object for encapsulating Cauchy distributions.
* Sometimes referred to as the Lorenztian distribution as well.
*
* @version 0.3
* @author Mark Hale
* @author Paul Meagher
*/
class CauchyDistribution extends ProbabilityDistribution {

  /**
  * @float location parameter.
  */
  var $alpha;

  /**
  * @float scale parameter.
  */
  var $gamma;

  /**
  * Constructs a Cauchy distribution.
  * @param location the location parameter.
  * @param scale the scale parameter.
  */
  function CauchyDistribution($location=0.0,$scale=1.0) {
    if(scale<0.0)
      return PEAR::raiseError("The scale parameter should be positive.");
    $this->alpha=$location;
    $this->gamma=$scale;
  }
  
  /**
  * Returns the location parameter.
  */
  function getLocationParameter() {
    return $this->alpha;
  }

  /**
  * Returns the scale parameter.
  */
  function getScaleParameter() {
    return $this->gamma;
  }
  
  /**
  * Probability density function of a Cauchy distribution.
  * P(X) = <img border=0 alt="Gamma" src="../doc-files/ugamma.gif">/(<img border=0 alt="pi" src="../doc-files/pi.gif">(<img border=0 alt="Gamma" src="../doc-files/ugamma.gif"><sup>2</sup>+(X-<img border=0 alt="alpha" src="../doc-files/alpha.gif">)<sup>2</sup>)).
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    $y = $x - $this->alpha;
    return $this->gamma/(pi()*($this->gamma*$this->gamma+$y*$y));
  }
  
  /**
  * Cumulative Cauchy distribution function.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    return 0.5+atan(($x-$this->alpha)/$this->gamma)/pi();
  }

  /**
  * Inverse of the cumulative Cauchy distribution function.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {
    $this->checkRange($p);
    return $this->alpha-$this->gamma/tan(pi()*$p);
  }
  
  /**
  * Cauchy random number generator.
  * @return a single Cauchy deviate
  */ 
  function _getRNG() {
    $u = mt_rand() / mt_getrandmax();
    return $this->alpha + $this->gamma * tan(pi() * ($u - .5));
  }

}
?>