<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
chdir('../examples');
$files = glob("*.php");
?>
<table>
  <tr><th colspan='2' align='left'>Examples</th></tr>
  <tr><td colspan='2'><br></td></tr>
  <?php
  foreach($files as $file) {
    ?>
    <tr><td><a href="examples.php?src=<?php echo $file; ?>#source"><?php echo $file; ?></a></td><td><a href="../examples/<?php echo $file; ?>">(execute)</a></td></tr>
    <?php
   }
  ?>
</table>
<?php
if(isset($_GET['src'])) {
  ?>
  <hr />
  <div id="source">
    <code>
    <?php highlight_file(basename($_GET['src'])); ?>
    </code>
  </div>
  <hr />
  <?php
}
chdir('../docs');
include_once "includes/footer.php";
?>