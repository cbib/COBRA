<?php
/** 
* @package PDL 
*/ 
require_once 'ProbabilityDistribution.php'; 
require_once 'BetaDistribution.php'; 
require_once 'functions/SpecialMath.php'; 
/** 
* The FDistribution class provides an object for encapsulating F-distributions.
* @version 1.3
* @author Jaco van Kooten
* @author Mark Hale
* @author Kyle Siegrist - RNG method
* @author Dawn Duehring - RNG method
* @author Paul Meagher - ports and integration
*/ 
class FDistribution extends ProbabilityDistribution {

  /**
  * @int numerator degrees of freedom.
  */
  var $numerator_df;

  /**
  * @int denominator degrees of freedom.
  */
  var $denominator_df;

  /**
  * @object beta distribution object.
  */
  var $beta;
  
  /**
  * Constructs an F-distribution.
  *
  * We make use of the fact that when x has an F-distibution then
  * y = q/(q+p*x) has a beta distribution with parameters p/2 and q/2.
  *
  * @param $df1 numerator degrees of freedom.
  * @param $df2 denominator degrees of freedom.
  */
  function FDistribution($df1, $df2) {
    if($df1<=0.0 || $df2<=0.0)
      return PEAR::raiseError("The degrees of freedom must be greater than zero.");
    $this->numerator_df   = $df1;
    $this->denominator_df = $df2;
    $this->beta = new BetaDistribution($this->denominator_df/2.0, $this->numerator_df/2.0);
  }
  /**
  * Returns the degrees of freedom p.
  */
  function getNumeratorDF() {
    return $this->numerator_df;
  }
  
  /**
  * Returns the degrees of freedom q.
  */
  function getDenominatorDF() {
    return $this->denominator_df;
  }
  
  /**
  * Private method to obtain single PDF value.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X).
  */
  function _getPDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    $y = $this->denominator_df  / ($this->denominator_df + ($this->numerator_df * $x) );        
    return $this->beta->PDF($y) * $y * $y * $this->numerator_df / $this->denominator_df;
  }

  /**
  * Private method to obtain single CDF value.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X).
  */
  function _getCDF($x) {
    $this->checkRange($x, 0.0, MAX_VALUE);
    return incompleteBeta(1.0 /(1.0 + $this->denominator_df / ($this->numerator_df * $x)), $this->numerator_df/2.0, $this->denominator_df/2.0);
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
    $y = $this->beta->ICDF(1.0 - $p);
    if($y < 2.23e-308) //avoid overflow
      return MAX_VALUE;
    else
      return ($this->denominator_df / $this->numerator_df) * (1.0 / $y - 1.0);
  }
  
  /**
  * This method simulates a value from the distribution. This is done by
  * simulating independent variables u and v, where u is chi-square n and
  * v is chi-squared d, and then computing (u / n) / (v / d).
  * Copyright (C) 2001-2004  Kyle Siegrist, Dawn Duehring
  * @see http://www.math.uah.edu/stat/    
  * @return a simulated value from the distribution
  */
  function _getRNG(){
    $u = 0;
    for ($i = 1; $i <= $this->numerator_df; $i++){
      $urand1 = mt_rand() / mt_getrandmax();
      $urand2 = mt_rand() / mt_getrandmax();
      $r = sqrt(-2 * log($urand1));
      $theta = 2 * pi() * $urand2;
      $z = $r * cos($theta);
      $u = $u + $z * $z;
    }
    $v = 0;
    for ($j = 1; $j <= $this->denominator_df; $j++){
      $urand1 = mt_rand() / mt_getrandmax();
      $urand2 = mt_rand() / mt_getrandmax();
      $r = sqrt(-2 * log($urand1));
      $theta = 2 * pi() * $urand2;
      $z = $r * cos($theta);
      $v = $v + $z * $z;
    }
    return ($u / $this->numerator_df) / ($v / $this->denominator_df);
  }
}
?>