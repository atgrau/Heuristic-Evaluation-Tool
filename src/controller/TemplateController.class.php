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
/*
    function updateTemplateView($adminView, $templateId, $edit) {
      $template = getTemplateById($templateId);

        if ((!$template) || ((!$GLOBALS["USER_SESSION"]->isAdmin()) && ($GLOBALS["USER_SESSION"]->getId() != $template->getUser()->getId()))) {
            $this->showTemplateList($adminView);
        } else {
          $this->render();
        }
    }
*/
    function removeCategory(){

      $category = getCategorybyId($_POST["idTemplate"], $_POST["idCategory"]);
      $category->remove();
      $this->showTemplateView(true, $category->getTemplateId(), 1);
    }

    function newCategory(){
      if (empty($_POST["categoryName"])) {
          $this->error = "The category's name is empty";
      }
      if (empty($_POST["questionName"])) {
          $this->error = "The question is empty";
      }
      $questionList = array();
      array_push($questionList, new Question(0, $_POST["questionName"],0));
      $category = new Category(0, $_POST["categoryName"],0, $questionList);
      $category->setTemplateId($_POST["idTemplate"]);
      $category-> insert();
      if($category){
        $this->showTemplateView(true, $category->getTemplateId(), 1);
      }

    }

    function removeQuestion($idQuestion, $idTemplate){
      $question = getQuestionbyId($idQuestion);
      $question->setTemplateId($idTemplate);
      $question->remove();
      $this->showTemplateView(true, $question->getTemplateId(), 1);
    }

    function newQuestion(){
      if (empty($_POST["questionName"])) {
          $this->error = "The question is empty";
      }

      $question = new Question(0, $_POST["questionName"],0);
      $question->setTemplateId($_POST["idTemplate"]);
      $question->setCategoryId($_POST["idCategory"]);
      $question-> insert();
      if($question){
        $this->showTemplateView(true, $question->getTemplateId(), 1);
      }

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



  }

?>
