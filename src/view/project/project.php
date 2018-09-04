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

  if ($_POST["finish_date"]) {
    $finishDate = $_POST["finish_date"];
  } elseif ($this->project) {
    $finishDate = $this->project->getFinishDate();
  }

  if ($_POST["template"]) {
    $templateId = $_POST["template"];
  } elseif ($this->project) {
    $templateId = $this->project->getTemplate()->getId();
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
  <?php if (!$this->project): ?>
    <h1 class="page-header">New Project</h1>
  <?php else: ?>
    <h1 class="page-header">Edit Project</h1>
  <?php endif; ?>
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
          <?php } else { ?>
            <div class="alert alert-info" role="alert">
              <strong>Please Note:</strong> Fields marked with <big>*</big> are obligatory
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
                <label for="name">Project's Name (*):</label>
                <input name="name" type="text" maxlength="50" class="form-control" id="name" placeholder="Name of project" value="<?=$name?>" />
              </div>
              <div class="form-group">
                <label for="description">Description (*):</label>
                <textarea rows="4" id="description" name="description" maxlength="1000" class="form-control" placeholder="Description of project"><?=$desription?></textarea>
              </div>
              <div class="form-group">
                <label for="link">Link (*):</label>
                <input name="link" type="text" maxlength="100" class="form-control" id="name" placeholder="http://website.domain" value="<?=$link?>" />
              </div>
              <div class="form-group">
                <label for="name">Evaluation ending date (*):</label>
                <div class="input-group date">
                    <input id="finishDate" autocomplete="off" name="finish_date" type="text" class="form-control" value="<?=$finishDate?>" placeholder="yyyy-mm-dd"/>
                    <span id="finishDateIcon" style="cursor:pointer;" class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>

              <div class="form-group">
                <label for="name">Template (*):</label>
                <div class="input-group">
                  <select id="template" name="template" id="template" class="form-control" <?php if (($this->project) && (count($this->project->getEvaluations()) > 0)) echo "disabled"; ?>>
                    <?php
                      foreach ($this->templateList as $template) { ?>
                      <option value="<?=$template->getId();?>" <?php if($templateId == $template->getId()) echo "selected"; ?>><?=$template->getName();?></option>
                    <?php } ?>
                  </select>
                  <span class="input-group-btn">
                    <a href="#" id="viewTemplate" href="#" class="btn btn-default" title="View Template"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                  </span>
                </div>
                <?php if (($this->project) && (count($this->project->getEvaluations()) > 0)): ?>
                  <small class="text-muted"><span class="glyphicon glyphicon-info-sign"></span> Is not possible to modify template, due to some evaluations have started.</small>
                <?php endif; ?>
              </div>

              <?php if ($this->adminView): ?>
                <div class="form-group">
                  <input value="1" name="active" type="checkbox" class="form-check-input" id="active" <?php if ($this->project->isActive()) echo 'checked="checked"'; ?>>
                  <label class="form-check-label" for="active">Active</label> <br />
                  <small class="text-muted"><span class="glyphicon glyphicon-info-sign"></span> By activating this option, evaluations will be allowed to be started.</small>
                </div>
              <?php endif; ?>

              <?php if(!$this->new): ?>
                <div class="form-group">
                  <input value="1" name="archived" type="checkbox" class="form-check-input" id="archived" <?php if (($this->project) && ($this->project->isArchived())) echo 'checked="checked"'; ?>>
                  <label class="form-check-label" for="archived">Archive Project</label><br />
                  <small class="text-muted"><span class="glyphicon glyphicon-info-sign"></span> By activating this option, the project will be archived and won't be shown to the evaluators.</small>
                </div>
              <?php endif; ?>

              <?php if(!$this->new): ?>
                  <?php if($this->project->isActive()): ?>
                    <h4>Assign Evaluators</h4>
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
                          value="<?=$user->getId();?>"><?="(".$user->getEntity().") ".$user->getName();?></option>
                      <?php } ?>
                  <?php endif?>  
              <?php endif?>
                </select>
              </div>
            <?php if(!$this->new): ?>
              <?php if($this->project->isActive()): ?>
                <div class="form-group">
                  <input value="1" name="email" type="checkbox" class="form-check-input" id="email">
                  <?php infoModal("infoModal", "Send and e-mail reminder", "Checking this option, it will be send an e-mail reminder with the newer project information to the all assigned users."); ?>
                  <label class="form-check-label" for="email">Send an e-mail reminder</label> <a href="#" title="Send a notification to all users with project's information." class="text-blue" data-toggle="modal" data-target="#infoModal"><span class="glyphicon glyphicon-info-sign"></span></a>
                </div>
              <?php endif; ?>
            <?php endif; ?>
              <?php if (($this->project) && (count($this->project->getEvaluations()) > 0)): ?>
                <div class="alert alert-warning" role="alert">
                  <span class="glyphicon glyphicon-info-sign"></span> <strong>Please note:</strong> Modifying this project, current evaluations may be affected.
                </div>
              <?php endif; ?>
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

<script>
  $(document).ready(function(){
    $('#finishDate').datepicker({ dateFormat: 'yy-mm-dd' });

    $('#finishDate').focus(function(){
        $('#finishDate').datepicker('show');
    });

    $('#finishDate').click(function(){
        $('#finishDate').datepicker('show');
    });

    $('#finishDateIcon').click(function(){
        $('#finishDate').datepicker('show');
    });
  });

  $("#viewTemplate").click(function(){
    window.open("/templates/view/" + $("#template").val());
  })
</script>
