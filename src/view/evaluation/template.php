<button id="topButton" title="Go to top"><span class="glyphicon glyphicon-menu-up"></span></button>
<div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Evaluation of: <small><?=$this->evaluation->getProject()->getName();?></small></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
  <table class="table">
    <thead>
    </thead>
    <tbody>
      <th colspan="2" class="thead-light text-center">Project Information</th>
      <tr>
        <th width="20%">Project's Name:</th>
        <td><?=$this->evaluation->getProject()->getName();?></td>
      </tr>
      <tr>
        <th>Project's Description:</th>
        <td><?=$this->evaluation->getProject()->getDescription();?></td>
      </tr>
      <tr>
        <th>Project's Link:</th>
        <td><a href="<?=$this->evaluation->getProject()->getLink();?>" target="_blank" title="Link to <?=$this->evaluation->getProject()->getLink();?>"><?=$this->evaluation->getProject()->getLink();?></a></td>
      </tr>
      <tr>
        <th>Ending Date:</th>
        <td><?=$this->evaluation->getProject()->getFinishDate();?></td>
      </tr>
    </tbody>
  </table>
  <form id="evaluation_form">
    <div id="result" style="display:none"></div>
    <input name="id_evaluation" type="hidden" value="<?=$this->evaluation->getId();?>">
    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="right">
            <a class="btn btn-default" id="hideButton" href="#"><span class="glyphicon glyphicon-eye-close"></span> Hide Sidebar</a>
            <a style="display:none" class="btn btn-default" id="showButton" href="#"><span class="glyphicon glyphicon-eye-open"></span> Show Sidebar</a>
            <button id="save" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
            <a href="/evaluations" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancel</a>
            <button id="finish" type="button" class="btn btn-warning disabled"><span class="glyphicon glyphicon-ok"></span> Finish</button>
          </div>
          <ul class="nav nav-tabs">
              <li class="active">
                <a href="#template" data-toggle="tab">Evaluation</a>
              </li>
              <li>
                <a href="#project" data-toggle="tab">View Project</a>
              </li>
              <li>
                <a href="#results" data-toggle="tab">View Results</a>
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
                </tbody>
              </table>

            </div>

            <div class="tab-pane fade in margin-lg-t" id="project" >
              <iframe name="iframe" width="100%" style="min-height:94vh" src="//<?=str_replace("http://", "", $this->evaluation->getProject()->getLink());?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="tab-pane fade in margin-lg-t" id="results" >
              <table class="table">
                <thead>
                </thead>
                <tbody>
                  <th colspan="3" class="thead-light text-center">My own results</th>
                  <tr>
                    <th width="20%">Total Questions:</th>
                    <td width="20%">80</td>
                  </tr>
                  <tr>
                    <th>Total answered Questions:</th>
                    <td>75</td>
                  </tr>
                  <tr>
                    <th>Score</th>
                    <td>65</td>
                  </tr>
                  <tr>
                    <th>Finished at:</th>
                    <td><?=$this->evaluation->getProject()->getFinishDate();?></td>
                  </tr>
                </tbody>
              </table>

              <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Pie Chart Example
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" width="472" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 472px; height: 400px;"></canvas><canvas class="flot-overlay" width="472" height="400" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 472px; height: 400px;"></canvas><div class="legend"><div style="position: absolute; width: 57px; height: 64px; top: 5px; right: 5px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:5px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,194,64);overflow:hidden"></div></div></td><td class="legendLabel">Series 0</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(175,216,248);overflow:hidden"></div></div></td><td class="legendLabel">Series 1</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(203,75,75);overflow:hidden"></div></div></td><td class="legendLabel">Series 2</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(77,167,77);overflow:hidden"></div></div></td><td class="legendLabel">Series 3</td></tr></tbody></table></div></div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>
              <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pie Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
      labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
      datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
      }]
  },
  options: {
      scales: {
          yAxes: [{
              ticks: {
                  beginAtZero:true
              }
          }]
      }
  }
});
</script>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

              <table class="table">
                <thead>
                </thead>
                <tbody>
                  <th colspan="2" class="thead-light text-center">Global Results</th>
                  <tr>
                    <th width="20%">Total Evaluations:</th>
                    <td><?=$this->evaluation->getProject()->getName();?></td>
                  </tr>
                  <tr>
                    <th>Project's Description:</th>
                    <td><?=$this->evaluation->getProject()->getDescription();?></td>
                  </tr>
                  <tr>
                    <th>Project's Link:</th>
                    <td><a href="<?=$this->evaluation->getProject()->getLink();?>" target="_blank" title="Link to <?=$this->evaluation->getProject()->getLink();?>"><?=$this->evaluation->getProject()->getLink();?></a></td>
                  </tr>
                  <tr>
                    <th>Ending Date:</th>
                    <td><?=$this->evaluation->getProject()->getFinishDate();?></td>
                  </tr>
                </tbody>
              </table>
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
          $("#result").delay(3000).fadeOut("slow");
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
