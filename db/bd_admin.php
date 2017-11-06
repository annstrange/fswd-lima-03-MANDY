<?php
// Métodos para crear base de datos, y convertir de json archivo.
  $db = null;
  require_once('conexion.php');
  require_once('../fcs_mandy.php');

  // function dropSchema() {
  //   // ¡Cuidado con esta función!
  //   $db = conectarBD();
  //   try {
  //     $ddl = "DROP SCHEMA 'mandy_db';";
  //     $result=$db->exec($ddl);
  //     var_dump($result);
  //   } catch (PDOException $e) {
  //     echo "Failure: " . $e->getMessage() . " <br>";
  //   }
  //   $db = null;
  // }
  //
  // function dropTablaUsuario () {
  //   $db = conectarBD();
  //   $ddl = "DROP TABLE mandy_db.usuario;";
  //   try {
  //     $result=$db->exec($ddl);
  //     $db = null;
  //   } catch (PDOException $e) {
  //     echo "Failure in dropTablaUsuario(): ". $e->getMessage()." <br>";
  //   }
  // }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/normalize.css" rel="stylesheet">
    <link href="../css/ionicons-2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <title>Mandy.com - Compra arte independiente local</title>
  </head>
  <body>

    <?php
      if (isLoggedIn()) {
        $usuario = getUserByIdBD($_SESSION['idUsuario']);
        $username = $usuario['username'];
        $imgSrc = glob("images/img_profile/" . $username . ".*");
      }
    ?>

    <header class="main-header">
      <input type="checkbox" id="open-nav">
      <label for="open-nav" class="toggle-nav">
        <span class="ion-navicon-round"></span>
      </label>
      <a href="../index.php" class="logo-title">
        <h1>Mandy</h1>
      </a>

      <!-- NAV -->
      <nav class="main-nav">
        <label class="close-nav" for="open-nav">
          <span class="ion-chevron-left"></span>
        </label>
        <a href="#" class="shopping-bag sb-mobile">
          <span class="ion-bag"></span>
        </a>
        <div class="links-mobile">
          <?php if(isLoggedIn()) : ?>
            <div class="user-avatar">
              <img src="<?=$imgSrc[0];?>">
            </div>
            <div class="user-display">
              <a href="../perfil_usuario.php">
                Hola, <?=$usuario['name'];?><br>
                <u>Ir a perfil &nbsp; ▸</u>
              </a>

            </div>
          <?php else : ?>
            <a href="../login.php" class="log-in-mobile">Login</a>
            <a href="../registro.php">
              ¿Aún no tienes cuenta?<br><u>Regístrate.</u>
            </a>
          <?php endif; ?>
        </div>
        <ul>
          <li><a href="../index.php">Inicio</a></li>
          <li><a href="#">Cómo funciona</a></li>
          <li><a href="#">Categorías</a></li>
          <li><a href="#">Servicios</a></li>
          <li><a href="../faqs.php">FAQs</a></li>
          <?php if(isLoggedIn()) : ?>
            <li><a href="../logout.php">Cerrar sesión</a></li>
          <?php endif; ?>
        </ul>
      </nav>

      <div class="icon-nav">
        <input type="checkbox" id="open-search">

        <div class="links-desktop">

          <?php if(isLoggedIn()) : ?>
            <span class="user-avatar">
              <img src="<?=$imgSrc[0];?>">
            </span>
            <span class="user-display">
              Hola, <?=$usuario['name'];?> &nbsp; ▾
            </span>
            <div class="user-menu">
              <ul>
                <li><a href="../perfil_usuario.php">Mi perfil</a></li>
                <li><a href="../logout.php">Cerrar sesión</a></li>
              </ul>
            </div>


          <?php else : ?>
            <a href="../registro.php">Regístrate</a>
            <a href="../login.php" class="log-in-desktop">Login</a>
          <?php endif; ?>

        </div>

        <form method="get" class="top-searchbar">
          <input type="text" name="top-searchbar" placeholder="¿Qué estás buscando?">
          <!-- <input type="submit" name="search" value="Ir"> -->
        </form>
        <label for="open-search" class="top-search">
            <span class="ion-search"></span>
        </label>
        <a href="#" class="shopping-bag sb-desktop">
          <span class="ion-bag"></span>
        </a>
      </div>
    </header>

    <section class="page-container">

      <div class="titulo-login">
        <h3>Administración de Base de Datos</h3>
      </div>

      <center>
        <div style="font-size: 20px">
          <p>
            La conexión está disponible?
            <b><?php echo bdDisponible() ? "Sí" : "No";?></b>
          </p>

            Existe la tabla "usuario"?
            <b><?php echo existeTabla("usuario") ? "Sí" : "No";?></b>
          </p>
        </div>

        <div class="bdResult">
          <?php
            if (count($_GET) == 0) {
            } elseif (isset($_GET['dbcreada']))  {
              echo "La base de datos ha sido creada con éxito.";
            } elseif (isset($_GET['tablacreada']) && $_GET['tablacreada'] == "si")  {
              echo "La tabla 'usuario' ha sido creada con éxito.";
            } elseif (isset($_GET['jsonimportado']) && $_GET['jsonimportado'] == "si")  {
              echo "Los usuarios del JSON han sido importados con éxito.";
            } else {
              echo "Se ha producido un error.";
            }
          ?>
        </div>

        <a href="crearSchema.php" class="boton-modificar">Crear Base de Datos</a>
        <a href="crearTabla.php" class="boton-modificar">Crear Tabla de usuarios</a>
        <a href="importJSON.php" class="boton-modificar">Importar datos de JSON</a>

      </center>

    </section>

    <?php require_once('../includes/footer.php'); ?>

  </body>
</html>
