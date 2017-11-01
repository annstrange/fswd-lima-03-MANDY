<?php
// Connecion a base de datos

function connectarDB() {

  $dsn =
  'mysql:host=localhost;dbname=mandy_db;
  charset=utf8mb4;port:3306';
  $db_user = 'root';
  $db_pass = 'root';
  $opciones = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $opciones);
  }
  catch( PDOException $Exception ) {
      echo ("<br>".$Exception->getMessage()."<br>");
  }
  return $db;

}


?>
