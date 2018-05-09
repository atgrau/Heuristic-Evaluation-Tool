<?php
  // Initial configurations: Setting up base uri of project
  define("BASE_URI", $_SERVER['DOCUMENT_ROOT']);

  // Start Session
  session_start();

  // Include configuration file
  require_once(BASE_URI."/config/config.inc.php");

  // Include Controller class
  require_once(BASE_URI."/src/controllers/controller.class.php");

  // Getting Resource & Action
  $resource = $_GET["resource"];
  $action = $_GET["action"];

  switch($resource) {
    // Account
    case account:
      switch($action) {
        case login:
          $username = $_POST["email"];
          $password = $_POST["password"];
          $controller = new AccountController();
          $controller->Login($username, $password);
          break;

        default:
          echo "Not specified";
      }
    // End Account

    default:
      echo "Not specified";
  }

?>
