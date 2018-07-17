<?php include("head.inc.php"); ?>
<?php infoModal("aboutUsModal", "About Us", $this->getAboutUsContent()); ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="login-panel panel panel-default" style="min-width:350px;margin-top:70px">
                  <?php if ($this->content != "signin"): ?>
                    <div class="panel-heading">
                      <h3 class="panel-title text-center font-weight-bold">Recover Account</h3>
                    </div>
                  <?php else: ?>
                    <center><img class="margin-t" src="/dist/images/logo-lg.png" title="Heuristic Evaluation Tool" /></center>
                  <?php endif; ?>
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
                                <div class="form-group input-group">
                                  <span class="input-group-addon text-bold">@</span>
                                  <input class="form-control" placeholder="E-mail" name="email" type="email" <?php if (!$this->email) echo "autofocus"; ?> value="<?php echo $this->email; ?>">
                                </div>
                                <div class="form-group input-group">
                                  <span class="input-group-addon text-bold"><span class="fa fa-key"></span></span>
                                  <input class="form-control" placeholder="Password" name="password" type="password" value="" <?php if ($this->email) echo "autofocus"; ?>>
                                </div>
                                <div class="form-group">
                                    <a href="/forgot" title="Recover your account">Forgot your password?</a>
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
                            <?php if(!$this->recovered) { ?>
                              <div class="form-group">
                                Introduce your e-mail in order to recover your account:
                                <input class="form-control margin-t" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo $this->email; ?>">
                              </div>
                              <input type="submit" value="Recover Account" class="btn btn-success" />
                              <a class="btn btn-danger" href="/">Cancel</a>
                            <?php } else { ?>
                              <a href="/" title="Go to the Sign In page">Go Back</a>
                            <?php } ?>
                          </fieldset>
                        </form>
                      <?php elseif ($this->content == "reset"): ?>
                        <form role="form" method="POST" action="/forgot/generate">
                          <?php
                            $user = getUserByToken($this->token);
                            if ($user) {
                              echo "Hello <strong>".$user->getName()."</strong>, you have been requested a password reset.<br />";
                              echo "We can send you a new password using the following button. <br /><br />";
                              echo "<form action='/forgot/send' method='POST'>";
                              echo "<input name='token' type='hidden' value='".$this->token."' />";
                              echo "<input type='submit' class='btn btn-primary' title='Send me a new password' value='Yes, send me a new password' />";
                              echo "</form>";
                            } else {
                              header("Location: /");
                            }
                          ?>
                        </form>
                      <?php else: ?>
                        <?="We have <strong>sent you a new password</strong>. <br /><br />Click <a href='/' title='Sign in'>here</a> to sign in.";?>
                      <?php endif; ?>
                    </div>
                    <div class="row margin">
                      <div class="left text-bold">
                        <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?=EMAIL?>" title="Send us and E-mail"><?=EMAIL?></a>
                      </div>
                      <div class="right text-bold">
                        <a href="#" data-toggle="modal" data-target="#aboutUsModal" title="About Us">What is Heuristic Evaluation Tool?</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php include("JQuery.inc.php"); ?>
</body>

</html>
