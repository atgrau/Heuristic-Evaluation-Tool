<script src="./path/to/dropzone.js"></script>
<?php
function generateModal($user) {
return '<!-- Modal -->
<div class="modal fade" id="deletingModal_'.$user->getId().'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="text-danger">User Deletion</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>User <strong>'.$user->getName().'</strong> and all his projects and evaluations <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a name="" href="/admin/user-remove/'.$user->getId().'" type="button" class="btn btn-danger">Delete User</a>
      </div>
    </div>
  </div>
</div>';
}
?>

<div class="modal fade" id="importcsv_modal" tabindex="-1" role="dialog" aria-labelledby="importingModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>Import CSV File</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/file-upload" class="dropzone" method="POST">
        <div class="modal-body">
          <div class="fallback">
            <input name="file" type="file" id="filename" />


              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th><input value="Ok"/></th>
                    <th><input value="@gmal..com"/></th>
                    <th><span class="glyphicon glyphicon-remove"></th>
                  </tr>
                <tbody>
              </table>

          </div>
        </div>
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <h1 class="page-header">List of Users</h1>
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/admin/new-user" title="Add new User" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new user</a>
  <a href="#"  title="Import CSV File" class="btn btn-primary" data-toggle="modal" data-target="#importcsv_modal"><span id="importcsv_modal" class="glyphicon glyphicon-cloud-upload"></span> Import CSV File</a>

</div>


<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> User <strong><?= $this->recentUser; ?></strong> has beed added successfully!
  </div>
<?php elseif (isset($this->success)): ?>
    <div class="alert alert-info" role="alert">
     <?php echo $this->success; ?>
    </div>
<?php endif; ?>
<?php if ($this->removeMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> User <strong><?= $this->recentUser; ?></strong> has beed removed successfully!
  </div>
<?php endif; ?>
<div class="row margin-lg-b">
  <div id="custom-search-input">
    <form action="/admin/users" method="GET">
      <div class="input-group col-md-12">
          <input name="q" type="text" class="form-control input" placeholder="Search by first name, last name, email..." value="<?= $this->query; ?>" />
          <span class="input-group-btn">
              <button class="btn btn-primary btn" type="submit">
                  <i class="glyphicon glyphicon-search"></i>
              </button>
          </span>
      </div>
    </form>
  </div>
</div>
<div class="row">
  <table class="table table-hover">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Role</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        if (!empty($this->userList)):
        foreach ($this->userList as $user) {
      ?>
        <tr>
          <th scope="row"><?= ++$i; ?></th>
          <td><?= $user->getName(); ?></td>
          <td><?= $user->getEmail(); ?></td>
          <td><?= getRoleName($user->getRole()); ?></td>
          <td>
            <?= generateModal($user); ?>
            <a href="/admin/users/<?= $user->getId(); ?>" title="Editar Usuario"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
            <span class="margin-l"></span>
            <a href="#" data-toggle="modal" data-target="#deletingModal_<?= $user->getId(); ?>" title="Eliminar Usuario" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
          </td>
        </tr>
      <?php
        }
        endif;
      ?>
    </tbody>
  </table>
  <?php
    if (empty($this->userList)) {
      echo "<span class='glyphicon glyphicon-info-sign'></span> No users found...";
    } else {
      echo "<strong>Total Users:</strong> ".sizeof($this->userList);
    }
  ?>
</div>

<!-- /.row -->
<script>
src="./path/to/dropzone.js">
$("div#myId").dropzone({ url: "/file/post" });
</script>
