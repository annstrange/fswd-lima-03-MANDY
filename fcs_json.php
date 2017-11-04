<?php
  session_start();

// REGISTRO

function validarRegistroJSON($post, $files) {
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
  } elseif (comprobarEmailJSON($email) != false) {
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
function comprobarEmailJSON($email) {
    // devuelva true si hay usuario con este email

    // no lo usamos este metodo
    $usuarios = todosLosUsuariosJSON();
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

function crearUsuarioJSON($post, $files) {
  $rowid = 0;
  $usuarioAGuardarPHP = [
      'id' => generarIdJSON(),
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
  $rowid = insertUsuarioJSON($usuarioAGuardarPHP);
}

function generarIdJSON() {

    $usuarios= todosLosUsuariosJSON();
    if (empty($usuarios)) {
      return 1;
    }
    $elUltimoUsuario = end($usuarios);
    $id = $elUltimoUsuario['id'];
    return $id++;
  }

// REGISTRO
function comprobarUsuarioJSON($username) {
    // devuelva true si hay usuario con este username
    $usuarios = todosLosUsuariosJSON();
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
  /*  $db = connectarBD();
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
    }  */
  }

// lOGIN
function validarLoginJSON($post) {
  $errores = [];

  $email = trim($post['email']);
  $pass = trim($post['password']);
  $formato_email = filter_var($email, FILTER_VALIDATE_EMAIL);

  if ($pass == '' || $email == '') {
    $errores['email'] = "Completá los datos requeridos";
  } elseif (!$formato_email) {
    $errores['email'] = "Usa el formato nombre@dominio.com";
  } elseif (comprobarEmailJSON($email) == false) {
    $errores['email'] = "Este e-mail no tiene cuenta asociada";
  } else {
    $elUsuario = comprobarEmailJSON($email);
    $password = $elUsuario['password'];
    $password_ingresada = $post['password'];
    if (!password_verify($password_ingresada, $password)) {
       $errores['email'] = "E-mail o contraseña incorrectos";
    }
  }
  return $errores;
}

// RECUPERAR CONRASEÑA
function validarEmailRecuJSON($post) {
  $errores = [];
  $email = trim($post['email']);
  if ($email == '') {
    $errores['email'] = "Completá tu email";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = "Usa el formato nombre@dominio.com";
  } elseif (comprobarEmailJSON($email) == false) {
     $errores['email'] = "E-mail incorrecto";
  }
  return $errores;
}

function traerPreguntaJSON($id) {
  $usuarios = todosLosUsuariosJSON();
  $usuario = getUserByIdJSON($id);
  var_dump($usuario);
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

function traerRespuestaJSON($usuarioRecibido, $answer) {
  $usuarios = todosLosUsuariosJSON();
  $usuario = getUserByIdJSON($usuarioRecibido['id']);
  $usuarioExistente = [];
  foreach ($usuarios as $usuario) {
    if ($usuario['answer'] == $answer && $usuario['id'] == $usuarioRecibido['id']) {
      $usuarioExistente = $usuario;
      break;
    }
  }
  if (!empty($usuarioExistente)) {
    return $usuarioExistente;
  }
    return false;

}

function validarRespuestaJSON($usuarioRecibido, $post) {
  $answer = trim($post['answer']);
  $errores['answer'] = '';
  if ($answer == '') {
    $errores['answer'] = "Escribí una respuesta";
  } elseif (traerRespuestaJSON($usuarioRecibido, $answer) == false) {
     $errores['answer'] = "Respuesta incorrecta";
   }
  return $errores['answer'];
}
// PERFIL DE USUARIO
function getUserByIdJSON($userId) {
  $usuarios = todosLosUsuariosJSON();
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
  }
}
function validarCambiosJSON($post, $files) {
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
  } elseif (comprobarEmailJSON($email) != false && comprobarEmailJSON($email)['email'] != $email) {
    $errores['email'] = "Ya hay una cuenta asociada a este e-mail";
  }

  return $errores;
}

function crearUsuarioCambiadoJSON($usuarioRecibido, $post) {
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

    $usuarios = todosLosUsuariosJSON();
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

  }

  function todosLosUsuariosJSON() {

      $jsonFile = file_get_contents("todosUsuarios.json");
      $usuariosJSON = explode(PHP_EOL, $jsonFile);
      array_pop($usuariosJSON);
      $usuarios = [];
      foreach ($usuariosJSON as $usuario) {
        $usuarios[] = json_decode($usuario, true);
      }
      return $usuarios;
    }


?>
