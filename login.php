<?php
  require_once('soporte.php');

  if (!$db->dbExists()) {
		header('Location: db/bd_admin.php');
		exit;
	}

  if ($auth->isLoggedIn()) {
     header('Location:index.php');
     exit;
   }

  $erroresTotales = [];
  $email = '';

  if ($_POST) {
    $email = $_POST['email'];
    $erroresTotales = $validator->validarLoginBD($_POST, $db);
    if (empty($erroresTotales)) {

      $usuario = $db->comprobarEmailBD($email);
      $auth->logUserIn($usuario);

      if (isset($_POST['remember'])) {
        $auth->rememberMe();
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
        <button class="boton-registrate" type="button"><a href="registro.php">Regístrate</a></button>

      </form>

    </div>

  </body>
</html>
