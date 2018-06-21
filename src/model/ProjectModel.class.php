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
    private $users;

    function __construct($id, $userId, $creationDate, $name, $description, $link, $active) {
      $this->id = $id;
      $this->user = getUserById($userId);
      $this->creationDate = $creationDate;
      $this->name = $name;
      $this->description = $description;
      $this->link = $link;
      $this->active = $active;
      $this->users = array();
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

    function getUsers() {
      return $this->users;
    }

    function setUsers($value) {
      $this->users = $value;
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

      // Getting recent project
      $projectId = DB::insertId();

      // Add Users to the project
      foreach ($this->users as $user) {
        DB::insert('projects_user', array(
          "id_project" => $projectId,
          "id_user" => $user->getId(),
        ));
      }
    }

    function update() {
      DB::update('projects', array(
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link,
        "active" => $this->active
      ), "ID=%i", $this->id);

      // Clear users
      DB::delete('projects_user', "id_project=%i", $this->id);

      // Add Users to the project
      foreach ($this->users as $user) {
        DB::insert('projects_user', array(
          "id_project" => $this->id,
          "id_user" => $user->getId(),
        ));
      }
    }

    function delete() {
      // Delete Project
      DB::delete('projects', "ID=%i", $this->id);
      // Delete Users associated with the project
      DB::delete('projects_user', "id_project=%i", $this->id);
    }
  }

  function getProjectById($projectId) {
    $project = DB::queryFirstRow("SELECT * FROM projects WHERE ID=%i", $projectId);
    if ($project) {
      $project = new ProjectModel($project["ID"], $project["id_user"], $project["creation_date"], $project["name"], $project["description"], $project["link"], boolval($project["active"]));

      $projectUsers = DB::query("SELECT * FROM projects_user WHERE id_project=%i", $projectId);
      $projectUsersList = array();
      if ($projectUsers) {
        foreach ($projectUsers as $row) {
          array_push($projectUsersList, getUserById($row["id_user"]));
        }
      }
      $project->setUsers($projectUsersList);
      return $project;
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

  function getAssignedProjects($userId,$filter) {
    $qry = "SELECT * FROM projects ";

    $condition = "WHERE active=1 AND ID IN (SELECT id_project FROM projects_user WHERE id_user = %i)";
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
        $project = new ProjectModel($row["ID"], $row["id_user"], $row["creation_date"], $row["name"], $row["description"], $row["link"], boolval($row["active"]));
        array_push($projectList, $project);
      }
      return $projectList;
    } else {
      return null;
    }
  }

?>
