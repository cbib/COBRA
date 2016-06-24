<?php
/**
* @package PDL
* @path examples/photosythesis.php
*
* @author Bill Shipley
* @author Paul Meagher
*
* Program to simulate net photosythesis as a function
* of leaf nitrogen and stomatal density.
*/
require_once '../NormalDistribution.php';
$num_simulations  = 100;
$leaf_nitrogen    = new NormalDistribution(0.035, 1.006);
$stomatal_density = new NormalDistribution(-0.031, 1.017);
?>
<table border='1'>
  <tr>
    <th>Simulation #</th>  
    <th>Leaf Nitrogen</th>
    <th>Stomatal Density</th>
    <th>Net Photosynthesis</th>        
  </tr>
  <?php
  for($i=0; $i < $num_simulations; $i++) {
    $leaf_nitrogens[$i]     = $leaf_nitrogen->RNG();
    $stomatal_densities[$i] = $stomatal_density->RNG();
    $net_photosynthesis[$i] = 0.003 + 0.527 * $leaf_nitrogens[$i] + 0.498 * $stomatal_densities[$i];
    ?>
    <tr>
      <td align='center'><?php echo $i ?></td>    
      <td align='right'><?php echo $leaf_nitrogens[$i] ?></td>
      <td align='right'><?php echo $stomatal_densities[$i] ?></td>
      <td align='right'><?php echo $net_photosynthesis[$i] ?></td>
    </tr>
    <?php
  }
  ?>
</table>
