<?php 
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 
require_once "GammaDistribution.php";
require_once "functions/SpecialMath.php"; 
/** 
* The BetaDistribution class provides an object for 
* encapsulating beta distributions. 
*
* @version 0.3 
* @author Mark Hale 
* @author Jaco van Kooten  
* @author Paul Meagher 
*/ 
class BetaDistribution extends ProbabilityDistribution { 

  /**
  * @int degrees of freedom p.
  */
  var $p;
  
  /**
  * @int degrees of freedom q.
  */
  var $q;

  /**
  * @object  gamma object for RNG method
  */
  var $gamma1;

  /**
  * @object gamma object for RNG method
  */
  var $gamma2;

  /**
  * Constructs a beta distribution.
  * @param dgrP degrees of freedom p.
  * @param dgrQ degrees of freedom q.
  */
  function BetaDistribution($dgrP, $dgrQ) {
    if (($dgrP <= 0) || ($dgrQ <= 0) ) {
      return PEAR::raiseError("Paramters must be greater than zero.");
    }
    $this->p = $dgrP;
    $this->q = $dgrQ;
    $this->gamma1 = new GammaDistribution($this->p, 1);
    $this->gamma2 = new GammaDistribution($this->q, 1);    
    
  }
  
  /**
  * Returns the degrees of freedom p.
  */
  function getDegreesOfFreedomP() {
    return $this->p;
  }
  
  /**
  * Returns the degrees of freedom q.
  */
  function getDegreesOfFreedomQ() {
    return $this->q;
  }

  /**
  * Returns the distribution mean.
  */
  function getMean() {
    return $this->p/($this->p+$this->q);
  }

  /**
  * Returns the distribution standard deviation.
  */
  function getStandardDeviation() {
    return sqrt(($this->p*$this->q)/(pow($this->p+$this->q,2)*($this->p+$this->q+1)));     
  }
  
  /**
  * Probability density function of a beta distribution.
  * @return probability that x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {     
    $this->checkRange($x);
    if ( ($x == 0.0) || ($x == 1.0) ) {
      return 0.0;
    } else {
      return exp(-logBeta($this->p,$this->q)+($this->p-1.0)*log($x)+($this->q - 1.0)*log(1.0-$x));
    }
  } 
    
  /**
  * Cumulative beta distribution function.
  * @return probability that x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {  
    $this->checkRange($x);
    return incompleteBeta($x, $this->p, $this->q);
  }   
  
  /**
  * Inverse of the cumulative beta distribution function.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) { 
    $this->checkRange($p);
    if($p == 0.0)
      return 0.0;
    if($p == 1.0) 
      return 1.0;
    return $this->findRoot($p, 0.5, 0.0, 1.0);
  }       

  /**
  * Private method for simulating beta variates.
  * @return single beta deviate
  */  
  function _getRNG() {
    $x = $this->gamma1->RNG();
    $y = $this->gamma2->RNG();
    return $x/($x + $y);
  }
   
}
?> 