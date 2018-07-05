<?php
function generateModal($user) {
return '<!-- Modal -->
<div class="modal fade" id="deletingModal_'.$user->getId().'" tabindex="-1" role="dialog" aria-labelledby="deletingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="text-danger">User Deletion</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>User <strong>'.$user->getName().'</strong> and all his projects and evaluations <span class="bg-danger">will be removed too</span>.<br /><br />Are you sure?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a name="" href="/admin/user-remove/'.$user->getId().'" type="button" class="btn btn-danger">Delete User</a>
      </div>
    </div>
  </div>
</div>';
}
?>
<div class="modal fade" id="importcsv_modal" tabindex="-1" role="dialog" aria-labelledby="importingModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>Import CSV File</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="dragandrophandler">Drag & Drop Files Here</div>
      <div id="status1"></div>
      <script>
function sendFileToServer(formData,status)
{
    var uploadURL ="/admin/importcsv"; //Upload URL
    var extraData ={}; //Extra Data.
    var jqXHR=$.ajax({
            xhr: function() {
            var xhrobj = $.ajaxSettings.xhr();
            if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //Set progress
                        status.setProgress(percent);
                    }, false);
                }
            return xhrobj;
        },
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
        cache: false,
        data: formData,
        success: function(data){
            status.setProgress(100);

            $("#status1").append("File upload Done<br>");
        }
    });

    status.setAbort(jqXHR);
}

var rowCount=0;
function createStatusbar(obj)
{
     rowCount++;
     var row="odd";
     if(rowCount %2 ==0) row ="even";
     this.statusbar = $("<div class='statusbar "+row+"'></div>");
     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
     this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
     this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
     obj.after(this.statusbar);

    this.setFileNameSize = function(name,size)
    {
        var sizeStr="";
        var sizeKB = size/1024;
        if(parseInt(sizeKB) > 1024)
        {
            var sizeMB = sizeKB/1024;
            sizeStr = sizeMB.toFixed(2)+" MB";
        }
        else
        {
            sizeStr = sizeKB.toFixed(2)+" KB";
        }

        this.filename.html(name);
        this.size.html(sizeStr);
    }
    this.setProgress = function(progress)
    {
        var progressBarWidth =progress*this.progressBar.width()/ 100;
        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
        if(parseInt(progress) >= 100)
        {
            this.abort.hide();
        }
    }
    this.setAbort = function(jqxhr)
    {
        var sb = this.statusbar;
        this.abort.click(function()
        {
            jqxhr.abort();
            sb.hide();
        });
    }
}
function handleFileUpload(files,obj)
{
   for (var i = 0; i < files.length; i++)
   {
        var fd = new FormData();
        fd.append('file', files[i]);

        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name,files[i].size);
        sendFileToServer(fd,status);

   }
}
$(document).ready(function()
{
var obj = $("#dragandrophandler");
obj.on('dragenter', function (e)
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
obj.on('dragover', function (e)
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e)
{

     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;

     //We need to send dropped files to Server
     handleFileUpload(files,obj);
});
$(document).on('dragenter', function (e)
{
    e.stopPropagation();
    e.preventDefault();
});
$(document).on('dragover', function (e)
{
  e.stopPropagation();
  e.preventDefault();
  obj.css('border', '2px dotted #0B85A1');
});
$(document).on('drop', function (e)
{
    e.stopPropagation();
    e.preventDefault();
});

});
</script>
      <div class="row">
         <div class="col-md-4">
            <form action="/account/importcsv" class="search-form" method="POST">

              <table class="table table-hover">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th><input value="name"/></th>
                    <th><input value="@gmal..com"/></th>
                    <th><span class="glyphicon glyphicon-remove"></th>
                  </tr>
                <tbody>
              </table>

            </form>
         </div>
      </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <h1 class="page-header">List of Users</h1>
</div>
<!-- /.row -->
<div class="row margin-lg-b">
  <a href="/admin/new-user" title="Add new User" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new user</a>
  <a href="#"  title="Import CSV File" class="btn btn-primary" data-toggle="modal" data-target="#importcsv_modal"><span id="importcsv_modal" class="glyphicon glyphicon-cloud-upload"></span> Import CSV File</a>

</div>


<?php if ($this->addMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> User <strong><?= $this->recentUser; ?></strong> has beed added successfully!
  </div>
<?php elseif (isset($this->success)): ?>
    <div class="alert alert-info" role="alert">
     <?php echo $this->success; ?>
    </div>
<?php endif; ?>
<?php if ($this->removeMessage): ?>
  <div class="row alert alert-info" role="alert">
   <span class="glyphicon glyphicon-info-sign"></span> User <strong><?= $this->recentUser; ?></strong> has beed removed successfully!
  </div>
<?php endif; ?>
<div class="row margin-lg-b">
  <div id="custom-search-input">
    <form action="/admin/users" method="GET">
      <div class="input-group col-md-12">
          <input name="q" type="text" class="form-control input" placeholder="Search by first name, last name, email..." value="<?= $this->query; ?>" />
          <span class="input-group-btn">
              <button class="btn btn-primary btn" type="submit">
                  <i class="glyphicon glyphicon-search"></i>
              </button>
          </span>
      </div>
    </form>
  </div>
</div>
<div class="row">
  <table class="table table-hover">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Role</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        if (!empty($this->userList)):
        foreach ($this->userList as $user) {
      ?>
        <tr>
          <th scope="row"><?= ++$i; ?></th>
          <td><?= $user->getName(); ?></td>
          <td><?= $user->getEmail(); ?></td>
          <td><?= getRoleName($user->getRole()); ?></td>
          <td>
            <?php if ($user->isActive()): ?>
              <span class="label label-success">Actived</span>
            <?php else: ?>
              <span class="label label-danger">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <?= generateModal($user); ?>
            <a href="/admin/users/<?= $user->getId(); ?>" title="Editar Usuario"><span class="glyphicon glyphicon-pencil padding-l"></span></a>
            <span class="margin-l"></span>
            <a href="#" data-toggle="modal" data-target="#deletingModal_<?= $user->getId(); ?>" title="Eliminar Usuario" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
          </td>
        </tr>
      <?php
        }
        endif;
      ?>
    </tbody>
  </table>
  <?php
    if (empty($this->userList)) {
      echo "<span class='glyphicon glyphicon-info-sign'></span> No users found...";
    } else {
      echo "<strong>Total Users:</strong> ".sizeof($this->userList);
    }
  ?>
</div>

<!-- /.row -->
