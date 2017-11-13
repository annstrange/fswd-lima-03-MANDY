<?php
require_once("soporte.php");

 abstract class db{

     // agregar "abstract" en los declaraciónes de functions.

    public abstract function insertUsuarioBD(user $user);
    public abstract function comprobarEmailBD($email);
    public abstract function traerPreguntaBD($id);
    public abstract function traerRespuestaBD(user $user, $answer);
    public abstract function getUserByIdBD($userId);
    public abstract function updateUsuarioBD(user $user, $post);
    public abstract function todosLosUsuariosDB();
    public abstract function comprobarUsuarioBD($username);

    // AS Esos no son bastante genéricos para el padre, y los quedamos para mySQL clase.
  //   public abstract function conectarSinBD();
    //public function createSchema();
    //public function createTablaUsuario ();
    //public function dbExists();
    //public function conectarBD();
    //public function conectarSinBD();
    //public function bdDisponible();
    //public function existeTabla($nombre);

  }




 ?>
