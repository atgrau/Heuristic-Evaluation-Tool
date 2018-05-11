<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Usuarios del Sistema</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
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
  foreach (GetUsers() as $user) { ?>
      <tr>
        <th scope="row"><?php echo $user->GetId(); ?></th>
        <td><?php echo $user->GetName(); ?></td>
        <td><?php echo $user->GetEmail(); ?></td>
        <td><?php echo $user->GetRoleName(); ?></td>
        <td>
          <a href="#" title="Editar Usuario"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
          <a href="#" title="Eliminar Usuario" class="text-danger"><span class="glyphicon glyphicon-remove padding-l"></span></a>
        </td>
      </tr>
  <?php } ?>
</tbody>
</table>
</div>
<!-- /.row -->
