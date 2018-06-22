<?php
  if ($_POST["name"]) {
    $name = $_POST["name"];
  } elseif ($this->project) {
    $name = $this->project->getName();
  }

  if ($_POST["description"]) {
    $desription = $_POST["description"];
  } elseif ($this->project) {
    $desription = $this->project->getDescription();
  }

  if ($_POST["link"]) {
    $link = $_POST["link"];
  } elseif ($this->project) {
    $link = $this->project->getLink();
  }

  if ($_POST["users"]) {
    $usersProject = array();
    foreach ($_POST["users"] as $user) {
      array_push($usersProject, getUserById($user));
    }
  } elseif (($this->project) && ($this->project->getUsers())) {
    $usersProject = $this->project->getUsers();
  }
?>
<div class="row">
    <div class="col-lg-12">
      <?php if (!$this->project): ?>
        <h1 class="page-header">New Project</h1>
      <?php else: ?>
        <h1 class="page-header">Edit Project</h1>
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
          <?php if (isset($this->error)) { ?>
            <div class="alert alert-danger" role="alert">
             <strong>Project has errors:</strong><br /><ul><?=$this->error; ?></ul>
            </div>
          <?php } ?>
          <?php if (($this->project) && ($this->adminView)): ?>
            <form action="/admin/project-update" method="POST">
            <input type="hidden" name="id" value="<?=$this->project->getId(); ?>" />
          <?php elseif (($this->project) && (!$this->adminView)): ?>
            <form action="/my-projects/update" method="POST">
            <input type="hidden" name="id" value="<?=$this->project->getId(); ?>" />
          <?php else: ?>
            <form action="/my-projects/add" method="POST">
          <?php endif; ?>
              <div class="form-group">
                <label for="name">Project's Name:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Name of project" value="<?=$name?>">
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" placeholder="Description of project"><?=$desription?></textarea>
              </div>
              <div class="form-group">
                <label for="link">Link:</label>
                <input name="link" type="text" class="form-control" id="name" placeholder="http://website.domain" value="<?=$link?>">
              </div>
              <?php if ($this->adminView): ?>
                <div class="form-group">
                  <input value="1" name="active" type="checkbox" class="form-check-input" id="active" <?php if ($this->project->isActive()) echo 'checked="checked"'; ?>>
                  <label class="form-check-label" for="active">Active</label>
                </div>
              <?php endif; ?>
              <h3>Asign Evaluators</h3>
              <div class="form-group">
              <select name="users[]" id="users" class="form-control selectpicker" data-live-search="true" multiple>
                <?php
                  $users = getUsers("");
                  foreach ($users as $user) { ?>
                    <option
                    <?php
                    if ($usersProject):
                      if (in_array($user, $usersProject)) echo " selected ";
                    endif;
                    ?>
                    value="<?=$user->getId();?>"><?=$user->getName();?></option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <input value="1" name="email" type="checkbox" class="form-check-input" id="email">
                <?php infoModal("infoModal", "Send and e-mail reminder", "Checking this option, it will be send an e-mail reminder with the newer project information to the all assigned users."); ?>
                <label class="form-check-label" for="email">Send an e-mail reminder</label> <a href="#" title="Send a notification to all users with project's information." class="text-blue" data-toggle="modal" data-target="#infoModal"><span class="glyphicon glyphicon-info-sign"></span></a>
              </div>
              <button type="submit" class="btn btn-success margin-r"><span class="glyphicon glyphicon-floppy-disk"></span> Save Project</button>
              <?php if ($this->adminView): ?>
                <a href="/admin/projects" class="btn btn-danger">Cancel</a>
              <?php else: ?>
                <a href="/my-projects" class="btn btn-danger">Cancel</a>
              <?php endif; ?>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
