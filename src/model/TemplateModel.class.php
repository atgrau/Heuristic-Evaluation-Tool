<?php
  /**
  * Categories Model
  */
  class TemplateModel
  {
    private $id;
    private $name;
    private $activated;
    private $modified;

    function __construct($id, $name, $activated, $modified) {
      $this->id = $id;
      $this->name = $name;
      $this->activated = $activated;
      $this->modified = $modified;
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

    function getStateActive() {
      return $this->activated;
    }

    function getStateModified() {
      return $this->modified;
    }
  }

class CategoryModel
  {

    private $id;
    private $name;

    function __construct($id, $name) {
      $this->id = $id;
      $this->name = $name;
    }

    function getId() {
      return $this->id;
    }

    function getName() {
      return $this->name;
    }

    function store() {
      if ($this->id == 0) {
        DB::insert('template_categories', array(
          "name" => $this->name,
        ));
      } else {
        DB::update("template_categories", array(
          "name" => $this->name,
        ), "ID=%i", $this->id);
      }
    }
}

  /**
   * Questions Model
   */
class QuestionModel
{

  private $id;
  private $order;
  private $question;

  function __construct($id, $order, $question)
  {
    $this->id = $id;
    $this->order = $order;
    $this->question = $question;
  }

  function getId() {
    return $this->id;
  }

  function getOrder() {
    return $this->order;
  }

  function setOrder($value) {
    $this->order = $value;
  }

  function getQuestion() {
    return $this->questions;
  }

  function setQuestion($value) {
    $this->question = $value;
  }

  function getQuestions() {

  }

  function getQuestionById($id) {

  }

}

class AnswerModel
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

    function getAnswer()
    {
      return $this->answer;
    }

    function getValue()
    {
      return $this->value;
    }

}

  function getTemplates() {
    $qry = "SELECT * FROM template_evaluation";

    $templates = DB::query($qry);
    return buildTmp($templates);
  }

  function buildTmp($templates) {
    $templateList = array();
    if ($templates) {
      foreach ($templates as $row) {
        array_push($templateList, new TemplateModel($row["ID"], $row["name"], $row["activated"], $row["modified"]));
      }
      return $templateList;
    } else {
      return null;
    }
  }

  function getTemplateById($templateId) {
    $template = DB::queryFirstRow("SELECT * FROM template_evaluation WHERE ID=%i", $templateId);
    if ($template) {
      return new TemplateModel($template["ID"], $template["name"], $template["activated"], $template["modified"]);
    } else {
      return null;
    }
  }


  function getCategories() {
    $qry = "SELECT * FROM template_categories";
    $categories = DB::query($qry);

    $categoriesList = array();

    if ($categories) {
      foreach ($categories as $row) {
        array_push($categoriesList, new Category($row["ID"], $row["name"]));
      }
      return $categoriesList;
    } else {
      return null;
    }
  }


  function getAnswerbyEvaluation($templateId)
  {
    $qry = "SELECT * FROM answersbyevaluation WHERE idEvaluation=%i";
    $answers = DB::query($qry,$templateId);
    $answerList = array();

    if ($answers) {
      foreach ($answers as $row) {
        $qryAnswer = DB::queryFirstRow("SELECT * FROM template_answers WHERE ID=%i", $row["idAnswer"]);

        if($qryAnswer)
          array_push($answerList, new AnswerModel($qryAnswer["ID"], $qryAnswer["answer"], $qryAnswer["value"]));
      }
      return $answerList;
    } else {
      return null;
    }

  }

  function getCategoriesbyEvaluation($templateId)
  {
    $qry = "SELECT * FROM categoriesbyevaluation WHERE idEvaluation=%i";
    $categories = DB::query($qry,$templateId);
    $categoryList = array();

    if ($categories) {
      foreach ($categories as $row) {
        $qryCategory = DB::queryFirstRow("SELECT * FROM template_categories WHERE ID=%i", $row["idCategory"]);

        if($qryCategory)
          array_push($categoryList, new CategoryModel($qryCategory["ID"], $qryCategory["name"]));
      }
      return $categoryList;
    } else {
      return null;
    }
  }

?>
