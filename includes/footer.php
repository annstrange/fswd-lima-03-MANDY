<footer class="main-footer">
  <div class="footer-content">
    <div class="newsletter">
      <p>¡Únete al newsletter y recibe novedades!</p>
      <form class="main-searchbar" action="" method="get">
        <input type="text" name="main-searchbar" placeholder="Ingresa tu correo electrónico">
        <input type="submit" name="suscribir" value="Suscribir">
      </form>
    </div>
    <span>Sobre nosotros</span>
    <ul>
      <li><a href="#">Inicio</a></li>
      <li><a href="#">FAQs</a></li>
      <li><a href="#">Cómo funciona</a></li>
      <?php if(!isLoggedIn()) : ?>
        <li><a href="#">Regístrate</a></li>
      <?php endif; ?>
      <li>
        <a href="#">
          <span class="ion-social-facebook"></span>
        </a>
        <a href="#">
          <span class="ion-social-instagram"></span>
        </a>
        <a href="#">
          <span class="ion-social-tumblr"></span>
        </a>
        <a href="#">
          <span class="ion-social-twitter"></span>
        </a>
      </li>
    </ul>
  </div>
</footer>
