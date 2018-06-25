<div class="row">
    <div class="col-lg-12">
      <?php if ($this->new): ?>
        <h1 class="page-header">New User</h1>
      <?php else: ?>
        <h1 class="page-header"><?= $this->user->getName(); ?>'s profile</h1>
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
                    <input type="hidden" name="UserId" value="<?php if(!$this->new) echo $this->user->getId(); ?>" />
                    <div class="form-group">
                      <label for="email">E-mail:</label>
                      <input autofocus name="email" type="email" class="form-control disabled" id="email" <?php if(!$this->new) echo "disabled" ; ?> placeholder="E-mail" value="
                      <?php
                        if (!$this->new)
                          echo $this->user->getEmail();
                        else
                          echo $_POST["email"];
                      ?>">
                      <?php if(!$this->new): ?>
                        <small id="emailHelp" class="form-text text-muted">E-mail cannot be modified.</small>
                      <?php endif; ?>
                    </div>
                    <?php if ($this->admin): ?>
                      <div class="form-group">
                        <label for="country">Rol:</label>
                        <select id="country" name="role" class="form-control">
                          <option value="0" <?php if ((!$this->new) && ($this->user->getRole() == 0)) echo "selected"; ?>>Evaluator</option>
                          <option value="1" <?php if ((!$this->new) && ($this->user->getRole() == 1)) echo "selected"; ?>>Project Manager</option>
                          <option value="2" <?php if ((!$this->new) && ($this->user->getRole() == 2)) echo "selected"; ?>>Administrator</option>
                        </select>
                       </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <label for="firstname">First name:</label>
                      <input name="firstname" maxlength="50" type="text" class="form-control" id="firstname" placeholder="First name" value="<?php
                        if (!$this->new)
                          echoDef($_POST["firstname"], $this->user->getFirstName());
                        else
                          echo $_POST["firstname"];
                      ?>">
                    </div>
                    <div class="form-group">
                      <label for="lastname">Last name:</label>
                      <input name="lastname" maxlength="50" type="text" class="form-control" id="lastname" placeholder="Last name" value="<?php
                        if (!$this->new)
                          echoDef($_POST["lastname"], $this->user->getLastName());
                        else
                          echo $_POST["lastname"];
                      ?>">
                    </div>
                    <label>Gender:</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbMale" value="0" <?php
                      if ($_POST["gender"] == "0") echo "checked";
                      else if ((!$this->new) && ($this->user->getGender() == 0)) { echo "checked"; }
                      else echo "checked"; ?>>
                      <label class="form-check-label" for="cbMale">
                        Male
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" id="cbFemale" value="1" <?php
                      if ($_POST["gender"] == "1") echo "checked";
                        else if ((!$this->new) && ($this->user->getGender() == 1)) { echo "checked"; }?>>
                      <label class="form-check-label" for="cbFemale">
                        Female
                      </label>
                    </div>
                    <br />
                    <div class="form-group">
                      <label for="entity">Entity:</label>
                      <input name="entity" type="text" maxlength="50" class="form-control" id="entity" placeholder="Organización" value="<?php
                        if (!$this->new)
                          echoDef($_POST["entity"], $this->user->getEntity());
                        else
                          echo $_POST["entity"];
                      ?>">
                    </div>
                    <div class="form-group">
                      <label for="country">Country:</label>
                      <select name="country" class="form-control">
                        <?php
                          foreach (getCountries() as $country) {
                              if (($_POST["country"] == $country->getIso())) {
                                $selected = "selected";
                              } else if ((!$this->new) && ($this->user->getCountry()->getIso() == $country->getIso() && $selected != "selected")) {
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
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                    <?php if($this->admin): ?>
                      <a href="/admin/users" title="User list" class="btn btn-danger">Cancel</a><br /><br />
                    <?php endif; ?>
                  </form>
                </div>
                <div class="tab-pane fade in <?php echo $change1; ?>" id="password">
                  <form class="margin margin-lg-t" method="POST" action="/account/update-password">
                    <div class="form-group">
                      <label for="password">Actual Password:</label>
                      <input name="password" type="password" class="form-control" id="password" placeholder="Enter a Password">
                    </div>
                    <div class="form-group">
                      <label for="newpassword">New Password:</label>
                      <input name="newpassword" type="password" class="form-control" id="newpassword" placeholder="Enter a Password">
                    </div>
                    <div class="form-group">
                      <label for="newpassword2">Repeat new Password:</label>
                      <input name="newpassword2" type="password" class="form-control" id="newpassword2" placeholder="Enter a Password">
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                  </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
