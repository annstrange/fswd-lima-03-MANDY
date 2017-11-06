<?php
  require_once('fcs_mandy.php');

  if (!dbExists()) {
		header('Location: db/bd_admin.php');
		exit;
	}

  if (isLoggedIn()) {
    header('Location:index.php');
    exit;
  }

  $erroresTotales = [];
  $email = '';

  if ($_POST) {
    $email = $_POST['email'];
    $erroresTotales = validarLoginBD($_POST);
    if (empty($erroresTotales)) {
      $usuario = comprobarEmailBD($email);
      logUserIn($usuario);
      if (isset($_POST['remember'])) {
        $time = time() + (60 * 60 * 24 * 365);
        setcookie('idUsuario', $usuario['id'], $time);
      }
      header('location:perfil_usuario.php');
      exit;
    }
  }

  require_once('includes/head.php');
  require_once('includes/header.php');
 ?>


    <div class="page-container login-registro-content">
      <div class="titulo-login">
          <h3>Login</h3>
      </div>
      <form class="form-login-registro" method="post">

        <input type="text" class="email" name="email" placeholder="Correo electrónico" value="<?=$email;?>">
        <input type="password" class="password" name="password" placeholder="Contraseña">

        <?php if (!empty($erroresTotales['email'])): ?>
            <span class="error">
              <span class="ion-close"></span>
              <?=$erroresTotales['email'];?>
            </span>
      <?php endif;?><br>


        <div class="adicionales-login">
          <label class="recordarme">
            <input type="checkbox" name="remember" value="remember"> Recordarme
          </label>
          <a class="olvidar" href="recuperar_contrasena.php">¿Olvidó su contraseña?</a>
        </div>

        <button class="boton-ingresar" type="submit">Ingresar</button>
        <button class="boton-registrate" type="button">Regístrate</button>

      </form>

    </div>

  </body>
</html>
