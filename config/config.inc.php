<?php
  # Do not show notice errors
  error_reporting(E_ALL & ~E_NOTICE);
  //error_reporting(~E_ALL);

  # MySQL Configuration
  define("MYSQL_ENCODING", "utf8");
  define("MYSQL_USER", "heuristic_evaluation");
  define("MYSQL_PWD", "toor");
  define("MYSQL_DB", "heuristic_evaluation");
?>
