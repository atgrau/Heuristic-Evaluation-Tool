<?php
  require_once(BASE_URI."model/UserModel.class.php");
  require_once(BASE_URI."model/CountryModel.class.php");

  /**
   *
   */
  class AccountController extends BaseController
  {

    function __construct() { }

    function Login() {
      if (DoLogin($_POST["email"], md5($_POST["password"]))) {
        header("Location: /");
      } else {
        $this->SetView("login");
        $this->error = true;
        $this->email = $email;
        $this->Render();
      }
    }

    function Logout() {
      session_start();
      session_destroy();
      unset($_SESSION);
      header("Location: /");
    }

    function ShowProfile($adminView, $userId) {
      $this->SetContentView("account/profile");
      $this->User = GetUserById($userId);
      if ($adminView) {
        $this->Action = "/admin/update-profile";
      } else {
        $this->Action = "/account/update-profile";
      }
      $this->Render();
    }

    function UpdateProfile($isAdmin) {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /account/profile");
      }

      if ($isAdmin) {
        $UserId = $_POST["UserId"];
      } else {
        $UserId = $GLOBALS["UserSession"]->GetId();
      }

      // Getting POST paramters
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $gender = $_POST["gender"];
      $entity = $_POST["entity"];
      $country = $_POST["country"];

      if (empty($firstname)) {
        $this->Error .= "<li>El nombre es obligatorio.</li>";
      }

      if (strlen($firstname) > 45) {
        $this->Error .= "<li>El nombre no puede contener más de 45 carácteres.</li>";
      }

      if (empty($lastname)) {
        $this->Error .= "<li>Los apellidos son obligatorios.</li>";
      }

      if (strlen($lastname) > 45) {
        $this->Error .= "<li>Los apellidos no pueden contener más de 45 carácteres.</li>";
      }

      if (($gender != 0) && ($gender != 1)) {
        $this->Error .= "<li>El género indicado no es correcto.</li>";
      }

      if (strlen($entity) > 70) {
        $this->Error .= "<li>El nombre de la organización no puede sobrepasar los 70 carácteres.</li>";
      }

      if (!CountryExists($country)) {
        $this->Error .= "<li>El país indicado no existe.</li>";
      }

      if (!empty($this->Error)) {
        $this->Error = "El nuevo perfil contiene errores: <br /><ul>".$this->Error."</ul>";
      } else {
        $User = GetUserById($UserId);
        $User->SetFirstName($firstname);
        $User->SetLastName($lastname);
        $User->SetGender($gender);
        $User->SetEntity($entity);
        $User->SetCountry(new Country($country, GetCountryByIso($country)));

        $User->Store();

        // Actualizamos la información de la Sesión
        if ($GLOBALS["UserSession"]->GetId() == $UserId) {
          $GLOBALS["UserSession"] = GetUserById($UserId);
        }

        $this->Success = "¡Los datos han sido actualizados correctamente!";
      }

      $this->Tab = 0;

      if ($isAdmin) {
        $this->ShowProfile(true, $_POST["UserId"]);
      } else {
        $this->ShowProfile(false, $GLOBALS["UserSession"]->GetId());
      }
    }

    function UpdatePassword() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /account/profile");
      }
      $UserId = $GLOBALS["UserSession"]->GetId();

      $clearpassword = $_POST["newpassword"];
      $password = md5($_POST["password"]);
      $newpassword = md5($_POST["newpassword"]);
      $newpassword2 = md5($_POST["newpassword2"]);

      $User = GetUserById($UserId);

      if ($User->GetPassword() != $password) {
        $this->Error .= "<li>La contraseña actual no correcta.</li>";
      } else if (strlen($clearpassword) < 6) {
        $this->Error .= "<li>La contraseña tiene que tener como mínimo 6 carácteres.</li>";
      } else if ($newpassword != $newpassword2) {
        $this->Error .= "<li>Las contraseñas no coinciden.</li>";
      }

      if (!empty($this->Error)) {
        $this->Error = "Tu solicitud de cambio de contraseña contiene errores: <br /><ul>".$this->Error."</ul>";
      } else {

        $User->SetPassword($newpassword);

        $User->Store();

        $this->Success = "¡Tu contraseña ha sido actualizada correctamente!";
      }

      // Render View
      $this->Tab = 1;
      $this->ShowProfile(false, $GLOBALS["UserSession"]->GetId());

    }


    // Admin Functions below

    function ShowUserList() {
      $this->SetContentView("admin/userlist");
      $this->query = $_GET["q"];
      $this->Render();
    }

  }
?>
