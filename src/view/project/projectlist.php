<?php
function generateModal($project, $admin) {
  if ($admin) {
    $linkRemove = "<a href='/admin/project-remove/".$project->getId()."' type='button' class='btn btn-danger'>Delete Project</a>";
  } else {
    $linkRemove = "<a href='/my-projects/remove/".$project->getId()."' type='button' class='btn btn-danger'>Delete Project</a>";
  }
  return '<!-- Modal -->
  <div class="modal fade" id="deletingModal_'.$project->getId().'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <strong class="text-danger">Project Deletion</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Project <strong>'.$project->getName().'</strong> and all related evaluations <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          '.$linkRemove.'
        </div>
      </div>
    </div>
  </div>';
}
?>

<div class="row">
  <?php if ($this->admin): ?>
    <h1 class="page-header">Projects</h1>
  <?php elseif ($this->edit): ?>
    <h1 class="page-header">My Projects</h1>
  <?php else: ?>
    <h1 class="page-header">Project Evaluations</h1>
  <?php endif; ?>
</div>
<!-- /.row -->
<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> Project <strong><?= $this->recentProject; ?></strong> has beed added successfully!
  </div>
<?php endif; ?>
<?php if ($this->editMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> Project <strong><?= $this->recentProject; ?></strong> has beed updated successfully!
  </div>
<?php endif; ?>
<?php if ($this->removeMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> Project <strong><?= $this->recentProject; ?></strong> has beed removed successfully!
  </div>
<?php endif; ?>
<form action="" method="GET">
  <div class="row margin-lg-b">
    <div id="custom-search-input">
      <div class="input-group col-md-12">
        <input name="q" type="text" class="form-control input" placeholder="Search by name..." value="<?= $this->query; ?>" />
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
  <table id="tableProject" class="table table-hover">
    <thead class="thead-light" style="cursor:pointer">
      <tr>
        <th scope="col" width="5%">#</th>
        <?php if ($this->admin): ?>
          <th scope="col">Owner</th>
        <?php endif; ?>
        <th scope="col">Project's Name</th>
        <th scope="col">Link</th>
        <th scope="col">Finishes at</th>
        <th scope="col" class="text-center">Status</th>
        <?php if ($this->edit): ?>
          <th scope="col">Manage</th>
        <?php else:?>
          <th scope="col" class="text-center">Percentage done</th>
          <th scope="col" class="text-center">Results</th>
        <?php endif;?>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($this->projectList)):
      foreach ($this->projectList as $project) {
        if (!$this->edit) {
          $link = "style='cursor:pointer' class='clickable-row' data-href='/evaluations/id/".$project->getId()."'";
        }
        ?>
          <tr <?=$link;?>>
            <?php
              $userId = $project->getId();
              if ($this->admin) {
                $admin = "?admin=1";
              }
              echo generateModal($project, $admin);
            ?>
            <th scope="row"><?= ++$i; ?></th>
            <?php if ($this->admin): ?>
              <td><a href="/admin/users/<?= $project->getUser()->getId(); ?>" title="<?= $project->getUser()->getName(); ?>'s profile"><?= $project->getUser()->getFirstName(); ?></a></td>
            <?php endif; ?>
            <td><?= $project->getName(); ?></td>
            <td><?= $project->getLink(); ?> <a href="<?= $project->getLink(); ?>" target="_blank" title="Link to <?= $project->getName(); ?>"><span class="glyphicon glyphicon-link"></span></a></td>
            <td><?= $project->getFinishDate(); ?></td>
            <?php if (!$this->edit): ?>
              <td class="text-center">
                <?php
                  $evaluation = getEvaluationByProjectAndUser($project->getId(), $GLOBALS["USER_SESSION"]->getId());
                  if (!$evaluation):
                    if (!$project->isClosed()):
                ?>
                  <span class="label label-success">Open</span>
                <?php else: ?>
                  <span class="label label-danger">Closed</span>
                <?php endif; ?>
                <?php
                  else:
                    if ((!$evaluation->getProject()->isClosed()) && ($evaluation->isFinished())):
                ?>
                  <span class="label label-warning">Finished</span>
                <?php elseif (!$evaluation->getProject()->isClosed()): ?>
                  <span class="label label-success">Open</span>
                <?php else: ?>
                  <span class="label label-danger">Closed</span>
                <?php endif; ?>
              <?php endif; ?>
              </td>
            <?php endif; ?>

            <?php if ($this->edit): ?>
              <td class="text-center" width="15%">
                <?php if ($project->isArchived()): ?>
                  <span class="label label-warning">Archived</span>
                <?php elseif (!$project->isActive()): ?>
                  <span class="label label-primary">Inactive</span>
                <?php elseif ($project->isClosed()): ?>
                  <span class="label label-danger">Closed</span>
                <?php else: ?>
                  <span class="label label-success">Open</span>
                <?php endif; ?>
              </td>
            <?php endif; ?>

            <?php if ($this->edit): ?>
              <td>
                <a href="/my-projects/results/<?= $project->getId(); ?><?php if ($this->admin) echo "?admin=1"; ?>" title="View Results"><span class="glyphicon glyphicon-eye-open"></span></a>
                <?php if ($this->admin): ?>
                  <span class="margin-l"></span>
                  <a href="/admin/projects/<?= $project->getId(); ?>" title="Edit Project"><span class="glyphicon glyphicon-pencil"></span></a>
                <?php else: ?>
                  <span class="margin-l"></span>
                  <a href="/my-projects/edit/<?= $project->getId(); ?>" title="Edit Project"><span class="glyphicon glyphicon-pencil"></span></a>
                <?php endif; ?>
                <span class="margin-l"></span>
                <a data-toggle="modal" data-target="#deletingModal_<?= $project->getId(); ?>" href="#" title="Remove Project" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
              </td>
            <?php else: ?>
              <td width="15%" class="text-center">
                <?php
                  if ($evaluation)
                    $percent = $evaluation->getPercentageDone();
                  else
                    $percent = 0;
                ?>
                <?php if ($percent == 100): ?>
                <span class="label label-success"><?="100%";?></span>
              <?php elseif ($percent == 0): ?>
                <span class="label label-danger"><?="0%";?></span>
              <?php else: ?>
                <span class="label label-warning"><?=$percent."%";?></span>
                <?php endif; ?>
              </td>
              <td width="10%" class="text-center">
                <?php if($evaluation): ?>
                  <a href="/evaluations/id/<?= $project->getId(); ?>?tab=results" title="View Results"><span class="glyphicon glyphicon-eye-open"></span></a>
                <?php endif; ?>
              </td>
            <?php endif; ?>
          </tr>
      <?php
      }
      endif;
      ?>
    </tbody>
  </table>
  <?php
    if (!empty($this->projectList)) {
      echo "<strong>Total projects:</strong> ".sizeof($this->projectList);
    }
  ?>

  <?php if ((!$this->admin) && ($this->edit)): ?>
    <h1 class="page-header">My Archived Projects</h1>
    <table id="tableProjectArchived" class="table table-hover">
      <thead class="thead-light" style="cursor:pointer">
        <tr>
          <th scope="col" width="5%">#</th>
          <?php if ($this->admin): ?>
            <th scope="col">Owner</th>
          <?php endif; ?>
          <th scope="col">Project's Name</th>
          <th scope="col">Link</th>
          <th scope="col">Finishes at</th>
          <th scope="col" class="text-center">Status</th>
          <th scope="col">Manage</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($this->archivedProjectList)):
        foreach ($this->archivedProjectList as $project) {
          if (!$this->edit) {
            $link = "style='cursor:pointer' class='clickable-row' data-href='/evaluations/id/".$project->getId()."'";
          }
          ?>
            <tr <?=$link;?>>
              <?php
                $userId = $project->getId();
                if ($this->admin) {
                  $admin = "?admin=1";
                }
                echo generateModal($project, $admin);
              ?>
              <th scope="row"><?= ++$ii ?></th>
              <?php if ($this->admin): ?>
                <td><a href="/admin/users/<?= $project->getUser()->getId(); ?>" title="<?= $project->getUser()->getName(); ?>'s profile"><?= $project->getUser()->getFirstName(); ?></a></td>
              <?php endif; ?>
              <td><?= $project->getName(); ?></td>
              <td><?= $project->getLink(); ?> <a href="<?= $project->getLink(); ?>" target="_blank" title="Link to <?= $project->getName(); ?>"><span class="glyphicon glyphicon-link"></span></a></td>
              <td><?= $project->getFinishDate(); ?></td>

              <?php if ($this->edit): ?>
                <td class="text-center" width="15%">
                  <?php if ($project->isArchived()): ?>
                    <span class="label label-warning">Archived</span>
                  <?php elseif (!$project->isActive()): ?>
                    <span class="label label-primary">Inactive</span>
                  <?php elseif ($project->isClosed()): ?>
                    <span class="label label-danger">Closed</span>
                  <?php else: ?>
                    <span class="label label-success">Open</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>

              <?php if ($this->edit): ?>
                <td width="15%">
                  <a href="/my-projects/results/<?= $project->getId(); ?><?php if ($this->admin) echo "?admin=1"; ?>" title="View Results"><span class="glyphicon glyphicon-eye-open"></span></a>
                  <?php if ($this->admin): ?>
                    <span class="margin-l"></span>
                    <a href="/admin/projects/<?= $project->getId(); ?>" title="Edit Project"><span class="glyphicon glyphicon-pencil"></span></a>
                  <?php else: ?>
                    <span class="margin-l"></span>
                    <a href="/my-projects/edit/<?= $project->getId(); ?>" title="Edit Project"><span class="glyphicon glyphicon-pencil"></span></a>
                  <?php endif; ?>
                  <span class="margin-l"></span>
                  <a data-toggle="modal" data-target="#deletingModal_<?= $project->getId(); ?>" href="#" title="Remove Project" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
              <?php endif; ?>

            </tr>
        <?php
        }
        endif;
        ?>
      </tbody>
    </table>
  <?php endif; ?>
  <?php
    if ((!$this->admin) && ($this->edit)):
      if (!empty($this->archivedProjectList)) {
        echo "<strong>Total of archived projects:</strong> ".sizeof($this->archivedProjectList);
      }
    endif;
  ?>
</div>
<!-- /.row -->

<script>
  jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
      });
  });

  $(document).ready(function() {
    $('#tableProject').DataTable( {searching: false, "bInfo": false, "language": {
      "emptyTable": "No projects found..."
    },
        "order": [[ 0, "asc" ]]
    } );

  } );

  $(document).ready(function() {
    $('#tableProjectArchived').DataTable( {searching: false,  "bInfo": false, "language": {
      "emptyTable": "No projects found..."
    },
        "order": [[ 0, "asc" ]]
    });

  });
</script>
