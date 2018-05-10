<?php

  // Initial configurations: Setting up base uri of project
  define("BASE_URI", $_SERVER["DOCUMENT_ROOT"]."/src/");

  // Include configuration files
  require_once(BASE_URI."config/global.php");

  // Include Uri Handler class
  require_once(BASE_URI."core/UriHandler.class.php");

  // Include SessionHandler
  require_once(BASE_URI."core/Session.class.php");

  // Initialize a Session Handler
  session_start();
  if (isset($_SESSION["UserId"])) {
    $UserSession = new Session($_SESSION["UserId"]);
    $UserSession->Update();
  }

  // Parse URI
  $uri = "/".$_GET["resource"];
  if (isset($_GET["action"])) {
    $uri .= "/".$_GET["action"];
  }

  // Handle URI
  $UriHandler = new UriHandler($uri);
  $UriHandler->Execute();
?>
