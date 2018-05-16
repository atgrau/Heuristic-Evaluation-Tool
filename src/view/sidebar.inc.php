<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="/"><i class="glyphicon glyphicon-home"></i> Inicio</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Proyectos<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <li>
                    <a href="flot.html">Proyectos Asignados</a>
                </li>
                <li>
                    <a href="/my-projects">Mis Proyectos</a>
                </li>
              </ul>
            </li>
            <?php if ($GLOBALS["UserSession"]->GetRole() >= 1) { ?>
              <li>
                  <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Crear Nuevo Proyecto</a>
              </li>
            <?php } ?>
            <?php if ($GLOBALS["UserSession"]->GetRole() >= 2) { ?>
              <li>
                  <a href="#"><i class="fa fa-wrench fa-fw"></i> Administración<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/users">Usuarios</a>
                    </li>
                    <li>
                        <a href="/admin/projects">Proyectos</a>
                    </li>
                    <li>
                        <a href="/admin/template">Plantilla de Evaluación</a>
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
