<?php
function generateModal($categoryId) {
return '<!-- Modal -->
<div class="modal fade" id="deletingModal_'.$categoryId.'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="text-danger">Category Deletion</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Category #'.$categoryId.' and all it related questions <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a name="" href="/admin/remove-category/'.$categoryId.'" type="button" class="btn btn-danger">Delete User</a>
      </div>
    </div>
  </div>
</div>';
}
?>
<div class="row">
<form class="margin margin-lg-t" method="POST" action="/templates/edit">
  <div class="row">
      <div class="col-lg-12">
        <?php if (!$this->editTemplate): ?>
          <h1 class="page-header"><?= $this->template->getName();?></h1>
        <?php else: ?>
          <div class="form-group">
            <input name="template" type="text" class="form-control input-lg" placeholder="Template name" value="<?= $this->template->getName();?>" >
          </div>
        <?php endif; ?>
      </div>
  </div>
<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> Template <strong><?= $this->recentProject; ?></strong> has beed added successfully!
  </div>
<?php endif; ?>
<?php if ($this->editTemplate): ?>
<div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>New  Category </strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="category">Category Name:</label>
            <input name="category" type="text" class="form-control" id="category" placeholder="Category name" value="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        </div>

    </div>
  </div>
</div>
<?php endif; ?>
</form>
</div>
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
            <!-- Nav tabs -->
            <?php
              if ($this->tab == 0) {
                $active0 = "active";
                $active1 = "";
                $active2 = "";
              } else if ($this->tab == 1){
                $active0 = "";
                $active1 = "active";
                $active2 = "";
              } else {
                $active0 = "";
                $active1 = "";
                $active2 = "active";
              }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?php echo $active0; ?>">
                  <a href="#categories" data-toggle="tab">Categories</a>
                </li>
                <!--<li class="<?php echo $active1; ?>">
                  <a href="#questions" data-toggle="tab">Questions</a>
                </li>-->
                <li class="<?php echo $active2; ?>">
                  <a href="#answers" data-toggle="tab">Answers</a>
                </li>
            </ul>
            <!-- Tab panes -->

            <div class="tab-content">
                <div class="tab-pane fade in <?php echo $active0; ?>" id="categories">
                  <?php if ($this->editTemplate): ?>
                    <div class="form-group margin-l margin-lg-t">
                      <a data-toggle="modal" data-target="#newCategoryModal" href="#" title="Add new Category" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new category</a>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($this->categoriesList)):
                          foreach ($this->categoriesList as $category) { ?>
                            <form class="margin margin-lg-t" method="POST" action="/admin/set-category">
                              <div class="form-group">
                                <label for="category"><?php echo $category->getName(); ?></label>
                                <?php if (!empty($this->questionList)):
                                      foreach ($this->questionList as $question) {
                                        if($question->getCategory() == $category->getId()): ?>
                                            <input name="category" type="text" class="form-control" id="category" placeholder="Category name" value="<?php echo $question->getQuestion(); ?>">
                                        <?php endif;
                                    }
                                  endif; ?>

                              </div>
                              <?php if ($this->editTemplate): ?>
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                              <?php endif; ?>
                            </form>
                            <?php } ?>

                    <?php endif; ?>
                </div>

<!--
                <div class="tab-pane fade in <?php echo $active1; ?>" id="questions">
                  <form class="margin margin-lg-t" method="POST" action="">
                    <div class="form-group">
                      <label for="category">Category:</label>
                      <select id="category" name="category" class="form-control">
                        <option value="0">Category 1</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="question">Question:</label>
                      <input name="question" type="text" class="form-control" id="question" placeholder="Question" value="">
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                  </form>
                </div>-->
                <div class="tab-pane fade in <?php echo $active2 ; ?>" id="answers">
                  <form class="margin margin-lg-t" method="POST" action="">
                    <div class="form-group">
                    <?php if (!empty($this->answerList)):
                        foreach ($this->answerList as $answer) { ?>
                          <label for="entity"><?php echo $answer->getAnswer(); ?></label>
                          <input name="entity" type="text" class="form-control" id="entity" placeholder="Organización" value="<?php echo $answer->getValue();?>" readonly>
                        <?php } ?>
                    <?php endif; ?>
                    </div>
                    <br />
                      <?php if ($this->editTemplate): ?>
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                      <?php endif ?>
                  </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
