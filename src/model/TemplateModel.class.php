<?php
  /**
  * Categories Model
  */
  class Template
  {
    private $id;
    private $name;
    private $active;
    private $modified;
    private $categories = array();

    function __construct($id, $name, $active) {
      $this->id = $id;
      $this->name = $name;
      $this->active = $active;
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

    function insert() {
      $template = DB::insert('templates', array(
        "name" => $this->name,
        "active" => false,
      ));

      $templateId = DB::insertId();

      if($templateId){
        //Insert default answers
        $qryAnswer = "SELECT * FROM template_answers WHERE original=1";
        $answers = DB::query($qryAnswer);
        if ($answers) {
            foreach ($answers as $row) {
              DB::insert('answersbytemplate', array(
                "idTemplate" => $templateId,
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
                "idTemplate" => $templateId,
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
                "idTemplate" => $templateId,
                "idQuestion" => $row["ID"],
              ));
            }
        }

      }

    }

    function getCategories() {

      $qry = "SELECT * FROM categoriesbytemplate WHERE idTemplate = %i";
      $qry .= " ORDER BY categoriesbytemplate.idCategory";
      $categories = DB::query($qry, $this->id);

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

    function getAnswers() {
      $qry = "SELECT * FROM answersbytemplate WHERE idTemplate=%i";
      $qry .= " ORDER BY answersbytemplate.idAnswer";
      $answers = DB::query($qry, $this->id);
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

    function getQuestions() {

      $qry = "SELECT * FROM questionsbytemplate WHERE idTemplate=%i";
      $qry .= " ORDER BY questionsbytemplate.idQuestion";
      $questions = DB::query($qry, $this->id);
      $questionList = array();

      if ($questions) {
        foreach ($questions as $row) {
            array_push($questionList, new Question($row["ID"], $row["category"], $row["question"]));
        }
        return $questionList;
      } else {
        return null;
      }
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

}

/**
 * Questions Model
 */
class Question
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

  function getQuestion() {
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
    $qry = "SELECT * FROM templates";

    $templates = DB::query($qry);
    return buildTmp($templates);
  }


  function buildTmp($templates) {
    $templateList = array();
    if ($templates) {
      foreach ($templates as $row) {
        array_push($templateList, new Template($row["ID"], $row["name"], $row["active"]));
      }
      return $templateList;
    } else {
      return null;
    }
  }

  function getTemplateById($templateId) {
    $template = DB::queryFirstRow("SELECT * FROM templates WHERE ID=%i", $templateId);
    if ($template) {
      return new Template($template["ID"], $template["name"], $template["active"]);
    } else {
      return null;
    }
  }


  function getAnswerbyTemplate($templateId)
  {
    $qry = "SELECT * FROM answersbytemplate WHERE idTemplate=%i";
    $qry .= " ORDER BY answersbytemplate.idAnswer";
    $answers = DB::query($qry,$templateId);
    $answerList = array();

    if ($answers) {
      foreach ($answers as $row) {
        $qryAnswer = DB::queryFirstRow("SELECT * FROM template_answers WHERE ID=%i", $row["idAnswer"]);

        if($qryAnswer)
          array_push($answerList, new Answer($qryAnswer["ID"], $qryAnswer["answer"], $qryAnswer["value"]));
      }
      return $answerList;
    } else {
      return null;
    }

  }

  function getCategoriesbyTemplate($templateId)
  {
    $qry = "SELECT * FROM categoriesbytemplate WHERE idTemplate=%i";
    $qry .= " ORDER BY categoriesbytemplate.idCategory";
    $categories = DB::query($qry,$templateId);
    $categoryList = array();

    if ($categories) {
      foreach ($categories as $row) {
        $qryCategory = DB::queryFirstRow("SELECT * FROM template_categories WHERE ID=%i", $row["idCategory"]);

        if($qryCategory)
          array_push($categoryList, new Category($qryCategory["ID"], $qryCategory["name"]));
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

  function getTemplateActives()
  {
    $qry = "SELECT * FROM templates WHERE active=1";
    $templateActive = DB::query($qry);
    $templateList = array();

    if ($templateActive) {
      foreach ($templateActive as $row) {
        array_push($templateList, new Template($template["ID"], $template["name"], $template["active"]));
      }
      return $templateList;
    } else {
      return null;
    }
  }


?>
