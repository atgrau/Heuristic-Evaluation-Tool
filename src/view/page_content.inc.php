<!-- #page-wrapper -->
<div id="page-wrapper" style="min-height:94vh">
  <?php
  if (empty($this->content)) {
    include("home.php");
  } else {
    include($this->content.".php");
  }
?>
</div>
<!-- /#page-wrapper -->
