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

<?php if ($this->editTemplate): ?>
<div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/template/category-new/" method="POST">
            <div class="modal-header">
              <strong>New  Category </strong>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label for="category">Category Name:</label>
                <input name="categoryName" type="text" class="form-control" placeholder="Category name" />
                <input name="idTemplate" type="hidden" class="form-control" value=<?= $this->template->getId(); ?>/>
              </div>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="question">Questions :</label>
                <input name="question" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                <?php
                    function createInputQuestion()
                    {?>
                      <input name="question" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                  <?php }

                ?>
                <div class="input-group-prepend" style="float:left"></br>
                  <button class="btn btn-outline-secondary" >+</button>
                </div>
              </div></br>
            </div></br>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
              </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
</form>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg">
      <div class="right">
        <a href="/admin/templates" class="btn btn-primary"><span class="glyphicon glyphicon-menu-left"></span> Template List</a>
        <?php if($this->editTemplate): ?>
          <button id="save" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        <?php endif; ?>
      </div>
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
              } else {
                $active0 = "";
                $active1 = "active";
              }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?php echo $active0; ?>">
                  <a href="#categories" data-toggle="tab">Categories</a>
                </li>
                <li class="<?php echo $active1; ?>">
                  <a href="#answers" data-toggle="tab">Answers</a>
                </li>
            </ul>
            <!-- Tab panes -->

            <div class="tab-content">
                <div class="tab-pane fade in <?php echo $active0; ?>" id="categories">
                        <?php if ($this->editTemplate): ?>
                          <div class="form-group margin-r margin-rg-t"></br>
                            <a data-toggle="modal" data-target="#newCategoryModal" href="#" title="Add new Category" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new category</a>
                          </div>
                        <?php endif; ?>

                          <?php
                              if(!empty($this->template->getCategories())):
                                foreach ($this->template->getCategories() as $category) { ?>
                                    <table class="table">
                                      <tbody>
                                        <tr>
                                          <td width="70%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd"><h4> <?= $category->getName(); ?></h4></td>
                                          <?php if ($this->editTemplate):?>
                                            <td width="10%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd">
                                              <form action="/template/category-remove/" method="POST">
                                                <input name="idTemplate" type="hidden" class="form-control"  value="<?= $this->template->getId()?>"/>
                                                <input name="idCategory" type="hidden" class="form-control"  value="<?= $category->getId()?>"/>
                                                <button type="submit" class="btn btn-danger">Remove category</button>
                                              </form>
                                            </td>
                                          <?php endif; ?>
                                        </tr>
                                        <?php foreach ($category->getQuestions() as $question) { ?>
                                              <tr>
                                                <td width="70%"><?= $question->getName(); ?></td>
                                                <?php if ($this->editTemplate):?>
                                                <td width="10%">
                                                    <a href="/template/question-remove/<?= $question->getId()?>?del=<?=$this->template->getId();?>" title="Remove question" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                </td>
                                                <?php endif; ?>
                                              </tr>
                                          <?php } ?>
                                      </tbody>
                                    </table>

                                    <?php if ($this->editTemplate): ?>
                                      <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Insert question">
                                        <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" type="button">+</button>
                                        </div>
                                      </div>

                                    <?php endif; ?>
                          <?php } ?>

                          <?php else:?>
                            <div class="container">
                              <div class="alert alert-info" role="alert">
                                  <h4 class="alert-heading">Empty template!</h4>
                                  <p>You can create new categories </p>
                                  <hr>
                                  <p class="mb-0">Enter each category more questions and don't forget add your answer in next tab</p>
                              </div>
                            </div>
                        <?php  ?>
                      <?php endif;?>
                        </form>
                </div>


                <div class="tab-pane fade in <?php echo $active1 ; ?>" id="answers">
                  <form class="margin margin-lg-t" method="POST" action="">
                    <div class="form-group">
                          <table class="table">
                              <thead class="thead-light">
                                <tr>
                                  <th scope="col">Answer's name</th>
                                  <th scope="col">Value</th>
                                  <th scope="col">Colour</th>
                                  <th scope="col"></th>
                                </tr>
                              </thread>
                              <tbody>
                                <?php foreach ($this->template->getAnswers() as $answer) { ?>
                                <tr>
                                  <td width="10%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd"> <?= $answer->getName();?></td>
                                  <td width="10%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd"> <?= $answer->getValue();?></td>
                                  <td width="10%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd"></td>
                                  <?php if ($this->editTemplate):?>
                                  <td width="10%" style="border-bottom: 1px solid #ddd ; border-top: 0px solid #ddd">
                                      <span class="glyphicon glyphicon-remove"></span></a><br>
                                  </td>
                                  <?php endif; ?>
                                </tr>
                                  <?php } ?>
                              </tbody>
                          </table>

                    </div>
                    <br />
                      <?php if ($this->editTemplate): ?>
                          <table class="table">
                              <tbody>
                                  <tr>
                                      <td width="10%">
                                          <input name="answer" type="text" class="form-control" id="answer" placeholder="Insert answer..." value="" ></td>
                                      <td width="10%" >
                                        <input name="value" type="text" class="form-control" id="value" placeholder="Insert value..." value="" ></td>
                                      <td width="10%" >
                                        <input name="colour" type="text" class="form-control" id="answer" placeholder="Choose colour..." value="" ></td>
                                  </tr>
                              </tbody>
                          </table>
                      <?php endif ?>

                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>
</div>
<!-- /.row -->
