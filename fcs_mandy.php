<?php

  session_start();

  if (isset($_COOKIE['idUsuario'])) {
    $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
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
       $errores['name'] = "Solo letras permitidas";
    } elseif (strlen($name) < 2) {
      $errores['name'] = "Mínimo 2 caracteres";
    }

    if ($surname == '') {
      $errores['surname'] = "Completá tu apellido";
    } elseif (!filter_var($surname, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
      $errores['surname'] = "Solo letras permitidas";
    } elseif (strlen($surname) < 2) {
      $errores['surname'] = "Mínimo 2 caracteres";
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
      $errores['answer'] = "La respuesta debe tener más de un carácter";
    }

    if ($pass == '') {
      $errores['password'] = "Completá tu contraseña";
    } elseif (strlen($pass) < 3) {
      $errores['password'] = "La contraseña debe tener más de 3 carácteres";
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
    $usuarioAGuardar = [
        'id' => generarId(),
        'name' => $post['name'],
        'surname' => $post['surname'],
        'username' => $post['username'],
        'email' => $post['email'],
        'question' => $post['question'],
        'answer' => $post['answer'],
        'password' => password_hash($post['password'],PASSWORD_DEFAULT),
      ];
    $usuarioGuardado = json_encode($usuarioAGuardar) . PHP_EOL;      file_put_contents('todosUsuarios.json', $usuarioGuardado, FILE_APPEND);
  }


  function todosLosUsuarios() {
    $jsonFile = file_get_contents("todosUsuarios.json");
    $usuariosJSON = explode(PHP_EOL, $jsonFile);
    array_pop($usuariosJSON);
    $usuariosTodos = [];
    foreach ($usuariosJSON as $usuario) {
      $usuariosTodos[] = json_decode($usuario, true);
    }
    return $usuariosTodos;
  }

  function generarId() {
    $todosUsuarios = todosLosUsuarios();
    if (empty($todosUsuarios)) {
      return 1;
    }
    $elUltimoUsuario = end($todosUsuarios);
    $id = $elUltimoUsuario['id'];
    return $id++;
  }

  function comprobarEmail($email) {
    $usuarios = todosLosUsuarios();
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
    }
  }

  function comprobarUsuario($username) {
    $usuarios = todosLosUsuarios();
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

  function traerPregunta($id) {
    $usuarios = todosLosUsuarios();
    $usuarioExistente['question'] = '';
    foreach ($usuarios as $usuario) {
      if($usuario['id'] == $id) {
        $usuarioExistente['question'] = $usuario['question'];
        break;
      }
    }
    if ($usuarioExistente['question'] != '') {
      return $usuarioExistente['question'];
    } else {
      return false;
    }
  }

  function comprobarAnswer($usuario, $answer) {
    $users = todosLosUsuarios();
    for ($i = 0; $i < count($users); $i++) {
      if ($users[$i]['answer'] == $answer && $users[$i]['id'] == $usuario['id']) {
       return $users[$i];
     }
   }
   return false;
  }

  function validarRespuesta($usuario, $post) {
    $answer = trim($post['answer']);
    $errores = [];
    if ($answer == '') {
      $errores['answer'] = "Escribí una respuesta";
    } elseif (comprobarAnswer($usuario, $answer) == false) {
       $errores['answer'] = "Respuesta incorrecta";
     }
    return $errores;
  }

  // LOGGEO
  function logUserIn($usuario) {
    $_SESSION['idUsuario'] = $usuario['id'];
  }

  function isLoggedIn() {
    return isset($_SESSION['idUsuario']);
  }


  // PERFIL DE USUARIO
  function getUserById($userId) {
    $usuarios = todosLosUsuarios();
    foreach ($usuarios as $usuario) {
      if ($usuario['id'] == $userId) {
        return $usuario;
      }
    }
    return false;
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
       $errores['name'] = "El campo debe contener solo letras";
    } elseif (strlen($name) < 2) {
      $errores['name'] = "El nombre debe tener más de un carácter";
    }

    if ($surname == '') {
      $errores['surname'] = "Completá tu apellido";
    } elseif (!filter_var($surname, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
      $errores['surname'] = "El campo debe contener solo letras";
    } elseif (strlen($surname) < 2) {
      $errores['surname'] = "El apellido debe tener más de un carácter";
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

  function modificarImagen($usuarioExistente, $img_profile) {
    $errores = [];

    if ($img_profile['error'] == UPLOAD_ERR_OK) {
     $imgName = $img_profile['name'];
     $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
     $imgTemp = $img_profile['tmp_name'];

     if ($imgExt == "jpg" || $imgExt == "jpeg" || $imgExt == "png" || $imgExt == "gif") {
       $fileName = $usuarioExistente['username'] . "." . $imgExt;
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

  function crearUsuarioCambiado($usuarioExistente, $post) {
    $usuarioAGuardar = [
        "id" => $usuarioExistente['id'],
        "name" => $post['name'],
        "surname" => $post['surname'],
        "username" => $usuarioExistente['username'],
        "email" => $post['email'],
        "question" => $usuarioExistente['question'],
        "answer" => $usuarioExistente['answer'],
        "password" => $usuarioExistente['password']
      ];
    $usuariosTodos = todosLosUsuarios();
    $usuariosTodos2 = [];

    foreach ($usuariosTodos as $usuario) {
      if ($usuario['id'] == $usuarioAGuardar['id']) {
        $usuariosTodos2[] = json_encode($usuarioAGuardar) . PHP_EOL;
      }
      elseif ($usuario['id'] != null) {
        $usuariosTodos2[] = json_encode($usuario) . PHP_EOL;
      }
    }
    file_put_contents('todosUsuarios.json', $usuariosTodos2);
  }

?>
