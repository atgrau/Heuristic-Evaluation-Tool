<?php
  require_once(BASE_URI."controller/ProjectController.class.php");
  require_once(BASE_URI."config/database.php");

  /**
   *
   */
  class ProjectModel
  {
    private $id;
    private $user;
    private $creationDate;
    private $name;
    private $description;
    private $link;

    function __construct($id, $userId, $creationDate, $name, $description, $link) {
      $this->id = $id;
      $this->user = getUserById($userId);
      $this->creationDate = $creationDate;
      $this->name = $name;
      $this->description = $description;
      $this->link = $link;
    }

    function getId() {
      return $this->Id;
    }

    function getIdUser() {
      return $this->idUser;
    }

    function setIdUser($value) {
      $this->idUser = $value;
    }

    function getCreationDate() {
      return $this->creationDate;
    }

    function getName() {
      return $this->name;
    }

    function getDescription() {
      return $this->description;
    }

    function getLink() {
      return $this->link;
    }
  }

  function getProjectById($projectId) {
    $project = DB::queryFirstRow("SELECT * FROM projects WHERE ID=%i", $projectId);
    if ($project) {
      return new ProjectModel($project["ID"], $project["id_user"], $project["creation_date"], $project["name"], $project["description"], $project["link"]);
    } else {
      return null;
    }
  }

  function getProjects($filter) {
    $projectList = array();
    $qry = "SELECT * FROM projects";
    if (!empty($filter)) {
      $condition = " WHERE projects.name like %ss OR projects.description like %ss";
      $qry .= $condition." ORDER BY ID";

      $projects = DB::query($qry, $filter, $filter);
    } else {
      $qry .= " ORDER BY ID";

      $projects = DB::query($qry);
    }

    if ($projects) {
      foreach ($projects as $row) {
        array_push($projectList, new ProjectModel($row["ID"], $row["id_user"], $row["creation_date"], $row["name"], $row["description"], $row["link"]));
      }

      return $projectList;
    } else {
      return null;
    }
  }

?>
