<?php
  /**
  * Categories Model
  */
  class Category
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

    function setName($value) {
      $this->name = $value;
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


  /**
   * Questions Model
   */
  class Question
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

?>
