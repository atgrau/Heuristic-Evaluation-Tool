<?php

  class EvaluationController extends BaseController
  {
    function __construct() { }

    function showEvaluationTemplate($projectId) {
      $this->evaluation = getEvaluationByProjectAndUser($projectId, $GLOBALS["USER_SESSION"]->getId());
      if (!$this->evaluation) {
        $this->new = true;
        $this->evaluation = new Evaluation(0, getProjectById($projectId), $GLOBALS["USER_SESSION"]);
      } else {
        $this->new = false;
      }
      $this->setContentView("evaluation/template");
      $this->render();
    }

  }

?>
