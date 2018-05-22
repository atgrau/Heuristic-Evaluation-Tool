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

  function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>
