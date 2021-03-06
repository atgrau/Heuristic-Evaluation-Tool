<?php
function generateModal($evaluationId) {
  return '<!-- Modal -->
  <div class="modal fade" id="open_'.$evaluationId.'" tabindex="-1" role="dialog" aria-labelledby="open_evaluation_'.$evaluationId.' aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <strong>Re-Open Evaluation</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Evaluation will be open again, are you sure?</h5>
        </div>
        <div class="modal-footer">
          <form action="/evaluation/reopen" method="POST">
            <input name="id_evaluation" type="hidden" value="'.$evaluationId.'" />
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Re-Open Evaluation</button>
          </form>
        </div>
      </div>
    </div>
  </div>';
}
function generateModalRemove($evaluationId) {
  return '<!-- Modal -->
  <div class="modal fade" id="remove_'.$evaluationId.'" tabindex="-1" role="dialog" aria-labelledby="open_evaluation_'.$evaluationId.' aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <strong>Remove Evaluation</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Evaluation will be removed, are you sure?</h5>
        </div>
        <div class="modal-footer">
          <form action="/evaluation/remove" method="POST">
            <input name="id_evaluation" type="hidden" value="'.$evaluationId.'" />
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Remove Evaluation</button>
          </form>
        </div>
      </div>
    </div>
  </div>';
}
?>

<?php if($this->showBreadcrumb) : ?>
  <div class="row">
    <div class="margin-lg-t"></div>
    <nav id="breadcrumb" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <?=$this->getBreadcrumb();?>
      </ol>
    </nav>
  </div>
