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
  <a href="index.php" class="logo-title">
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
          <a href="perfil_usuario.php">
            Hola, <?=$usuario['name'];?><br>
            <u>Ir a perfil &nbsp; ▸</u>
          </a>

        </div>
      <?php else : ?>
        <a href="login.php" class="log-in-mobile">Login</a>
        <a href="registro.php">
          ¿Aún no tienes cuenta?<br><u>Regístrate.</u>
        </a>
      <?php endif; ?>
    </div>
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#">Cómo funciona</a></li>
      <li><a href="#">Categorías</a></li>
      <li><a href="#">Servicios</a></li>
      <li><a href="faqs.php">FAQs</a></li>
      <?php if(isLoggedIn()) : ?>
        <li><a href="logout.php">Cerrar sesión</a></li>
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
            <li><a href="perfil_usuario.php">Mi perfil</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </div>


      <?php else : ?>
        <a href="registro.php">Regístrate</a>
        <a href="login.php" class="log-in-desktop">Login</a>
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
