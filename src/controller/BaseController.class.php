<?php
  /**
   *
   */
  class BaseController
  {
    private $View = "index";
    private $Content;

    function __construct($view, $content) {
      $this->View = $view;
      $this->Content = $content;
    }

    function SetView($view, $content) {
      $this->View = $view;
      $this->Content = $content;
    }

    function SetContentView($content) {
      $this->View = "index";
      $this->Content = $content;
    }

    function Render() {
      include(BASE_URI."view/".$this->View.".php");
      exit;
    }
  }

?>
