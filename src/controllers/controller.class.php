<?php

  /**
   *
   */
  class BaseController
  {

  }

  /**
   *
   */
  class AccountController extends BaseController
  {
    function __construct()
    {
    }

    function Login($Email, $password) {
      $a = 1;
      include(BASE_URI."/public/index.php");
    }
  }

?>
