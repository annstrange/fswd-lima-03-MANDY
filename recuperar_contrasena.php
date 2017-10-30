<?php
  require_once('fcs_mandy.php');

  $email = '';
  $erroresTotales = [];

    if ($_POST) {
      $email = trim($_POST['email']);
      $erroresTotales = validarEmailRecu($_POST);
      if (empty($erroresTotales)) {
        $usuario = comprobarEmail($email);
        $_SESSION['userRecover'] = $usuario;
        header('Location:comprobar_respuesta.php');
        exit;
        }
      }

  require_once('includes/head.php');
  require_once('includes/header.php');
 ?>

  <div class="page-container login-registro-content">

     <div class="titulo-login">
       <h3>¿Olvidaste tu contraseña?</h3>
     </div>

     <form class="form-login-registro" method="post">
       <input type="text" name="email" placeholder="Correo electrónico"value="<?=$email;?>" >
       <?php if (!empty($erroresTotales['email'])): ?>
         <span class="error">
           <span class="ion-close"></span>
           <?=$erroresTotales['email'];?>
         </span>
       <?php endif; ?>
       <center>
         <button type="submit">Buscar</button>
       </center>
    </form>
  </div>

   </body>
 </html>
