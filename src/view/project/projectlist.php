<div class="row">
    <div class="col-lg-12">
      <?php if ($this->admin): ?>
        <h1 class="page-header">Projects</h1>
      <?php else: ?>
        <h1 class="page-header">My Projects</h1>
      <?php endif; ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if (!$this->admin): ?>
<div class="row margin-lg-b">
  <a href="/projects/new" title="Add new Project" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new Project</a>
</div>
<?php endif; ?>
<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> Project <strong><?= $this->recentProject; ?></strong> has beed added successfully!
  </div>
<?php endif; ?>
<form action="" method="GET">
  <div class="row margin-lg-b">
    <div id="custom-search-input">
      <div class="input-group col-md-12">
        <input name="q" type="text" class="form-control input" placeholder="Search by name or description..." value="<?= $this->query; ?>" />
        <span class="input-group-btn">
        <button class="btn btn-primary btn" type="submit">
        <i class="glyphicon glyphicon-search"></i>
        </button>
        </span>
      </div>
    </div>
  </div>
  <?php if ($this->admin): ?>
  <div class="row margin-lg-b">
    <div id="custom-search-select">
      <div class="input-group col-md-12">
        <div class="form-group">
          <label for="user">Project Manager:</label>
          <select name="user" class="form-control" onchange="this.form.submit()">
            <option value="">Any</option>
            <?php
            foreach (getUsersByRoleGreaterThan(0) as $user) {
              if (($_GET["user"] == $user->getId())) {
                $selected = "selected";
              } else {
                $selected = "";
              }
            echo "<option value='".$user->getId()."' ".$selected.">".$user->getName()."</option>";
            }
            ?>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
</form>
<div class="row">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <?php if ($this->admin): ?>
          <th scope="col">Owner</th>
        <?php endif; ?>
        <th scope="col">Project's Name</th>
        <th scope="col">Description</th>
        <th scope="col">Link</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($this->projectList)):
      foreach ($this->projectList as $project) { ?>
          <tr>
            <th scope="row"><?= $project->getId(); ?></th>
            <?php if ($this->admin): ?>
              <td><?= $project->getUser()->getName(); ?> <a href="/admin/profile/<?= $project->getUser()->getId(); ?>" title="<?= $project->getUser()->getName(); ?>'s profile"><span class="fa fa-external-link"></span></a></td>
            <?php endif; ?>
            <td><?= $project->getName(); ?></td>
            <td><?= $project->getShortDescription(); ?></td>
            <td><?= $project->getLink(); ?> <a href="<?= $project->getLink(); ?>" target="_blank" title="Link a <?= $project->getName(); ?>"><span class="glyphicon glyphicon-link"></span></a></td>
            <td>
              <a href="/projects/<?= $project->getId(); ?>" title="Edit Project"><span class="glyphicon glyphicon-pencil"></span></a>
              <span class="margin-l"></span>
              <a href="#" title="Remove Proyecto" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
          </tr>
      <?php
      }
      endif;
      ?>
    </tbody>
  </table>
  <?php
    if (empty($this->projectList)) {
      echo "No projects found... <br /><br />";
    } else {
      echo "<strong>Total projects:</strong> ".sizeof($this->projectList);
    }
  ?>
</div>
<!-- /.row -->
