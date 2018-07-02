<?php

  /**
   * Project Model
   */
  class Project
  {
    private $id;
    private $user;
    private $creationDate;
    private $finishDate;
    private $name;
    private $description;
    private $link;
    private $active;
    private $users;
    private $template;
    private $archived;

    function __construct($id, $userId, $creationDate, $finishDate, $name, $description, $link, $active, $template, $archived) {
      $this->id = $id;
      $this->user = getUserById($userId);
      $this->creationDate = $creationDate;
      $this->finishDate = $finishDate;
      $this->name = $name;
      $this->description = $description;
      $this->link = $link;
      $this->active = $active;
      $this->users = array();
      $this->template = $template;
      $this->archived = $archived;
    }

    function setId($value) {
      return $this->$value;
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

    function getFinishDate() {
      return $this->finishDate;
    }

    function setFinishDate($value) {
      $this->finishDate = $value;
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
      if (strlen($this->description) > 40) {
        return substr($this->description, 0, 40)."...";
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

    function getTemplate() {
      return $this->template;
    }

    function setTemplate($value) {
      $this->template = $value;
    }

    function isArchived() {
      return $this->archived;
    }

    function setArchived($value) {
      $this->archived = $value;
    }

    function isClosed() {
      return ($this->getDaysLeft() < 0);
    }

    function getDaysLeft() {
      $now = new DateTime();
      $finish = new DateTime($this->finishDate);
      $days = intval($now->diff($finish)->format('%R%a'));
      return $days;
    }

    function getGlobalAnswerValue() {
      $totals = array();
      $qry = "SELECT evaluation_results.id_answer, count(1) AS value FROM ";
      $qry .= "evaluations JOIN evaluation_results ON evaluations.ID = evaluation_results.id_evaluation ";
      $qry .= " WHERE evaluations.id_project=%i and evaluations.finished = 1 GROUP BY evaluation_results.id_answer";
      $qry = DB::query($qry, $this->id);
      foreach ($qry as $row) {
        array_push($totals, $row["value"]);
      }
      return $totals;
    }

    function getScore() {
      $totalScore = 0;
      foreach ($this->getEvaluations() as $evaluation) {
        if ($evaluation->isFinished()) {
          $totalScore = $totalScore + $evaluation->getScore();
          $i++;
        }
      }
      if ($totalScore == 0) return 0;
      else return ($totalScore/$i);
    }

    function getUsabilityPercentage() {
      $total = 0;
      foreach ($this->getEvaluations() as $evaluation) {
        if ($evaluation->isFinished()) {
          $total += $evaluation->getUsabilityPercentage();
          $i++;
        }
      }

      if ($total == 0) return 0;
      else return round($total/$i, 1);
    }

    function getEvaluations() {
      $evaluations = array();
      $qry = DB::query("SELECT ID FROM evaluations WHERE id_project=%i", $this->id);
      foreach ($qry as $row) {
        array_push($evaluations, getEvaluationById($row["ID"]));
      }
      return $evaluations;
    }

    function getFinishedEvaluations() {
      $evaluations = array();
      $qry = DB::query("SELECT ID FROM evaluations WHERE id_project=%i AND finished=1", $this->id);
      foreach ($qry as $row) {
        array_push($evaluations, getEvaluationById($row["ID"]));
      }
      return $evaluations;
    }

    function canReassignTemplate() {
      DB::query("SELECT id_project FROM evaluations WHERE id_project=%i", $this->id);
      return (DB::count() == 0);
    }

    function insert() {
      DB::insert('projects', array(
        "id_user" => $this->user->getId(),
        "creation_date" => date('Y-m-d H:i:s', time()),
        "finish_date" => $this->finishDate,
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link,
        "active" => false,
        "id_template" => $this->template->getId()
      ));

      // Getting recent project
      $this->id = DB::insertId();

      // Add Users to the project
      foreach ($this->users as $user) {
        DB::insert('projects_user', array(
          "id_project" => $this->id,
          "id_user" => $user->getId(),
        ));
      }
    }

    function update() {
      DB::update('projects', array(
        "finish_date" => $this->finishDate,
        "name" => $this->name,
        "description" => $this->description,
        "link" => $this->link,
        "active" => $this->active,
        "archived" => $this->archived,
        "id_template" => $this->template->getId()
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
      $template = getTemplateById($project["id_template"]);
      $project = new Project($project["ID"], $project["id_user"], $project["creation_date"], $project["finish_date"], $project["name"], $project["description"], $project["link"], boolval($project["active"]), $template, boolval($project["archived"]));
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

    $condition = "WHERE projects.id_user = %i AND projects.archived = 0";
    if (!empty($filter))
      $condition .= " AND (projects.name like %ss OR projects.description like %ss)";

    $qry = $qry." ".$condition." ORDER BY projects.ID";
    $projects = DB::query($qry, $userId, $filter, $filter);

    return buildRs($projects);
  }

  function getMyArchivedProjects($userId,$filter) {
    $qry = "SELECT * FROM projects ";

    $condition = "WHERE projects.id_user = %i AND projects.archived = 1";
    if (!empty($filter))
      $condition .= " AND (projects.name like %ss OR projects.description like %ss)";

    $qry = $qry." ".$condition." ORDER BY projects.finish_date DESC";
    $projects = DB::query($qry, $userId, $filter, $filter);

    return buildRs($projects);
  }

  function getAssignedProjects($userId,$filter) {
    $qry = "SELECT * FROM projects ";

    $condition = "WHERE active=1 AND archived=0 AND ID IN (SELECT id_project FROM projects_user WHERE id_user = %i)";
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
        $template = getTemplateById($row["id_template"]);
        $project = new Project($row["ID"], $row["id_user"], $row["creation_date"], $row["finish_date"], $row["name"], $row["description"], $row["link"], boolval($row["active"]), $template, boolval($row["archived"]));
        array_push($projectList, $project);
      }
      return $projectList;
    } else {
      return null;
    }
  }

?>
