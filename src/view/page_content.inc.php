<!-- #page-wrapper -->
<div id="page-wrapper" style="min-height:94vh">
  <?php
  if (empty($this->Content)) {
    include("home.php");
  } else {
    include($this->Content.".php");
  }
?>
</div>
<!-- /#page-wrapper -->
