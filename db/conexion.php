<?php
// Conexión a base de datos
define("DB_USER", "root");
define("DB_PASS", "root");

function conectarBD() {
  // Se usa cuando ya tienes un schema
  $dsn = 'mysql:host=127.0.0.1;dbname=mandy_db;charset=utf8mb4;port:3306;';
  $db_user = constant("DB_USER");
  $db_pass = constant("DB_PASS");
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $options);
  } catch(PDOException $exception) {
      echo "<br>" . $exception->getMessage() . "<br>";
      $db = null;
  }
  return $db;
}

function conectarSinBD() {
  // Se usa cuando aún no tienes un schema
  $dsn = 'mysql:host=127.0.0.1;charset=utf8mb4;port:3306;';
  $db_user = constant("DB_USER");
  $db_pass = constant("DB_PASS");
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $options);
  } catch(PDOException $exception) {
      echo "<br>" . $exception->getMessage() . "<br>";
      $db = null;
  }
  return $db;
}

function bdDisponible() {
  // Boolean sobre la disponibilidad de la base
    $db = conectarBD();
    if ($db == null) {
      return false;
    }
    else {
      return true;
    }
}

function existeTabla($nombre) {
  // Boolean sobre la existencia de la tabla usuario
  $db = conectarBD();
  try {
    $ddl = "SELECT count(*) FROM mandy_db." . $nombre . ";";
    $stmt = $db->prepare($ddl);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(isset($result['count(*)'])) {
      return true;
    }
  }
  catch (PDOException $exception) {
    return false;
    echo "<br>" . $exception->getMessage() . "<br>";
  }
}

?>
