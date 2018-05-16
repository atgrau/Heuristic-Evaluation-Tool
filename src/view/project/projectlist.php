<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Mis Proyectos</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/admin/adduser" title="Añadir nuevo Usuario" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Añadir nuevo Usuario</a>
</div>
<div class="row margin-lg-b">
            <div id="custom-search-input">
              <form action="/admin/users" method="GET">
                <div class="input-group col-md-12">
                    <input name="q" type="text" class="form-control input" placeholder="Buscar" value="<?= $this->query; ?>" />
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
        <th scope="col">Email</th>
        <th scope="col">Rol</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $userList = GetUsers($_GET["q"]);
      foreach ($userList as $user) { ?>
          <tr>
            <th scope="row"><?= $user->GetId(); ?></th>
            <td><?= $user->GetName(); ?></td>
            <td><?= $user->GetEmail(); ?></td>
            <td><?= GetRoleName($user->GetRole()); ?></td>
            <td>
              <a href="/admin/profile/<?= $user->GetId(); ?>" title="Editar Usuario"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
              <a href="#" title="Eliminar Usuario" class="text-danger"><span class="glyphicon glyphicon-remove padding-l"></span></a>
            </td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php
    if (empty($userList)) {
      echo "No se han encontrado usuarios...";
    }
  ?>
</div>
<!-- /.row -->
