<?php

  /**
   * Account Controller
   */
  class AccountController extends BaseController
  {

    function __construct() { }

    function login() {
      if (doLogin($_POST["email"], md5($_POST["password"]))) {
        if (!empty($_POST["uri"])) {
          header("Location: ".$_POST["uri"]);
        } else {
          header("Location: /");
        }
      } else {
        $this->setView("login");
        $this->setContent("signin");
        $this->error = true;
        $this->email = $_POST["email"];
        $this->uri = $_POST["uri"];
        $this->render();
      }
    }

    function logout() {
      session_start();
      session_destroy();
      unset($_SESSION);
      header("Location: /");
    }

    function forgot() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /forgot");
      }

      if (!userEmailExists($_POST["email"])) {
        $this->error = "<span class='glyphicon glyphicon-remove-sign'></span> E-mail does not exists in our database";
      } else {
        // Generate a token
        $token = md5(randomPassword());

        $user = getUserByEmail($_POST["email"]);
        $user->setNewToken($token);

        // Send an Email
        $subject = "Reset Password";
        $body = "Hello <b>".$user->getName()."</b>, <br /><br />";
        $body .= "You have requested to reset your password.<br /><br />";
        $body .= "You can proceed by doing click below:<br />";
        $body .= "<a href='".URL."/forgot/reset?token=".$token."' target='_blank'>".URL."/forgot/reset/?token=".$token."</a><br /><br />";
        $body .= "If you have not request a password reset, please remove this e-mail.<br /><br />";

        $email = new Email($_POST["email"], $subject, $body);
        $email->send();

        $this->recovered = "<span class='glyphicon glyphicon-info-sign'></span> Check your email for more information on how to reset your password.";
      }
      $this->setView("login");
      $this->setContent("forgot");
      $this->render();
    }

    function reset() {
      $this->token = $_GET["token"];
      $this->setView("login");
      $this->setContent("reset");
      $this->render();
    }

    function generateNewPassword() {
      $user = getUserByToken($_POST["token"]);

      if (!$user) {
        $this->setView("login");
        $this->setContent("signin");
        $this->render();
      } else {
        $password = randomPassword();
        $md5Password = md5($password);

        $user->setPassword($md5Password);

        // Insert new user to database
        $user->update();
        $user->resetToken();

        // Send and Email with Password
        $subject = "Recovered Account";
        $body = "Hello <b>".$user->getName()."</b>, <br /><br />";
        $body .= "Your account has been recovered successfully!<br /><br />";
        $body .= "You can access using the following credentials:<br />";
        $body .= "<b>Email:</b> ".$user->getEmail()."<br />";
        $body .= "<b>Password:</b> ".$password."<br /><br />";
        $body .= "<a href='".URL."' target='_blank'>Click here to Sign In</a><br /><br />";

        $email = new Email($user->getEmail(), $subject, $body);
        $email->send();
      }

      $this->setView("login");
      $this->setContent("generated");
      $this->render();
    }

    function showProfile($adminView) {
      $this->setContentView("account/profile");
      $this->admin = $adminView;
      $this->new = false;

      if (($this->admin) && (!empty($_POST["UserId"]))){
        $this->user = getUserById($_POST["UserId"]);
        $this->action = "/admin/user-update";
      } else if (($this->admin) && (!empty($_GET["param"]))){
        $this->user = getUserById($_GET["param"]);
        $this->action = "/admin/user-update";
      } else {
        $this->user = getUserById($GLOBALS["USER_SESSION"]->GetId());
        $this->action = "/account/update-profile";
      }

      if (!$this->user) {
        $this->showUserList($adminView);
      } else {
        $this->render();
      }
    }

    function updateProfile($isAdmin) {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /account/profile");
      }

      if ($isAdmin) {
        $userId = $_POST["UserId"];
      } else {
        $userId = $GLOBALS["USER_SESSION"]->getId();
      }

      // Getting POST paramters
      $role = $_POST["role"];
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $gender = $_POST["gender"];
      $entity = $_POST["entity"];
      $country = $_POST["country"];

      // Validation
      if (($isAdmin) && ($role != 0) && ($role != 1) && ($role != 2)) {
        $this->error .= "<li>Specified role is not valid.</li>";
      }

      if (($isAdmin) && ($role != 2) && ($userId == $GLOBALS["USER_SESSION"]->getId())) {
        $this->error .= "<li>You cannot re-assign a role to yourself.</li>";
      }

      $this->validateProfile($firstname, $lastname, $gender, $entity, $country);

      if (!empty($this->error)) {
        $this->error = "<span class='glyphicon glyphicon-remove-sign'></span> The new profile has errors: <br /><ul>".$this->error."</ul>";
      } else {
        $user = getUserById($userId);

        // Only if is Admin
        if ($isAdmin) {
          $user->setRole($role);
        }
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setGender($gender);
        $user->setEntity($entity);
        $user->setCountry(new Country($country, getCountryByIso($country)));

        $user->update();

        // Actualizamos la información de la Sesión
        if ($GLOBALS["USER_SESSION"]->getId() == $userId) {
          $GLOBALS["USER_SESSION"] = getUserById($userId);
        }

        if ($isAdmin)
          $this->success = "<span class='glyphicon glyphicon-info-sign'></span> ".$user->getFirstName()."'s profile has been updated successfully!";
        else
          $this->success = "<span class='glyphicon glyphicon-info-sign'></span> Your profile has been updated successfully!";
      }

      $this->tab = 0;

      if (($isAdmin) && (empty($this->error))) {
        $this->showUserList();
      } elseif ($isAdmin) {
        $this->showProfile(true);
      } else {
        $this->showProfile(false);
      }
    }

    function validateProfile($firstname, $lastname, $gender, $entity, $country) {

      if (empty($firstname)) {
        $this->error .= "<li>First name is required.</li>";
      }

      if (strlen($firstname) > 45) {
        $this->error .= "<li>First name cannot contain more than 45 characters.</li>";
      }

      if (empty($lastname)) {
        $this->error .= "<li>Last name is required.</li>";
      }

      if (strlen($lastname) > 45) {
        $this->error .= "<li>Last name cannot contain more than 45 characters</li>";
      }

      $gender = (int) $gender;
      if (($gender != 0) && ($gender != 1)) {
        $this->error .= "<li>Gender is not valid.</li>";
      }

      if (strlen($entity) > 70) {
        $this->error .= "<li>Entity name cannot contain more than 70 characters.</li>";
      }

      if (!CountryExists($country)) {
        $this->error .= "<li>Country doesn't exist.</li>";
      }
    }

    function updatePassword() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /account/profile");
      }

      $userId = $GLOBALS["USER_SESSION"]->getId();

      $clearpassword = $_POST["newpassword"];
      $password = md5($_POST["password"]);
      $newpassword = md5($_POST["newpassword"]);
      $newpassword2 = md5($_POST["newpassword2"]);

      $user = getUserById($userId);

      if ($user->getPassword() != $password) {
        $this->error .= "<li>La contraseña actual no correcta.</li>";
      }

      if (strlen($clearpassword) < 6) {
        $this->error .= "<li>La contraseña tiene que tener como mínimo 6 carácteres.</li>";
      }

      if ($newpassword != $newpassword2) {
        $this->error .= "<li>Las contraseñas no coinciden.</li>";
      }

      $this->tab = 1;

      if (!empty($this->error)) {
        $this->error = "Tu solicitud de cambio de contraseña contiene errores: <br /><ul>".$this->error."</ul>";
      } else {
        $user->setPassword($newpassword);
        $user->update();
        $this->success = "¡Tu contraseña ha sido actualizada correctamente!";
      }
      $this->showProfile(false, $GLOBALS["USER_SESSION"]->getId());
    }

    // Admin Functions below
    function showUserList() {
      $this->setContentView("account/userlist");
      $this->query = $_GET["q"];
      $this->userList = getUsers($this->query);
      $this->render();
    }

    function addNewUserView() {
      $this->setContentView("account/profile");
      $this->new = true;
      $this->admin = true;
      $this->action = "/admin/add-user";
      $this->render();
    }

    function addNewUser() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /admin/users");
      }

      // Getting POST paramters
      $email = $_POST["email"];
      $role = $_POST["role"];
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $gender = $_POST["gender"];
      $entity = $_POST["entity"];
      $country = $_POST["country"];

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error .= "<li>Invalid e-mail format.</li>";
      }

      if (userEmailExists($email)) {
        $this->error .= "<li>Specified e-mail already exists in our database.</li>";
      }

      if (($isAdmin) && ($role != 0) && ($role != 1) && ($role != 2)) {
        $this->error .= "<li>Specified role is not valid.</li>";
      }

      $this->validateProfile($firstname, $lastname, $gender, $entity, $country);

      if (!empty($this->error)) {
        $this->error = "<span class='glyphicon glyphicon-remove-sign'></span> The new profile has errors: <br /><ul>".$this->error."</ul>";

        $this->setContentView("account/profile");
        $this->new = true;
        $this->admin = true;
        $this->action = "/admin/add-user";
        $this->render();
      } else {
        $user = UserModel::create();

        // Generate new Password
        $password = randomPassword();
        $md5Password = md5($password);

        $user->setEmail($email);
        $user->setPassword($md5Password);
        $user->setRole($role);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setGender($gender);
        $user->setEntity($entity);
        $user->setCountry(new Country($country, getCountryByIso($country)));

        // Insert new user to database
        $user->insert();

        // Send and Email with Password
        $subject = "Welcome to ".APP_TITLE;
        $body = "Hello <b>".$user->getName()."</b>, <br /><br />";
        $body .= "Welcome to <b>".APP_TITLE."</b>, your account has been created successfully!<br /><br />";
        $body .= "You can access using the following credentials:<br />";
        $body .= "<b>Email:</b> ".$email."<br />";
        $body .= "<b>Password:</b> ".$password."<br /><br />";
        $body .= "<a href='".URL."' target='_blank'>Click here to Sign In</a><br /><br />";

        $email = new Email($email, $subject, $body);
        $email->send();

        // Render View
        $this->addMessage = true;
        $this->recentUser = $firstname;
        $this->showUserList();
      }
    }

    function removeUser() {
      // Getting POST paramters
      $user = getUserById($_GET["param"]);
      if (!$user) {
        $this->showUserList();
        exit;
      }

      // Check user dependencies

      // Delete Users

      //Render View
      $this->removeMessage = true;
      $this->recentUser = $user->getName();
      $this->showUserList();
    }
  }
?>
