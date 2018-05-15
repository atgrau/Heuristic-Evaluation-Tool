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
      "/admin/update-profile" => 2,
      "/account/update-password" => 0,
      "/admin/users" => 2,
      "/admin/profile" => 2
    );

    private $Uri;

    function __construct($uri) {
      $this->Uri = $uri;
    }

    function Execute() {

      // 1- Firstly, check if Uri exists
      if (!isset($this->Uris[$this->Uri])) {
        $view = new BaseController("404","");
        $view->Render();
      }

      // 2- Check Uri and permissions
      if (!$this->CheckUriAndPermissions()) {
        // Can't access or Uri doesn't exist!!
        $view = new BaseController("login","");
        $view->required = true;
        $view->Render();
      }

      // 3- Load Controller
      if ($this->Uri == "/") {
        $view = new BaseController("index","");
        $view->Render();
      } else if ($this->Uri == "/signin") {
        $view = new BaseController("login","");
        $view->Render();
      } else if ($this->Uri == "/account/login") {
        $controller = new AccountController();
        $controller->Login();
      } else if ($this->Uri == "/account/logout") {
        $controller = new AccountController();
        $controller->Logout();
      } else if ($this->Uri == "/account/profile") {
        $controller = new AccountController();
        $controller->ShowProfile(false, $GLOBALS["UserSession"]->GetId());
      } else if ($this->Uri == "/account/update-profile") {
        $controller = new AccountController();
        $controller->UpdateProfile(false);
      } else if ($this->Uri == "/admin/update-profile") {
        $controller = new AccountController();
        $controller->UpdateProfile(true);
      } else if ($this->Uri == "/account/update-password") {
        $controller = new AccountController();
        $controller->UpdatePassword();
      } else if ($this->Uri == "/admin/users") {
        $controller = new AccountController();
        $controller->ShowUserList();
      } else if ($this->Uri == "/admin/profile") {
        $controller = new AccountController();
        $controller->ShowProfile(true, $_GET["param"]);
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
