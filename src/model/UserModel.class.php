<?php
  require_once(BASE_URI."config/database.php");
  
  /**
   *
   */
  class UserModel
  {
    private $Id;
    private $Role;
    private $Email;
    private $Password;
    private $FirstName;
    private $LastName;

    function __construct()
    {
    }

  }

  function DoLogin($email, $password) {
    $account = DB::queryFirstRow("SELECT * FROM users WHERE email=%s and password=%s", $email, $password);
    if ($account) {
      // Create new Session
      session_start();
      $UserSession = new Session($account["ID"]);
      $UserSession->Update();
      return true;
    } else {
      return false;
    }
  }
?>
