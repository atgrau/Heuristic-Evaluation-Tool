<?php include("head.inc.php"); ?>

<body>

    <div class="container"><br />
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
          <h1 class="text-center"><?php echo APP_TITLE; ?></h1>
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Page not found</h3>
                </div>
                <div class="panel-body">
                  The requested URL <?= "<strong>".$this->requestedUri."</strong>"; ?> was not found on this server. <br />
                  Click <a href="#" onclick="parent.history.back();">here</a> to go back.
                </div>
            </div>
        </div>
      </div>
    </div>

  <?php include("botJQuery.inc.php"); ?>

</body>

</html>
