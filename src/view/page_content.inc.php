<?php
  if (empty($this->content)) {
    include("home.php");
  } else {
    include($this->content.".php");
  }
?>
