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
      $project->insert();

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
          $project->setActive($_POST["active"]);
        }
        $project->update();

        $this->editMessage = true;
        $this->recentProject = $_POST["name"];
        $this->showProjectList($adminView);
      }
    }

    function removeProject($adminView) {
      // Getting POST paramters
      $project = getProjectById($_GET["param"]);
      if (!$project) {
        $this->showProjectList($adminView);
      }

      // Check user dependencies

      // Delete Users

      // Delete Project
      $project->delete();

      //Render View
      $this->removeMessage = true;
      $this->recentProject = $project->getName();
      $this->showProjectList($adminView);
    }
  }

?>
