<?php

  /**
   * Template Controller
   */
  class TemplateController extends BaseController
  {
    function __construct() { }

    function showTemplateList($admin) {
      $this->admin = $admin;
      $this->setContentView("template/templatelist");
      $this->new = false;
      $this->edit = false;
      $this->templateList = getTemplates();
      $this->render();
    }

    function showTemplateView($adminView, $templateId, $edit) {
      $template = getTemplateById($templateId);

        if ((!$template) || (!$GLOBALS["USER_SESSION"]->isAdmin())){
            $this->showTemplateList($adminView);
        } else {
          $this->setContentView("template/template");
          $this->template = $template;
          $this->adminView = $adminView;
          $this->editTemplate = (($edit == 1) && ($template->getId()!= 1));
          $this->render();
        }
    }

    function removeCategory(){
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /admin/templates");
      }
      $category = getCategorybyId($_POST["idTemplate"], $_POST["idCategory"]);

      if ($category) {
        $category->remove();
      }

      $this->showTemplateView(true, $_POST["idTemplate"], 1);
    }

    function newCategory(){
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /admin/templates");
      }

      if (!getTemplateById($_POST["idTemplate"])) {
          header("Location: /admin/templates");
      }

      if (empty($_POST["categoryName"])) {
          $this->error = "Category name is empty";
          $this->showTemplateView(true, $_POST["idTemplate"], 1);
      }

      $questionCount = $_POST["questionsCount"];

      $questionList = array();
      for($i = 0; $i <= $questionCount; ++$i) {
        $question = new Question(0, $_POST["questionName_".$i], 0);
        array_push($questionList, $question);
      }

      $category = new Category(0, $_POST["categoryName"], 0, $questionList);

      $category->setTemplateId($_POST["idTemplate"]);

      $category->insert();

      $this->showTemplateView(true, $category->getTemplateId(), 1);
    }

    function removeQuestion(){
      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /admin/templates");
      }

      $question = getQuestionbyId($_POST["id_question"]);
      if ($question) {
        $question->setTemplateId($_POST["id_template"]);
        $question->remove();
      }
      $this->showTemplateView(true, $_POST["id_template"], 1);
    }

    function newQuestion(){
      if (empty($_POST["questionName"])) {
          $this->error = "The question is empty";
      }

      $question = new Question(0, $_POST["questionName"],0);
      $question->setTemplateId($_POST["idTemplate"]);
      $question->setCategoryId($_POST["idCategory"]);
      $question-> insert();
      $this->showTemplateView(true, $question->getTemplateId(), 1);

    }

    function addNewTemplateView(){

      if ((empty($_POST["name"])) || (existTemplatebyName($_POST["name"]))) {
          $this->error = "The template's name is empty or already exists";
          $this->showTemplateList(true);
      } else {
          $template = new Template(0, $_POST["name"],0,null,null);
          $template->insert();

          if($template)
          {
            $this->showTemplateView(true,$template->getId(),1);
          }
      }
    }

    function removeTemplate($adminView) {

      $template = getTemplateById($_GET["param"]);
      if (!$template) {
        $this->showTemplateList($adminView);
      }

      $template->delete();
      $this->removeMessage = true;
      $this->showTemplateList($adminView);
    }

    function removeAnswer(){

      if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: /admin/templates");
      }

      $answer = getAnswerbyId($_POST["id_answer"]);
      if ($answer){
        $answer->setTemplateId($_POST["id_template"]);
        $answer->remove();
      }

      $this->showTemplateView(true, $answer->getTemplateId(), 1);
    }

    function newAnswer(){
      if ((empty($_POST["answer"])) || (empty($_POST["value"])) || (empty($_POST["color"]))) {
          $this->error = "Some value is incorrect.";
      }

      $answer = new Answer(0, $_POST["answer"], $_POST["value"], 0,0);
      if($answer){
        $answer->setColor($_POST["color"]);
        $answer->setTemplateId($_POST["idTemplate"]);
        $answer-> insert();
      }

      $this->showTemplateView(true, $answer->getTemplateId(), 1);

    }

    function editStateTemplate($idTemplate, $state){
      $template = getTemplateById($idTemplate);
      $template->changeState($state);
      $this->showTemplateView(true, $idTemplate, 1); 
    }

  }

?>
