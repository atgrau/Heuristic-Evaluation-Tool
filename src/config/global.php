<?php
  # Do not show notice errors
  error_reporting(E_ALL & ~E_NOTICE);
  //error_reporting(~E_ALL);

  define("APP_TITLE", "Heuristic Evaluation Tool");

  // Email Configuration
  define("SMTP_SERVER", "smtp.gmail.com");
  define("SMTP_PORT", 587);
  define("SMTP_USER", "**");
  define("SMTP_PASSWORD", "**");
  define("SMTP_SECURE", "tls");
  define("SMTP_AUTH", true);
  define("SMTP_NAME", "Heuristic Evaluation Tool");
  define("SMTP_FROM", "**");
?>
