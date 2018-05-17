<?php
  // General Functions

  function getRoleName($id) {
    switch ($id) {
      case 0: return "Evaluador";
      case 1: return "Responsable de Proyecto";
      case 2: return "Administrador";
    }
  }

  function echoDef($value1, $value2) {
    if (!empty($value1)) {
      echo $value1;
    } else {
      echo $value2;
    }
  }
?>
