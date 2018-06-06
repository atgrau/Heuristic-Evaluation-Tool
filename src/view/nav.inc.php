<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
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

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <span class="label label-primary margin-lg-r"><?= getRoleName($GLOBALS["USER_SESSION"]->getRole()); ?></span>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Projects">
                <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-tasks">
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Proyecto 1</strong>
                              <span class="pull-right text-muted">40% Completado</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                  <span class="sr-only">40% Completado</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Proyecto 2</strong>
                              <span class="pull-right text-muted">100% Completado</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                  <span class="sr-only">100% Completado</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a href="#">
                      <div>
                          <p>
                              <strong>Proyecto 3</strong>
                              <span class="pull-right text-muted">10% Completado</span>
                          </p>
                          <div class="progress progress-striped active">
                              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                  <span class="sr-only">10% Completado</span>
                              </div>
                          </div>
                      </div>
                  </a>
              </li>
              <li class="divider"></li>
              <li>
                  <a class="text-center" href="#" title="See all projects">
                      <strong>See all projects</strong>
                      <i class="fa fa-angle-right"></i>
                  </a>
              </li>
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
                <li><a href="/account/profile"><i class="fa fa-user fa-fw"></i> Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Options</a>
                </li>
                <li class="divider"></li>
                <li><a href="/account/logout"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <?php include("sidebar.inc.php"); ?>
</nav>
