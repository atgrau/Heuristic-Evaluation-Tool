<?php
  require_once(BASE_URI."config/database.php");

  /**
   * UserSession
   */
  class Session //extends SessionHandler
  {
    private $UserId;
    private $Role;
    private $Email;
    private $FirstName;
    private $LastName;

    function __construct($userId) {
      $this->UserId = $userId;
    }

    function Update() {
      $account = DB::queryFirstRow("SELECT * FROM users WHERE ID=%i", $this->UserId);
      if ($account) {
        $_SESSION["UserId"] = $this->UserId;
        $this->UserId = $account["ID"];
        $this->Role = $account["role"];
        $this->Email = $account["email"];
        $this->FirstName = $account["firstname"];
        $this->LastName = $account["lastname"];
      }
    }

    function GetName() {
      return $this->FirstName." ".$this->LastName;
    }

    function GetRole() {
      return $this->Role;
    }
  }
?>
