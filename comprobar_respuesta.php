<?php
  require_once('fcs_mandy.php');

  if (!dbExists()) {
		header('Location: db/bd_admin.php');
		exit;
	}

  if (isset($_SESSION['userRecover'])) {
    $usuario = $_SESSION['userRecover'];
  } else {
    header('Location:recuperar_contrasena.php');
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

  $erroresTotales['answer'] = '';
  $erroresTotales['password'] = '';

  if ($_POST) {
    $erroresTotales['answer'] = validarRespuestaBD($usuario, $_POST);
    $erroresTotales['password'] = validarNuevaPass($_POST);
    var_dump($erroresTotales);
    if ($erroresTotales['answer'] == ''
    && $erroresTotales['password'] == '') {
      unset($_SESSION['userRecover']);
      header('Location:contrasena_actualizada.php');
      exit;
    }
  }

  $pregunta = traerPreguntaBD($usuario['id']);
  $pregunta = $questions[$pregunta];

  require_once('includes/head.php');
  require_once('includes/header.php');
 ?>

     <div class="page-container login-registro-content">
       <div class="titulo-login">
           <h3>¿Olvidaste tu contraseña?</h3>
       </div>
       <form class="form-login-registro" method="post">
         <label class="input-label"><?=$pregunta;?></label><br>
         <input type="text" name="answer" placeholder="Respuesta">
         <?php if ($erroresTotales['answer'] != '') : ?>
           <span class="error">
             <span class="ion-close"></span>
             <?=$erroresTotales['answer'];?>
           </span>
         <?php endif; ?>
         <label class="input-label">Ingresa una nueva contraseña</label><br>
         <input type="password" name="newpass" placeholder="Contraseña">
         <?php if ($erroresTotales['password'] != '') : ?>
           <span class="error">
             <span class="ion-close"></span>
             <?=$erroresTotales['password'];?>
           </span>
         <?php endif;?>
         <button class="boton-ingresar" type="submit">Enviar</button>
       </form>
     </div>

   </body>
 </html>
