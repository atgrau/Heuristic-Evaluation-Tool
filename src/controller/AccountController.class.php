<?php
  require_once(BASE_URI."model/UserModel.class.php");

  /**
   *
   */
  class AccountController extends BaseController
  {
    function Login($email, $password) {
      if (DoLogin($email, hash('sha256', $password))) {
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
      $_SESSION = array();
      session_destroy();
      header("Location: /");
    }
  }
?>
