<?php 
/** 
* @package PDL 
*/ 
include_once "PEAR.php"; 
include_once "NumericalConstants.php";
/** 
* The ProbabilityDistribution superclass provides an object 
* for encapsulating probability distributions.
* 
* @version 1.2 
* @author Jaco van Kooten 
* @author Mark Hale 
* @author Paul Meagher 
* @author Jesus Castagnetto 
*/ 
class ProbabilityDistribution { 

  /** 
  * Constructs a probability distribution. 
  */ 
  function ProbabilityDistribution() {} 

  /** 
  * Probability density function. 
  * @return scalar or vector of PDF values.
  */ 
  function PDF($X) { 
    if (is_array($X)) {    
      $pdf_vals = array();
      $num_vals = count($X);
      for($i=0; $i < $num_vals; $i++) {     
        $pdf_vals[$i] = $this->_getPDF($X[$i]);
      }      
      return $pdf_vals;
    } else {
      return $this->_getPDF($X);
    }  
  } 
  
  /** 
  * Private method to be implemented in subclass.
  * @return the probability that a stochastic variable x has the value X, i.e. P(x=X). 
  */ 
  function _getPDF($x) {}

  /** 
  * Cumulative distribution function. 
  * @return scalar or vector of CDF values.
  */ 
  function CDF($X) {
    if (is_array($X)) {    
      $cdf_vals = array();
      $num_vals = count($X);
      for($i=0; $i < $num_vals; $i++) {     
        $cdf_vals[$i] = $this->_getCDF($X[$i]);
      }      
      return $cdf_vals;
    } else {
      return $this->_getCDF($X);
    }
  }

  /** 
  * Private method to be implemented in subclass.
  * @return the probability that a stochastic variable x is less then X, i.e. P(x&lt;X). 
  */ 
  function _getCDF($x) {}

  /** 
  * Inverse cumulative distribution function. 
  * @return scalar or vector of inverse CDF values. 
  */          
  function ICDF($P) {
    if (is_array($P)) {    
      $inv_vals = array();
      $num_vals = count($P);
      for($i=0; $i < $num_vals; $i++) {     
        $inv_vals[$i] = $this->_getICDF($P[$i]);
      }      
      return $inv_vals;
    } else {
      return $this->_getICDF($P);
    }
  }

  /** 
  * Private method to be implemented in subclass.  
  * @return the value X for which P(x&lt;X). 
  */          
  function _getICDF($p) {} 

  /** 
  * Random number generator
  * @return scalar or vector of random deviates. 
  */      
  function RNG($n=1) {
    if ($n < 1) {      
      return PEAR::raiseError("Number of random numbers to return must be 1 or greater");
    }
    if ($n > 1) {    
      $rnd_vals = array();
      for($i=0; $i < $n; $i++) {   
        $rnd_vals[$i] = $this->_getRNG();
      }
      return $rnd_vals;
    } else { 
      return $this->_getRNG();
    }
  }    
  
  /** 
  * Private method to be implemented in subclass.  
  * @return a random deviate
  */          
  function _getRNG() {}         
  
  /** 
  * Check if the range of the argument of the distribution 
  * method is between <code>lo</code> and <code>hi</code>. 
  * @exception OutOfRangeException If the argument is out of range. 
  */ 
  function checkRange($x, $lo=0.0, $hi=1.0) { 
    if (($x < $lo) || ($x > $hi)) { 
      return PEAR::raiseError("The argument should be between $lo and $hi."); 
    } 
  } 

  /** 
  * Get the factorial of the argument 
  * @return factorial of n. 
  */ 
  function getFactorial($n) { 
    return $n <= 1 ? 1 : $n * $this->getFactorial($n-1); 
  } 
      
  /** 
  * This method approximates the value of X for which P(x&lt;X)=<I>prob</I>. 
  * It applies a combination of a Newton-Raphson procedure and bisection method 
  * with the value <I>guess</I> as a starting point. Furthermore, to ensure convergency 
  * and stability, one should supply an inverval [<I>xLo</I>,<I>xHi</I>] in which the probability 
  * distribution reaches the value <I>prob</I>. The method does no checking, it will produce 
  * bad results if wrong values for the parameters are supplied - use it with care. 
  */      
  function findRoot($prob, $guess, $xLo, $xHi) {                      
    $accuracy     = 1.0e-10; 
    $maxIteration = 150; 
    $x     = $guess; 
    $xNew  = $guess; 
    $error = 0.0; 
    $pdf   = 0.0; 
    $dx    = 1000.0; 
    $i     = 0;      
    while ( (abs($dx) > $accuracy) && ($i++ < $maxIteration) ) { 
      // Apply Newton-Raphson step 
      $error = $this->CDF($x) - $prob; 
      if($error < 0.0) { 
        $xLo = $x; 
      } else { 
        $xHi = $x; 
      } 
      $pdf = $this->PDF($x); 
      // Avoid division by zero        
      if ($pdf != 0.0) { 
        $dx   = $error / $pdf; 
        $xNew = $x - $dx; 
      } 

      // If the NR fails to converge (which for example may be the 
      // case if the initial guess is to rough) we apply a bisection 
      // step to determine a more narrow interval around the root. 
      if ( ($xNew < $xLo) || ($xNew > $xHi) || ($pdf==0.0) ) { 
        $xNew = ($xLo + $xHi) / 2.0; 
        $dx   = $xNew - $x; 
      } 
      $x = $xNew; 
    } 
    return $x; 
  }    

} 
?> 