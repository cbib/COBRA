<?php 
/** 
* @package PDL 
*/ 
function make_table($title, $xHeader, $yHeader, $xVals, $yVals) { 
  ?> 
  <table border='1' cellspacing='2' width='400'> 
    <tr> 
      <th colspan='2'><?php echo $title ?></th> 
    </tr> 
    <tr> 
      <td width='200'><i><?php echo $xHeader ?></i></td> 
      <td width='200'><i><?php echo $yHeader ?></i></td> 
    </tr>      
    <?php 
    $num = count($xVals); 
    for($i=0; $i < $num; $i++) {      
      ?> 
      <tr> 
        <td><?php echo $xVals[$i] ?></td> 
        <td><?php echo $yVals[$i] ?></td> 
      </tr> 
      <?php 
    } 
    ?> 
  </table> 
  <br/> 
  <br/> 
  <?php 
}    
?> 