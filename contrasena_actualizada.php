<?php
  // require_once('fcs_mandy.php');
  require_once('soporte.php');
  require_once('includes/head.php');
  require_once('includes/header.php');

  if (!$db->dbExists()) {
		header('Location: db/bd_admin.php');
		exit;
	}

?>
    <div class="page-container login-registro-content">
      <div class="titulo-login">
          <h3>¡Tu password ha sido actualizada!</h3>
      </div>

      <center>
        <a class="boton-modificar" href="login.php">Ir al login</a> &nbsp;
        <a class="boton-modificar" href="index.php">Volver al inicio</a>
      </center>

    </div>

  </body>
</html>
