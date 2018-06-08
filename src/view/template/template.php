<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Evaluation Template</h1>
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
                <li class="<?php echo $active1; ?>">
                  <a href="#questions" data-toggle="tab">Questions</a>
                </li>
                <li class="<?php echo $active2; ?>">
                  <a href="#answers" data-toggle="tab">Answers</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in <?php echo $active0; ?>" id="categories">
                  <?php
                  if (!empty($this->categoriesList)):
                  foreach ($this->categoriesList as $category) { ?>
                    <form class="margin margin-lg-t" method="POST" action="">
                      <div class="form-group">
                        <label for="category">Category Name:</label>
                        <input name="category" type="text" class="form-control" id="category" placeholder="Category name" value="<?= $category->getName(); ?>">
                      </div>
                      <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                    </form>
                  <?php } ?>
                <?php endif; ?>
                <br />
                <a href="#" title="Add new Category" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new category</a>
                </div>

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
                </div>
                <div class="tab-pane fade in <?php echo $active2; ?>" id="answers">
                  <form class="margin margin-lg-t" method="POST" action="">
                    <div class="form-group">
                      <label for="entity">Answer:</label>
                      <input name="entity" type="text" class="form-control" id="entity" placeholder="Organización" value="">
                    </div>
                    <br />
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                  </form>
                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
