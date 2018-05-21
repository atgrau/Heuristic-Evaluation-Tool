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
                <label for="name">Project's Name:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Name of project" value="">
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" placeholder="Description of project"></textarea>
              </div>
              <div class="form-group">
                <label for="link">Link:</label>
                <input name="link" type="text" class="form-control" id="name" placeholder="http://website.domain" value="">
              </div>
              <button type="submit" class="btn btn-success margin-r">Create Project</button>
              <a href="/my-projects" class="btn btn-danger">Cancel</a>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
