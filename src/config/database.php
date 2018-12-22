<?php
  # MySQL Configuration
  define("MYSQL_ENCODING", "utf8");
  define("MYSQL_USER", getenv('MYSQL_USER'));
  define("MYSQL_PASSWORD", getenv('MYSQL_PASSWORD'));
  define("MYSQL_DATABASE", getenv('MYSQL_DATABASE'));
  define("MYSQL_HOST", getenv('MYSQL_HOST'));
  define("MYSQL_PORT", getenv('MYSQL_PORT'));

  require_once(BASE_URI."core/lib/DB.class.php");
?>
