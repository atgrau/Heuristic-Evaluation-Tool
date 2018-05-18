<?php
  require_once(BASE_URI."model/UserModel.class.php");
  require_once(BASE_URI."model/CountryModel.class.php");

  /**
   *
   */
  class AccountController extends BaseController
  {

    function __construct() { }

    function login() {
      if (doLogin($_POST["email"], md5($_POST["password"]))) {
        header("Location: /");
      } else {
        $this->setView("login");
        $this->error = true;
        $this->email = $email;
        $this->render();
      }
    }

    function logout() {
      session_start();
      session_destroy();
      unset($_SESSION);
      header("Location: /");
    }

    function showProfile($adminView) {
      $this->setContentView("account/profile");
      $this->admin = $adminView;

      if (($this->admin) && (!empty($_POST["UserId"]))){
        $this->user = getUserById($_POST["UserId"]);
        $this->action = "/admin/update-profile";
      } else if (($this->admin) && (!empty($_GET["param"]))){
        $this->user = getUserById($_GET["param"]);
        $this->action = "/admin/update-profile";
      } else {
        $this->user = getUserById($GLOBALS["USER_SESSION"]->GetId());
        $this->action = "/account/update-profile";
      }
      $this->render();
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

      if (($isAdmin) && ($role != 0) && ($role != 1) && ($role != 2)) {
        $this->error .= "<li>El rol especificado no es correto.</li>";
      }

      if (($isAdmin) && ($role != 2) && ($userId == $GLOBALS["USER_SESSION"]->getId())) {
        $this->error .= "<li>No puedes re-asignarte un rol a ti mismo.</li>";
      }

      if (empty($firstname)) {
        $this->error .= "<li>El nombre es obligatorio.</li>";
      }

      if (strlen($firstname) > 45) {
        $this->error .= "<li>El nombre no puede contener más de 45 carácteres.</li>";
      }

      if (empty($lastname)) {
        $this->error .= "<li>Los apellidos son obligatorios.</li>";
      }

      if (strlen($lastname) > 45) {
        $this->error .= "<li>Los apellidos no pueden contener más de 45 carácteres.</li>";
      }

      if (($gender != 0) && ($gender != 1)) {
        $this->error .= "<li>El género indicado no es correcto.</li>";
      }

      if (strlen($entity) > 70) {
        $this->error .= "<li>El nombre de la organización no puede sobrepasar los 70 carácteres.</li>";
      }

      if (!CountryExists($country)) {
        $this->error .= "<li>El país indicado no existe.</li>";
      }

      if (!empty($this->error)) {
        $this->error = "El nuevo perfil contiene errores: <br /><ul>".$this->error."</ul>";
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

        $user->store();

        // Actualizamos la información de la Sesión
        if ($GLOBALS["USER_SESSION"]->getId() == $userId) {
          $GLOBALS["USER_SESSION"] = getUserById($userId);
        }

        $this->success = "¡Los datos han sido actualizados correctamente!";
      }

      $this->tab = 0;

      if ($isAdmin) {
        $this->showProfile(true, $_POST["UserId"]);
      } else {
        $this->showProfile(false, $GLOBALS["USER_SESSION"]->getId());
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

      if (!empty($this->error)) {
        $this->error = "Tu solicitud de cambio de contraseña contiene errores: <br /><ul>".$this->error."</ul>";
      } else {

        $user->setPassword($newpassword);

        $user->store();

        $this->success = "¡Tu contraseña ha sido actualizada correctamente!";
      }

      // Render View
      $this->tab = 1;
      $this->showProfile(false, $GLOBALS["USER_SESSION"]->getId());

    }


    // Admin Functions below

    function showUserList() {
      $this->setContentView("admin/userlist");
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
      $this->addMessage = true;
      $this->recentUser = "Toni";
      $this->showUserList();
    }

  }
?>
