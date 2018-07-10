<?php

  /**
   * Users
   */
  class User
  {
    private $id;
    private $role;
    private $email;
    private $password;
    private $clearPassword;
    private $firstName;
    private $lastName;
    private $gender;
    private $country;
    private $entity;

    public static function create() {
        $instance = new self(0, 0, '', '', '', '', 0, '', '', 1);
        return $instance;
    }

    function __construct($id, $role, $email, $password, $firstName, $lastName, $gender, $entity, $country, $active)
    {
      $this->id = $id;
      $this->role = $role;
      $this->email = $email;
      $this->password = $password;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->gender = $gender;
      $this->country = $country;
      $this->entity = $entity;
      $this->active = $active;
    }

    function getId() {
      return $this->id;
    }

    function getRole() {
      return $this->role;
    }

    function isAdmin() {
      return ($this->role == 2);
    }

    function isProjectManager() {
      return ($this->role == 1);
    }

    function setRole($value) {
      $this->role = $value;
    }

    function getEmail() {
      return $this->email;
    }

    function setEmail($value) {
      $this->email = $value;
    }

    function getPassword() {
      return $this->password;
    }

    function setPassword($value) {
      $this->password = $value;
    }

    function getClearPassword() {
      return $this->clearPassword;
    }

    function setClearPassword($value) {
      $this->clearPassword = $value;
    }

    function getFirstName() {
      return $this->firstName;
    }

    function setFirstName($value) {
      $this->firstName = $value;
    }

    function getLastName() {
      return $this->lastName;
    }

    function setLastName($value) {
      $this->lastName = $value;
    }

    function getName() {
      return $this->firstName." ".$this->lastName;
    }

    function getGender() {
      return $this->gender;
    }

    function setGender($value) {
      $this->gender = $value;
    }

    function getEntity() {
      return $this->entity;
    }

    function setEntity($value) {
      $this->entity = $value;
    }

    function getCountry() {
      return $this->country;
    }

    function setCountry($value) {
      $this->country = $value;
    }

    function isActive() {
      return $this->active;
    }

    function setActive($value) {
      $this->active = $value;
    }

    function setNewToken($token) {
      DB::update("users", array(
        "token" => $token
      ), "ID=%i", $this->id);
    }

    function resetToken() {
      DB::update("users", array(
        "token" => ""
        ), "ID=%i", $this->id);
    }

    function update() {
      if (!empty($this->id)) {
        DB::update("users", array(
          "role" => $this->role,
          "password" => $this->password,
          "firstname" => $this->firstName,
          "lastname" => $this->lastName,
          "gender" => $this->gender,
          "entity" => $this->entity,
          "country" => $this->country->getIso(),
          "active" => $this->active
        ), "ID=%i", $this->id);
      }
    }

    function insert() {
      if (!$this->country) {
        $country = "";
      } else {
        $country = $this->country->getIs();
      }
      DB::insert('users', array(
        "email" => $this->email,
        "role" => $this->role,
        "password" => $this->password,
        "firstname" => $this->firstName,
        "lastname" => $this->lastName,
        "gender" => $this->gender,
        "entity" => $this->entity,
        "country" => $country,
        "active" => true
      ));
    }

    function remove() {
      // Delete evaluations
      DB::delete('evaluation_results', "id_evaluation=(SELECT ID FROM evaluations WHERE id_user = %i)", $this->id);
      DB::delete('evaluations', "id_user=%i", $this->id);

      // Delete Project Users
      DB::delete('projects_user', "id_user=%i", $this->id);
      DB::delete('projects', "id_user=%i", $this->id);

      // Delete User
      DB::delete('users', "ID=%i", $this->id);
    }
  }

  function buildUser($account) {
    if ($account) {
      return new User($account["ID"], $account["role"], $account["email"], $account["password"], $account["firstname"], $account["lastname"], $account["gender"], $account["entity"], new Country($account["iso"], $account["name"]), boolval($account["active"]));
    } else {
      return null;
    }
  }

  function getUsersByRoleGreaterThan($role) {
    $userlist = array();
    $users = DB::query("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.role>%i", $role);
    if ($users) {
      foreach ($users as $row) {
        array_push($userlist, buildUser($row));
      }
      return $userlist;
    } else {
      return null;
    }
  }

  function getUserById($userId) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.ID=%i", $userId);
    return buildUser($account);
  }

  function getUserByEmail($email) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.email=%s", $email);
    return buildUser($account);
  }

  function getUserByToken($token) {
    $account = DB::queryFirstRow("SELECT * FROM users WHERE token=%s", $token);
    return buildUser($account);
  }

  function getUsers($filter) {
    $userlist = array();
    $qry = "SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso";
    if (!empty($filter)) {
      $condition = " WHERE users.email like %ss OR users.firstname like %ss OR users.lastname like %ss OR users.entity like %ss";
      $qry .= $condition." ORDER BY users.lastname";
      $users = DB::query($qry, $filter, $filter, $filter, $filter);
    } else {
      $qry .= " ORDER BY users.lastname";
      $users = DB::query($qry);
    }

    if ($users) {
      foreach ($users as $row) {
        array_push($userlist, buildUser($row));
      }
      return $userlist;
    } else {
      return null;
    }
  }

  function userExists($userId) {
    DB::query("SELECT ID FROM users WHERE ID=%i", $userId);
    return DB::count() > 0;
  }

  function userEmailExists($email) {
    DB::query("SELECT ID FROM users WHERE email=%s", $email);
    return DB::count() > 0;
  }

  function doLogin($email, $password) {
    $account = DB::queryFirstRow("SELECT ID FROM users WHERE active = 1 AND email=%s AND password=%s", $email, $password);
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
