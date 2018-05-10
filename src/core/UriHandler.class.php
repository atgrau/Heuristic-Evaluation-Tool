<?php
  // Controllers
  require_once(BASE_URI."controller/BaseController.class.php");
  require_once(BASE_URI."controller/AccountController.class.php");

  /**
   * Uri Handler -> Call controller
   */
  class UriHandler
  {
    // Defined Uris and minmium role to acces in
    private $Uris = array(
      "/" => 1,
      "/signin" => 0,
      "/account/login" => 0,
      "/account/logout" => 0,
      "/account/profile" => 1
    );

    private $Uri;

    function __construct($uri) {
      $this->Uri = $uri;
    }

    function Execute() {

      // 1- Firstly, check if Uri exists
      if (!isset($this->Uris[$this->Uri])) {
        $view = new BaseController("404");
        $view->Render();
      }

      // 2- Check Uri and permissions
      if (!$this->CheckUriAndPermissions()) {
        // Can't access or Uri doesn't exist!!
        $view = new BaseController("login");
        $view->required = true;
        $view->Render();
      }

      // 3- Load Controller
      if ($this->Uri == "/") {
        $view = new BaseController("index");
        $view->Render();
      } else if ($this->Uri == "/signin") {
        $view = new BaseController("login");
        $view->Render();
      } else if ($this->Uri == "/account/login") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $controller = new AccountController();
        $controller->Login($email, $password);
      } else if ($this->Uri == "/account/logout") {
        $controller = new AccountController();
        $controller->Logout();
      } else if ($this->Uri == "/account/profile") {
        $controller = new AccountController();
        $controller->Profile();
      } else {
        include(BASE_URI."view/index.php");
      }

    }

    function CheckUriAndPermissions() {
      GLOBAL $UserSession;

      if (($this->Uri == "/signin") || ($this->Uri == "/account/login")) { // User tries to sign in
        return true;
      } else if ((!isset($UserSession)) && ($this->Uri == "/")) { // First page
        $this->Uri = "/signin";
        return true;
      } else if ((!isset($UserSession)) || ($this->Uris[$this->Uri] > $UserSession->GetRole())) { // User tries to access private content without a minumum role level
        return false;
      } else {
        return true;
      }
    }
  }
?>
