<?php
  require_once(BASE_URI."config/database.php");

  /**
   * Users
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

    function __construct($id, $role, $email, $password, $firstName, $lastName, $gender, $entity, $country)
    {
      $this->Id = $id;
      $this->Role = $role;
      $this->Email = $email;
      $this->Password = $password;
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

    function SetEmail($value) {
      $this->Email = $value;
    }

    function GetPassword() {
      return $this->Password;
    }

    function SetPassword($value) {
      $this->Password = $value;
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
          "email" => $this->Email,
          "password" => $this->Password,
          "firstname" => $this->FirstName,
          "lastname" => $this->LastName,
          "gender" => $this->Gender,
          "entity" => $this->Entity,
          "country" => $this->Country->GetIso()
        ), "ID=%i", $this->Id);
      }
    }
  }

  function GetUserById($userId) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.ID=%i", $userId);
    if ($account) {
      return new UserModel($account["ID"], $account["role"], $account["email"], $account["password"], $account["firstname"], $account["lastname"], $account["gender"], $account["entity"], new Country($account["iso"], $account["name"]));
    } else {
      return null;
    }
  }

  function GetUsers($filter) {
    $userlist = array();
    $qry = "SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso";
    if (!empty($filter)) {
      $condition = " WHERE users.email like %ss OR users.firstname like %ss OR users.lastname like %ss";
      $qry .= $condition." ORDER BY users.ID";
      $users = DB::query($qry, $filter, $filter, $filter);
    } else {
      $qry .= " ORDER BY users.ID";
      $users = DB::query($qry);
    }

    if ($users) {
      foreach ($users as $row) {
        array_push($userlist, new UserModel($row["ID"], $row["role"], $row["email"], $row["password"], $row["firstname"], $row["lastname"], $row["gender"], $row["entity"], new Country($row["iso"], $row["name"])));
      }
      return $userlist;
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
