<?php include("head.inc.php"); ?>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <h1 class="text-center"><?php echo APP_TITLE; ?></h1>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center font-weight-bold">Iniciar Sesión</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="/account/login">
                            <fieldset>
                              <?php if($this->required) { ?>
                                <div class="alert alert-warning" role="alert">
                                 Necesitas iniciar sesión para acceder a este contenido.
                                </div>
                              <?php } else if ($this->error) { ?>
                                <div class="alert alert-danger" role="alert">
                                 Las credenciales introducidas son incorrectas.
                                </div>
                              <?php } ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo $this->email; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" value="Entrar" class="btn btn-lg btn-success btn-block" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php include("botJQuery.inc.php"); ?>

</body>

</html>
