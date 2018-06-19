<?php
  /**
  * Categories Model
  */
  class TemplateModel
  {
    private $id;
    private $name;
    private $active;
    private $modified;

    function __construct($id, $name, $active, $modified) {
      $this->id = $id;
      $this->name = $name;
      $this->active = $active;
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
      return $this->active;
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
  private $category;
  private $question;

  function __construct($id, $category, $question)
  {
    $this->id = $id;
    $this->category = $category;
    $this->question = $question;
  }

  function getId() {
    return $this->id;
  }

  function getCategory() {
    return $this->category;
  }

  function setOrder($value) {
    $this->order = $value;
  }

  function getQuestion() {
    return $this->question;
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
    $qry .= " ORDER BY answersbyevaluation.idAnswer";
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
    $qry .= " ORDER BY categoriesbyevaluation.idCategory";
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

  function getQuestionsbyEvaluation($templateId)
  {
    $qry = "SELECT * FROM questionsbyevaluation WHERE idEvaluation=%i";
    $qry .= " ORDER BY questionsbyevaluation.idQuestion";
    $questions = DB::query($qry,$templateId);
    $questionList = array();

    if ($questions) {
      foreach ($questions as $row) {
        $qryQuestion = DB::queryFirstRow("SELECT * FROM template_questions WHERE ID=%i", $row["idQuestion"]);

        if($qryQuestion)
          array_push($questionList, new QuestionModel($qryQuestion["ID"],$qryQuestion["id_category"] ,$qryQuestion["question"]));
      }
      return $questionList;
    } else {
      return null;
    }
  }

  function insertTemplate() {
    DB::insert('templates', array(
      "name" => $this->name,
      "active" => false,
      "modified" => false,
    ));
  }
?>
