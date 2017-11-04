<?php

$db = null;
require_once('conexion.php');

$result = import_json ();
echo "Result of import_json(): ". $result." <br>";


function import_json() {
  // devuelva el numero de records imported successfully.
  $db = connectarBD();

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
  var_dump($usuariosJSON);
  array_pop($usuariosJSON);
  $usuariosTodos = [];
  foreach ($usuariosJSON as $usuario) {
    $usuariosTodos[] = json_decode($usuario, true);
  }
  return $usuariosTodos;
}

 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Importar JSON</title>
   </head>
   <body>
     <p></p>
     <a type="button" href="bd_admin.php">Atrás</a>
   </body>
 </html>
