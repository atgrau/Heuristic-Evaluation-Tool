<?php

  /**
   * Evaluation Class
   */
  class Evaluation
  {
    private $id;
    private $project;
    private $user;
    private $results = array();

    function __construct($id, $project, $user, $results)
    {
      $this->id = $id;
      $this->project = $project;
      $this->user = $user;
      $this->results = $results;
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

    function getResults() {
      return $this->results;
    }

    function setResults($value) {
      $this->results = $value;
    }

    function getEvaluationResultByQuestionId($questionId) {
      $results = DB::queryFirstRow("SELECT id_question, id_answer, comment FROM evaluation_results WHERE id_evaluation=%i AND id_question=%i", $this->id, $questionId);
      if ($results) {
        return new EvaluationResult($questionId, $results["id_answer"], $results["comment"]);
      } else {
        return null;
      }
    }

    function insert() {
      DB::insert('evaluations', array(
        "id_project" => $this->project->getId(),
        "id_user" => $this->user->getId()
      ));
      $this->id = DB::insertId();
    }

    function update() {
      // Update results... (EvaluationResult)
      DB::delete('evaluation_results', "id_evaluation=%i", $this->id);

      foreach ($this->results as $result) {
        DB::insert('evaluation_results', array(
          "id_evaluation" => $this->id,
          "id_question" => $result->getQuestionId(),
          "id_answer" => $result->getAnswerId(),
          "comment" => $result->getComment()
        ));
      }
    }
  }

  /**
   * Evaluation Result
   */
  class EvaluationResult
  {
    private $questionId;
    private $answerId;
    private $comment;

    function __construct($questionId, $answerId, $comment)
    {
      $this->questionId = $questionId;
      $this->answerId = $answerId;
      $this->comment = $comment;
    }

    function getQuestionId() {
      return $this->questionId;
    }

    function getAnswerId() {
      return $this->answerId;
    }

    function getComment() {
      return $this->comment;
    }
  }

  function getEvaluationById($evaluationId) {
    $evaluation = DB::queryFirstRow("SELECT * FROM evaluations WHERE ID=%i", $evaluationId);
    return buildEvaluation($evaluation);
  }

  function getEvaluationByProjectAndUser($projectId, $userId) {
    $evaluation = DB::queryFirstRow("SELECT * FROM evaluations WHERE id_project=%i AND id_user=%i", $projectId, $userId);
    return buildEvaluation($evaluation);
  }

  function getNumberOfEvaluationsByUser($userId) {
    DB::query("SELECT projects_user.ID FROM projects_user JOIN projects ON projects_user.id_project = projects.ID WHERE projects.active = 1 AND projects_user.id_user=%i", $userId);
    return DB::count();
  }

  function buildEvaluation($evaluation) {
    if ($evaluation) {
      $project = getProjectById($evaluation["id_project"]);
      $user = getUserById($evaluation["id_user"]);

      // Get Results...
      $results = DB::query("SELECT id_question, id_answer, comment FROM evaluation_results WHERE id_evaluation=%i", $evaluation["ID"]);
      $arrResults = array();
      if ($results) {
        foreach ($results as $result) {
          // Create question, answer and comment
          $questionId = $result["id_question"];
          $answerId = $result["id_answer"];
          $comment = $result["comment"];

          $evaluationResult = new EvaluationResult($questionId, $answerId, $comment);
          array_push($arrResults, $evaluationResult);
        }
      }
      return new Evaluation($evaluation["ID"], $project, $user, $arrResults);
    } else {
      return null;
    }
  }

?>
