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
    private $Country;
    private $Entity;

    function __construct($id, $role, $email, $firstName, $lastName, $gender, $entity, $country)
    {
      $this->Id = $id;
      $this->Role = $role;
      $this->Email = $email;
      $this->FirstName = $firstName;
      $this->LastName = $lastName;
      $this->Gender = $gender;
      $this->Country = $country;
      $this->Entity = $entity;
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

    function SetFirstName($value) {
      $this->FirstName = $value;
    }

    function GetLastName() {
      return $this->LastName;
    }

    function SetLastName($value) {
      $this->LastName = $value;
    }

    function GetName() {
      return $this->FirstName." ".$this->LastName;
    }

    function GetGender() {
      return $this->Gender;
    }

    function SetGender($value) {
      $this->Gender = $value;
    }

    function GetEntity() {
      return $this->Entity;
    }

    function SetEntity($value) {
      $this->Entity = $value;
    }

    function GetCountry() {
      return $this->Country;
    }

    function SetCountry($value) {
      $this->Country = $value;
    }

    function Store() {
      if (!empty($this->Id)) {
        DB::update("users", array(
          "firstname" => $this->FirstName,
          "lastname" => $this->LastName,
          "gender" => $this->Gender,
          "entity" => $this->Entity,
          "country" => $this->Country
        ), "ID=%i", $this->Id);
      }
    }
  }

  function GetUserById($userId) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.ID=%i", $userId);
    if ($account) {
      return new UserModel($account["ID"], $account["role"], $account["email"], $account["firstname"], $account["lastname"], $account["gender"], $account["entity"], new Country($account["iso"], $account["name"]));
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
