<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="/"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Proyectos Asignados<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="flot.html">Proyecto 1</a>
                    </li>
                    <li>
                        <a href="morris.html">Proyecto 2</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
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
                          <a href="panels-wells.html">Usuarios</a>
                      </li>
                      <li>
                          <a href="buttons.html">Plantilla de Evaluación</a>
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
