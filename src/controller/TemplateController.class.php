<?php

  /**
   * Template Controller
   */
  class TemplateController extends BaseController
  {
    function __construct() { }

    function showTemplate($tab) {
      $this->setContentView("template/template");
      $this->tab = $tab;

      // Categories
      $this->categoriesList = getCategories();
      $this->render();
    }

    function setCategory() {
      $categoryId = $_POST["categoryId"];
      $categoryName = $_POST["category"];
      $category = new Category($categoryId, $categoryName);
      $category->store();

      $this->showTemplate(0);
    }
  }

?>
