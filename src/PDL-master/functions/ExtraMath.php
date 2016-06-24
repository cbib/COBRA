<?php

/**
* Returns the binomial coefficient (n k).
* Uses gamma functions.
* @planetmath BinomialCoefficient
* @param n a double.
* @param k a double.
*/
function binomial($n, $k) {
  return exp(logGamma($n + 1.0) - logGamma($k + 1.0) - logGamma($n - $k + 1.0));
}

?> 
