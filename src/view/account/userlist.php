<?php
function generateModal($user) {
return '<!-- Modal -->
<div class="modal fade" id="deletingModal_'.$user->getId().'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="text-danger">Remove User</strong>
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
        <strong>Import users</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="row alert alert-info margin" role="alert">
           <span class="glyphicon glyphicon-info-sign"></span> In order to import multiple users, you have to upload a <strong><span class="label label-primary">csv</span></strong> with the following format: <br />
           <em>[email],[entity],[firstname],[lastname]</em><br /><br /><strong>Note: </strong>Account passwords will be sent to their emails.
          </div>
           <div class="col-md-12">
             <form method="post" id="uploadForm" action="/admin/importcsv" class="dropzone needsclick dz-clickable" enctype="multipart/form-data">
               <input type="file" name="file" id="file" style="display:none" />
               <div class="dz-message needsclick" style="color:#666">
                 <h2>Drop files here or click to upload</h2>
                 <h1 class="glyphicon glyphicon-cloud-upload"></h1>
               </div>
              </form>
           </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="/admin/process-csv" title="Import CSV" class="btn btn-success">Import</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="massiveDeletingModal" tabindex="-1" role="dialog" aria-labelledby="massiveDeletingModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>Remove Users</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5><strong>Selected users </strong> and all his projects and evaluations <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h5>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a id="massiveDeleteBtn" href="#" title="Import CSV" class="btn btn-danger">Remove</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <h1 class="page-header">User Accounts</h1>
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/admin/new-user" title="Add new User" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new user</a>
  <a href="#" title="Import CSV File" class="btn btn-primary" data-toggle="modal" data-target="#importcsv_modal"><span id="importcsv_modal" class="glyphicon glyphicon-cloud-upload"></span> Import CSV File</a>

</div>


<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> User <strong><?= $this->recentUser; ?></strong> has beed added successfully!
  </div>
<?php elseif (isset($this->success)): ?>
    <div class="alert alert-info" role="alert">
     <?php echo $this->success; ?>
    </div>
  <?php elseif ($this->removedUsers): ?>
      <div class="alert alert-info" role="alert">
       <span class="glyphicon glyphicon-info-sign"></span> Some users have been removed:
       <?php foreach ($this->removedUsers as $removedUser) { ?>
         <li><?=$removedUser->getName()?></li>
        <?php } ?>
      </div>
<?php elseif (isset($this->error)): ?>
    <div class="alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-info-sign"></span> <strong>Error importing users:</strong>
      <ul>
        <?php echo $this->error; ?>
      </ul>
    </div>
  <?php elseif (isset($this->importedUsers)): ?>
    <div class="alert alert-info" role="alert">
      <span class="glyphicon glyphicon-info-sign"></span> <strong>The following users has been imported successfully:</strong>
      <ul>
        <?php echo $this->importedUsers; ?>
      </ul>
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
          <input name="q" type="text" class="form-control input" placeholder="Search by first name, last name, email, entity..." value="<?= $this->query; ?>" />
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
  <a href="#" class="btn btn-xs btn-danger left" title="Remove users" data-toggle="modal" data-target="#massiveDeletingModal">Remove selected Users</a>
  <form id="usersForm" action="/admin/remove-users" method="POST">
    <table id="tableUsers" class="table table-hover">
      <thead class="thead-light" style="cursor:pointer">
        <tr>
          <th scope="col" width="5%"></th>
          <th scope="col" width="5%">#</th>
          <th scope="col" width="20%">Name</th>
          <th scope="col" width="25%">E-mail</th>
          <th scope="col" width="15%">Entity</th>
          <th scope="col" width="15%">Role</th>
          <th scope="col" width="5%">Status</th>
          <th scope="col" width="10%"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (!empty($this->userList)):
          foreach ($this->userList as $user) {
        ?>
          <tr>
            <th scope="row"><input type="checkbox" name="user_<?=$user->getId();?>" value="1" <?php if ($user->getId() == $GLOBALS["USER_SESSION"]->getId()) echo "disabled"; ?> /></th>
            <th scope="row"><?= ++$i; ?></th>
            <td><?= $user->getName(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td><?= $user->getEntity(); ?></td>
            <td><?= getRoleName($user->getRole()); ?></td>
            <td>
              <?php if ($user->isActive()): ?>
                <span class="label label-success">Actived</span>
              <?php else: ?>
                <span class="label label-danger">Inactive</span>
              <?php endif; ?>
            </td>
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
  </form>
  <?php
    if (!empty($this->userList)) {
      echo "<strong>Total Users:</strong> ".sizeof($this->userList);
    }
  ?>
</div>

<!-- /.row -->
<script src="/dist/js/dropzone.js"></script>

<script>
  $("#btnUpload").click(function() {
    $("#uploadForm").submit();
  });

  $(document).ready(function() {
    $('#tableUsers').DataTable( {searching: false, "bInfo": false, "language": {
      "emptyTable": "No users found..."
    },
        "order": [[ 0, "asc" ]]
    } );

  });

  $("#massiveDeleteBtn").click(function() {
    $('#usersForm').submit();
  })
</script>
