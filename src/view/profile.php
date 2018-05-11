<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Perfil de <?php echo $GLOBALS["UserSession"]->GetName(); ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <?php if (isset($this->Success)) { ?>
            <div class="alert alert-info" role="alert">
             <?php echo $this->Success; ?>
            </div>
          <?php } else if (isset($this->Error)) { ?>
            <div class="alert alert-danger" role="alert">
             <?php echo $this->Error; ?>
            </div>
          <?php } ?>
            <!-- Nav tabs -->
            <?php
              if ($this->Tab == 0) {
                $change0 = "active";
                $change1 = "";
              } else {
                $change0 = "";
                $change1 = "active";
              }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?php echo $change0; ?>">
                  <a href="#profile" data-toggle="tab">Datos personales</a>
                </li>
                <li class="<?php echo $change1; ?>">
                  <a href="#password" data-toggle="tab">Contraseña</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in <?php echo $change0; ?>" id="profile">
                  <form class="margin margin-lg-t" method="POST" action="/account/update-profile">
                    <div class="form-group">
                      <label for="email">Correo Electrónico:</label>
                      <input type="email" class="form-control" id="email" readonly placeholder="Introduzca un Email" value="<?php echo $GLOBALS["UserSession"]->GetEmail(); ?>">
                      <small id="emailHelp" class="form-text text-muted">La dirección de correo electrónico no se puede modificar.</small>
                    </div>
                    <div class="form-group">
                      <label for="firstname">Nombre:</label>
                      <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Nombre" value="<?php echo $GLOBALS["UserSession"]->GetFirstName(); ?>">
                    </div>
                    <div class="form-group">
                      <label for="lastname">Apellidos:</label>
                      <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Apellidos" value="<?php echo $GLOBALS["UserSession"]->GetLastName(); ?>">
                    </div>
                    <label>Sexo:</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbMale" value="0" <?php if ($GLOBALS["UserSession"]->GetGender() == 0) { echo "checked"; }?>>
                      <label class="form-check-label" for="cbMale">
                        Masculino
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbFemale" value="1" <?php if ($GLOBALS["UserSession"]->GetGender() == 1) { echo "checked"; }?>>
                      <label class="form-check-label" for="cbFemale">
                        Femenino
                      </label>
                    </div>
                    <br />
                    <div class="form-group">
                      <label for="entity">Organización:</label>
                      <input name="entity" type="text" class="form-control" id="entity" placeholder="Organización" value="<?php echo $GLOBALS["UserSession"]->GetEntity(); ?>">
                    </div>
                    <div class="form-group">
                      <label for="country">País:</label>
                      <select name="country" class="form-control">
                        <?php
                          foreach(GetCountries() as $country) {
                              if ($GLOBALS["UserSession"]->GetCountry()->GetIso() == $country->GetIso()) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                              echo "<option value='".$country->GetIso()."' ".$selected.">".$country->GetName()."</option>";
                          }
                        ?>


                     </select>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </form>
                </div>
                <div class="tab-pane fade in <?php echo $change1; ?>" id="password">
                  <form class="margin margin-lg-t" method="POST" action="/account/update-password">
                    <div class="form-group">
                      <label for="password">Contraseña Actual:</label>
                      <input name="password" type="password" class="form-control" id="password" placeholder="Introduzca un contraseña">
                    </div>
                    <div class="form-group">
                      <label for="newpassword">Nueva Contraseña:</label>
                      <input name="newpassword" type="password" class="form-control" id="newpassword" placeholder="Introduzca un contraseña">
                    </div>
                    <div class="form-group">
                      <label for="newpassword2">Repite la Nueva Contraseña:</label>
                      <input name="newpassword2" type="password" class="form-control" id="newpassword2" placeholder="Introduzca un contraseña">
                    </div>
                    <br />
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
