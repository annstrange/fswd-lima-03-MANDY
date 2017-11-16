<?php
//require_once('soporte.php');
//require_once('$dbMySql.php');
require_once('user.php');
  class Validator{
    public function validarRegistroBD($post, $files, db $db) {
      // llama métodos de BD comprobarUsuarioBD y comprobarEmailBD
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
      } elseif ($db->comprobarUsuarioBD($username) != false) {
        $errores['username'] = "Ya hay una cuenta asociada a este nombre de usuario";
      }

      if ($email == '') {
        $errores['email'] = "Completá tu e-mail";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Usá el formato nombre@dominio.com";
      } elseif ($db->comprobarEmailBD($email) != false) {
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


    function validarLoginBD($post, db $db) {
      $errores = [];

      $email = trim($post['email']);
      $pass = trim($post['password']);
      $formato_email = filter_var($email, FILTER_VALIDATE_EMAIL);

      if ($pass == '' || $email == '') {
        $errores['email'] = "Completá los datos requeridos";
      } elseif (!$formato_email) {
        $errores['email'] = "Usa el formato nombre@dominio.com";
      } elseif ($db->comprobarEmailBD($email) == false) {
        $errores['email'] = "Este e-mail no tiene cuenta asociada";
      } else {
        $elUsuario = $db->comprobarEmailBD($email);
        //$password = $elUsuario['password'];
        if ($elUsuario) {
           $password = $elUsuario->getPassword();
           echo "<br><br><br><br><br><br> password $password";
        }
        else {
          $password = '';
        }

        $password_ingresada = $post['password'];
        // echo "<br>elUsuario <br><br><br><br><br><br><br><br><br><br>";
        // var_dump($elUsuario);
        // echo "<br>pw from object <br>";
        // var_dump($elUsuario->getPassword());
        // echo "<br>pw ingresada <br>";
        // var_dump($password_ingresada);
        // echo "<br>pw <br>";
        // var_dump($password);
        if (!password_verify($password_ingresada, $password)) {
           $errores['email'] = "E-mail o contraseña incorrectos";
        }
      }
      return $errores;
    }



    function validarEmailRecuBD($post,db $db) {
      $errores = [];
      $email = trim($post['email']);
      if ($email == '') {
        $errores['email'] = "Completá tu email";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Usa el formato nombre@dominio.com";
      } elseif ($db->comprobarEmailBD($email) == false) {
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

      public function validarRespuestaBD( user $user, $post,db $db) {
            $answer = trim($post['answer']);
            $errores['answer'] = '';
            if ($answer == '') {
              $errores['answer'] = "Escribí una respuesta";
            } elseif ($db->traerRespuestaBD($user, $answer) == false) {
               $errores['answer'] = "Respuesta incorrecta";
             }
            return $errores['answer'];
          }


  public function validarCambiosBD($post, $files, db $db) {
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
          //  AS  missing comma next line:
        } elseif (!filter_var($surname, FILTER_VALIDATE_REGEXP, ['options'=>['regexp'=>'/^[a-zA-Z_ ]*$/']])) {
          $errores['surname'] = "El campo solo debe contener letras";
        } elseif (strlen($surname) < 2) {
            $errores['surname'] = "El apellido debe contener mínimo 2 caracteres";
          }

          if ($email == '') {
            $errores['email'] = "Completá tu e-mail";
          } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "Usá el formato nombre@dominio.com";
          }
          // AS - Este necesita ayuda.  Como sabemos que el email que exista es diferente
          //     Pasé el id o el usuario viejo para ver.
          // elseif ($db->comprobarEmailBD($email) != $oldUser->getEmail() && $db->comprobarEmailBD($email) != false) {
          //   $errores['email'] = "Ya hay una cuenta asociada a este e-mail";
          // }
            return $errores;
          }
}
 ?>
