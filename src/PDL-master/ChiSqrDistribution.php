<?php
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'GammaDistribution.php'; 
require_once 'functions/SpecialMath.php'; 
/** 
* The ChiSqrDistribution class provides an object for encapsulating 
* chi-squared distributions. 
*
* @author Jaco van Kooten
* @author Paul Meagher 
* @version 1.1
*/ 
class ChiSqrDistribution extends ProbabilityDistribution {
  
  var $df;    
  var $gamma; 

  /**
  * Constructs a chi-squared distribution.
  * @param dgr degrees of freedom.
  */
  function ChiSqrDistribution($dgr) {
    if($dgr<=0.0)
      return PEAR::raiseError("The degrees of freedom must be greater than zero.");
    $this->df    = $dgr;
    $this->gamma = new GammaDistribution(0.5 * $this->df);
  }
  
  /**
  * Returns the degrees of freedom.
  */
  function getDF() {
    return $this->df;
  }
  
  /**
  * Private method to obtain single PDF value.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    return 0.5 * $this->gamma->PDF(0.5 * $x);
  }
 
  /**
  * Private method to obtain single CDF value.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    return incompleteGamma(0.5 * $this->df, 0.5 * $x);
  }
    
  /**
  * Private method to obtain single inverse CDF value.
  * @return the value X for which P(x&lt;X).
  */
  function _getICDF($p) {      
    if($p == 1.0)
      return MAX_VALUE;
    else
      return 2.0 * $this->gamma->ICDF($p);
  }

  /**
	* This method simulates a value from the distribution, as the sum of squares
	* of independent, standard normal distribution.
  * Copyright (C) 2001-2004  Kyle Siegrist, Dawn Duehring
  * @see http://www.math.uah.edu/stat/	
	* @return a simulated value form the chi square distribution
	*/
	function _getRNG() {
		$v = 0;	  
		for ($i = 1; $i <= $this->df; $i++){
		  $urand1 = mt_rand() / mt_getrandmax();
      $urand2 = mt_rand() / mt_getrandmax();
			$r = sqrt(-2 * log($urand1));
			$theta = 2 * pi() * $urand2;
			$z = $r * cos($theta);
			$v = $v + $z * $z;
		}
		return $v;
	}
  
}
?>