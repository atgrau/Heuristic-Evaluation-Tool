<?php
  class EvaluationController extends BaseController
  {
    function __construct() { }

    function showEvaluationTemplate($projectId) {
      // Check if exists the relationship
      $project = getProjectById($projectId);
      if ((!$project) || (!in_array($GLOBALS["USER_SESSION"], $project->getUsers()))) {
        header("Location: /evaluations");
      }

      $this->evaluation = getEvaluationByProjectAndUser($projectId, $GLOBALS["USER_SESSION"]->getId());
      // If evaluation is not created yet, lets create it.
      if (!$this->evaluation) {
        $this->evaluation = new Evaluation(0, getProjectById($projectId), $GLOBALS["USER_SESSION"], false, null);
        $this->evaluation->insert();
      }
      $this->tab = $_GET["tab"];
      $this->setContentView("evaluation/template");
      $this->render();
    }

    function update() {
      // Check if exists the relationship
      $evaluation = getEvaluationById($_POST["id_evaluation"]);

      if ((!$evaluation) || ($evaluation->isFinishedOrClosed()) || ($GLOBALS["USER_SESSION"] != $evaluation->getUser())) {
        echo
        '<div id="result" class="alert alert-danger fade in" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <span class="glyphicon glyphicon-remove"></span> This evaluation is already finished or closed, it cannot be modified.
        </div>';
        exit;
      }

      // Get categories of template
      $results = array();
      foreach ($evaluation->getProject()->getTemplate()->getCategories() as $category) {
        foreach ($category->getQuestions() as $question) {
          $question = getQuestionbyId($question->getId());
          $answer = getAnswerbyId($_POST["answer_".$question->getId()]);
          $comment = $_POST["comment_".$question->getId()];
          if ($answer) {
            $evaluationResult = new EvaluationResult($question, $answer, $comment);
            array_push($results, $evaluationResult);
          }
        }
      }
      $evaluation->setResults($results);

      // Store results to DB
      $evaluation->update();

      // Percentage
      $percentage = $evaluation->getPercentageDone();
      if ($percentage < 10) {
        $style = "danger";
        $active = "active";
        $state = $percentage.'%';
      } elseif (($percentage >= 10) && ($percentage < 100)) {
        $style = "warning";
        $active = "active";
        $state = $percentage.'%';
      } else {
        $style = "success";
        $active = "";
        $state = 'Evaluation Completed';
      }
      echo
      '<div id="percentageResult" class="progress progress-striped '.$active.'">
          <div class="progress-bar progress-bar-'.$style.'" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%">
              <strong><small><span style="color:#333">'.$state.'</span></small></strong>
          </div>
      </div>';

      // Feedback
      echo
      '<div id="resultMessage" class="alert alert-info fade in" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <span class="glyphicon glyphicon-ok"></span> Your changes have been saved successfully!
      </div>';
      exit;
    }

    function finish() {
      // Check if exists the relationship
      $evaluation = getEvaluationById($_POST["id_evaluation"]);

      if ((!$evaluation) || ($evaluation->isFinishedOrClosed()) || ($GLOBALS["USER_SESSION"] != $evaluation->getUser())) {
        $style = "danger";
        $this->finishMessage = '<span class="glyphicon glyphicon-remove"></span> This evaluation is already finished or closed, it cannot be modified.';
      } elseif (!$evaluation->allQuestionsAnswered()) {
        $style = "danger";
        $this->finishMessage = '<span class="glyphicon glyphicon-remove"></span> This evaluation is not completed. Please, answer all questions in order to finish.';
      } else {
        $style = "info";
        $this->finishMessage = '<span class="glyphicon glyphicon-info-sign"></span> Evaluation has been finished.';

        $evaluation->setFinished(true);
        $evaluation->update();
      }
      $this->finishMessage = '<div id="result_finish" class="alert alert-'.$style.' fade in" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$this->finishMessage.'</div>';
      $this->showEvaluationTemplate($evaluation->getProject()->getId());
    }

  }
?>
