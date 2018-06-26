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

    function updateTemplateView($adminView, $templateId, $edit) {
      $template = getTemplateById($templateId);

        if ((!$template) || ((!$GLOBALS["USER_SESSION"]->isAdmin()) && ($GLOBALS["USER_SESSION"]->getId() != $template->getUser()->getId()))){
            $this->showTemplateList($adminView);
        } else {

          $this->render();
        }
    }

    function addNewTemplateView(){

      $template = new Template(0, $_POST["name"],0);
      $template->insert();
      $this->addMessage = true;

      if($template)
      {
        $this->setContentView("template/template");
        $this->template = $template;
        $this->answerList = getAnswerbyTemplate($template->getId());
        $this->categoriesList = getCategoriesbyTemplate($template->getId());
        $this->questionList = getQuestionsbyTemplate($template->getId());
        $this->adminView = $adminView;
        $this->editTemplate = true;
        $this->render();
      }

    }


  }

?>
