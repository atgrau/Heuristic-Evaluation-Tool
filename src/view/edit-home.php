<div class="row">
  <div class="col-lg-12">
    <?php if ($this->saved): ?>
      <div class="alert alert-info" role="alert">
       <span class="glyphicon glyphicon-info-sign"></span> Saved
      </div>
    <?php endif; ?>
    <form id="postForm" method="POST" action="/admin/home" enctype="multipart/form-data" onsubmit="return postForm()">
      <textarea id="summernote" name="content">
        <?=$this->getHomeContent()?>
      </textarea>
      <div class="margin-b right">
        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
      </div>
    </form>
  </div>
</div>

<script>
$('#summernote').summernote({
  placeholder: 'Enter here home page content...',
  tabsize: 2,
  height: 300
});

var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
}

</script>
