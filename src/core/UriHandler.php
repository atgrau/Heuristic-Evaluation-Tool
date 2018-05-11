<?php

  // Initial configurations: Setting up base uri of project
  define("BASE_URI", $_SERVER["DOCUMENT_ROOT"]."/src/");

  // Include configuration files
  require_once(BASE_URI."config/global.php");

  // Include Uri Handler class
  require_once(BASE_URI."core/UriHandler.class.php");

  // Initialize a Session Handler
  session_start();
  if (isset($_SESSION["UserId"])) {
    require_once(BASE_URI."model/UserModel.class.php");
    $UserSession = GetUserById($_SESSION["UserId"]);
    $GLOBALS["UserSession"] = $UserSession;
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
