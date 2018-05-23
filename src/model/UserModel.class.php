<?php

  /**
   * Users
   */
  class UserModel
  {
    private $id;
    private $role;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $gender;
    private $country;
    private $entity;

    public static function create() {
        $instance = new self(0, 0, '', '', '', '', 0, '', '', null);
        return $instance;
    }

    function __construct($id, $role, $email, $password, $firstName, $lastName, $gender, $entity, $country)
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
    }

    function getId() {
      return $this->id;
    }

    function getRole() {
      return $this->role;
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

    function setNewToken($token) {
      DB::update("users", array(
        "token" => $token
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
          "country" => $this->country->getIso()
        ), "ID=%i", $this->id);
      }
    }

    function insert() {
      DB::insert('users', array(
        "email" => $this->email,
        "role" => $this->role,
        "password" => $this->password,
        "firstname" => $this->firstName,
        "lastname" => $this->lastName,
        "gender" => $this->gender,
        "entity" => $this->entity,
        "country" => $this->country->getIso()
      ));
    }
  }

  function getUserById($userId) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.ID=%i", $userId);
    if ($account) {
      return new UserModel($account["ID"], $account["role"], $account["email"], $account["password"], $account["firstname"], $account["lastname"], $account["gender"], $account["entity"], new Country($account["iso"], $account["name"]));
    } else {
      return null;
    }
  }

  function getUserByEmail($email) {
    $account = DB::queryFirstRow("SELECT users.*, countries.iso, countries.name FROM users LEFT JOIN countries on users.country = countries.iso WHERE users.email=%s", $email);
    if ($account) {
      return new UserModel($account["ID"], $account["role"], $account["email"], $account["password"], $account["firstname"], $account["lastname"], $account["gender"], $account["entity"], new Country($account["iso"], $account["name"]));
    } else {
      return null;
    }
  }

  function getUsers($filter) {
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

  function userExists($userId) {
    DB::query("SELECT ID FROM users WHERE ID=%i", $userId);
    return DB::count() > 0;
  }

  function userEmailExists($email) {
    DB::query("SELECT ID FROM users WHERE email=%s", $email);
    return DB::count() > 0;
  }

  function doLogin($email, $password) {
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
