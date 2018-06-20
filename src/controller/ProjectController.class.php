<?php

  class ProjectController extends BaseController
  {
    function __construct() { }

    function showProjectList($admin) {
      $this->admin = $admin;
      $this->setContentView("project/projectlist");
      $this->query = $_GET["q"];
      $this->userId = $_GET["user"];
      if (!$admin) {
        $this->projectList = getMyProjects($GLOBALS["USER_SESSION"]->getId(), $this->query);
      } else {
        $this->projectList = getProjects($this->query, $this->userId);
      }
      $this->render();
    }

    function addNewProjectView() {
      $this->setContentView("project/project");
      $this->render();
    }

    function addNewProject() {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /my-projects");
      }

      $project = new ProjectModel(0, $GLOBALS["USER_SESSION"]->getId(), null, $_POST["name"], $_POST["description"], $_POST["link"], false);
      $users = array();
      if ($_POST["users"]):
        foreach ($_POST["users"] as $user) {
          array_push($users, getUserById($user));
        }
        $project->setUsers($users);
      endif;

      // Validate Project
      $this->validateProject($project);

      $project->insert();

      foreach ($project->getUsers() as $user) {
        // Send Email to the users
        $subject = "You have been assigned to a new project";
        $body = "Hello <b>".$user->getName()."</b>, <br /><br />";
        $body .= "You have been assigned to a new project:<br />";
        $body .= "<ul>";
        $body .= "<li><strong>Name:</strong> ".$project->getName()."</li>";
        $body .= "<li><strong>Description:</strong> ".$project->getDescription()."</li>";
        $body .= "<li><strong>Link:</strong> ".$project->getLink()."</li>";
        $body .= "</ul>";
        $body .= "<br />Now, you can evaluate it by using ".APP_TITLE."<br /><br />";

        $email = new Email($user->getEmail(), $subject, $body);
        $email->send();
      }

      $this->addMessage = true;
      $this->recentProject = $_POST["name"];
      $this->showProjectList(false);
    }

    function updateProjectView($adminView, $projectId) {
      $project = getProjectById($projectId);
      if ((!$project) || ((!$GLOBALS["USER_SESSION"]->isAdmin()) && ($GLOBALS["USER_SESSION"]->getId() != $project->getUser()->getId()))){
          $this->showProjectList($adminView);
      } else {
        $this->setContentView("project/project");
        $this->project = $project;
        $this->adminView = $adminView;
        $this->render();
      }
    }

    function updateProject($adminView) {
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /");
      }

      $project = getProjectById($_POST["id"]);
      if ((!$project) || ((!$GLOBALS["USER_SESSION"]->isAdmin()) && ($GLOBALS["USER_SESSION"]->getId() != $project->getUser()->getId()))){
        header("Location: /");
      } else {
        $project->setName($_POST["name"]);
        $project->setDescription($_POST["description"]);
        $project->setLink($_POST["link"]);

        if ($adminView) {
          $project->setActive($_POST["active"]=="1");
        }

        $users = array();
        if ($_POST["users"]):
          foreach ($_POST["users"] as $user) {
            array_push($users, getUserById($user));
          }
          $project->setUsers($users);
        endif;

        // Validate Project
        $this->validateProject($project);

        // Update Project
        $project->update();

        foreach ($project->getUsers() as $user) {
          // Send Email to the users
          $subject = "A project that you have been assigned in was modified";
          $body = "Hello <b>".$user->getName()."</b>, <br /><br />";
          $body .= "You are assigned in a project which has been modified, check the newer information:<br />";
          $body .= "<ul>";
          $body .= "<li><strong>Name:</strong> ".$project->getName()."</li>";
          $body .= "<li><strong>Description:</strong> ".$project->getDescription()."</li>";
          $body .= "<li><strong>Link:</strong> ".$project->getLink()."</li>";
          $body .= "</ul>";
          $body .= "<br />Now, you can evaluate it by using ".APP_TITLE."<br /><br />";

          $email = new Email($user->getEmail(), $subject, $body);
          $email->send();
        }

        $this->editMessage = true;
        $this->recentProject = $_POST["name"];
        $this->showProjectList($adminView);
      }
    }

    function validateProject($project) {
      $validate = "";
      if (strlen($project->getName()) > 50) {
        $validate .= "<li>Project's name cannot contain more than 50 characters.</li>";
      }

      if (strlen($project->getName()) == 0) {
        $validate .= "<li>Project's name cannot be empty.</li>";
      }

      if (strlen($project->getDescription()) > 1000) {
        $validate .= "<li>Project's description cannot contain more than 1000 characters.</li>";
      }

      if (strlen($project->getDescription()) == 0) {
        $validate .= "<li>Project's description cannot be empty.</li>";
      }

      if (strlen($project->getLink()) > 50) {
        $validate .= "<li>Project's link cannot contain more than 50 characters.</li>";
      }

      if (strlen($project->getLink()) == 0) {
        $validate .= "<li>Project's link cannot be empty.</li>";
      }

      if ($validate) {
          $this->error = $validate;
          if ($project->getId() == 0) {
            $this->addNewProjectView();
          } else {
            $this->updateProjectView($this->adminView, $project->getId());
          }

      }
    }

    function removeProject($adminView) {
      // Getting POST paramters
      $project = getProjectById($_GET["param"]);
      if (!$project) {
        $this->showProjectList($adminView);
      }

      // Check user dependencies


      // Delete Project
      $project->delete();

      //Render View
      $this->removeMessage = true;
      $this->recentProject = $project->getName();
      $this->showProjectList($adminView);
    }
  }

?>
