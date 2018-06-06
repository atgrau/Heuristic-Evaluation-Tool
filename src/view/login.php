<?php include("head.inc.php"); ?>

<body>
    <div class="logo-lg" style="margin: 0 auto 0 auto;margin-bottom:-80px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center font-weight-bold">Sign In</h3>
                    </div>
                    <div class="panel-body">
                      <?php if ($this->content == "signin"): ?>
                        <form role="form" method="POST" action="/account/login">
                            <fieldset>
                              <?php if($this->required) { ?>
                                <div class="alert alert-warning" role="alert">
                                  <span class="glyphicon glyphicon-warning-sign"></span> You must Sign In in order to access to this content.
                                </div>
                              <?php } else if ($this->error) { ?>
                                <div class="alert alert-danger" role="alert">
                                  <span class="glyphicon glyphicon-remove-sign"></span> User credentials are not valid.
                                </div>
                              <?php } ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo $this->email; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <a href="/forgot">Forgot your password?</a>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" value="Sign In" class="btn btn-lg btn-success btn-block" />
                            </fieldset>
                        </form>
                      <?php else: ?>
                        <form role="form" method="POST" action="/forgot/send">
                            <fieldset>
                              <?php if($this->recovered) { ?>
                                <div class="alert alert-info" role="alert">
                                  <?= $this->recovered; ?>
                                </div>
                              <?php } else if ($this->error) { ?>
                                <div class="alert alert-danger" role="alert">
                                  <?= $this->error; ?>
                                </div>
                              <?php } ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Introduce your e-mail in order to recover your account" name="email" type="email" autofocus value="<?php echo $this->email; ?>">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" value="Recover Account" class="btn btn-lg btn-success btn-block" />
                                <a class="btn btn-danger btn-block" href="/">Cancel</a>
                            </fieldset>
                        </form>
                      <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php include("JQuery.inc.php"); ?>

</body>

</html>
