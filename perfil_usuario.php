<?php
  require_once('fcs_mandy.php');

  if (isLoggedIn()) {
    $usuario = getUserById($_SESSION['idUsuario']);
    $name = $usuario['name'];
    $surname = $usuario['surname'];
    $username = $usuario['username'];
    $email = $usuario['email'];
    $imgSrc = glob("images/img_profile/" . $username . ".*");
  } else {
    header('Location:login.php');
    exit;
    }

  require_once('includes/head.php');
  require_once('includes/header.php');

?>

    <div class="page-container login-registro-content">
      <div class="titulo-registro">
          <h3>Mi Perfil</h3>
      </div>
      <div class="img_perfil_container">
        <img class="imagen-perfil" src="<?=$imgSrc[0];?>" alt="foto">
       </div>
      <div class="perfil-view">
        <p><strong>Nombre:</strong><br> <?=$name." ".$surname;?></p>
        <p><strong>Usuario:</strong><br> <?=$username;?></p>
        <p><strong>E-mail:</strong><br> <?=$email;?></p>
      </div>
      <div class="clearfix"></div>
      <center>
        <a class="boton-modificar" href="modificar_perfil.php">Modificar perfil</a>
      </center>
    </div>

  </body>
</html>
