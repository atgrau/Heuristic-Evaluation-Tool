<?php
  /**
  * Categories Model
  */
  class Template
  {
    private $id;
    private $name;
    private $active;
    private $categories = array();
    private $answers = array();


    function __construct($id, $name, $active, $categories, $answers) {
      $this->id = $id;
      $this->name = $name;
      $this->active = $active;
      $this->categories = $categories;
      $this->answers = $answers;
    }

    function getId() {
      return $this->id;
    }

    function getName() {
      return $this->name;
    }

    function setName($value) {
      $this->name = $value;
    }

    function isActive() {
      return $this->active;
    }

    function getCategories() {
      return $this->categories;
    }

    function getAnswers() {
      return $this->answers;
    }

    function insert() {
      $template = DB::insert('templates', array(
        "name" => $this->name,
        "active" => false,
      ));

      $this->id = DB::insertId();

      if($template){
        //Insert default answers
        $qryAnswer = "SELECT * FROM template_answers WHERE original=1";
        $answers = DB::query($qryAnswer);
        if ($answers) {
            foreach ($answers as $row) {
              DB::insert('answersbytemplate', array(
                "idTemplate" => $this->id,
                "idAnswer" => $row["ID"],
              ));
            }
          }

        //Insert default categories
        $qryCategories = "SELECT * FROM template_categories WHERE original=1";
        $categories = DB::query($qryCategories);
        if ($categories) {
            foreach ($categories as $row) {
              DB::insert('categoriesbytemplate', array(
                "idTemplate" => $this->id,
                "idCategory" => $row["ID"],
              ));
            }
        }

        //Insert default questions
        $qryQuestions = "SELECT * FROM template_questions WHERE original=1";
        $questions = DB::query($qryQuestions);
        if ($questions) {
            foreach ($questions as $row) {
              DB::insert('questionsbytemplate', array(
                "idTemplate" => $this->id,
                "idQuestion" => $row["ID"],
              ));
            }
        }

      }

    }

    function delete() {

      DB::delete('answersbytemplate', "idTemplate=%i", $this->id);
      DB::delete('categoriesbytemplate', "idTemplate=%i", $this->id);
      DB::delete('questionsbytemplate', "idTemplate=%i", $this->id);
      DB::delete('templates', "ID=%i", $this->id);
    }

  }

/**
 * Category Model
 */

class Category
  {

    private $id;
    private $name;
    private $questions = array();

    function __construct($id, $name, $questions) {
      $this->id = $id;
      $this->name = $name;
      $this->questions = $questions;
    }

    function getId() {
      return $this->id;
    }

    function getName() {
      return $this->name;
    }

    function getQuestions() {
      return $this->questions;
    }
}

/**
 * Questions Model
 */
class Question
{

  private $id;
  private $question;

  function __construct($id, $question)
  {
    $this->id = $id;
    $this->question = $question;
  }

  function getId() {
    return $this->id;
  }

  function getName() {
    return $this->question;
  }

  function setQuestion($value) {
    $this->question = $value;
  }

}

class Answer
  {

    private $id;
    private $answer;
    private $value;

    function __construct($id, $answer, $value)
    {
      $this->id = $id;
      $this->answer = $answer;
      $this->value = $value;
    }

    function getId() {
      return $this->id;
    }

    function getName()
    {
      return $this->answer;
    }

    function getValue()
    {
      return $this->value;
    }

}


  function getTemplates() {
    $qry = "SELECT * FROM templates";
    $templates = DB::query($qry);
    return buildTmp($templates);
  }

  function buildTmp($templates) {
    $templateList = array();
    if ($templates) {
      foreach ($templates as $row) {
        array_push($templateList, new Template($row["ID"], $row["name"], $row["active"], null, null));
      }
      return $templateList;
    } else {
      return null;
    }
  }

  function getTemplateById($templateId) {

    $template = DB::queryFirstRow("SELECT * FROM templates WHERE ID=%i", $templateId);

    if ($template) {

      $categories = getCategoriesbyTemplate($template["ID"]);
      $answers = getAnswersbyTemplate($template["ID"]);
      return new Template($template["ID"], $template["name"], $template["active"], $categories, $answers);
    } else {
      return null;
    }
  }


  function getAnswersbyTemplate($templateId)
  {
    $qry = "SELECT ta.ID, ta.answer, ta.value  FROM answersbytemplate a JOIN template_answers ta ON a.idAnswer = ta.ID WHERE a.idTemplate=%i";
    $answers = DB::query($qry,$templateId);
    $answerList = array();

    if ($answers) {
      foreach ($answers as $row) {
        array_push($answerList, new Answer($row["ID"], $row["answer"], $row["value"]));
      }
      return $answerList;
    } else {
      return null;
    }
  }

  function getAnswerbyId($answerId)
  {
    $qry = "SELECT ID, answer, value  FROM template_answers WHERE ID=%i";
    $answer = DB::queryFirstRow($qry,$answerId);
    if ($answer) {
      return new Answer($answer["ID"], $answer["answer"], $answer["value"]);
    } else {
      return null;
    }
  }

  function getCategoriesbyTemplate($templateId)
  {
    $qry = "SELECT tc.ID, tc.name  FROM categoriesbytemplate a JOIN template_categories tc ON a.idCategory = tc.ID WHERE a.idTemplate=%i";
    $categories = DB::query($qry,$templateId);
    $categoryList = array();

    if ($categories) {

      foreach ($categories as $row) {
        $questions = DB::query("SELECT ID, question FROM template_questions WHERE id_category=%i", $row["ID"]);
        $questionList = array();

        if($questions)
        {
          foreach ($questions as $question) {
            array_push($questionList, new Question($question["ID"], $question["question"]));
          }
        }
        array_push($categoryList, new Category($row["ID"], $row["name"], $questionList));
      }

      return $categoryList;
    } else {
      return null;
    }
  }

  function getQuestionsbyTemplate($templateId)
  {
    $qry = "SELECT * FROM questionsbytemplate WHERE idTemplate=%i";
    $qry .= " ORDER BY questionsbytemplate.idQuestion";
    $questions = DB::query($qry,$templateId);
    $questionList = array();

    if ($questions) {
      foreach ($questions as $row) {
        $qryQuestion = DB::queryFirstRow("SELECT * FROM template_questions WHERE ID=%i", $row["idQuestion"]);

        if($qryQuestion)
          array_push($questionList, new Question($qryQuestion["ID"],$qryQuestion["id_category"] ,$qryQuestion["question"]));
      }
      return $questionList;
    } else {
      return null;
    }
  }

  function getQuestionbyId($questionId)
  {
    $qry = "SELECT ID, id_category, question  FROM template_questions WHERE ID=%i";
    $question = DB::queryFirstRow($qry,$questionId);
    if($question) {
      return new Question($question["ID"],$question["id_category"] ,$question["question"]);
    } else {
      return null;
    }
  }

  function getActiveTemplates()
  {
    $qry = "SELECT * FROM templates WHERE active=1";
    $templateActive = DB::query($qry);
    return buildTmp($templateActive);
  }

  function existTemplatebyName($name)
  {
      $qry = DB::queryFirstRow("SELECT * FROM templates WHERE name=%i", $name);

      if($qry){
        return false;
      } else {
        return false;
      }


  }

?>
