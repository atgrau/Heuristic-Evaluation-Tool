<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="/"><i class="glyphicon glyphicon-home"></i> Home</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Projects<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <li>
                    <a href="flot.html">Assigned Projects</a>
                </li>
                <li>
                    <a href="/my-projects">My Projects</a>
                </li>
              </ul>
            </li>
            <?php if ($GLOBALS["USER_SESSION"]->GetRole() >= 1) { ?>
              <li>
                  <a href="/projects/new"><i class="fa fa-edit fa-fw"></i> Create a new Project</a>
              </li>
            <?php } ?>
            <?php if ($GLOBALS["USER_SESSION"]->GetRole() >= 2) { ?>
              <li>
                  <a href="#"><i class="fa fa-wrench fa-fw"></i> Administration<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/users">Users</a>
                    </li>
                    <li>
                        <a href="/admin/projects">Projects</a>
                    </li>
                    <li>
                        <a href="/admin/template">Evaluation Template</a>
                    </li>
                  </ul>
                  <!-- /.nav-second-level -->
              </li>
            <?php } ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
