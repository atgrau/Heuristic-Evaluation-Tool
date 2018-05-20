<?php
  require_once(BASE_URI."model/ProjectModel.class.php");
  require_once(BASE_URI."model/UserModel.class.php");

  class ProjectController extends BaseController
  {
    function __construct() { }

    function ShowProjectList() {
      $this->SetContentView("project/projectlist");
      $this->query = $_GET["q"];
      $this->projectList = getProjects($this->query);
      $this->Render();
    }

    function addNewProject() {
      $this->SetContentView("project/project");
      $this->Render();
    }
  }

?>
