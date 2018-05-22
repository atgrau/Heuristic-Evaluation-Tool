<?php

  /**
   * Project Model
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

    function insert() {
      DB::insert('projects', array(
        "id_user" => $this->user->getId(),
        "creation_date" => date('Y-m-d H:i:s', time()),
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link
      ));
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

  function getProjects($userId, $filter) {
    $projectList = array();
    $qry = "SELECT * FROM projects ";



    if (!empty($userId)) {
      $condition .= " WHERE active = 1 AND projects.id_user = %i";
    } else {
      $condition .= " WHERE 1=1";
    }

    if (!empty($filter))
      $condition .= " AND (projects.name like %ss OR projects.description like %ss)";

    $qry .= $condition." ORDER BY ID";

    if ((!empty($userId)) && (!empty($filter)))
      $projects = DB::query($qry, $userId, $filter, $filter);
    else if (!empty($userId))
      $projects = DB::query($qry, $userId);
    else if (!empty($filter))
      $projects = DB::query($qry, $filter, $filter);
    else
      $projects = DB::query($qry);

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
