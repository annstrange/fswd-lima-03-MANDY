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
    if (count($todosUsuarios) == 0) {
      return 1;
    }
    $elUltimoUsuario = end($todosUsuarios);
    $id = $elUltimoUsuario['id'];
    return $id + 1;
  }

  function comprobarEmail($email) {
   $usuarios = todosLosUsuarios();
   for ($i = 0; $i < count($usuarios); $i++) {
     if ($usuarios[$i]['email'] == $email) {
       return $usuarios[$i];
     }
   }
   return false;
  }

  function comprobarUsuario($username) {
   $usuarios = todosLosUsuarios();
   for ($i = 0; $i < count($usuarios); $i++) {
     if ($usuarios[$i]['username'] == $username) {
       return $usuarios[$i];
     }
   }
   return false;
  }


  function guardarImagen($img_profile) {
    $errores = [];
    $posibles_errores = [
      "Debes subir una imagen jpg, jpeg, png o gif",
      "Error " . $img_profile['error'] . ". Intentá de nuevo.",
    ];

    if ($img_profile['error'] == UPLOAD_ERR_OK) {
     $imgName = $img_profile['name'];
     $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
     $imgTemp = $img_profile['tmp_name'];
     $ext_ok = ($imgExt == 'jpg' || $imgExt == 'JPG' || $imgExt == 'JPEG' || $imgExt == 'jpeg' || $imgExt == 'png' || $imgExt == 'PNG' || $imgExt == 'gif' || $imgExt == 'GIF');
     if ($ext_ok) {
       $fileName = $_POST['username'] . "." . $imgExt;
       $imgSrc = dirname(__FILE__) . "/images/img_profile/" . $fileName;
       move_uploaded_file($imgTemp, $imgSrc);
     } else {
       $errores['img_profile'] = $posibles_errores[0];
     }
   } else {
       $errores['img_profile'] = $posibles_errores[1];
     }
   return $errores;
  }


  // LOG-IN
  function validarLogin($post) {
    $errores = [];
    $posibles_errores = [
      "Completá los datos requeridos",
      "Usa el formato nombre@dominio.com",
      "Este e-mail no tiene cuenta asociada",
      "E-mail o contraseña incorrectos"
    ];
    $email = trim($post['email']);
    $pass = trim($post['password']);
    $formato_email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($pass == '' || $email == '') {
      $errores['email'] = $posibles_errores[0];
    } elseif (!$formato_email) {
      $errores['email'] = $posibles_errores[1];
    } elseif (comprobarEmail($email) == false) {
      $errores['email'] = $posibles_errores[2];
    } else {
      $elUsuario = comprobarEmail($email);
      $password = $elUsuario['password'];
      $password_ingresada = $post['password'];
      if (!password_verify($password_ingresada, $password)) {
         $errores['email'] = $posibles_errores[3];
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

  function traerPregunta($email) {
    $users = todosLosUsuarios();
    for ($i=0; $i < count($users) ; $i++) {
      if ($users[$i]['email'] == $email) {
        return $users[$i]['question'];
      }
    }
    return false;
  }

  function comprobarAnswer($answer) {
    $users = todosLosUsuarios();
    for ($i = 0; $i < count($users); $i++) {
      if ($users[$i]['answer'] == $answer && $users[$i]['email'] == $_SESSION['userRecover']['email']) {
       return $users[$i];
     }
   }
   return false;
  }

  function validarRespuesta($post) {
    $answer = trim($post['answer']);
    $errores = [];
    if ($answer == '') {
      $errores['answer'] = "Escribí una respuesta";
    } elseif (comprobarAnswer($answer) == false) {
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
    $posibles_errores = [
      "No aceptamos este formato. Probá guardarla como jpg, jpeg, png o gif",
      "Error " . $img_profile['error'] . ". Intentá de nuevo.",
    ];
    $ext_ok = ($imgExt = 'jpg' || $imgExt = 'JPG' || $imgExt = 'JPEG' || $imgExt = 'jpeg' || $imgExt = 'png' || $imgExt = 'PNG' || $imgExt = 'gif' || $imgExt = 'GIF');

    if ($img_profile['error'] == UPLOAD_ERR_OK) {
     $imgName = $img_profile['name'];
     $imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
     $imgTemp = $img_profile['tmp_name'];
     if ($ext_ok) {
       $fileName = $usuarioExistente['username'] . "." . $imgExt;
       $imgSrc = dirname(__FILE__) . "/images/img_profile/" . $fileName;
       move_uploaded_file($imgTemp, $imgSrc);
     } else {
       $errores['img_profile'] = $posibles_errores[0];
     }
   } elseif ($img_profile['error'] == UPLOAD_ERR_NO_FILE) {
     return $errores;
   } else {
       $errores['img_profile'] = $posibles_errores[1];
     }
   return $errores;
  }

  function crearUsuarioCambiado($usuarioExistente, $post, $files) {
    $usuarioAGuardar = [
        'id' => $usuarioExistente['id'],
        'name' => $post['name'],
        'surname' => $post['surname'],
        'username' => $usuarioExistente['username'],
        'email' => $post['email'],
        'question' => $usuarioExistente['question'],
        'answer' => $usuarioExistente['answer'],
        'password' => $usuarioExistente['password'],
        'img_profile' => $files['img_profile']
      ];

    return guardarUsuarioCambiado($usuarioAGuardar);

    }

    function guardarUsuarioCambiado($usuarioNuevo) {
        // re-escribe el archivo en total, con nuevo entrada para el usuario cambiado.
        $usuariosTodos = todosLosUsuarios();
        $usuariosTodos2 = [];

        // find user to replace. write each user to the new array of users
        foreach ($usuariosTodos as $index => $usuario) {
          if ($usuario["id"] == $usuarioNuevo["id"]) {
            $usuariosTodos2[] = json_encode($usuarioNuevo).PHP_EOL;
          }
          elseif ($usuario["id"] != null) {
            $usuariosTodos2[] = json_encode($usuario).PHP_EOL;
          }
        }

       file_put_contents('todosUsuarios.json', $usuariosTodos2);  // write all users
       return true;
      }

?>
