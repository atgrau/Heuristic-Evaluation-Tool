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
    private $active;

    function __construct($id, $userId, $creationDate, $name, $description, $link, $active) {
      $this->id = $id;
      $this->user = getUserById($userId);
      $this->creationDate = $creationDate;
      $this->name = $name;
      $this->description = $description;
      $this->link = $link;
      $this->active = $active;
    }

    function getId() {
      return $this->id;
    }

    function getUser() {
      return $this->user;
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

    function setName($value) {
      $this->name = $value;
    }

    function getDescription() {
      return $this->description;
    }

    function setDescription($value) {
      $this->description = $value;
    }

    function getShortDescription() {
      if (strlen($this->description) > 30) {
        return substr($this->description, 0, 30)."...";
      } else {
        return $this->description;
      }
    }

    function getLink() {
      return $this->link;
    }

    function setLink($value) {
      $this->link = $value;
    }

    function isActive() {
      return $this->active;
    }

    function setActive($value) {
      $this->active = $value;
    }

    function insert() {
      DB::insert('projects', array(
        "id_user" => $this->user->getId(),
        "creation_date" => date('Y-m-d H:i:s', time()),
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link,
        "active" => false
      ));
    }

    function update() {
      DB::update('projects', array(
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link,
        "active" => $this->active
      ), "ID=%i", $this->id);
    }

    function delete() {
      DB::delete('projects', "ID=%i", $this->id);
    }
  }

  function getProjectById($projectId) {
    $project = DB::queryFirstRow("SELECT * FROM projects WHERE ID=%i", $projectId);
    if ($project) {
      return new ProjectModel($project["ID"], $project["id_user"], $project["creation_date"], $project["name"], $project["description"], $project["link"], $project["active"]);
    } else {
      return null;
    }
  }

  function getMyProjects($userId,$filter) {
    $qry = "SELECT * FROM projects ";

    $condition = "WHERE projects.id_user = %i";
    if (!empty($filter))
      $condition .= " AND (projects.name like %ss OR projects.description like %ss)";

    $qry = $qry." ".$condition." ORDER BY projects.name";
    $projects = DB::query($qry, $userId, $filter, $filter);

    return buildRs($projects);
  }

  function getProjects($filter,$userId) {
    $qry = "SELECT * FROM projects WHERE 1=1";

    if (!empty($filter))
      $condition .= " AND (projects.name like %ss OR projects.description like %ss)";

    if (!empty($userId))
      $condition .= " AND projects.id_user=%i";

    $qry = $qry." ".$condition." ORDER BY projects.name";

    if ((!empty($filter)) && (!empty($userId))){
      $projects = DB::query($qry, $filter, $filter, $userId);
    } else if (!empty($filter)) {
      $projects = DB::query($qry, $filter, $filter);
    } else if (!empty($userId)) {
      $projects = DB::query($qry, $userId);
    } else {
      $projects = DB::query($qry);
    }

    return buildRs($projects);
  }

  function getProjectsByUser($filter,$userId) {
    $qry = "SELECT * FROM projects WHERE projects.id_user=%i";

    if (!empty($filter))
      $condition = " AND (projects.name like %ss OR projects.description like %ss)";

    $projects = DB::query($qry, $userId, $filter, $filter);

    return buildRs($projects);
  }

  function buildRs($projects) {
    $projectList = array();
    if ($projects) {
      foreach ($projects as $row) {
        array_push($projectList, new ProjectModel($row["ID"], $row["id_user"], $row["creation_date"], $row["name"], $row["description"], $row["link"], $row["active"]));
      }
      return $projectList;
    } else {
      return null;
    }
  }


?>
