<?php
require_once("soporte.php");

 abstract class db{

    public abstract function insertUsuarioBD(user $user);
    public abstract function comprobarEmailBD($email);
    public abstract function traerPreguntaBD($id);
    public abstract function traerRespuestaBD(user $user, $answer);
    public abstract function getUserByIdBD($userId);
    public abstract function updateUsuarioBD(user $user, $post);
    public abstract function todosLosUsuariosDB();
    public abstract function comprobarUsuarioBD($username);

  }

 ?>
