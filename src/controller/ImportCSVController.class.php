<?php

  /**
   * Template Controller
   */
  class ImportCSVController extends BaseController
  {
    function __construct() { }

    function showTemplate($tab) {
      $this->setContentView("account/importcsv");
      $this->tab = $tab;
      $this->render();
    }

    function newImport() {
        $this->showTemplate(0);
    }


  }

?>
