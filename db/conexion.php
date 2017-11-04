<?php
// Connecion a base de datos
define("DB_USER", "root");
define("DB_PASS", "root");

function connectarBD() {

  $dsn = 'mysql:host=localhost;dbname=mandy_db;
  charset=utf8mb4;port:3306';
  $db_user = constant("DB_USER");
  $db_pass = constant("DB_PASS");
  $opciones = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $opciones);
  }
  catch( PDOException $Exception ) {
      echo ("<br>".$Exception->getMessage()."<br>");
  }
  return $db;

}

function connectarSinBD() {
  // Lo usá cuando no ya tienes schema.
  $dsn = 'mysql:host=localhost; charset=utf8mb4;port:3306';
  $db_user = constant("DB_USER");
  $db_pass = constant("DB_PASS");
  $opciones = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $opciones);
  }
  catch( PDOException $Exception ) {
      echo ("<br>".$Exception->getMessage()."<br>");
  }
return $db;

}

function esBDDisponible() {
    $db = connectarBD();
    if ($db == null) {
      return false;
    }
    else {
      return true;
    }
}

function esTablaDefinido($nombre) {
  // si tabla exista, devuelva true.

 $db = connectarBD();
  try {
    $ddl = "SELECT count(*) FROM `mandy_db`.$nombre;";
    $result=$db->exec($ddl);
    var_dump($result);
  }
  catch (PDOException $ex) {
    echo ("<br>".$ex->getMessage()."<br>");
    return false;
  }

}

?>
