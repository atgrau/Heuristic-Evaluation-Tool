<?php

  class ProjectController extends BaseController
  {
    function __construct() { }

    function showProjectList($admin) {
      $this->admin = $admin;
      $this->setContentView("project/projectlist");
      $this->new = false;
      $this->edit = false;
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

      $project = new ProjectModel(0, $GLOBALS["USER_SESSION"]->getId(), null, $_POST["name"], $_POST["description"], $_POST["link"]);
      $project->insert();

      $this->addMessage = true;
      $this->recentProject = $_POST["name"];
      $this->showProjectList(false);
    }
  }

?>
