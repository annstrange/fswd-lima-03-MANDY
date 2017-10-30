<?php

require_once('fcs_mandy.php');

if (isLoggedIn()) {
  $usuario = getUserById($_SESSION['idUsuario']);
  $id = $usuario['id'];
  $name = $usuario['name'];
  $surname = $usuario['surname'];
  $username = $usuario['username'];
  $email = $usuario['email'];
  $img_profile = [];
  $imgSrc = glob("images/img_profile/" . $username . ".*");
} else {
  header('Location:login.php');
  exit;
  }

  if ($_POST) {
    $erroresTotales = [];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $img_profile = $_FILES['img_profile'];

    $erroresTotales = validarCambios($_POST, $_FILES);

  if (empty($erroresTotales)) {
    $erroresTotales = modificarImagen($usuario, $img_profile);
    if (empty($erroresTotales)) {
      crearUsuarioCambiado($usuario, $_POST);
    }
  }
}

require_once('includes/head.php');
require_once('includes/header.php');
 ?>

  <div class="page-container login-registro-content">

    <div class="titulo-registro">
      <h3>Mi Perfil</h3>
    </div>

    <form class="form-login-registro" method="post" enctype="multipart/form-data">

      <?php if($_POST && empty($erroresTotales)) : ?>
           <h3>¡Tus cambios han sido guardados con éxito!</h3>
      <?php endif;?>

      <center>
        <img class="imagen-perfil" src= "<?=$imgSrc[0];?>" alt="imagen de perfil"><br>
        <input type="file" name="img_profile" id="img_profile" class="img_profile">
        <label for="img_profile">Subir nueva imagen</label>
        <!-- <button class="boton-imagen" type="submit">Aceptar</button> -->
      </center>
    <!-- </form>

    <form class="form-login-registro" method="post" enctype="multipart/form-data"> -->
      <?php if (isset($erroresTotales['img_profile'])): ?>
        <span class="error">
          <span class="ion-close"></span>
          <?=$erroresTotales['img_profile'];?>
        </span>
      <?php endif;?>

      <label class="input-label" for="name">Nombre</label><br>
      <input type="text" name="name" value="<?=$name;?>">
      <?php if (isset($erroresTotales['name'])): ?>
        <span class="error">
          <span class="ion-close"></span>
          <?=$erroresTotales['name'];?>
        </span>
      <?php endif;?>

      <label class="input-label" for="surname">Apellido</label><br>
      <input type="text" name="surname" value="<?=$surname;?>" >
      <?php if (isset($erroresTotales['surname'])): ?>
        <span class="error">
          <span class="ion-close"></span>
          <?=$erroresTotales['surname'];?>
        </span>
      <?php endif;?>

      <label class="input-label" for="email">Correo electrónico</label><br>
      <input type="text" name="email" value="<?=$email;?>">
      <?php if (isset($erroresTotales['email'])): ?>
        <span class="error">
          <span class="ion-close"></span>
          <?=$erroresTotales['email'];?>
        </span>
      <?php endif;?>
      <center>
        <button class="boton-modificar" type="submit">Guardar cambios</button>
      </center>

    </form>
  </div>

</div>

  </body>
</html>
