<?php

  class ProjectController extends BaseController
  {
    function __construct() { }

    function showProjectList($onlyMine) {
      $this->setContentView("project/projectlist");
      $this->new = false;
      $this->edit = false;
      $this->query = $_GET["q"];
      if ($onlyMine) {
        $this->projectList = getProjects($GLOBALS["USER_SESSION"]->getId(), $this->query);
      } else {
        $this->projectList = getProjects(null, $this->query);
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
      $this->showProjectList();
    }
  }

?>