<?php endif; ?>
<div id="content">
  <button id="topButton" title="Go to top"><span class="glyphicon glyphicon-menu-up"></span></button>
    <div class="row">
      <h1 class="page-header">Evaluation Results</h1>
    </div>

    <?php if ($this->reopened): ?>
      <div class="alert alert-info row" role="alert">
        <span class="glyphicon glyphicon-info-sign"></span> Evaluation has been re-opened.
      </div>
    <?php elseif ($this->removed): ?>
        <div class="alert alert-info row" role="alert">
          <span class="glyphicon glyphicon-info-sign"></span> Evaluation has been removed.
        </div>
    <?php endif; ?>

    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
      <table class="table">
        <thead>
        </thead>
        <tbody>
          <th colspan="2" class="thead-light text-center">Project Information
            <a id="exportGlobal" class="right" href="#"><span class="glyphicon glyphicon-print"></span> Print global results</a>
          </th>
          <tr>
            <th width="15%">Name:</th>
            <td><?=$this->project->getName();?></td>
          </tr>
          <tr>
            <th>Description:</th>
            <td><?=$this->project->getDescription();?></td>
          </tr>
          <tr>
            <th>Link:</th>
            <td><a href="<?=$this->project->getLink();?>" target="_blank" title="Link to <?=$this->project->getLink();?>"><?=$this->project->getLink();?></a></td>
          </tr>
        </tbody>
      </table>

      <div class="col-lg">
        <div id="globalResults">
          <table class="table">
            <tbody>
              <th colspan="2" class="thead-light text-center">Global results Chart</th>
              <tr>
                <th width="22%">Evaluations</th>
                <td><?=count($this->project->getEvaluations());?></td>
              </tr>
              <tr>
                <th width="22%">Finished Evaluations</th>
                <td><?=count($this->project->getFinishedEvaluations());?> <strong>(<?=round(count($this->project->getFinishedEvaluations())*100/count($this->project->getEvaluations()), 1);?>%)</strong></td>
              </tr>
              <tr>
                <th width="22%">Average Score</th>
                <td><?=round($this->project->getScore(), 1);?>/<?=$this->project->getMaxScore()?> (Maximum Achievable: <?=$this->project->getMaxPosibleScore()?>)</td>
              </tr>
              <tr>
                <?php
                  $usabilityPercentage = $this->project->getUsabilityPercentage();
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
                  <?php if (count($this->project->getFinishedEvaluations()) > 0): ?>
                    <canvas id="chartjs-1" class="chartjs" width="770" height="385"></canvas>
                    <script>new Chart(document.getElementById("chartjs-1"),{"type":"radar","data":{"labels":[<?php foreach ($this->project->getFinishedEvaluations() as $value) { echo "'".$value->getUser()->getName()."',"; } ?>],"datasets":[
                      {"label":"<?=$this->project->getName();?>","data":[<?php foreach ($this->project->getFinishedEvaluations() as $value) { echo $value->getUsabilityPercentage().","; } ?>],"fill":true,"backgroundColor":"rgba(255, 99, 132, 0.2)","borderColor":"rgb(255, 99, 132)","pointBackgroundColor":"rgb(255, 99, 132)","pointBorderColor":"#fff","pointHoverBackgroundColor":"#fff","pointHoverBorderColor":"rgb(255, 99, 132)"}
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
                  <?php if (count($this->project->getFinishedEvaluations()) > 0): ?>
                  <canvas id="chartjs-2" class="chartjs" width="770" height="385"></canvas>
                  <script>new Chart(document.getElementById("chartjs-2"),{"type":"doughnut","data":{"labels":[<?php foreach ($this->project->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($this->project->getGlobalAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":[<?php foreach ($this->project->getTemplate()->getAnswers() as $value) { echo "'".$value->getColor()."',"; } ?>]}]}});</script>
                  <?php else: ?>
                    There is not finished evaluations yet...
                  <?php endif; ?>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
          </div>
        </div>

        <div id="detailedResults">
          <?php if ($this->project->getFinishedEvaluations()): ?>
          <div class="col-lg-12">
            <h2 class="page-header">Detailed Results</h2>
          </div>

          <div class="col-lg">
            <!-- /.panel-heading -->
            <div class="panel-body">
              <ul id="userNav" class="nav nav-tabs">
                <?php foreach ($this->project->getFinishedEvaluations() as $evaluation) { $i++;?>
                  <li <?php if ($i == 1) echo "class='active'"; ?>>
                    <a href="#evaluation_<?=$evaluation->getId();?>" data-toggle="tab"><small><?=$evaluation->getUser()->getName();?></small></a>
                  </li>
                <?php } ?>
              </ul>
              <div class="margin-lg-t"></div>
                <div class="tab-content">
                  <?php $i = 0; foreach ($evaluation->getProject()->getFinishedEvaluations() as $evaluation) { $i++; $q = 0; $c = 0; ?>
                    <div class="tab-pane fade in <?php if ($i == 1) echo "active"; ?> margin-lg-t" id="evaluation_<?=$evaluation->getId();?>">
                        <div class="col-lg-7">
                          <table class="table">
                            <tbody>
                              <th colspan="2" class="thead-light text-center">
                                <?=$evaluation->getUser()->getName(); ?>'s results
                                <a name="export" class="right" href="#"><span class="glyphicon glyphicon-print"></span> Print results</a>
                              </th>
                              <tr>
                                <th>Made by</th>
                                <td><?=$evaluation->getUser()->getName(); ?></td>
                              </tr>
                              <tr>
                                <th>E-mail</th>
                                <td><?=$evaluation->getUser()->getEmail(); ?></td>
                              </tr>
                              <tr>
                                <th>Entity</th>
                                <td><?=$evaluation->getUser()->getEntity(); ?></td>
                              </tr>
                              <tr>
                                <th>Score</th>
                                <td><?=$evaluation->getScore();?>/<?=$evaluation->getMaxScore();?> (Maximum Achievable: <?=$evaluation->getMaxPosibleScore()?>)</td>
                              </tr>
                              <tr>
                                <th>Usability Percentage</th>
                                <?php
                                  $usabilityPercentage = $evaluation->getUsabilityPercentage();
                                  if ($usabilityPercentage < 35)
                                    $style = "danger";
                                  elseif (($usabilityPercentage >= 35) && ($usabilityPercentage < 70))
                                    $style = "warning";
                                  else
                                    $style = "success";
                                ?>
                                <td><big><span class="label label-<?=$style;?>"><?=$evaluation->getUsabilityPercentage();?>%</span></big></td>
                              </tr>
                              <tr>
                                <th name="options">Options</th>
                                <td name="options">
                                  <?=generateModal($evaluation->getId()); ?>
                                  <?=generateModalRemove($evaluation->getId()); ?>
                                  <a data-toggle="modal" data-target="#open_<?=$evaluation->getId(); ?>" href="#" title="Re-Open evaluation" class="btn btn-default">Re-Open Evaluation</a>
                                  <a data-toggle="modal" data-target="#remove_<?=$evaluation->getId(); ?>" href="#" title="Re-Open evaluation" class="btn btn-danger">Remove Evaluation</a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                        <div class="col-lg-5">
                          <div class="panel panel-default">
                              <div class="panel-heading text-center text-bold">
                                  <?=$evaluation->getUser()->getName(); ?>'s Answers
                              </div>
                              <!-- /.panel-heading -->
                              <div class="panel-body">
                                <canvas id="chartjs-ev-<?=$evaluation->getId();?>" class="chartjs" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
                                <script>new Chart(document.getElementById("chartjs-ev-<?=$evaluation->getId();?>"),{"type":"doughnut","data":{"labels":[<?php foreach ($evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getName()."',"; } ?>],"datasets":[{"data":[<?php foreach ($evaluation->getAnswerValue() as $value) { echo $value.","; } ?>],"backgroundColor":[<?php foreach ($evaluation->getProject()->getTemplate()->getAnswers() as $value) { echo "'".$value->getColor()."',"; } ?>]}]}});</script>
                              </div>
                              <!-- /.panel-body -->
                          </div>
                          <!-- /.panel -->
                        </div>


                        <table class="table">
                          <tbody>
                            <th colspan="2" class="thead-light text-center">Score per Category</th>
                            <?php $cs = 0; foreach ($evaluation->getProject()->getTemplate()->getCategories() as $category) { ?>
                              <tr>
                                <th width="90%"><?=++$cs.". ".$category->getName(); ?></th>
                                <td><?=$evaluation->getScoreByCategory($category->getId());?></td>
                              </tr>
                          <?php } ?>
                          <tr>
                            <th></th>
                            <td><strong><?=$evaluation->getScore();?></strong></td>
                          </tr>
                          </tbody>
                        </table>

                        <?php foreach ($evaluation->getProject()->getTemplate()->getCategories() as $category) { ?>
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
                                  $result = $evaluation->getEvaluationResultByQuestionId($question->getId());
                              ?>
                              <tr>
                                <th scope="row" width="20px">#<?=++$q;?></th>
                                <td width="60%"><?=$question->getName(); ?></td>
                                <td width="10%">
                                  <span class="text-bold" style="color:<?=$result->getAnswer()->getColor();?>"><?=$result->getAnswer()->getName();?></span>
                                </td>
                                <td width="30%">
                                    <?=$result->getComment();?></textarea>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      <?php } ?>
                    </div>

                  <?php
                    // End foreach
                      }
                    endif;
                  ?>
              </div>
            </div>
            <!-- /.panel-body -->
        </div>
      </div>
    </form>
  </div>
</div>
<!-- /.row -->

<script>
  // Top Button
  window.onscroll = function() {scrollFunction()};
  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      $("#topButton").fadeIn("slow");
    } else {
      $("#topButton").fadeOut("slow");
    }
  }
  $("#topButton").click(function(){
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $('a[name = "export"]').click(function () {
    $(this).hide();
    $("#footer").hide();
    $("#breadcrumb").hide();
    $("#globalResults").hide();
    $("#userNav").hide();
    $('th[name = "options"]').hide();
    $('td[name = "options"]').hide();
    $('#exportGlobal').hide();
    $("#topButton").hide();
    window.print();
    $("#topButton").show();
    $('#exportGlobal').show()
    $('th[name = "options"]').show();
    $('td[name = "options"]').show();
    $("#userNav").show();
    $("#globalResults").show();
    $("#footer").show();
    $("#breadcrumb").show();
    $(this).show();
  });

  $('#exportGlobal').click(function () {
    $(this).hide();
    $("#footer").hide();
    $("#breadcrumb").hide();
    $("#detailedResults").hide();
    $('a[name = "export"]').hide();
    $("#topButton").hide();
    $("#sidebar").hide();
    window.print();
    $("#sidebar").show();
    $("#topButton").show();
    $('a[name = "export"]').show();
    $("#footer").show();
    $("#detailedResults").show();
    $(this).show();
  });
</script>
