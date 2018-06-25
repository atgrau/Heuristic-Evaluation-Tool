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
        $this->evaluation = new Evaluation(0, getProjectById($projectId), $GLOBALS["USER_SESSION"], null);
        $this->evaluation->insert();
      }
      $this->setContentView("evaluation/template");
      $this->render();
    }

    function update() {
      // Check if exists the relationship
      $evaluation = getEvaluationById($_POST["id_evaluation"]);
      if ((!$evaluation) || ($GLOBALS["USER_SESSION"] != $evaluation->getUser())) {
        header("Location: /evaluations");
      }

      echo "update";
      exit;

    }

  }

?>
