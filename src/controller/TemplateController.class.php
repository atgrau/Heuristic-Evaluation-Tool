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

    function updateTemplateView($adminView, $templateId) {
      $template = getTemplateById($templateId);

      if ((!$template) || ((!$GLOBALS["USER_SESSION"]->isAdmin()) && ($GLOBALS["USER_SESSION"]->getId() != $template->getUser()->getId()))){
          $this->showTemplateList($adminView);
      } else {
        $this->setContentView("template/template");
        $this->template = $template;
        $this->answerList = getAnswerbyEvaluation($template->getId());
        $this->categoriesList = getCategoriesbyEvaluation($template->getId());
        $this->adminView = $adminView;
        $this->render();
      }

    }

  }

?>
