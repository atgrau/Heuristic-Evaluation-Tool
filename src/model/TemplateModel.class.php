<?php

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
