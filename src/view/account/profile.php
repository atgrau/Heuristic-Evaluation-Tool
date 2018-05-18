<div class="row">
    <div class="col-lg-12">
      <?php if ($this->new): ?>
        <h1 class="page-header">New User</h1>
      <?php else: ?>
        <h1 class="page-header">Perfil de <?= $this->user->getName(); ?></h1>
      <?php endif; ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <?php if($this->admin): ?>
            <a href="/admin/users" title="Listado de Usuarios" class="btn btn-primary">Volver al listado de Usuarios</a><br /><br />
          <?php endif; ?>
          <?php if (isset($this->success)) { ?>
            <div class="alert alert-info" role="alert">
             <?php echo $this->success; ?>
            </div>
          <?php } else if (isset($this->error)) { ?>
            <div class="alert alert-danger" role="alert">
             <?php echo $this->error; ?>
            </div>
          <?php } ?>
            <!-- Nav tabs -->
            <?php
              if ($this->tab == 0) {
                $change0 = "active";
                $change1 = "";
              } else {
                $change0 = "";
                $change1 = "active";
              }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?php echo $change0; ?>">
                  <a href="#profile" data-toggle="tab">Personal Data</a>
                </li>
                <?php if(!$this->admin): ?>
                <li class="<?php echo $change1; ?>">
                  <a href="#password" data-toggle="tab">Password</a>
                </li>
              <?php endif; ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in <?php echo $change0; ?>" id="profile">
                  <form class="margin margin-lg-t" method="POST" action="<?= $this->action; ?>">
                    <input type="hidden" name="UserId" value="<?= $this->user->getId(); ?>" />
                    <div class="form-group">
                      <label for="email">Correo Electrónico:</label>
                      <input type="email" class="form-control" id="email" readonly placeholder="E-mail" value="<?= $this->user->getEmail(); ?>">
                      <small id="emailHelp" class="form-text text-muted">La dirección de correo electrónico no se puede modificar.</small>
                    </div>
                    <?php if ($this->admin): ?>
                      <div class="form-group">
                        <label for="country">Rol:</label>
                        <select name="role" class="form-control">
                          <option value="0" <?php if ($this->user->getRole() == 0) echo "selected"; ?>>Evaluador</option>
                          <option value="1" <?php if ($this->user->getRole() == 1) echo "selected"; ?>>Responsable de Proyecto</option>
                          <option value="2" <?php if ($this->user->getRole() == 2) echo "selected"; ?>>Administrador</option>
                        </select>
                       </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <label for="firstname">Nombre:</label>
                      <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Nombre" value="<?php echoDef($_POST["firstname"], $this->user->getFirstName()); ?>">
                    </div>
                    <div class="form-group">
                      <label for="lastname">Apellidos:</label>
                      <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Apellidos" value="<?php echoDef($_POST["lastname"], $this->user->getLastName()); ?>">
                    </div>
                    <label>Sexo:</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbMale" value="0" <?php
                      if ($_POST["gender"] == "0") echo "checked";
                      else if ($this->user->getGender() == 0) { echo "checked"; }?>>
                      <label class="form-check-label" for="cbMale">
                        Masculino
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbFemale" value="1" <?php
                      if ($_POST["gender"] == "1") echo "checked";
                      else if ($this->user->getGender() == 1) { echo "checked"; }?>>
                      <label class="form-check-label" for="cbFemale">
                        Femenino
                      </label>
                    </div>
                    <br />
                    <div class="form-group">
                      <label for="entity">Organización:</label>
                      <input name="entity" type="text" class="form-control" id="entity" placeholder="Organización" value="<?php echoDef($_POST["entity"], $this->user->getEntity()); ?>">
                    </div>
                    <div class="form-group">
                      <label for="country">País:</label>
                      <select name="country" class="form-control">
                        <?php
                          foreach (getCountries() as $country) {
                              if ($_POST["country"] == $country->getIso()) {
                                $selected = "selected";
                              } else if ($this->user->getCountry()->getIso() == $country->getIso() && $selected != "selected") {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                              echo "<option value='".$country->getIso()."' ".$selected.">".$country->getName()."</option>";
                          }
                        ?>
                     </select>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success">Guardar</button>
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
                    <button type="submit" class="btn btn-success">Guardar</button>
                  </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
