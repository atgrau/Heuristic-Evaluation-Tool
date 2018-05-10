<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
              <?php echo APP_TITLE; ?>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <?php
      if (empty($this->content)) {
        include("home.php");
      } else {
        include($this->content.".php");
      }
    ?>
</div>
<!-- /#page-wrapper -->
