<?php
require_once('soporte.php');

  class Auth{
    public function __construct(){
      session_start();
      if (isset($_COOKIE['idUsuario'])) {
        $_SESSION['idUsuario'] = $_COOKIE['idUsuario'];
      }
    }

    public function rememberMe(){
      $time = time() + (60 * 60 * 24 * 365);
      setcookie('idUsuario', $usuario['id'], $time);
    }

    public function logUserIn( user $user) {

      $_SESSION['idUsuario'] = $user->getId();
    }

    public function isLoggedIn() {
      return isset($_SESSION['idUsuario']);
    }

    public function logout(){
      session_unset();
      $time = time() - (60 * 60 * 24 * 365);
      setcookie('idUsuario', "", $time);
      session_destroy();
    }


  }





 ?>
