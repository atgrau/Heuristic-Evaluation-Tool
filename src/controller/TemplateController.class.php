<?php

  /**
   * Template Controller
   */
  class TemplateController extends BaseController
  {
    function __construct() { }

    function showTemplate() {
      $this->setContentView("template/template");
      $this->tab = 0;

      // Categories
      $this->categoriesList = getCategories();

      $this->render();
    }
  }

?>
