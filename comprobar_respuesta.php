<?php
  require_once('fcs_mandy.php');

  if (isset($_SESSION['userRecover'])) {
    $usuario = $_SESSION['userRecover'];
  } else {
    header("Location:login.php");
    exit;
  }

  $questions = [
    'q1' => '¿Cuál es tu libro favorito?',
    'q2' => '¿Cuál es el nombre de tu mascota?',
    'q3' => '¿Cuál es tu artista favorito?',
    'q4' => '¿Cuál es tu vanguardia favorita?',
    'q5' => '¿Cuál es tu película favorita?',
    'q6' => '¿Cuál es tu sueño?'
  ];
  $erroresTotales = [];
  $erroresAnswer = [];


  if ($_POST) {
      $erroresAnswer = validarRespuesta($_POST);
      if (count($erroresAnswer) == 0) {
        unset($_SESSION['userRecover']);
        header('Location:contrasena_actualizada.php');
      }
  }

  $pregunta = traerPregunta($usuario['email']);
  $pregunta = $questions[$pregunta];

  require_once('includes/head.php');
  require_once('includes/header.php');
 ?>

     <div class="page-container login-registro-content">
       <div class="titulo-login">
           <h3>¿Olvidaste tu contraseña?</h3>
       </div>
       <form class="form-login-registro" method="post">
         <label class="input-label"><?=$pregunta?></label><br>
         <input type="text" name="answer" placeholder="Respuesta">
         <?php if (!empty($erroresAnswer)): ?>
           <span class="error">
             <span class="ion-close"></span>
             <?=$erroresAnswer['answer'];?>
           </span>
         <?php endif; ?>
         <button class="boton-ingresar" type="submit">Enviar</button>
       </form>
     </div>

   </body>
 </html>
