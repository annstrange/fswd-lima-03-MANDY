<?php

$db = null;
require_once('conexion.php');

$result = createTablaUsuario();
echo "Result of createTabla(): ". $result." <br>";


function createTablaUsuario () {
  $db = connectarBD();

  $ddl = "CREATE TABLE IF NOT EXISTS usuario (
      id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(45) NOT NULL,
      surname VARCHAR(100) NOT NULL,
      username VARCHAR(45) NOT NULL,
      email VARCHAR(100) NOT NULL,
      password VARCHAR(120) NULL,
      question VARCHAR(200) NULL,
      answer VARCHAR(80) NULL ) ";

  try {
    $result=$db->exec($ddl);
    $db = null;
    return true;
  }
  catch (PDOException $e) {
    echo "Failure in createTablaUsuario(): ". $e->getMessage()." <br>";
    return false;
  }
}

 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Crear Tabla</title>
   </head>
   <body>
     <p></p>
     <a type="button" href="bd_admin.php">Atrás</a>
   </body>
 </html>
