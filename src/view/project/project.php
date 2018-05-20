<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Nuevo Proyecto</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <?php if (isset($this->success)) { ?>
            <div class="alert alert-info" role="alert">
             <?php echo $this->success; ?>
            </div>
          <?php } else if (isset($this->error)) { ?>
            <div class="alert alert-danger" role="alert">
             <?php echo $this->error; ?>
            </div>
          <?php } ?>
            <form action="#" method="POST">
              <div class="form-group">
                <label for="name">Nombre del Proyecto:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nombre del Proyecto" value="">
              </div>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
