<?php

 class User
 {
   private $id = 0;
   private $name;
   private $surname;
   private $username;
   private $email;
   private $question;
   private $answer;
   private $pass;

  // //se supone que crearUsuarioBD= al constructor
  //  function crearUsuarioBD($post, $files) {
  //      $rowid = 0;
  //      $usuarioAGuardarPHP = [
  //          // 'id' => generarId(),
  //          'name' => $post['name'],
  //          'surname' => $post['surname'],
  //          'username' => $post['username'],
  //          'email' => $post['email'],
  //          'question' => $post['question'],
  //          'answer' => $post['answer'],
  //          'password' => password_hash($post['password'], PASSWORD_DEFAULT)
  //        ];
  //
  //      $rowid = insertUsuarioBD($usuarioAGuardarPHP);
  //      return $rowid;
  //    }


   public function __construct($name,$surname,$username,$email,$question,$answer,$pass,$id = NULL)
   {
     if($id == NULL){
       // Viene por POST
       $this->pass=password_hash($pass,PASSWORD_DEFAULT);
     }
     else {
       // Viene de la base
       $this->pass = $pass;
     }
     //$this->id=insertUsuarioBD($usuarioAGuardarPHP);
     $this->id=$id;  // despues de INSERT, consiguá el id.
     $this->name=$name;
     $this->surname=$surname;
     $this->username=$username;
     $this->email=$email;
     $this->question=$question;
     $this->answer=$answer;
 }

    public function setId($id){
       $this->id=$id;
     }
    public function getId(){
      return $this->id;
    }
    public function setName($name){
       $this->name=$name;
     }
    public function getName(){
      return $this->name;
    }
    public function setSurname($surname){
       $this->surname=$surname;
     }
    public function getSurname(){
      return $this->surname;
    }
    public function setUsername($username){
       $this->username=$username;
     }
    public function getUsername(){
      return $this->username;
    }
    public function setEmail($email){
       $this->email=$email;
     }
    public function getEmail(){
      return $this->email;
    }
    public function setQuestion($question){
       $this->question=$question;
     }
    public function getQuestion(){
      return $this->question;
    }
    public function setAnswer($answer){
       $this->answer=$answer;
     }
    public function getAnswer(){
      return $this->answer;
    }
    public function setPassword($pass) {
      $this->pass = $pass;
    }

    public function getPassword() {
      return $this->pass;
    }

    public function guardarImagen($img_profile) {
      $errores = [];

      if ($img_profile['error'] == UPLOAD_ERR_OK) {
       $imgName = $img_profile['name'];
       $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
       $imgTemp = $img_profile['tmp_name'];

       if ($imgExt == "jpg" || $imgExt == "jpeg" || $imgExt == "png" || $imgExt == "gif") {
         $fileName = $this->username . "." . $imgExt;
         $imgSrc = dirname(__FILE__) . "../images/img_profile/" . $fileName;
         move_uploaded_file($imgTemp, $imgSrc);
       }
       else {
         $errores['img_profile'] = "Debes subir una imagen jpg, jpeg, png o gif";
       }
     } else {
         $errores['img_profile'] = "Error " . $img_profile['error'] . ". Intentá de nuevo.";
       }
     return $errores;
    }

    function modificarImagen(user $user, $img_profile) {
      $errores = [];

      if ($img_profile['error'] == UPLOAD_ERR_OK) {
       $imgName = $img_profile['name'];
       $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
       $imgTemp = $img_profile['tmp_name'];

       if ($imgExt == "jpg" || $imgExt == "jpeg" || $imgExt == "png" || $imgExt == "gif") {
         $fileName = $this->username. "." . $imgExt;
         $imgSrc = dirname(__FILE__) . "../images/img_profile/" . $fileName;
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
}

 ?>
