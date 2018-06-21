<?php include("head.inc.php"); ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                      <?php if ($this->content == "signin"): ?>
                        <h3 class="panel-title text-center font-weight-bold">Sign In</h3>
                      <?php else: ?>
                        <h3 class="panel-title text-center font-weight-bold">Recover Account</h3>
                      <?php endif; ?>
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
                                <input type="hidden" name="uri" value="<?=$this->uri;?>" />
                                <input type="submit" value="Sign In" class="btn btn-lg btn-success btn-block" />
                            </fieldset>
                        </form>
                      <?php elseif ($this->content == "forgot"): ?>
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
                      <?php elseif ($this->content == "reset"): ?>
                        <form role="form" method="POST" action="/forgot/generate">
                          <?php
                            $user = getUserByToken($this->token);
                            if ($user) {
                              echo "Hello <strong>".$user->getName()."</strong>, you have been requested a password reset.<br />";
                              echo "We can send to your email a new password using the following button. <br /><br />";
                              echo "<form action='/forgot/send' method='POST'>";
                              echo "<input name='token' type='hidden' value='".$this->token."' />";
                              echo "<input type='submit' class='btn btn-primary' title='Send me a new password' value='Send me a new password' />";
                              echo "</form>";
                            } else {
                              header("Location: /");
                            }
                          ?>
                        </form>
                      <?php else: ?>
                        <?="We have <strong>send a new password</strong> to your <strong>email</strong>. <br /><br />Click <a href='/' title='Sign in'>here</a> to sign in.";?>
                      <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php include("JQuery.inc.php"); ?>
</body>

</html>
