<?php

  /**
   * Evaluation Class
   */
  class Evaluation
  {
    private $id;
    private $project;
    private $user;
    private $results;

    function __construct($id, $project, $user)
    {
      $this->id = $id;
      $this->project = $project;
      $this->user = $user;
    }

    function getId() {
      return $this->id;
    }

    function getProject() {
      return $this->project;
    }

    function getUser() {
      return $this->user;
    }

    function insert() {
      DB::insert('evaluations', array(
        "id_project" => $this->project->getId(),
        "id_user" => $this->user->getId()
      ));
    }
  }


  function getEvaluationById($evaluationId) {
    $evaluation = DB::queryFirstRow("SELECT * FROM evaluations WHERE ID=%i", $evaluationId);
    if ($evaluation) {
      $project = getProjectById($evaluation["id_project"]);
      $user = getUserById($evaluation["id_user"]);
      return new Evaluation($evaluation["ID"], $project, $user);
    } else {
      return null;
    }
  }

  function getEvaluationByProjectAndUser($projectId, $userId) {
    $evaluation = DB::queryFirstRow("SELECT * FROM evaluations WHERE id_project=%i AND id_user=%i", $projectId, $userId);
    if ($evaluation) {

      $project = getProjectById($evaluation["id_project"]);
      $user = getUserById($evaluation["id_user"]);
      return new Evaluation($evaluation["ID"], $project, $user);
    } else {
      return null;
    }
  }

?>
