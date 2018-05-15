<?php
  // General Functions

  function GetRoleName($id) {
    switch ($id) {
      case 0: return "Evaluador";
      case 1: return "Responsable de Proyecto";
      case 2: return "Administrador";
    }
  }
?>
