<?php
  if (isLoggedIn()) {
    $usuario = getUserById($_SESSION['idUsuario']);
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
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="#">Cómo funciona</a></li>
      <li><a href="#">Categorías</a></li>
      <li><a href="#">Servicios</a></li>
      <li><a href="faqs.php">FAQs</a></li>
    </ul>
    <span class="registro-mobile">
      <?php if(isLoggedIn()) : ?>
        <a href="logout.php" class="log-in-mobile">Logout</a>
      <?php else : ?>
        <a href="login.php" class="log-in-mobile">Login</a>
        <a href="registro.php">
          ¿Aún no tienes cuenta?<br><u>Regístrate.</u>
        </a>
      <?php endif; ?>

    </span>
  </nav>

  <div class="icon-nav">
    <input type="checkbox" id="open-search">
    <div class="links-desktop">
      <?php if(isLoggedIn()) : ?>
        <a href="logout.php" class="log-in-desktop">Logout</a>
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
