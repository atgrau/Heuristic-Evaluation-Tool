<div class="row">
    <div class="col-lg-12">
      <?php if (!$this->project): ?>
        <h1 class="page-header">New Project</h1>
      <?php else: ?>
        <h1 class="page-header">Edit Project</h1>
      <?php endif; ?>
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
          <?php if (($this->project) && ($this->adminView)): ?>
            <form action="/admin/update-project" method="POST">
            <input type="hidden" name="id" value="<?=$this->project->getId(); ?>" />
          <?php elseif (($this->project) && (!$this->adminView)): ?>
            <form action="/projects/update" method="POST">
            <input type="hidden" name="id" value="<?=$this->project->getId(); ?>" />
          <?php else: ?>
            <form action="/projects/add" method="POST">
          <?php endif; ?>
              <div class="form-group">
                <label for="name">Project's Name:</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Name of project" value="<?php if($this->project) echo $this->project->getName();?>">
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" placeholder="Description of project"><?php if($this->project) echo $this->project->getDescription();?></textarea>
              </div>
              <div class="form-group">
                <label for="link">Link:</label>
                <input name="link" type="text" class="form-control" id="name" placeholder="http://website.domain" value="<?php if($this->project) echo $this->project->getLink();?>">
              </div>
              <button type="submit" class="btn btn-success margin-r"><span class="glyphicon glyphicon-floppy-disk"></span> Save Project</button>
              <?php if ($this->adminView): ?>
                <a href="/admin/projects" class="btn btn-danger">Cancel</a>
              <?php else: ?>
                <a href="/my-projects" class="btn btn-danger">Cancel</a>
              <?php endif; ?>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
