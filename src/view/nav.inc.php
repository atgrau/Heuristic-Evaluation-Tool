<!-- Navigation -->
<nav id="top-nav" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/">
        <div class="logo"></div>
      </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right navbar-collapse">
        <!-- /.dropdown -->
        <span class="label label-<?php if ($GLOBALS["USER_SESSION"]->getRole() == 2) {echo "danger";} elseif($GLOBALS["USER_SESSION"]->getRole() == 1) {echo "info";} else {echo "primary";} ?>  margin-lg-r"><?= getRoleName($GLOBALS["USER_SESSION"]->getRole()); ?></span>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Evaluations">
                <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
              <?php
                $assignedProjects = $this->getMyAssignedProjects();
                if ($assignedProjects):
                foreach ($assignedProjects as $project) {
                  $evaluation = getEvaluationByProjectAndUser($project->getId(), $GLOBALS["USER_SESSION"]->getId());
                  if ($evaluation) {
                    $percentage = $evaluation->getPercentageDone();
                  } else {
                    $percentage = 0;
                  }
                  if ($percentage < 10) $style = "danger";
                  elseif (($percentage >= 10) && ($percentage < 100)) $style = "warning";
                  else $style = "success";
              ?>
              <li>
                  <a href="/evaluations/id/<?=$project->getId();?>" title="View evaluations">
                      <div>
                          <p>
                              <strong><?php if (strlen($project->getName()) > 22) { echo substr($project->getName(), 0, 22)."..."; } else { echo $project->getName(); } ?></strong>
                              <span class="pull-right text-muted"><?=$percentage;?>% completed</span>
                          </p>
                          <div class="progress progress-striped <?php if ($percentage < 100) echo "active";?>">
                              <div class="progress-bar progress-bar-<?=$style;?>" role="progressbar" aria-valuenow="<?=$percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percentage;?>%">
                                  <span class="sr-only"><?=$percentage;?>% Completado</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
            <?php } ?>
              <li>
                  <a class="text-center" href="/evaluations" title="View all projects">
                      <strong>View all active evaluations</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
            <?php else: ?>
              <li>
                  <a class="#" href="/evaluations" title="You have no assigned projects">
                      <strong>You have no assigned projects...</strong>
                  </a>
              </li>
            <?php endif; ?>
            </ul>
            <!-- /.dropdown-tasks -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown hide">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-tasks fa-fw"></i> Nuevo Proyecto
                          <span class="pull-right text-muted small">Hace 15 minutos</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <i class="fa fa-tasks fa-fw"></i> Nuevo Proyecto
                          <span class="pull-right text-muted small">Hace 55 minutos</span>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#">
                      <strong>Ver todas las Notificaciones</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Account">
                <?= $GLOBALS["USER_SESSION"]->getName(); ?> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="/account/profile"><i class="fa fa-user fa-fw"></i> My Account</a></li>
                <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <?php include("sidebar.inc.php"); ?>
</nav>
