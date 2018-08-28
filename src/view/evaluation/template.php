<?php infoModal("evaluationModal", "How to make an Heuristic Evaluation", $this->getEvaluationContent()); ?>
<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="finishModal_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong>Finish Evaluation</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure about finishing this Evaluation?<br /><br />
        <strong>Please note:</strong> If you finish it, you cannot be able to modify again.
      </div>
      <div class="modal-footer">
        <form id="finishForm" action="/evaluation/finish" method="POST">
          <div class="right">
              <input type="hidden" name="id_evaluation" value="<?=$this->evaluation->getId();?>" />
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button onclick="$(this).attr('disabled', true );$(this).text('Finishing...');$('#finishForm').submit();" id="finish" type="button" class="btn btn-warning" <?php if ($this->evaluation->isFinishedOrClosed()) echo "disabled"; ?>><span class="glyphicon glyphicon-ok"></span> Finish</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<button id="topButton" title="Go to top"><span class="glyphicon glyphicon-menu-up"></span></button>
  <div class="row">
    <h1 class="page-header">Evaluation</h1>
  </div>
  <!-- /.row -->
  <div class="row">
    <?=$this->finishMessage; ?>
  </div>

  <div class="row">
    <table class="table">
      <thead>
      </thead>
      <tbody>
        <th colspan="2" class="thead-light text-center">Project Information</th>
        <tr>
          <th width="15%">Owner:</th>
          <td><?=$this->evaluation->getProject()->getUser()->getName();?></td>
        </tr>
        <tr>
          <th width="15%">Name:</th>
          <td><?=$this->evaluation->getProject()->getName();?></td>
        </tr>
        <tr>
          <th>Description:</th>
          <td><?=$this->evaluation->getProject()->getDescription();?></td>
        </tr>
        <tr>
          <th>Link:</th>
          <td><a href="<?=$this->evaluation->getProject()->getLink();?>" target="_blank" title="Link to <?=$this->evaluation->getProject()->getLink();?>"><?=$this->evaluation->getProject()->getLink();?></a></td>
        </tr>
        <tr>
          <th>Finishes at:</th>
          <?php
            if (($daysLeft = $this->evaluation->getProject()->getDaysLeft()) == 0) $daysLeft = "some hours"; elseif ($daysLeft < 0) $daysLeft = "0 days"; else $daysLeft = $daysLeft." days";
          ?>
          <td><?=$this->evaluation->getProject()->getFinishDate();?> (<?=$daysLeft;?> left)</td>
        </tr>
        <tr>
          <th>Status:</th>
          <td>
            <?php if ((!$this->evaluation->getProject()->isClosed()) && ($this->evaluation->isFinished())): ?>
              <span class="label label-warning">Finished</span>
            <?php elseif (!$this->evaluation->getProject()->isClosed()): ?>
              <span class="label label-success">Open</span>
            <?php else: ?>
              <span class="label label-danger">Closed</span>
            <?php endif; ?>
            <div class="right">
              <a href="#" data-toggle="modal" data-target="#evaluationModal" title="About Us" class="text-bold"><span class="glyphicon glyphicon-info-sign"></span> How to make and Heuristic Evaluation?</a>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="col-lg">
        <!-- /.panel-heading -->
        <div class="panel-body">
          <div class="right">
              <a class="btn btn-default" id="hideButton" href="#"><span class="glyphicon glyphicon-eye-close"></span> Hide Sidebar</a>
              <a style="display:none" class="btn btn-default" id="showButton" href="#"><span class="glyphicon glyphicon-eye-open"></span> Show Sidebar</a>
              <button <?php if ($this->evaluation->isFinishedOrClosed()) echo "disabled"; ?> id="save" type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
              <input type="hidden" name="id_evaluation" value="<?=$this->evaluation->getId();?>" />
              <button id="finish" type="button" class="btn btn-warning" <?php if ($this->evaluation->isFinishedOrClosed()) echo "disabled"; ?> data-toggle="modal" data-target="#finishModal"><span class="glyphicon glyphicon-ok"></span> Finish</button>
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
              <?php
                $percentage = $this->evaluation->getPercentageDone();
                if ($percentage < 10) $style = "danger";
                elseif (($percentage >= 10) && ($percentage < 100)) $style = "warning";
                else $style = "success";
              ?>
              <div id="percentage" class="progress progress-striped <?php if ($percentage < 100) echo "active";?>">
                  <div class="progress-bar progress-bar-<?=$style;?>" role="progressbar" aria-valuenow="<?=$percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?=$percentage;?>%">
                      <?php if ($percentage < 100): ?>
                        <strong><small><span style="color:#333"><?=$percentage;?>%</span></small></strong>
                      <?php else: ?>
                        <strong><small><span style="color:#333">Evaluation Completed</span></small></strong>
                      <?php endif; ?>
                  </div>
              </div>

              <div id="result"></div>
              <form id="evaluation_form">
                <input name="id_evaluation" type="hidden" value="<?=$this->evaluation->getId();?>">
                <?php foreach ($this->evaluation->getProject()->getTemplate()->getCategories() as $category) { ?>
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th colspan="2"><?=++$c.". ".$category->getName(); ?></th>
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
                              <select id="question_<?=$question->getId();?>" <?php if ($result): ?>style="color:<?=$result->getAnswer()->getColor()?>;" <?php endif; ?> <?php if ($this->evaluation->isFinishedOrClosed()) echo "disabled"; ?> name="answer_<?=$question->getId();?>" class="form-control text-bold" onChange="changed = true; $('#question_<?=$question->getId(); ?>').css('color',$(this).children(':selected').attr('color'));" <?php //onChange="$('#save').click()"?>>
                                <option value=""></option>
                                <?php
                                  foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $answer) {
                                    if (($result) && ($result->getAnswer()->getId() == $answer->getId())) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                ?>
                                <option color="<?=$answer->getColor();?>" style="color:<?=$answer->getColor();?>;" <?=$selected;?> value="<?=$answer->getId();?>"><?=$answer->getName();?></option>
                              <?php } ?>
                              </select>
                             </div>
                          </td>
                          <td width="30%">
                            <div class="form-group">
                              <textarea <?php if ($this->evaluation->isFinishedOrClosed()) echo "disabled"; ?> onChange="changed = true;" <?php //onfocusout="$('#save').click()"?> name="comment_<?=$question->getId();?>" class="form-control"><?php
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
              <iframe name="iframe" width="100%" style="min-height:100vh" src="//<?=str_replace("http://", "", $this->evaluation->getProject()->getLink());?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="tab-pane fade in <?php if ($this->tab == "results") echo "active"; ?> margin-lg-t" id="results">

              <div class="col-lg-7">
                <table class="table">
                  <tbody>
                    <th colspan="2" class="thead-light text-center">My Results</th>
                    <tr>
                      <th width="50%">Total Questions</th>
                      <td><?=$this->evaluation->getQuestionsCount();?></td>
                    </tr>
                    <tr>
                      <th>Answered Questions</th>
                      <td><?=$this->evaluation->getAnsweredQuestionsCount();?> <big>(<?=round($this->evaluation->getAnsweredQuestionsCount()/$this->evaluation->getQuestionsCount()*100, 1);?>%)</big></td>
                    </tr>
                    <tr>
                      <th>Answered Questions without N/A</th>
                      <td><?=$this->evaluation->getAnsweredScorableQuestionsCount();?></td>
                    </tr>
                    <tr>
                      <th>Unanswered Questions</th>
                      <td><?=$this->evaluation->getQuestionsCount()-$this->evaluation->getAnsweredQuestionsCount();?></td>
                    </tr>
                    <tr>
                      <th>Score</th>
                      <td><?=$this->evaluation->getScore();?>/<?=$this->evaluation->getMaxScore();?>  (Maximum Achievable: <?=$this->evaluation->getMaxPosibleScore()?>)</td>
                    </tr>
                    <tr>
                      <th>Usability Percentage</th>
                      <?php
                        $usabilityPercentage = $this->evaluation->getUsabilityPercentage();
                        if ($usabilityPercentage < 35)
                          $style = "danger";
                        elseif (($usabilityPercentage >= 35) && ($usabilityPercentage < 70))
                          $style = "warning";
                        else
                          $style = "success";
                      ?>
                      <td><big><span class="label label-<?=$style;?>"><?=$this->evaluation->getUsabilityPercentage();?>%</span></big></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading text-center text-bold">
                        My Answers Chart
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                      <canvas id="chartjs-1" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                      <script>new Chart(document.getElementById("chartjs-1"),{"type":"doughnut","data":{"labels":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($this->evaluation->getAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getColor()."',"; } ?>]}]}});</script>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>

                <table class="table">
                  <tbody>
                    <th colspan="2" class="thead-light text-center">Score per Category</th>
                    <?php foreach ($this->evaluation->getProject()->getTemplate()->getCategories() as $category) { ?>
                      <tr>
                        <th width="90%"><?=++$cs.". ".$category->getName(); ?></th>
                        <td><?=$this->evaluation->getScoreByCategory($category->getId());?></td>
                      </tr>
                  <?php } ?>
                  <tr>
                    <th></th>
                    <td><strong><?=$this->evaluation->getScore();?></strong></td>
                  </tr>
                  </tbody>
                </table>

                <table class="table">
                  <tbody>
                    <th colspan="2" class="thead-light text-center">Global results</th>
                    <tr>
                      <th width="22%">Evaluations</th>
                      <td><?=count($this->evaluation->getProject()->getEvaluations());?></td>
                    </tr>
                    <tr>
                      <th width="22%">Finished Evaluations</th>
                      <td><?=count($this->evaluation->getProject()->getFinishedEvaluations());?></td>
                    </tr>
                    <tr>
                      <th width="22%">Average Score</th>
                      <td><?=round($this->evaluation->getProject()->getScore(), 1);?>/<?=$this->evaluation->getProject()->getMaxScore()?>  (Maximum Achievable: <?=$this->evaluation->getProject()->getMaxPosibleScore()?>)</td>
                    </tr>
                    <tr>
                      <?php
                        $usabilityPercentage = $this->evaluation->getProject()->getUsabilityPercentage();
                        if ($usabilityPercentage < 35)
                          $style = "danger";
                        elseif (($usabilityPercentage >= 35) && ($usabilityPercentage < 70))
                          $style = "warning";
                        else
                          $style = "success";
                      ?>
                      <th>Average Usability Percentage</th>
                      <td><big><span class="label label-<?=$style;?>"><?=$usabilityPercentage;?>%</span></big></td>
                    </tr>
                  </tbody>
                </table>

                <div class="col-lg-6">
                  <div class="panel panel-default">
                      <div class="panel-heading text-center text-bold">
                          Global Usability Percentage Chart
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <?php if (count($this->evaluation->getProject()->getFinishedEvaluations()) > 0): ?>
                          <canvas id="chartjs-3" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                          <script>new Chart(document.getElementById("chartjs-3"),{"type":"radar","data":{"labels":[<?php foreach ($this->evaluation->getProject()->getFinishedEvaluations() as $value) { echo "'".$value->getUser()->getName()."',"; } ?>],"datasets":[
                            {"label":"<?=$this->evaluation->getProject()->getName();?>","data":[<?php foreach ($this->evaluation->getProject()->getFinishedEvaluations() as $value) { echo $value->getUsabilityPercentage().","; } ?>],"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBackgroundColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(255, 99, 132)"}
                          ]},"options":{"scale":{"ticks":{"beginAtZero":true,"max":100}},"legend":{"display":false},"elements":{"line":{"tension":0,"borderWidth":3}}}});</script>
                        <?php else: ?>
                          There is not finished evaluations yet...
                        <?php endif; ?>
                      </div>
                      <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>

                <div class="col-lg-6">
                  <div class="panel panel-default">
                      <div class="panel-heading text-center text-bold">
                          Global Answers Chart
                      </div>
                      <!-- /.panel-heading -->
                      <div class="panel-body">
                        <canvas id="chartjs-2" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                        <script>new Chart(document.getElementById("chartjs-2"),{"type":"doughnut","data":{"labels":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($this->evaluation->getProject()->getGlobalAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":[<?php foreach ($this->evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getColor()."',"; } ?>]}]}});</script>
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
  var changed = false;
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
    $("#save").html("<span class='glyphicon glyphicon-floppy-disk'></span> Saving...");
    $("#save").prop('disabled', true);
    $.ajax({
        type:'POST',
        url:'/evaluation/update',
        data:$('#evaluation_form').serialize(),
        success:function(msg){
          $("#result").show();
          $("#result").html(msg);
          $("#percentage").hide("fast");
          $("#result_finish").hide("fast");
          $("#resultMessage").delay(3000).hide("blind");
          $("#save").html("<span class='glyphicon glyphicon-floppy-disk'></span> Save");
          $("#save").prop('disabled', false);
          changed = false;
        }
    });
  });

  window.onbeforeunload = function() {
    if (changed) {
      return 1;
    }
  };

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
