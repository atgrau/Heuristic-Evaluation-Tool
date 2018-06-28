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
        <tr>
          <th>Status:</th>
          <td><span class="text-success">Open</span></td>
        </tr>
      </tbody>
    </table>

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
              <li <?php if ($this->tab != "results") echo "class='active'"; ?>>
                <a href="#template" data-toggle="tab">Evaluation</a>
              </li>
              <li>
                <a href="#project" data-toggle="tab">View Project</a>
              </li>
              <li <?php if ($this->tab == "results") echo "class='active'"; ?>>
                <a href="/evaluations/id/<?=$this->evaluation->getProject()->getId();?>?tab=results">View Results</a>
              </li>
          </ul>
          <div class="margin-lg-t"></div>
          <div class="tab-content">
            <div class="tab-pane fade in <?php if ($this->tab != "results") echo "active"; ?> margin-lg-t" id="template">
              <div id="percentage" class="progress progress-striped active ">
                <?php
                  $percentage = $this->evaluation->getPercentageDone();
                  if ($percentage < 10) $style = "danger";
                  elseif (($percentage >= 10) && ($percentage < 100)) $style = "warning";
                  else $style = "success";
                ?>
                  <div class="progress-bar progress-bar-<?=$style;?>" role="progressbar" aria-valuenow="<?=$percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$percentage;?>%">
                      <strong><small><span style="color:#333"><?=$percentage;?>%</span></small></strong>
                  </div>
              </div>
              <div id="result"></div>
              <form id="evaluation_form">
                <input name="id_evaluation" type="hidden" value="<?=$this->evaluation->getId();?>">
                <?php foreach ($this->evaluation->getProject()->getTemplate()->getCategories() as $category) { ?>
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th colspan="2"><?=$category->getName(); ?></th>
                        <th>Answer</th>
                        <th>Comments</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                          foreach ($category->getQuestions() as $question) {
                            $result = $this->evaluation->getEvaluationResultByQuestionId($question->getId());
                        ?>
                        <tr>
                          <th scope="row" width="20px">#<?=++$i;?></th>
                          <td width="50%"><?=$question->getName(); ?></td>
                          <td width="20%">
                            <div class="form-group">
                              <select name="answer_<?=$question->getId();?>" class="form-control" onChange="$('#save').click()">
                                <option value="">Select...</option>
                                <?php
                                  foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $answer) {
                                    if (($result) && ($result->getAnswer()->getId() == $answer->getId())) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                ?>
                                <option <?=$selected;?> value="<?=$answer->getId();?>"><?=$answer->getName();?></option>
                              <?php } ?>
                              </select>
                             </div>
                          </td>
                          <td width="30%">
                            <div class="form-group">
                              <textarea onfocusout="$('#save').click()" name="comment_<?=$question->getId();?>" class="form-control"><?php
                                  if ($result) {
                                    echo $result->getComment();
                                  }
                                ?></textarea>
                             </div>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                <?php } ?>
              </form>
            </div>

            <div class="tab-pane fade in margin-lg-t" id="project" >
              <iframe name="iframe" width="100%" style="min-height:94vh" src="//<?=str_replace("http://", "", $this->evaluation->getProject()->getLink());?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="tab-pane fade in <?php if ($this->tab == "results") echo "active"; ?> margin-lg-t" id="results">
              <table class="table">
                <thead>
                </thead>
                <tbody>
                  <th colspan="3" class="thead-light text-center">My own results</th>
                  <tr>
                    <th width="20%">Total Questions:</th>
                    <td><?=$this->evaluation->getQuestionsCount();?></td>
                  </tr>
                  <tr>
                    <th>Answered Questions:</th>
                    <td><?=$this->evaluation->getAnsweredQuestionsCount();?> <big>(<?=round($this->evaluation->getAnsweredQuestionsCount()/$this->evaluation->getQuestionsCount()*100, 1);?>%)</big></td>
                  </tr>
                  <tr>
                    <th>Not answered Questions:</th>
                    <td><?=$this->evaluation->getQuestionsCount()-$this->evaluation->getAnsweredQuestionsCount();?></td>
                  </tr>
                  <tr>
                    <th>Score</th>
                    <td><?=$this->evaluation->getScore();?></td>
                  </tr>
                  <tr>
                    <th>Usability Percentage</th>
                    <td><big><span class="label label-danger"><?=round($this->evaluation->getScore()*100/($this->evaluation->getProject()->getTemplate()->getMaxAnswerValue()*$this->evaluation->getQuestionsCount()), 1); ?>%</span></big></td>
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
                        Answer Chart
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                      <canvas id="chartjs-1" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                      <script>new Chart(document.getElementById("chartjs-1"),{"type":"doughnut","data":{"labels":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($this->evaluation->getAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}]}});</script>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>
              <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Other Chart
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <canvas id="chartjs-2" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                          <script>new Chart(document.getElementById("chartjs-2"),{"type":"radar","data":{"labels":["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],"datasets":[{"label":"My First Dataset","data":[65,59,90,81,56,55,40],"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBackgroundColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(255, 99, 132)"},{"label":"My Second Dataset","data":[28,48,40,19,96,27,100],"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(54, 162, 235)"}]},"options":{"elements":{"line":{"tension":0,"borderWidth":3}}}});</script>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                <table class="table">
                  <thead>
                  </thead>
                  <tbody>
                    <th colspan="2" class="thead-light text-center">Global results</th>
                    <tr>
                      <th width="22%">Average Score</th>
                      <td><?=$this->evaluation->getProject()->getScore();?></td>
                    </tr>
                    <tr>
                      <th>Average Usability Percentage</th>
                      <td><big><span class="label label-danger"><?=$this->evaluation->getProject()->getUsabilityPercentage(); ?>%</span></big></td>
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
                          Answer Chart
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <canvas id="chartjs-3" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                        <script>new Chart(document.getElementById("chartjs-3"),{"type":"doughnut","data":{"labels":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($this->evaluation->getProject()->getGlobalAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}]}});</script>
                      </div>
                      <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                </div>
                <div class="col-lg-6">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                              Other Chart
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                            <canvas id="chartjs-4" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                            <script>new Chart(document.getElementById("chartjs-4"),{"type":"radar","data":{"labels":["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],"datasets":[{"label":"My First Dataset","data":[65,59,90,81,56,55,40],"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBackgroundColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(255, 99, 132)"},{"label":"My Second Dataset","data":[28,48,40,19,96,27,100],"fill":true,"backgroundColor":"rgba(54, 162, 235, 0.2)","borderColor":"rgb(54, 162, 235)","pointBackgroundColor":"rgb(54, 162, 235)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(54, 162, 235)"}]},"options":{"elements":{"line":{"tension":0,"borderWidth":3}}}});</script>
                          </div>
                          <!-- /.panel-body -->
                      </div>
                      <!-- /.panel -->
                  </div>
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
          $("#result").show();
          $("#result").html(msg);
          $("#percentage").hide("fast");
          $("#resultMessage").delay(3000).hide("blind");
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

  // AutoScroll
  $(document).ready(function(){
    $('html, body').animate({
        scrollTop: $("#results").offset().top
    }, 500);
  });
</script>
