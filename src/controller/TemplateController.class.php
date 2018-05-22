<?php

  /**
   * Template Controller
   */
  class TemplateController extends BaseController
  {
    function __construct() { }

    function showTemplate() {
      $this->setContentView("template/template");
      $this->render();
    }
  }

?>
