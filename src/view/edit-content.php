<div class="row">
  <div class="col-lg-12">
    <h2>Edit Content</h2>
    <?php if ($this->saved): ?>
      <div class="alert alert-info" role="alert">
       <span class="glyphicon glyphicon-info-sign"></span> Saved
      </div>
    <?php endif; ?>

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
            $change0 = "active";
            $change1 = "";
          } else {
            $change0 = "";
            $change1 = "active";
          }
        ?>
        <ul class="nav nav-tabs">
            <li class="<?php echo $change0; ?>">
              <a href="#home" data-toggle="tab">Home</a>
            </li>
            <?php if(!$this->admin): ?>
            <li class="<?php echo $change1; ?>">
              <a href="#about-us" data-toggle="tab">About Us</a>
            </li>
          <?php endif; ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in <?php echo $change0; ?>" id="home">
              <form id="postForm" method="POST" action="/admin/content" enctype="multipart/form-data" onsubmit="return postForm()">
                <input type="hidden" name="entry" value="home" />
                <textarea id="summernote" name="content">
                  <?=$this->getHomeContent()?>
                </textarea>
                <div class="margin-b right">
                  <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade in <?php echo $change1; ?>" id="about-us">
              <form id="postForm2" method="POST" action="/admin/content" enctype="multipart/form-data" onsubmit="return postForm()">
                <input type="hidden" name="entry" value="about-us" />
                <textarea id="summernote2" name="content">
                  <?=$this->getAboutUsContent()?>
                </textarea>
                <div class="margin-b right">
                  <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                </div>
              </form>
            </div>
        </div>
    </div>
    <!-- /.panel-body -->

  </div>
</div>

<script>
  $('#summernote').summernote({
    placeholder: 'Enter here home page content...',
    tabsize: 2,
    height: 300
  });

  $('#summernote2').summernote({
    placeholder: 'Enter here about us page content...',
    tabsize: 2,
    height: 300
  });

  var postForm = function() {
  	var content = $('textarea[name="content"]').html($('#summernote').code());
  }

  var postForm = function() {
    var content = $('textarea[name="content"]').html($('#summernote2').code());
  }
</script>
