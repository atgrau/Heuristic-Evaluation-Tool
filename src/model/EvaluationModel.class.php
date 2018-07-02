<?php

  /**
   * Evaluation Class
   */
  class Evaluation
  {
    private $id;
    private $project;
    private $user;
    private $finished;
    private $results = array();

    function __construct($id, $project, $user, $finished, $results)
    {
      $this->id = $id;
      $this->project = $project;
      $this->user = $user;
      $this->finished = $finished;
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

    function isFinished() {
      return $this->finished;
    }

    function setFinished($value) {
      $this->finished = $value;
    }

    function isFinishedOrClosed() {
      return (($this->finished) || ($this->project->isClosed()));
    }

    function getResults() {
      return $this->results;
    }

    function setResults($value) {
      $this->results = $value;
    }

    function getQuestionsCount() {
      foreach ($this->project->getTemplate()->getCategories() as $category) {
        foreach ($category->getQuestions() as $question) {
          $totalQuestions++;
        }
      }
      return $totalQuestions;
    }

    function getAnsweredQuestionsCount() {
      if ($this->results) return count($this->results);
      else return 0;
    }

    function getAnsweredScorableQuestionsCount() {
      $total = 0;
      if ($this->results) {
        foreach ($this->results as $result) {
          if ($result->getAnswer()->isScorable()) {
            $total++;
          }
        }
      } else {
        $total = 0;
      }

      return $total;
    }

    function getPercentageDone() {
      return round($this->getAnsweredQuestionsCount()*100/$this->getQuestionsCount(), 1);
    }

    function getScore() {
      $score = 0;
      foreach ($this->results as $result) {
        if ($result->getAnswer()->isScorable()) {
          $score = $score + $result->getAnswer()->getValue();
        }
      }
      return $score;
    }

    function getUsabilityPercentage() {
      $val = $this->getProject()->getTemplate()->getMaxAnswerValue()*$this->getAnsweredScorableQuestionsCount();
      if ($val > 0) return round($this->getScore()*100/($val), 1);
      else return 0;
    }

    function allQuestionsAnswered() {
      return ($this->getQuestionsCount() == $this->getAnsweredQuestionsCount());
    }

    function getScoreByCategory($categoryId) {
      $score = 0;
      $questions = array();
      foreach ($this->project->getTemplate()->getCategories() as $category) {
        if ($category->getId() == $categoryId) {
          foreach ($category->getQuestions() as $question) {
            array_push($questions, $question->getId());
          }
        }
      }

      foreach ($this->results as $result) {
        if (in_array($result->getQuestion()->getId(), $questions)) {
          if ($result->getAnswer()->isScorable()) {
            $score += $result->getAnswer()->getValue();
          }
        }
      }

      return $score;
    }

    function getAnswerValue() {
      $totals = array();
      $qry = "SELECT evaluation_results.id_answer, count(1) AS value FROM ";
      $qry .= "evaluations JOIN evaluation_results ON evaluations.ID = evaluation_results.id_evaluation ";
      $qry .= " WHERE evaluations.ID=%i GROUP BY evaluation_results.id_answer";
      $qry = DB::query($qry, $this->id);
      foreach ($qry as $row) {
        array_push($totals, $row["value"]);
      }
      return $totals;
    }

    function getEvaluationResultByQuestionId($questionId) {
      if ($this->results) {
        foreach ($this->results as $questionResult) {
          if ($questionResult->getQuestion()->getId() == $questionId) {
            return $questionResult;
          }
        }
      }
      return null;
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
      DB::update('evaluations', array(
        "finished" => $this->finished
      ), "ID=%i", $this->id);

      DB::delete('evaluation_results', "id_evaluation=%i", $this->id);

      foreach ($this->results as $result) {
        DB::insert('evaluation_results', array(
          "id_evaluation" => $this->id,
          "id_question" => $result->getQuestion()->getId(),
          "id_answer" => $result->getAnswer()->getId(),
          "comment" => $result->getComment()
        ));
      }
    }

    function delete() {
      DB::delete('evaluation_results', "id_evaluation=%i", $this->id);
      DB::delete('evaluations', "ID=%i", $this->id);
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
          $question = getQuestionbyId($result["id_question"]);
          $answer = getAnswerbyId($result["id_answer"]);
          $comment = $result["comment"];

          $evaluationResult = new EvaluationResult($question, $answer, $comment);
          array_push($arrResults, $evaluationResult);
        }
      }
      return new Evaluation($evaluation["ID"], $project, $user, boolval($evaluation["finished"]), $arrResults);
    } else {
      return null;
    }
  }

?>
