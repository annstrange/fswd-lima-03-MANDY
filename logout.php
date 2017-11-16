<?php

  require_once("soporte.php");
  $auth->logout();
  header("Location:index.php");
  exit;

?>
