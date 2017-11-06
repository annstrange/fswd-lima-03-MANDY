<?php
  $db = null;
  require_once('conexion.php');

  if (import_json()) {
    header('Location: ../index.php');
    exit;
  } else {
    header('Location: bd_admin.php?jsonimportado=no');
    exit;
  }

  function import_json() {
    // Devuelve el número de registros importados correctamente.
    $db = conectarBD();
    $todosUsuarios = todosLosUsuarios();
    if (empty($todosUsuarios)) {
      return true;
    }
    foreach ($todosUsuarios as $usuario) {
        $sql = "INSERT INTO mandy_db.usuario (name, surname, username, email, question, answer, password) VALUES ('$usuario[name]', '$usuario[surname]', '$usuario[username]', '$usuario[email]', '$usuario[question]','$usuario[answer]', '$usuario[password]')";
        try {
          $query = $db->prepare($sql);
          $query->execute();
      }
      catch (PDOException $exception) {
        echo "Failure in import_json(): " . $exception->getMessage() . "<br>";
        return false;
      }
    }
    $db = null;
    return true;
    }


  function todosLosUsuarios() {
    $jsonFile = file_get_contents("../todosUsuarios.json");
    $usuariosJSON = explode(PHP_EOL, $jsonFile);
    var_dump($usuariosJSON);
    array_pop($usuariosJSON);
    $usuariosTodos = [];
    foreach ($usuariosJSON as $usuario) {
      $usuariosTodos[] = json_decode($usuario, true);
    }
    return $usuariosTodos;
  }
