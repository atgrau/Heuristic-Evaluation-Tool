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

    function setResult($question, $answer) {
      $result = new EvaluationResult($question, $answer);
      array_push($this->results, $result);
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
    }
  }

  /**
   * Evaluation Result
   */
  class EvaluationResult
  {
    private $question;
    private $answer;
    private $comment;

    function __construct($question, $answer, $comment)
    {
      $this->question = $question;
      $this->answer = $answer;
      $this->comment = $comment;
    }

    function getQuestion() {
      return $this->question;
    }

    function getAnswer() {
      return $this->answer;
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
          $question = getQuestionById(0);
          $answer = getAnswerById(0);
          $comment = $result["comment"];

          $evaluationResult = new EvaluationResult($question, $answer, $comment);
          array_push($arrResults, $evaluationResult);
        }
      }
      return new Evaluation($evaluation["ID"], $project, $user, $arrResults);
    } else {
      return null;
    }
  }

?>
