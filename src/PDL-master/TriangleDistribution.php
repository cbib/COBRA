<?php
/**
* @package PDL
*/

include_once "ProbabilityDistribution.php";

/**
* Class to encapsulate the triangle distribution.
*
* @author Paul Meagher
* @version 0.2
*/
class TriangleDistribution extends ProbabilityDistribution {
      
  /**
  * @var float 
  */
  var $lowerBound;

  /**
  * @var float 
  */
  var $upperBound;

  /**
  * @var float;
  */ 
  var $mode;

  /**
  * This general constructor creates a new triangle distribution on a specified
  * interval and with a specified mode.  
  * @param a the left endpoint
  * @param b the right endpoint
  * @param c the mode
  */
  function TriangleDistribution($a, $b, $c) {
    if ($a >= $b) 
      die("Left endpoint must be less than right endpoint.");
    $this->lowerBound = $a;
    $this->upperBound = $b;
    $this->mode = $c;
  }

  /**
  * This method returns the lower bound
  * @return the left endpoint of the domain
  */
  function getLowerBound() {
    return $this->lowerBound;
  }

  /**
  * This method returns the upper bound.
  * @return the right endpoint of the domain
  */
  function getUpperBound() {
    return $this->upperBound;
  }

  /**
  * This method computes the mode.
  * @return the mode
  */
  function getMode() {
    return $this->mode;
  }

  /**
  * This method computes the quartile mode.
  * @return the quartile mode
  */
  function getQuartileMode(){
    return ($this->mode - $this->lowerBound) / ($this->upperBound - $this->lowerBound);
  }


  /**
  * This method computes the mean.
  * @return the mean of the distribution
  */
  function getMean() {
    return ($this->lowerBound + $this->mode + $this->upperBound) / 3;
  }

  /**
  * This method computes the variance.
  * @return the variance of the distribution
  */
  function getVariance(){
    return ( pow($this->lowerBound, 2) + pow($this->mode, 2) + pow($this->upperBound, 2) - 
    ($this->lowerBound * $this->upperBound) - ($this->lowerBound * $this->mode) -
    ($this->upperBound * $this->mode) ) / 18;
  }
  
  /**
  * This method computes the probability density function at $x.
  * @param float $x value to be evaluated
  * @return the probability density at $x
  */
  function _getPDF($x){
    if (($x < $this->lowerBound) OR ($x > $this->upperBound)) return 0; 
    if (($x >= $this->lowerBound) AND ($x <= $this->mode)) 
      return (2 * ($x - $this->lowerBound)) / 
             (($this->upperBound - $this->lowerBound) * ($this->mode - $this->lowerBound));
    else 
      return (2 * ($this->upperBound - $x)) / 
             (($this->upperBound - $this->lowerBound) * ($this->upperBound - $this->mode));
  }

  /**
  * Computes the cumulative distribution function at $x.
  * @param float $x value to be evaluated
  * @return the cumulative probability density at $x
  */
  function _getCDF($x){
    if ($x < $this->lowerBound) return 0;   
    if ($x > $this->upperBound) return 1;     
    if (($x >= $this->lowerBound) AND ($x <= $this->mode)) 
      return pow(($x - $this->lowerBound), 2) / 
             (($this->upperBound - $this->lowerBound) * ($this->mode - $this->lowerBound));
    else        
      return 1 - pow(($this->upperBound - $x), 2) /
             (($this->upperBound - $this->lowerBound) * ($this->upperBound - $this->mode));
  }   


  /**
  * Computes the inverse cumulative distribution function at $p.
  * @see http://www.iro.umontreal.ca/~simardr/ssj/dist/doc/html/umontreal/iro/lecuyer/probdist/TriangularDist.html
  * @param float $p value to be evaluated
  * @return the value X for which P(x < X) = $p
  */
  function _getICDF($p){
    if (($p < 0) || ($p > 1))
      die("Probability should be between 0 and 1.");
    else {
      $crit  = ($this->mode - $this->lowerBound)/($this->upperBound - $this->lowerBound);
      $range = ($this->upperBound - $this->lowerBound);
      if (($p >= 0) AND ($p <= $crit))
        $x = $this->lowerBound + sqrt($range * ($this->mode - $this->lowerBound) * $p);      
      elseif (($p  > $crit) AND ($p <= 1))
        $x = $this->upperBound - sqrt($range * ($this->upperBound - $this->mode) * (1 - $p));
    }
    return $x;
  }   
  
  /**
  * RNG method for the triangle distribution.
  * @return a simulated value from triangle distribution
  */
  function _getRNG(){         
    $urand = mt_rand() / mt_getrandmax();
    $qmode = $this->getQuartileMode();
    if ($urand >= $qmode) 
      return $this->lowerBound + sqrt($urand * ($this->upperBound - $this->lowerBound) * ($this->mode - $this->lowerBound));
    else 
      return $this->upperBound - sqrt((1 - $urand) * ($this->upperBound-$this->lowerBound) * ($this->upperBound - $this->mode));
  }    
  
}
?>