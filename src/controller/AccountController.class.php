<?php
  require_once(BASE_URI."model/UserModel.class.php");
  require_once(BASE_URI."model/CountryModel.class.php");

  /**
   *
   */
  class AccountController extends BaseController
  {
    function Login($email, $password) {
      if (DoLogin($email, md5($password))) {
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

    function ShowProfile() {
      $this->SetContentView("profile");
      $this->Render();
    }

    function UpdateProfile() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /account/profile");
      }
      $UserId = $GLOBALS["UserSession"]->GetId();

      // Getting POST paramters
      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $gender = $_POST["gender"];
      $entity = $_POST["entity"];
      $country = $_POST["country"];

      if ((strlen($firstname) < 3) || (strlen($firstname) > 45)) {
        $this->Error .= "<li>El nombre tiene que tener entre 3 y 45 carácteres.</li>";
      }

      if ((strlen($lastname) < 3) || (strlen($lastname) > 45)) {
        $this->Error .= "<li>Los apellidos tienen que tener entre 3 y 45 carácteres.</li>";
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
        $this->Error = "Tu perfil contiene errores: <br /><ul>".$this->Error."</ul>";
      } else {
        $User = GetUserById($UserId);
        $User->SetFirstName($firstname);
        $User->SetLastName($lastname);
        $User->SetGender($gender);
        $User->SetEntity($entity);
        $User->SetCountry($country);

        $User->Store();

        // Actualizamos la información de la Sesión
        $GLOBALS["UserSession"] = GetUserById($UserId);

        $this->Success = "¡Tu perfil ha sido actualizado correctamente!";
      }

      // Render View
      $this->SetContentView("profile");
      $this->Render();
    }
  }
?>
