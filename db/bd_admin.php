<?php
// métodos para crear base de datos, y convertir de json archivo.

// importar .json file a base de datos
$db = null;
require_once('conexion.php');



function import_json() {
  // devuelva el numero de records imported successfully.
  $db = connectarDB();

  $todosUsuarios = todosLosUsuarios();
  if (empty($todosUsuarios)) {
    return 0;
  }
  foreach ($todosUsuarios as $usuario){
      var_dump($usuario);

      $sql = "INSERT INTO usuario (name, surname, username, email, question, answer, password)
      VALUES ('$usuario[name]', '$usuario[surname]', '$usuario[username]', '$usuario[email]', '$usuario[question]','$usuario[answer]', '$usuario[password]')";
      try {
        $query = $db->prepare($sql);
        echo ($sql);
        $query->execute();
    }
    catch (PDOException $ex) {
      echo "Failure in import_json(): ". $ex->getMessage()." <br>";
    }

  }

}

function todosLosUsuarios() {
  $jsonFile = file_get_contents("../todosUsuarios.json");
  $usuariosJSON = explode(PHP_EOL, $jsonFile);
  array_pop($usuariosJSON);
  $usuariosTodos = [];
  foreach ($usuariosJSON as $usuario) {
    $usuariosTodos[] = json_decode($usuario, true);
  }
  return $usuariosTodos;
}

function createSchema() {
  // This is not working because if I don't have the mandy_db schema, I can't connect.
  $dsn = 'mysql:host=localhost; charset=utf8mb4;port:3306';
  $db_user = 'root';
  $db_pass = 'root';
  $opciones = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

  try {
    $db = new PDO($dsn, $db_user, $db_pass, $opciones);
  }
  catch( PDOException $Exception ) {
      echo ("<br>".$Exception->getMessage()."<br>");
  }

  if ($db) {
    try {
      $ddl = "CREATE SCHEMA IF NOT EXISTS `mandy_db` DEFAULT CHARACTER SET utf8 ;";
      $result=$db->exec($ddl);
      var_dump($result);
    }
    catch (PDOException $ex) {
      echo "Failure: ". $ex->getMessage()." <br>";
    }
 }
 else {
   echo "No database connection <br> ";
 }
  $db = null;
  return true;
}

function dropSchema() {
// Cuidate con este!
  $db = connectarDB();
  try {
    $ddl = "DROP SCHEMA `mandy_db`;";
    $result=$db->exec($ddl);
    var_dump($result);
  }
  catch (PDOException $e) {
    echo "Failure: ". $e->getMessage()." <br>";
  }

  $db = null;

}


function createTablaUsuario () {
  $db = connectarDB();

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
  }
  catch (PDOException $e) {
    echo "Failure in createTablaUsuario(): ". $e->getMessage()." <br>";
  }
}

function dropTablaUsuario () {
  $db = connectarDB();

  $ddl = "DROP TABLE mandy_db.usuario; ";

  try {
    $result=$db->exec($ddl);
    $db = null;
  }
  catch (PDOException $e) {
    echo "Failure in dropTablaUsuario(): ". $e->getMessage()." <br>";
  }
}

 ?>
