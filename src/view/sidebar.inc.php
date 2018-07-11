<div id="sidebar" class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <li>
              <a href="/" rel="/"><i class="glyphicon glyphicon-home"></i> Home</a>
          </li>
          <li>
              <a href="/about-us" rel="/about-us"><i class="glyphicon glyphicon-info-sign"></i> About Us</a>
          </li>
            <li>
                <a href="/evaluations" rel="/evaluations"><i class="glyphicon glyphicon-tasks"></i> Project Evaluations (<?=$this->numberOfEvaluations();?>)</a>
            </li>
            <?php if ($GLOBALS["USER_SESSION"]->GetRole() >= 1) { ?>
              <li>
                <a href="#"><i class="glyphicon glyphicon-folder-close"></i> Manage Projects<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                  <li>
                      <a href="/my-projects/new" rel="/projects/new"><i class="glyphicon glyphicon-plus"></i> New Project</a>
                  </li>
                  <li>
                      <a href="/my-projects" rel="/my-projects"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; My Projects</a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <?php if ($GLOBALS["USER_SESSION"]->GetRole() >= 2) { ?>
              <li>
                  <a href="#"><i class="glyphicon glyphicon-wrench"></i> Administration<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                    <li class="in">
                        <a href="/admin/users" rel="/admin/user"><i class="fa fa-user fa-fw"></i> Users</a>
                    </li>
                    <li>
                        <a href="/admin/projects" rel="/admin/project"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Projects</a>
                    </li>
                    <li>
                        <a href="/admin/templates" rel="/templates"><i class="glyphicon glyphicon-th-list"></i> Evaluation Template</a>
                    </li>
                    <li>
                        <a href="/admin/content" rel="/admin/content"><i class="glyphicon glyphicon-pencil"></i> Edit Content</a>
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
