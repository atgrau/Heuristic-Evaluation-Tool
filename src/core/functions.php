<?php
  // General Functions

  function getRoleName($id) {
    switch ($id) {
      case 0: return "Evaluator";
      case 1: return "Project Manager";
      case 2: return "Administrator";
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
