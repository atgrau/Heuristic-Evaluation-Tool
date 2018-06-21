<?php

  /**
   * Evaluation Class
   */
  class Evaluation
  {
    private $id;
    private $idProject;
    private $idUser;

    function __construct($id, $idProject, $idUser)
    {
      $this->id = $id;
      $this->idProject = $idProject;
      $this->idUser = $idUser;
    }

    function getId() {
      return $this->id;
    }

    function getIdProject() {
      return $this->idProject;
    }

    function getIdUser() {
      return $this->idUser;
    }
  }


  function getEvaluationByProjectAndUser($idProject, $idUser) {

  }

  function getTemplateByProject($idProject) {

  }

?>
