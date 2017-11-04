<?php
  require_once('fcs_mandy.php');

  if (isLoggedIn()) {
    header('Location:index.php');
    exit;
  }

  $questions = [
    "q1" => "¿Cuál es tu libro favorito?",
    "q2" => "¿Cuál es el nombre de tu mascota?",
    "q3" => "¿Cuál es tu artista favorito?",
    "q4" => "¿Cuál es tu vanguardia favorita?",
    "q5" => "¿Cuál es tu película favorita?",
    "q6" => "¿Cuál es tu sueño?"
  ];

  // Initialize
  $name = '';
  $surname = '';
  $username = '';
  $email = '';
  $question = '';
  $answer = '';
  $password = '';
  $repass = '';
  $erroresTotales = [];

  if ($_POST) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $question = $_POST['question'];
    $answer=$_POST['answer'];
    $password = $_POST['password'];
    $repass = $_POST['repass'];
    $img_profile = $_FILES['img_profile'];

    $erroresTotales = validarRegistroBD($_POST, $_FILES);

    if (empty($erroresTotales)) {
      $erroresTotales = guardarImagen($img_profile);
      if (empty($erroresTotales)) {
        $userId = crearUsuarioBD($_POST, $_FILES);
        //$userId = insertUsuarioDB($_POST, $_FILES);
        // $usuario = comprobarUsuario($username);
        $usuario = getUserByIdBD($userId);
        logUserIn($usuario);
        header('location:perfil_usuario.php');
        exit;
      }
    }
  }

  require_once('includes/head.php');
  require_once('includes/header.php');

 ?>

    <div class="page-container login-registro-content">
      <div class="titulo-registro">
        <h3>Registro</h3>
      </div>
      <form class="form-login-registro" method="post" enctype="multipart/form-data">


        <div class="two-input-wrapper">
          <div class="input-container">
            <input type="text" name="name" class="name" placeholder="Nombre" value="<?=$name;?>">
            <?php if (isset($erroresTotales['name'])): ?>
              <span class="error">
                <span class="ion-close"></span>
                <?=$erroresTotales['name'];?>
              </span>
            <?php endif;?>
          </div>

          <div class="input-container">
            <input type="text" name="surname" class="surname" placeholder="Apellido" value="<?=$surname;?>" >
            <?php if (isset($erroresTotales['surname'])): ?>
              <span class="error">
                <span class="ion-close"></span>
                <?=$erroresTotales['surname'];?>
              </span>
            <?php endif;?>
          </div>
        </div>

        <input type="text" class="user" name="username" placeholder="Usuario" value="<?=$username;?>">
        <?php if (isset($erroresTotales['username'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['username'];?>
          </span>
        <?php endif;?>


        <input type="text" class="email" name="email" placeholder="Correo electrónico" value="<?=$email;?>">
        <?php if (isset($erroresTotales['email'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['email'];?>
          </span>
        <?php endif;?>


        <select name="question" class="question">
          <option value="">Pregunta de seguridad</option>
          <?php foreach ($questions as $key => $value) : ?>
            <?php if(isset($question) && $question == $key) : ?>
              <option selected value="<?=$key;?>">
                <?=$value;?>
              </option>
            <?php else:?>
              <option value="<?=$key;?>">
                <?=$value;?>
              </option>
            <?php endif;?>
          <?php endforeach;?>
        </select>

        <?php if (isset($erroresTotales['question'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['question'];?>
          </span>
        <?php endif;?>

        <input type="text" class="answer" name="answer" placeholder="Respuesta" value="<?=$answer;?>">
        <?php if (isset($erroresTotales['answer'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['answer'];?>
          </span>
        <?php endif;?>

        <input type="password" class="password" name="password" placeholder="Contraseña" value="<?=$password;?>">
        <?php if (isset($erroresTotales['password'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['password'];?>
          </span>
        <?php endif;?>

        <input type="password" class="repass" name="repass" placeholder="Reingresar contraseña" value="<?=$repass;?>">
        <?php if (isset($erroresTotales['repass'])) : ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['repass'];?>
          </span>
        <?php endif;?>

        <label class="input-label">Subí una foto de perfil: </label>
        <input type="file" name="img_profile" id="img_profile" class="img_profile">
        <label for="img_profile">Elegir</label>
        <?php if (isset($erroresTotales['img_profile'])): ?>
          <span class="error">
            <span class="ion-close"></span>
            <?=$erroresTotales['img_profile'];?>
          </span>
        <?php endif;?>

        <button class="boton-registrarme" type="submit" name="button">Registrarme</button>

      </form>
    </div>
  </body>
</html>
