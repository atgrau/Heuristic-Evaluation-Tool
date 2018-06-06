<?php include("head.inc.php"); ?>

<body>

    <div class="container"><br />
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
          <div class="logo-lg" style="margin: 0 auto 0 auto;margin-bottom:-80px;"></div>
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

  <?php include("JQuery.inc.php"); ?>

</body>

</html>
