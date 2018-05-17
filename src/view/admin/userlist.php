<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Usuarios del Sistema</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/admin/add-user" title="Añadir nuevo Usuario" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Añadir nuevo Usuario</a>
</div>
<div class="row margin-lg-b">
  <div id="custom-search-input">
    <form action="/admin/users" method="GET">
      <div class="input-group col-md-12">
          <input name="q" type="text" class="form-control input" placeholder="Buscar por nombre, apellido o email..." value="<?= $this->query; ?>" />
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
        if (!empty($this->userList)):
        foreach ($this->userList as $user) {
      ?>
        <tr>
          <th scope="row"><?= $user->getId(); ?></th>
          <td><?= $user->getName(); ?></td>
          <td><?= $user->getEmail(); ?></td>
          <td><?= getRoleName($user->getRole()); ?></td>
          <td>
            <a href="/admin/profile/<?= $user->getId(); ?>" title="Editar Usuario"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
            <a href="#" title="Eliminar Usuario" class="text-danger"><span class="glyphicon glyphicon-remove padding-l"></span></a>
          </td>
        </tr>
      <?php
        }
        endif;
      ?>
    </tbody>
  </table>
  <?php
    if (empty($this->userList)) {
      echo "No se han encontrado usuarios... <br /><br />";
    } else {
      echo "<strong>Total de Usuarios:</strong> ".sizeof($this->userList);
    }
  ?>
</div>
<!-- /.row -->
