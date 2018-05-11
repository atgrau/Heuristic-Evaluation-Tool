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
      "/" => -1,
      "/signin" => -1,
      "/account/login" => -1,
      "/account/logout" => 0,
      "/account/profile" => 0,
      "/account/update-profile" => 0,
      "/account/update-password" => 0
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
        $controller = new AccountController();
        $controller->Login($_POST["email"], $_POST["password"]);
      } else if ($this->Uri == "/account/logout") {
        $controller = new AccountController();
        $controller->Logout();
      } else if ($this->Uri == "/account/profile") {
        $controller = new AccountController();
        $controller->ShowProfile();
      } else if ($this->Uri == "/account/update-profile") {
        $controller = new AccountController();
        $controller->UpdateProfile();
      } else if ($this->Uri == "/account/update-password") {
        $controller = new AccountController();
        $controller->UpdatePassword();
      } else {
        include(BASE_URI."view/index.php");
      }

    }

    function CheckUriAndPermissions() {
      if (($this->Uri == "/signin") || ($this->Uri == "/account/login")) { // User tries to sign in
        return true;
      } else if ((!isset($GLOBALS["UserSession"])) && ($this->Uri == "/")) { // First page
        $this->Uri = "/signin";
        return true;
      } else if ((!isset($GLOBALS["UserSession"])) || ($this->Uris[$this->Uri] > $GLOBALS["UserSession"]->GetRole())) { // User tries to access private content without a minumum role level
        return false;
      } else {
        return true;
      }
    }
  }
?>
