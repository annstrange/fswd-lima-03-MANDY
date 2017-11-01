<?php
  session_start();
	require_once('db/conexion.php');

  // LOGGEO
  if (isset($_COOKIE['idUsuario'])) {
    $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
  }

  function logUserIn($usuarioRecibido) {
    $_SESSION['idUsuario'] = $usuarioRecibido['id'];
  }

  function isLoggedIn() {
    return isset($_SESSION['idUsuario']);
  }


  //REGISTRO
  function validarRegistro($post, $files) {
    $errores = [];
    $name = trim($post['name']);
    $surname = trim($post['surname']);
    $username = trim($post['username']);
    $email = trim($post['email']);
    $question = $post['question'];
    $answer = trim ($post['answer']);
    $pass = trim($post['password']);
    $repass = trim($post['repass']);
    $img_profile = $files['img_profile']['error'];

    if ($name == '') {
      $errores['name'] = "Completá tu nombre";
    } elseif (!filter_var($name, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
       $errores['name'] = "El campo solo debe contener letras";
    } elseif (strlen($name) < 2) {
      $errores['name'] = "El nombre debe contener mínimo 2 caracteres";
    }

    if ($surname == '') {
      $errores['surname'] = "Completá tu apellido";
    } elseif (!filter_var($surname, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
      $errores['surname'] = "El campo solo debe contener letras";
    } elseif (strlen($surname) < 2) {
      $errores['surname'] = "El apellido debe contener mínimo 2 caracteres";
    }

    if ($username == '') {
      $errores['username'] = "Completá tu nombre de usuario";
    } elseif (strlen($username) < 2) {
      $errores['username'] = "El nombre de usuario debe contener mínimo 1 caracter";
    } elseif (comprobarUsuario($username) != false) {
      $errores['username'] = "Ya hay una cuenta asociada a este nombre de usuario";
    }

    if ($email == '') {
      $errores['email'] = "Completá tu e-mail";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores['email'] = "Usá el formato nombre@dominio.com";
    } elseif (comprobarEmail($email) != false) {
      $errores['email'] = "Ya hay una cuenta asociada a este e-mail";
    }

    if ($question == '') {
      $errores['question'] = "Elegí una pregunta";
    }

    if ($answer == '') {
      $errores['answer'] = "Escribí una respuesta";
    } elseif (!filter_var($answer, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z0-9_ ]*$/']])) {
      $errores['answer'] = "El campo solo debe contener letras o números";
    } elseif (strlen($answer) < 2) {
      $errores['answer'] = "La respuesta debe tener más de un caracter";
    }

    if ($pass == '') {
      $errores['password'] = "Completá tu contraseña";
    } elseif (strlen($pass) < 3) {
      $errores['password'] = "La contraseña debe tener más de 3 caracteres";
    } elseif (!filter_var($pass, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z0-9]+$/']])) {
      $errores['password'] = "El campo debe contener solo letras o números";
    }

    if ($repass == '') {
      $errores['repass'] = "Repetí tu contraseña";
    } elseif ($pass != $repass) {
      $errores['repass'] = "Las contraseñas deben coincidir";
    }

    if ($img_profile != UPLOAD_ERR_OK) {
      $errores['img_profile'] = 'Subí una imagen';
    }

    return $errores;
  }

  function crearUsuario($post, $files) {
    $rowid = 0;
    $usuarioAGuardarPHP = [
        'id' => generarId(),
        'name' => $post['name'],
        'surname' => $post['surname'],
        'username' => $post['username'],
        'email' => $post['email'],
        'question' => $post['question'],
        'answer' => $post['answer'],
        'password' => password_hash($post['password'], PASSWORD_DEFAULT)
      ];
    //$usuarioAGuardarJSON = json_encode($usuarioAGuardarPHP) . PHP_EOL;
    //file_put_contents('todosUsuarios.json', $usuarioAGuardarJSON, FILE_APPEND);
    $rowid = insertUsuarioDB($usuarioAGuardarPHP);
  }


  /* function todosLosUsuarios() {
    // no lo usamos
    $jsonFile = file_get_contents("todosUsuarios.json");
    $usuariosJSON = explode(PHP_EOL, $jsonFile);
    array_pop($usuariosJSON);
    $usuarios = [];
    foreach ($usuariosJSON as $usuario) {
      $usuarios[] = json_decode($usuario, true);
    }
    return $usuarios;
  }  */

/*  function generarId() {
    // no lo usamos
    $usuarios= todosLosUsuarios();
    if (empty($usuarios)) {
      return 1;
    }
    $elUltimoUsuario = end($usuarios);
    $id = $elUltimoUsuario['id'];
    return $id++;
  }  */

  function comprobarEmail($email) {
    // devuelva true si hay usuario con este email

    // no lo usamos este metodo
    /* $usuarios = todosLosUsuarios();
    $usuarioExistente = [];
    foreach ($usuarios as $usuario) {
     if ($usuario['email'] == $email) {
       $usuarioExistente = $usuario;
       break;
     }
    }
    if (!empty($usuarioExistente)) {
      return $usuarioExistente;
    } else {
      return false;
    }  */

    // Nuevo:  uso BD para compartir.
    // Solo necesito "prepare" si queremos usar el query con frequencia con valores differente.
    // Por ejemplo, la busca de productos va a usar la misma query de productos muchas veces.
    // Debemos pre-prepare eso, o ejecutar directamente.
    $db = connectarDB();
    $query = $db->prepare("SELECT id, name, surname, username, email, password, question, answer
        FROM usuario
        WHERE email = '$email'
        ORDER BY id asc
        LIMIT 1
      ");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);
      var_dump($results);
      $db = null;
    // Para hacer:  try catch, y confirma tengo una linea
    if (count($results) > 0){
      // acá necesito devolver usuario completa
      return $results[0];
    }
    else {
      return false;
    }

  }

  function comprobarUsuario($username) {
    // devuelva true si hay usuario con este username
    /* $usuarios = todosLosUsuarios();
    $usuarioExistente = [];
    foreach ($usuarios as $usuario) {
     if ($usuario['username'] == $username) {
       $usuarioExistente = $usuario;
       break;
     }
    }
    if (!empty($usuarioExistente)) {
      return $usuarioExistente;
    } else {
      return false;
    }  */
    $db = connectarDB();
    $query = $db->prepare("SELECT id, email
        FROM usuario
        WHERE username = '$username'
        ");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);
      //var_dump($results);
      $db = null;
    // Para hacer:  try catch, y confirma tengo una linea
    if (count($results) > 0){
      return true;
    }
    else {
      return false;
    }
  }

  function guardarImagen($img_profile) {
    $errores = [];

    if ($img_profile['error'] == UPLOAD_ERR_OK) {
     $imgName = $img_profile['name'];
     $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
     $imgTemp = $img_profile['tmp_name'];

     if ($imgExt == "jpg" || $imgExt == "jpeg" || $imgExt == "png" || $imgExt == "gif") {
       $fileName = $_POST['username'] . "." . $imgExt;
       $imgSrc = dirname(__FILE__) . "/images/img_profile/" . $fileName;
       move_uploaded_file($imgTemp, $imgSrc);
     } else {
       $errores['img_profile'] = "Debes subir una imagen jpg, jpeg, png o gif";
     }
   } else {
       $errores['img_profile'] = "Error " . $img_profile['error'] . ". Intentá de nuevo.";
     }
   return $errores;
  }


  // LOG-IN
  function validarLogin($post) {
    $errores = [];

    $email = trim($post['email']);
    $pass = trim($post['password']);
    $formato_email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($pass == '' || $email == '') {
      $errores['email'] = "Completá los datos requeridos";
    } elseif (!$formato_email) {
      $errores['email'] = "Usa el formato nombre@dominio.com";
    } elseif (comprobarEmail($email) == false) {
      $errores['email'] = "Este e-mail no tiene cuenta asociada";
    } else {
      $elUsuario = comprobarEmail($email);
      $password = $elUsuario['password'];
      $password_ingresada = $post['password'];
      if (!password_verify($password_ingresada, $password)) {
         $errores['email'] = "E-mail o contraseña incorrectos";
      }
    }
    return $errores;
  }


  // RECUPERAR CONTRASEÑA
  function validarEmailRecu($post) {
    $errores = [];
    $email = trim($post['email']);
    if ($email == '') {
      $errores['email'] = "Completá tu email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores['email'] = "Usa el formato nombre@dominio.com";
    } elseif (comprobarEmail($email) == false) {
       $errores['email'] = "E-mail incorrecto";
    }
    return $errores;
  }

  function validarNuevaPass($post) {
    $errores['password'] = '';
    $pass = trim($post['newpass']);
    if ($pass == '') {
      $errores['password'] = "Completá tu contraseña";
    } elseif (strlen($pass) < 3) {
      $errores['password'] = "La contraseña debe tener más de 3 caracteres";
    } elseif (!filter_var($pass, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z0-9]+$/']])) {
      $errores['password'] = "El campo debe contener solo letras o números";
    }
    return $errores['password'];
  }

  function traerPregunta($id) {
    //$usuarios = todosLosUsuarios();
    $usuario = getUserById($id);
    var_dump($usuario);
    $usuarioExistente['question'] = '';
    // foreach ($usuarios as $usuario) {
      if($usuario['id'] == $id) {
        $usuarioExistente['question'] = $usuario['question'];
        // break;
      }
    //}
    if ($usuarioExistente['question'] != '') {
      return $usuarioExistente['question'];
    } else {
      return false;
    }
  }

  function traerRespuesta($usuarioRecibido, $answer) {
    //$usuarios = todosLosUsuarios();
    $usuario = getUserById($usuarioRecibido['id']);
    $usuarioExistente = [];
    //foreach ($usuarios as $usuario) {
      if ($usuario['answer'] == $answer && $usuario['id'] == $usuarioRecibido['id']) {
        $usuarioExistente = $usuario;
        //break;
      }
    //}
    if (!empty($usuarioExistente)) {
      return $usuarioExistente;
    }
      return false;

  }

  function validarRespuesta($usuarioRecibido, $post) {
    $answer = trim($post['answer']);
    $errores['answer'] = '';
    if ($answer == '') {
      $errores['answer'] = "Escribí una respuesta";
    } elseif (traerRespuesta($usuarioRecibido, $answer) == false) {
       $errores['answer'] = "Respuesta incorrecta";
     }
    return $errores['answer'];
  }


  // PERFIL DE USUARIO
  function getUserById($userId) {
/*    $usuarios = todosLosUsuarios();
    $usuarioExistente = [];
    foreach ($usuarios as $usuario) {
      if ($usuario['id'] == $userId) {
        $usuarioExistente = $usuario;
        break;
      }
    }
    if (!empty($usuarioExistente)) {
      return $usuario;
    } else {
    return false;
  }  */

    // Usa el BD
    $db = connectarDB();

    $query = $db->prepare("SELECT id, name, surname, username, email, question, answer, password
        FROM usuario
        WHERE id = '$userId'
        LIMIT 1
        ");
    try {
      $query->execute();

      $results = $query->fetchAll(PDO::FETCH_ASSOC);
      //echo "<br><br><br><br><br> Hi var_dump results in getUserById() ";
      //var_dump($_SESSION['userRecover']);
      //var_dump($userId);
      //var_dump($results);
      $db = null;
    }
    catch (PDOException $ex) {
      echo ("Failure in getUserById():".$ex->getMessage()."");
    }

    return $results[0];
  }


  // MODIFICAR USUARIO
  function validarCambios($post, $files) {
    $errores = [];
    $name = trim($post['name']);
    $surname = trim($post['surname']);
    $email = trim($post['email']);
    $img_profile = $files['img_profile'];

    if ($name == '') {
      $errores['name'] = "Completá tu nombre";
    } elseif (!filter_var($name, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
       $errores['name'] = "El campo solo debe contener letras";
    } elseif (strlen($name) < 2) {
      $errores['name'] = "El nombre debe contener mínimo 2 caracteres";
    }

    if ($surname == '') {
      $errores['surname'] = "Completá tu apellido";
    } elseif (!filter_var($surname, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
      $errores['surname'] = "El campo solo debe contener letras";
    } elseif (strlen($surname) < 2) {
      $errores['surname'] = "El apellido debe contener mínimo 2 caracteres";
    }

    if ($email == '') {
      $errores['email'] = "Completá tu e-mail";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errores['email'] = "Usá el formato nombre@dominio.com";
    } elseif (comprobarEmail($email) != false && comprobarEmail($email)['email'] != $email) {
      $errores['email'] = "Ya hay una cuenta asociada a este e-mail";
    }

    return $errores;
  }

  function modificarImagen($usuarioRecibido, $img_profile) {
    $errores = [];

    if ($img_profile['error'] == UPLOAD_ERR_OK) {
     $imgName = $img_profile['name'];
     $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
     $imgTemp = $img_profile['tmp_name'];

     if ($imgExt == "jpg" || $imgExt == "jpeg" || $imgExt == "png" || $imgExt == "gif") {
       $fileName = $usuarioRecibido['username'] . "." . $imgExt;
       $imgSrc = dirname(__FILE__) . "/images/img_profile/" . $fileName;
       move_uploaded_file($imgTemp, $imgSrc);
     } else {
       $errores['img_profile'] = "Debes subir una imagen jpg, jpeg, png o gif";
     }
   } elseif ($img_profile['error'] == UPLOAD_ERR_NO_FILE) {
     return $errores;
   } else {
       $errores['img_profile'] = "Error " . $img_profile['error'] . ". Intentá de nuevo.";
     }
   return $errores;
  }

/*  function crearUsuarioCambiado($usuarioRecibido, $post) {
    $usuarioAGuardar = [
        "id" => $usuarioRecibido['id'],
        "name" => $post['name'],
        "surname" => $post['surname'],
        "username" => $usuarioRecibido['username'],
        "email" => $post['email'],
        "question" => $usuarioRecibido['question'],
        "answer" => $usuarioRecibido['answer'],
        "password" => $usuarioRecibido['password']
      ];

    $usuarios = todosLosUsuarios();
    $nuevosUsuarios = [];

    foreach ($usuarios as $usuario) {
      if ($usuario['id'] == $usuarioAGuardar['id']) {
        $nuevosUsuarios[] = json_encode($usuarioAGuardar) . PHP_EOL;
      }
      elseif ($usuario['id'] != null) {
        $nuevosUsuarios[] = json_encode($usuario) . PHP_EOL;
      }
    }
    file_put_contents('todosUsuarios.json', $nuevosUsuarios);

  }  */

  // Bases de Datos metodos
  function updateUsuario($usuarioRecibido, $post) {
    // hace UPDATE to userId.  Para hacer, prueba cada valor isset.

    $usuarioAGuardar = [
        "id" => $usuarioRecibido['id'],
        "name" => $post['name'],
        "surname" => $post['surname'],
        "username" => $usuarioRecibido['username'],
        "email" => $post['email'],
        "question" => $usuarioRecibido['question'],
        "answer" => $usuarioRecibido['answer'],
        "password" => $usuarioRecibido['password']
      ];

      $db = connectarDB();
      $sqlQuery = "UPDATE usuario SET name = :name,
            surname = :surname,
            email=:email
          WHERE id = :id; ";

      $statement = $db->prepare($sqlQuery);
      $statement->bindParam(":id", $usuario['id'], PDO::PARAM_INT);
      $statement->bindParam(":name", $usuario['name'], PDO::PARAM_STR);
      $statement->bindParam(":surname", $usuario['surname'], PDO::PARAM_STR);
      //$statement->bindParam(":username", $usuario['username'], PDO::PARAM_STR);
      $statement->bindParam(":email", $usuario['email'], PDO::PARAM_STR);
      //$statement->bindParam(":question", $usuario['question'], PDO::PARAM_STR);
      //$statement->bindParam(":answer", $usuario['answer'], PDO::PARAM_STR);
      //$statement->bindParam(":password", $usuario['password'], PDO::PARAM_STR);

      try {
        $statement->execute();
        $db = null;
      }
      catch (PDOException $ex) {
        echo "Failure in updateUsuario()".$ex->getMessage();
      }

      return true;
  }

  function todosLosUsuariosDB() {
  // Devuelva array de usuarios de base de datos (BD)
  // En realidad, no necesitamos traer todos usuarios con BD.
  $db = connectarDB();
  $query = $db->prepare("SELECT id, name, surname, username, email, password
      FROM usuario
      ");
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    var_dump($results);

 //VALUES ($usuario[id], '$usuario[name]', '$usuario[surname]', '$usuario[username]', '$usuario[email]', '$usuario[password]')";
  return $results;
}

function generarIdDB() {
  // no lo usamos porque Auto Increment lo genera
    $db = connectarDB();
    $query = $db->prepare("SELECT MAX(id) as id
        FROM usuario
        ");
      $query->execute();

      $results = $query->fetchAll(PDO::FETCH_ASSOC);

      $id = $results[0]['Id'];
      var_dump($results);

    // Para hacer:  try catch, y confirma tengo una linea
    return $id +1;

  }

  function insertUsuarioDB($usuario){
    // expect $usuario to be an associative array
      $rowid = 0;
      $db = connectarDB();
      $sqlQuery = "INSERT INTO usuario(Name,Surname,Username,Email,Password) VALUES(:name,:surname,:username,:email,:password)";

      $statement = $db->prepare($sqlQuery);

      // format if $usuario passed in is an Object
      /*    $statement->bindParam(":user_id", $employee->getUserId(), PDO::PARAM_INT);
          $statement->bindParam(":name", $employee->getName(), PDO::PARAM_STR);
          $statement->bindParam(":address", $employee->getAddress(), PDO::PARAM_STR);
          $statement->bindParam(":city", $employee->getCity(), PDO::PARAM_STR);
      */
        $statement->bindParam(":name", $usuario['name'], PDO::PARAM_STR);
          $statement->bindParam(":surname", $usuario['surname'], PDO::PARAM_STR);
          $statement->bindParam(":username", $usuario['username'], PDO::PARAM_STR);
          $statement->bindParam(":email", $usuario['email'], PDO::PARAM_STR);
          $statement->bindParam(":password", $usuario['password'], PDO::PARAM_STR);

        $statement->execute();

        // $result = $statement->fetch(PDO::FETCH_ASSOC);
        // $rowid = $db.lastInsertId();  // this function wasn't found.

        // Trae Id
        $queryId = $db->prepare("SELECT id
            FROM usuario
            WHERE username = :username
                ORDER BY id desc
            LIMIT 1
            ");
        $queryId->bindParam(":username", $usuario['username'], PDO::PARAM_STR);
        $queryId->execute();

          $results = $queryId->fetchAll(PDO::FETCH_ASSOC);
          var_dump($results);

          $db = null;
          echo "<br><br><br><br><br> Hi from insertTest";
          var_dump($results);
          return $results[0]['Id'];
      }
?>
