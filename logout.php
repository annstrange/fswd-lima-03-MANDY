<?php
  session_start();
  session_unset();
  $time = time() - (60 * 60 * 24 * 365);
  setcookie('idUsuario', "", $time);
  session_destroy();
  header('location:index.php');
  exit;
?>
