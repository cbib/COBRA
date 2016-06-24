<?php 
/** 
* @package PDL 
*/ 
function make_table($title, $xHeader, $yHeader, $xVals, $yVals, $width=400) { 
  $half_width = $width / 2;
  ?> 
  <table border='1' cellspacing='2' width='<?php echo $width ?>'> 
    <tr> 
      <th colspan='2'><?php echo $title ?></th> 
    </tr> 
    <tr> 
      <td width='<?php echo $half_width ?>'><i><?php echo $xHeader ?></i></td> 
      <td width='<?php echo $half_width ?>'><i><?php echo $yHeader ?></i></td> 
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