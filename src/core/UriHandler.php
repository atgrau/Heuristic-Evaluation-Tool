<?php

  // Initial configurations: Setting up base uri of project
  define("BASE_URI", $_SERVER["DOCUMENT_ROOT"]."/src/");

  // Include configuration files
  require_once(BASE_URI."config/global.php");

  // Include general funcions
  require_once(BASE_URI."core/functions.php");

  // Include Uri Handler class
  require_once(BASE_URI."core/UriHandler.class.php");

  // Initialize a Session Handler
  session_start();
  if (isset($_SESSION["UserId"])) {
    require_once(BASE_URI."model/UserModel.class.php");
    $userSession = getUserById($_SESSION["UserId"]);
    $GLOBALS["USER_SESSION"] = $userSession;
  }

  // Parse URI
  $uri = "/".$_GET["resource"];
  if (isset($_GET["action"])) {
    $uri .= "/".$_GET["action"];
  }

  // Handle URI
  $uriHandler = new UriHandler($uri);
  $uriHandler->execute();
?>
