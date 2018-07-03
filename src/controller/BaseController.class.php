<?php

  /**
   * Base Controller
   */
  class BaseController
  {
    private $view = "index";
    private $content;
    private $breadcrumb = array();

    function __construct($view, $content) {
      $this->view = $view;
      $this->content = $content;
    }

    function setView($view) {
      $this->view = $view;
    }

    function setContent($content) {
      $this->content = $content;
    }

    function setContentView($content) {
      $this->view = "index";
      $this->content = $content;
    }

    function setBreadcrumb($value) {
      $this->breadcrumb = $value;
    }

    function getBreadcrumb() {
      if ($this->breadcrumb) {
        $output .= '<li class="breadcrumb-item active" aria-current="page"><a href="/">Home</a></li>';

        foreach ($this->breadcrumb as $crumb) {
          if ($crumb[1]) {
            $output .= '<li class="breadcrumb-item"><a title="'.$crumb[0].'" href="'.$crumb[1].'">'.$crumb[0].'</a></li>';
          } else {
            $output .= '<li class="breadcrumb-item">'.$crumb[0].'</li>';
          }
        }
      } else {
        $output .= '<li class="breadcrumb-item"><strong>'.$GLOBALS["USER_SESSION"]->getName().'</strong>, welcome to '.APP_TITLE.'.</li>';
      }

      return $output;
    }

    function render() {
      include(BASE_URI."view/".$this->view.".php");
      exit;
    }

    /*
    * For Navigation Menu
    */
    function getMyAssignedProjects() {
      return getAssignedProjects($GLOBALS["USER_SESSION"]->getId(), "");
    }

    function numberOfEvaluations() {
      $projects = getAssignedProjects($GLOBALS["USER_SESSION"]->getId(), "");
      if ($projects) return count($projects);
      else return 0;
    }
  }

?>
