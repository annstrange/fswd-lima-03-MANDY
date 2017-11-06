<?php
  $db = null;
  require_once('conexion.php');

  if (createSchema()) {
    header('Location: bd_admin.php?dbcreada=si');
    exit;
  } else {
    header('Location: bd_admin.php?dbcreada=yaexiste');
    exit;
  }

  function createSchema() {
    $db = conectarSinBD();
    if ($db) {
      try {
        $ddl = "CREATE SCHEMA IF NOT EXISTS mandy_db DEFAULT CHARACTER SET utf8;";
        $db->exec($ddl);
      } catch (PDOException $exception) {
        echo "Failure in createSchema(): " . $exception->getMessage() . "<br>";
        return false;
      }
   } else {
     echo "No database connection";
   }
    $db = null;
    return true;
  }
