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
    private $Gender;

    function __construct($id, $role, $email, $firstName, $lastName, $gender)
    {
      $this->Id = $id;
      $this->Role = $role;
      $this->Email = $email;
      $this->FirstName = $firstName;
      $this->LastName = $lastName;
      $this->Gender = $gender;
    }

    function GetId() {
      return $this->Id;
    }

    function GetRole() {
      return $this->Role;
    }

    function GetEmail() {
      return $this->Email;
    }

    function GetFirstName() {
      return $this->FirstName;
    }

    function GetLastName() {
      return $this->LastName;
    }

    function GetName() {
      return $this->FirstName." ".$this->LastName;
    }

    function GetGender() {
      return $this->Gender;
    }
  }

  function GetUserById($userId) {
    $account = DB::queryFirstRow("SELECT * FROM users WHERE ID=%i", $userId);
    if ($account) {
      return new UserModel($account["ID"], $account["role"], $account["email"], $account["firstname"], $account["lastname"], $account["gender"]);
    } else {
      return null;
    }
  }

  function DoLogin($email, $password) {
    $account = DB::queryFirstRow("SELECT ID FROM users WHERE email=%s and password=%s", $email, $password);
    if ($account) {
      // Create new Session
      session_start();
      $_SESSION["UserId"] = $account["ID"];
      return true;
    } else {
      return false;
    }
  }
?>
