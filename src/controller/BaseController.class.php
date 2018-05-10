<?php
  /**
   *
   */
  class BaseController
  {
    private $View;

    function __construct($view) {
      $this->View = $view;
    }

    function SetView($view) {
      $this->View = $view;
    }

    function Render() {
      include(BASE_URI."view/".$this->View.".php");
      exit;
    }
  }

?>
