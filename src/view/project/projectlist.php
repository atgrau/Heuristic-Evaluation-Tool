<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Mis Proyectos</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/projects/new" title="Añadir nuevo Usuario" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Añadir nuevo Proyecto</a>
</div>
<div class="row margin-lg-b">
            <div id="custom-search-input">
              <form action="/my-projects" method="GET">
                <div class="input-group col-md-12">
                    <input name="q" type="text" class="form-control input" placeholder="Buscar por nombre o descripción..." value="<?= $this->query; ?>" />
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
              </form>
            </div>
	</div>
<div class="row">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Descripción</th>
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
            <td><?= $project->getName(); ?></td>
            <td><?= $project->getDescription(); ?></td>
            <td><?= $project->getLink(); ?> <a href="<?= $project->getLink(); ?>" target="_blank" title="Link a <?= $project->getName(); ?>"><span class="glyphicon glyphicon-link"></span></a></td>
            <td>
              <a href="/projects/<?= $project->getId(); ?>" title="Editar Proyecto"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
              <a href="#" title="Eliminar Proyecto" class="text-danger"><span class="glyphicon glyphicon-remove padding-l"></span></a>
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
      echo "No se han encontrado proyectos... <br /><br />";
    } else {
      echo "<strong>Total de Proyectos:</strong> ".sizeof($this->projectList);
    }
  ?>
</div>
<!-- /.row -->
