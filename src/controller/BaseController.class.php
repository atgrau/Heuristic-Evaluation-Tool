<?php

  /**
   * Base Controller
   */
  class BaseController
  {
    private $view = "index";
    private $content;

    function __construct($view, $content) {
      $this->view = $view;
      $this->content = $content;
    }

    function setView($view) {
      $this->view = $view;
    }

    function setContentView($content) {
      $this->view = "index";
      $this->content = $content;
    }

    function render() {
      include(BASE_URI."view/".$this->view.".php");
      exit;
    }
  }

?>
