<?php

  class EvaluationController extends BaseController
  {
    function __construct() { }

    function showEvaluationTemplate($evaluationId) {
      $this->setContentView("evaluation/template");
      $this->render();
    }

  }

?>
