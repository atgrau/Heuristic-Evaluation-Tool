<?php

  /**
   * Uri Handler -> Call controller
   */
  class UriHandler
  {
    // Defined Uris and minmium role to acces in
    private $uris = array(
      "/" => -1,
      "/signin" => -1,
      "/forgot" => -1,
      "/forgot/send" => -1,
      "/forgot/reset" => -1,
      "/forgot/generate" => -1,
      "/account/login" => -1,
      "/about-us" => 0,
      "/logout" => 0,
      "/privacy-policy" => 0,
      "/legal-disclaimer" => 0,
      "/account/profile" => 0,
      "/account/update-profile" => 0,
      "/account/update-password" => 0,
      "/evaluations" => 0,
      "/evaluations/id" => 0,
      "/evaluation/update" => 0,
      "/evaluation/finish" => 0,
      "/evaluation/reopen" => 1,
      "/evaluation/remove" => 1,
      "/template/setCategory" => 0,
      "/my-projects" => 1,
      "/my-projects/new" => 1,
      "/my-projects/edit" => 1,
      "/my-projects/add" => 1,
      "/my-projects/update" => 1,
      "/my-projects/remove" => 1,
      "/my-projects/results" => 1,
      "/templates/view" => 1,
      "/templates/edit" => 2,
      "/templates/new" => 2,
      "/admin/projects" => 2,
      "/admin/project-update" => 2,
      "/admin/user-update" => 2,
      "/admin/users" => 2,
      "/admin/new-user" => 2,
      "/admin/add-user" => 2,
      "/admin/user-remove" => 2,
      "/admin/remove-users" => 2,
      "/admin/project-remove" => 2,
      "/admin/templates" => 2,
      "/template/category-remove" => 2,
      "/template/category-new" => 2,
      "/template/question-remove" => 2,
      "/template/question-new" => 2,
      "/template/answer-remove" => 2,
      "/template/answer-new" => 2,
      "/admin/importcsv" => 2,
      "/admin/process-csv" => 2,
      "/admin/template-remove" => 2,
      "/template/active" => 2,
      "/admin/content" => 2
    );

    private $uri;

    function __construct($uri) {
      $this->uri = $uri;
    }

    function execute() {
      // 1- Firstly, check if Uri exists
      if (!isset($this->uris[$this->uri])) {
        $view = new BaseController("404","");
        if ($this->uri != "/404"){
          $view->requestedUri = $this->uri;
        }
        $view->render();
      }

      // 2- Check Uri and permissions
      if (!$this->checkUriAndPermissions()) {
        // Can't access or Uri doesn't exist!!
        $view = new BaseController("login","signin");
        $view->required = true;
        $view->uri = $this->uri."/".$_GET["param"];
        $view->render();
      }

      // 3- Load Controller
      if ($this->uri == "/") {
        $view = new BaseController("index","");
        $view->render();
      } elseif ($this->uri == "/about-us") {
        $view = new BaseController("index","about-us");
        $view->setBreadcrumb(array(
            array("About Us")
        ));
        $view->render();
      } else if ($this->uri == "/signin") {
        $view = new BaseController("login","signin");
        $view->render();
      }  else if ($this->uri == "/forgot") {
        $view = new BaseController("login","forgot");
        $view->render();
      } else if ($this->uri == "/forgot/send") {
        $controller = new AccountController();
        $controller->forgot();
      } else if ($this->uri == "/forgot/reset") {
        $controller = new AccountController();
        $controller->reset();
      } else if ($this->uri == "/forgot/generate") {
        $controller = new AccountController();
        $controller->generateNewPassword();
      } else if ($this->uri == "/account/login") {
        $controller = new AccountController();
        $controller->login();
      } else if ($this->uri == "/logout") {
        $controller = new AccountController();
        $controller->logout();
      } else if ($this->uri == "/privacy-policy") {
        $view = new BaseController("index","privacy-policy");
        $view->setBreadcrumb(array(
            array("Privacy Policy")
        ));
        $view->render();
      } else if ($this->uri == "/legal-disclaimer") {
        $view = new BaseController("index","legal-disclaimer");
        $view->setBreadcrumb(array(
            array("Legal Disclaimer")
        ));
        $view->render();
      } else if ($this->uri == "/account/profile") {
        $controller = new AccountController();
        $controller->showProfile(false);
      } else if ($this->uri == "/account/update-profile") {
        $controller = new AccountController();
        $controller->updateProfile(false);
      } else if ($this->uri == "/account/update-password") {
        $controller = new AccountController();
        $controller->updatePassword();
      } else if ($this->uri == "/evaluations") {
        $controller = new ProjectController();
        $controller->showAssignedProjectList();
      } else if ($this->uri == "/evaluations/id") {
        $controller = new EvaluationController();
        $controller->showEvaluationTemplate($_GET["param"]);
      } else if ($this->uri == "/evaluation/reopen") {
        $controller = new EvaluationController();
        $controller->reOpenEvaluation();
      } else if ($this->uri == "/evaluation/remove") {
        $controller = new EvaluationController();
        $controller->removeEvaluation();
      } else if ($this->uri == "/my-projects/results") {
        $controller = new EvaluationController();
        $controller->showEvaluationResults($_GET["param"], $_GET["ajax"]!="1");
      }else if ($this->uri == "/evaluation/update") {
        $controller = new EvaluationController();
        $controller->update();
      } else if ($this->uri == "/evaluation/finish") {
        $controller = new EvaluationController();
        $controller->finish();
      } else if ($this->uri == "/my-projects") {
        $controller = new ProjectController();
        $controller->showProjectList(false);
      } else if ($this->uri == "/my-projects/new") {
        $controller = new ProjectController();
        $controller->addNewProjectView();
      } else if ($this->uri == "/my-projects/edit") {
        $controller = new ProjectController();
        $controller->updateProjectView(false, $_GET["param"]);
      } else if ($this->uri == "/my-projects/update") {
        $controller = new ProjectController();
        $controller->updateProject(false);
      } else if ($this->uri == "/my-projects/remove") {
        $controller = new ProjectController();
        $controller->removeProject(false);
      } else if ($this->uri == "/my-projects/add") {
        $controller = new ProjectController();
        $controller->addNewProject();
      } else if ($this->uri == "/admin/projects") {
        $controller = new ProjectController();
        if (empty($_GET["param"])) {
          $controller->showProjectList(true);
        } else {
          $controller->updateProjectView(true, $_GET["param"]);
        }
      } else if ($this->uri == "/admin/project-update") {
        $controller = new ProjectController();
        $controller->updateProject(true);
      } else if ($this->uri == "/admin/project-remove") {
        $controller = new ProjectController();
        $controller->removeProject(true);
      } else if ($this->uri == "/admin/user-update") {
        $controller = new AccountController();
        $controller->updateProfile(true);
      } else if ($this->uri == "/admin/remove-users") {
        $controller = new AccountController();
        $controller->removeUsers();
      } else if ($this->uri == "/admin/users") {
        $controller = new AccountController();
        if (!empty($_GET["param"])) {
          $controller->showProfile(true);
        } else {
          $controller->showUserList();
        }
      } else if ($this->uri == "/admin/new-user") {
        $controller = new AccountController();
        $controller->addNewUserView();
      } else if ($this->uri == "/admin/add-user") {
        $controller = new AccountController();
        $controller->addNewUser();
      } else if ($this->uri == "/admin/user-remove") {
        $controller = new AccountController();
        $controller->removeUser();
      } else if ($this->uri == "/templates/view") {
        $controller = new TemplateController();
        $controller->showTemplateView(false, $_GET["param"], 0, 0);
      } else if ($this->uri == "/admin/templates") {
        $controller = new TemplateController();
        if (!empty($_GET["param"]))  {
          $controller->showTemplateView(true, $_GET["param"], $_GET["edit"], 0);
        }
        else if (!empty($_GET["q"]))  {
          $controller->showTemplateList(true, $_GET["q"]);
        }
        else {
          $controller->showTemplateList(true, "");
        }
      } else if ($this->uri == "/templates/new") {
        $controller = new TemplateController();
        $controller->addNewTemplateView();
      }
       else if ($this->uri == "/templates/edit") {
        $controller = new TemplateController();
        $controller->updateTemplateView(false, $_GET["param"]);
      } else if ($this->uri == "/admin/template-remove") {
        $controller = new TemplateController();
        $controller->removeTemplate(true);
      } else if ($this->uri == "/template/category-remove") {
        $controller = new TemplateController();
        $controller->removeCategory();
      } else if ($this->uri == "/template/category-new") {
        $controller = new TemplateController();
        $controller->newCategory();
      } else if ($this->uri == "/template/question-remove") {
        $controller = new TemplateController();
        $controller->removeQuestion();
      } else if ($this->uri == "/template/question-new") {
        $controller = new TemplateController();
        $controller->newQuestion();
      } else if ($this->uri == "/template/answer-remove") {
        $controller = new TemplateController();
        $controller->removeAnswer();
      } else if ($this->uri == "/template/answer-new") {
        $controller = new TemplateController();
        $controller->newAnswer();
      } else if ($this->uri == "/template/active") {
        $controller = new TemplateController();
        $controller->editStateTemplate($_GET["param"], $_GET["edit"]);
      } else if ($this->uri == "/admin/importcsv") {
        $controller = new AccountController();
        $controller->newImport();
      } else if ($this->uri == "/admin/process-csv") {
        $controller = new AccountController();
        $controller->newImportProcess();
      } else if ($this->uri == "/admin/content") {
        $view = new BaseController("index","edit-content");
        $view->setBreadcrumb(array(
            array("Content")
        ));
        $view->editContent();
        $view->render();
      } else {
        include(BASE_URI."view/index.php");
      }

    }

    function checkUriAndPermissions() {
      if ((!isset($GLOBALS["USER_SESSION"])) && ($this->uri == "/")) { // First page
        header("Location: /signin");
      } else if ($this->uris[$this->uri] < 0) { // User tries to access public content
        return true;
      } else if ((!isset($GLOBALS["USER_SESSION"])) || ($this->uris[$this->uri] > $GLOBALS["USER_SESSION"]->getRole())) { // User tries to access private content without a minumum role level
        return false;
      } else {
        return true;
      }
    }
  }
?>
