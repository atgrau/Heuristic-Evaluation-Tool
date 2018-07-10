<!-- #page-wrapper -->
<div id="page-wrapper" style="min-height:100vh">
  <div class="row">
    <div class="margin-lg-t"></div>
    <nav id="breadcrumb" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <?=$this->getBreadcrumb();?>
      </ol>
    </nav>
  </div>

  <?php
  if (empty($this->content)) {
    include("home.php");
  } else {
    include($this->content.".php");
  }
?>
</div>
<!-- /#page-wrapper -->
