<?php

  /**
   * Template Controller
   */
  class TemplateController extends BaseController
  {
    function __construct() { }

    function showTemplate() {
      $email = new Email("agp5@alumnes.udl.cat", "Hola", "Body <b>Hola</b>", "Hola Hola");
      $email->send();
    }
  }

?>
