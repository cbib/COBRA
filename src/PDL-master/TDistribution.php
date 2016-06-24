<?php
/** 
* @package PDL 
*/ 
require_once "ProbabilityDistribution.php"; 
require_once "functions/SpecialMath.php"; 
/**
* The TDistribution class provides an object for encapsulating student's t-distributions.
*
* @version 1.1
* @author Jaco van Kooten
* @author Kyle Siegrist - RNG method
* @author Dawn Duehring - RNG method
* @author Paul Meagher - ports and integration
*/
class TDistribution extends ProbabilityDistribution {

  /**
  * @int degrees of freedom
  */
  var $df;    

  /**
  * @int log degrees of freedom
  */
  var $log_df;
  
  /**
  * Constructor for student's t-distribution.
  * @param r degrees of freedom.
  */
  function TDistribution($r) {
    if($r<=0)
      return PEAR::raiseError("The degrees of freedom must be greater than zero.");
    $this->df     = $r;
    $this->log_df = -logBeta(0.5 * $this->df, 0.5) -0.5 * log($this->df);
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
    $log_df  = $this->log_df;
    $log_df -= (0.5*($this->df + 1))* log(1.0 + ($x * $x)/ $this->df);
    return exp($log_df);
  }

  /**
  * Private method to obtain single CDF value.  
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $a = 0.5 * incompleteBeta(($this->df)/($this->df + $x * $x), 0.5 * $this->df, 0.5);
    return $x > 0 ? 1 - $a : $a;
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
      return 0.0;
    return $this->findRoot($p, 0.0, -0.5 * MAX_VALUE, 0.5 * MAX_VALUE);
  }

  /**
  * Private method to obtain single RNG value.
  * Copyright (C) 2001-2004  Kyle Siegrist, Dawn Duehring
  * @see http://www.math.uah.edu/stat/
  * @return simulated value from t distribution
  */
  function _getRNG(){
    $v = 0;
    for ($i = 1; $i <= $this->df; $i++){
      $urand1 = mt_rand() / mt_getrandmax();
      $urand2 = mt_rand() / mt_getrandmax();
      $r = sqrt(-2 * log($urand1));
      $theta = 2 * pi() * $urand2;
      $z = $r * cos($theta);
      $v = $v + $z * $z;
    }
    $urand1 = mt_rand() / mt_getrandmax();
    $urand2 = mt_rand() / mt_getrandmax();    
    $r = sqrt(-2 * log($urand1));
    $theta = 2 * pi() * $urand2;
    $z = $r * cos($theta);
    return $z / sqrt($v / $this->df);
  }  
}
?>