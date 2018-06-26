<button id="topButton" title="Go to top"><span class="glyphicon glyphicon-menu-up"></span></button>
<div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Evaluation</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
  <form id="evaluation_form">
    <div id="result" style="display:none"></div>
    <input name="id_evaluation" type="hidden" value="<?=$this->evaluation->getId();?>">
    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="right">
            <a class="btn btn-default" id="hideButton" href="#"><span class="glyphicon glyphicon-eye-close"></span> Hide Sidebar</a>
            <a style="display:none" class="btn btn-default" id="showButton" href="#"><span class="glyphicon glyphicon-eye-open"></span> Show Sidebar</a>
            <a href="/evaluations" class="btn btn-primary"><span class="glyphicon glyphicon-menu-left"></span> Project List</a>
            <button id="save" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
          </div>
          <ul class="nav nav-tabs">
              <li class="active">
                <a href="#template" data-toggle="tab">Evaluation</a>
              </li>
              <li>
                <a href="#project" data-toggle="tab">View Project</a>
              </li>
          </ul>
          <div class="tab-content">

            <div class="tab-pane fade in active margin-lg-t" id="template">

              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th colspan="2">Categoría 1</th>
                    <th>Answer</th>
                    <th>Comments</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" width="20px">#1</th>
                    <td width="50%">Pregunta nº 1</td>
                    <td width="20%">
                      <div class="form-group">
                        <select name="role" class="form-control">
                          <option value="0">Evaluator</option>
                          <option value="1">Project Manager</option>
                          <option value="2">Administrator</option>
                        </select>
                       </div>
                    </td>
                    <td width="30%">
                      <div class="form-group">
                        <textarea class="form-control" maxlength="50"></textarea>
                       </div>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>

            <div class="tab-pane fade in margin-lg-t" id="project" >
              <iframe name="iframe" width="100%" style="min-height:94vh" src="//www.eps.udl.cat/ca/" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
        <!-- /.panel-body -->
    </div>
  </form>
</div>
<!-- /.row -->

<script>
  // Hide SidebarButton
  $("#hideButton").click(function() {
    $("#sidebar").hide("fast");
    $("#hideButton").hide("fast");
    $("#showButton").show("fast");
    $('#page-wrapper').css('margin-left', '0');
  });

  // Show SidebarButton
  $("#showButton").click(function() {
    $("#sidebar").show( "fast");
    $("#showButton").hide("fast");
    $("#hideButton").show("fast");
    $('#page-wrapper').css('margin-left', '250px');
  });

  // Save Button
  $("#save").click(function(){
    $.ajax({
        type:'POST',
        url:'/evaluation/update',
        data:$('#evaluation_form').serialize(),
        success:function(msg){
          $("#result").fadeIn("slow");
          $("#result").html(msg);
          $("#result").delay(2000).fadeOut("slow");
        }
    });
  });

  // Top Button
  window.onscroll = function() {scrollFunction()};
  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      $("#topButton").fadeIn( "slow");
    } else {
      $("#topButton").fadeOut( "slow");
    }
  }
  $("#topButton").click(function(){
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
</script>
