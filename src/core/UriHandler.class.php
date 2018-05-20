<?php
  // Controllers
  require_once(BASE_URI."controller/BaseController.class.php");
  require_once(BASE_URI."controller/AccountController.class.php");
  require_once(BASE_URI."controller/ProjectController.class.php");

  /**
   * Uri Handler -> Call controller
   */
  class UriHandler
  {
    // Defined Uris and minmium role to acces in
    private $uris = array(
      "/" => -1,
      "/signin" => -1,
      "/account/login" => -1,
      "/account/logout" => 0,
      "/account/profile" => 0,
      "/account/update-profile" => 0,
      "/account/update-password" => 0,
      "/my-projects" => 1,
      "/projects/new" => 1,
      "/admin/update-profile" => 2,
      "/admin/users" => 2,
      "/admin/profile" => 2,
      "/admin/new-user" => 2,
    );

    private $uri;

    function __construct($uri) {
      $this->uri = $uri;
    }

    function execute() {

      // 1- Firstly, check if Uri exists
      if (!isset($this->uris[$this->uri])) {
        $view = new BaseController("404","");
        $view->render();
      }

      // 2- Check Uri and permissions
      if (!$this->checkUriAndPermissions()) {
        // Can't access or Uri doesn't exist!!
        $view = new BaseController("login","");
        $view->required = true;
        $view->render();
      }

      // 3- Load Controller
      if ($this->uri == "/") {
        $view = new BaseController("index","");
        $view->render();
      } else if ($this->uri == "/signin") {
        $view = new BaseController("login","");
        $view->render();
      } else if ($this->uri == "/account/login") {
        $controller = new AccountController();
        $controller->login();
      } else if ($this->uri == "/account/logout") {
        $controller = new AccountController();
        $controller->logout();
      } else if ($this->uri == "/account/profile") {
        $controller = new AccountController();
        $controller->showProfile(false);
      } else if ($this->uri == "/account/update-profile") {
        $controller = new AccountController();
        $controller->updateProfile(false);
      } else if ($this->uri == "/account/update-password") {
        $controller = new AccountController();
        $controller->updatePassword();
      } else if ($this->uri == "/my-projects") {
        $controller = new ProjectController();
        $controller->showProjectList();
      } else if ($this->uri == "/projects/new") {
        $controller = new ProjectController();
        $controller->addNewProject();
      } else if ($this->uri == "/admin/update-profile") {
        $controller = new AccountController();
        $controller->updateProfile(true);
      } else if ($this->uri == "/admin/users") {
        $controller = new AccountController();
        $controller->showUserList();
      } else if ($this->uri == "/admin/profile") {
        $controller = new AccountController();
        $controller->showProfile(true);
      } else if ($this->uri == "/admin/new-user") {
        $controller = new AccountController();
        $controller->addNewUser();
      } else {
        include(BASE_URI."view/index.php");
      }

    }

    function checkUriAndPermissions() {
      if (($this->uri == "/signin") || ($this->uri == "/account/login")) { // User tries to sign in
        return true;
      } else if ((!isset($GLOBALS["USER_SESSION"])) && ($this->uri == "/")) { // First page
        $this->uri = "/signin";
        return true;
      } else if ((!isset($GLOBALS["USER_SESSION"])) || ($this->uris[$this->uri] > $GLOBALS["USER_SESSION"]->GetRole())) { // User tries to access private content without a minumum role level
        return false;
      } else {
        return true;
      }
    }
  }
?>
