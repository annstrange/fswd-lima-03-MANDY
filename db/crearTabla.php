<?php
  $db = null;
  require_once('conexion.php');

  if (createTablaUsuario()) {
    header('Location: bd_admin.php?tablacreada=si');
    exit;
  } else {
    header('Location: bd_admin.php?tablacreada=no');
    exit;
  }

  function createTablaUsuario () {
    $db = conectarBD();
    $ddl = "CREATE TABLE IF NOT EXISTS mandy_db.usuario (
        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL,
        surname VARCHAR(100) NOT NULL,
        username VARCHAR(45) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(120) NULL,
        question VARCHAR(200) NULL,
        answer VARCHAR(80) NULL
      );";

    try {
      $result=$db->exec($ddl);
      $db = null;
      return true;
    }
    catch (PDOException $exception) {
      echo "Failure in createTablaUsuario(): " . $exception->getMessage() . "<br>";
      return false;
    }
  }
