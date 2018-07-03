<?php
function generateModal($template) {
return '<!-- Modal -->
<div class="modal fade" id="deletingModal_'.$template->getId().'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="text-danger">Template Deletion</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Template <strong>'.$template->getName().'</strong> and all related relations <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="/admin/template-remove/'.$template->getId().'" type="button" class="btn btn-danger">Delete Project</a>
      </div>
    </div>
  </div>
</div>';
}
?>

<div class="modal fade" id="template_modal" tabindex="-1" role="dialog" aria-labelledby="templateModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>New Template</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="/templates/new/<?php $_POST["name"]?>" method="POST">
        <div class="modal-body">
              <input name="name" type="text" class="form-control input" placeholder="Template Name" value="" />
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><span data-dismiss="modal"></span>Accept</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Templates</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if ($this->admin): ?>
<div class="row margin-lg-b">
  <a href="#"  title="Create new template" class="btn btn-primary" data-toggle="modal" data-target="#template_modal"><span id="template_modal" class="glyphicon glyphicon-plus"></span> Add new Template</a>
</div>
<?php endif; ?>

<?php if ($this->error): ?>
  <div class="row alert alert-danger" role="alert">
   <span class="glyphicon glyphicon-remove"></span> <?=$this->error; ?>
  </div>
<?php endif; ?>
<form action="" method="GET">
  <div class="row margin-lg-b">
    <div id="custom-search-input">
      <div class="input-group col-md-12">
        <input name="q" type="text" class="form-control input" placeholder="Search by name ..." value="" />
        <span class="input-group-btn">
        <button class="btn btn-primary btn" type="submit">
        <i class="glyphicon glyphicon-search"></i>
        </button>
        </span>
      </div>
    </div>
  </div>
</form>
<div class="row">
  <table class="table table-hover">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Template's Name</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($this->templateList)):
      foreach ($this->templateList as $template) { ?>
          <tr>
            <?= generateModal($template); ?>
            <th scope="row"><?=++$te; ?></th>
            <td><a href="/admin/templates/<?= $template->getId(); ?>?edit=0" title="<?= $template->getName(); ?> "><?=$template->getName(); ?></a> </td>
            <td>
              <?php if ($template->getEvaluations()): ?>
              <span class="label label-danger">In use</span>
              <?php elseif ($template->isActive() == 0): ?>
              <span class="label label-warning">Inactive</span>
              <?php else: ?>
              <span class="label label-success">Active</span>
              <?php endif; ?>
            <td>
              <?php
              if ($template->getId() != 1):?>
                <a class="<?php if ($template->getEvaluations()): echo "disabled"; endif;?>" href="/admin/templates/<?= $template->getId();?>?edit=1" title="Edit template"><span class="glyphicon glyphicon-pencil"></span></a>
                <span class="margin-l"></span>
                <a class="text-danger <?php if ($template->getEvaluations()): echo "disabled"; endif;?>" data-toggle="modal" data-target="#deletingModal_<?= $template->getId(); ?>" href="#" title="Remove template" ><span class="glyphicon glyphicon-remove"></span></a>
              <?php endif; ?>
            </td>
          </tr>
      <?php
      }
      endif;
      ?>
    </tbody>
  </table>
  <?php
    if (empty($this->templateList)) {
      echo "No templates found... <br /><br />";
    } else {
      echo "<strong>Total Templates:</strong> ".sizeof($this->templateList);
    }
  ?>
</div>
<!-- /.row -->
