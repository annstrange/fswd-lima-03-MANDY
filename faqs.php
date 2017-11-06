<?php
	require_once('fcs_mandy.php');
	require_once('includes/head.php');
	require_once('includes/header.php');

	if (!dbExists()) {
		header('Location: db/bd_admin.php');
		exit;
	}
?>

  <body>

    <!-- contenido de la seccion -->
    <div class="page-container">
      <h2>Preguntas frecuentes</h2>
      <article class="grupo-faqs">
        <div class="titulo-grupo">
          <h3>Empezando</h3>
        </div>
          <div>
            <input type="checkbox" id="pregunta1" class="abrir-pregunta">
            <label for="pregunta1" class="pregunta">
              ¿Cómo me registro? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Para registrarse en el sitio es necesario seguir el link "Registrarse" que se encuentra en la página principal. En la nueva página tendrás que completar los campos obligatorios y elegir una contraseña personal de acceso y luego hacer click en "Registrarme" en el fondo de la página y luego confirmar en la nueva página los datos que se han registrado.</p>
              <p>  A la brevedad, recibirás un e-mail a la dirección de correo electrónico que indicaste para confirmar que has sido registrado. Desde este momento podrás acceder cada vez que lo desees a tu área personal simplemente introduciendo tus datos de acceso, nombre de usuario y contraseña, en el espacio de login en la página principal. Te recordamos que el nombre de usuario es su dirección de e-mail. </p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta2" class="abrir-pregunta">
            <label for="pregunta2" class="pregunta">
              ¿Qué es Mandy? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Somos un mercado de productos hechos a mano, artículos vintage y materiales para artesanía. Mnady está hecha de tiendas propiedad de creadores, artistas y coleccionistas de todo el mundo.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta3" class="abrir-pregunta">
            <label for="pregunta3" class="pregunta">
              ¿Cómo realizo una compra? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Cuando encuentres un artículo que quieras comprar, sigue estos pasos:</p>
              <p> Haz clic en Añadir al carro en la página del anuncio del artículo.</p>
              <p> Si el artículo que quieres comprar tiene opciones para elegir (como talla, color o forma), tendrás que seleccionar cada opción antes de poder añadirlo al carro.</p>
              <p>Accede a tu carro en cualquier momento haciendo clic en el icono del carro que verás en la esquina superior derecha del sitio. A partir de ahí, procede a realizar el pago o continúa comprando otros artículos.</p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta4" class="abrir-pregunta">
            <label for="pregunta4" class="pregunta">
              ¿Cómo informo sobre un problema con mi pedido? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Mandy es un mercado constituido por vendedores individuales que llevan sus propias tiendas. Cada vendedor es responsable de sus propias políticas respecto a envíos, reembolsos y devoluciones, así como de responder preguntas sobre su tienda y sus productos.</p>

              <p>Si quieres devolver un artículo o recibir un reembolso, o si tienes problemas en general con un pedido, lo primero que te recomendamos es que te pongas directamente en contacto con el vendedor. Si no consigues ponerte en contacto con el vendedor o resolver directamente el problema con él, sigue estos pasos para abrir un caso.</p>
            </div>
          </div>
      </article>

      <article class="grupo-faqs">
        <div class="titulo-grupo">
          <h3>Venta</h3>
        </div>
          <div>
            <input type="checkbox" id="pregunta5" class="abrir-pregunta">
            <label for="pregunta5" class="pregunta">
              ¿Cómo me registro? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Para registrarse en el sitio es necesario seguir el link "Registrarse" que se encuentra en la página principal. En la nueva página tendrás que completar los campos obligatorios y elegir una contraseña personal de acceso y luego hacer click en "Registrarme" en el fondo de la página y luego confirmar en la nueva página los datos que se han registrado.</p>
              <p>  A la brevedad. recibirás un e-mail a la dirección de correo electrónico que indicaste para confirmar que has sido registrado. Desde este momento podrás acceder cada vez que lo desees a tu área personal simplemente introduciendo tus datos de acceso, nombre de usuario y contraseña, en el espacio de login en la página principal. Te recordamos que el nombre de usuario es su dirección de e-mail. </p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta6" class="abrir-pregunta">
            <label for="pregunta6" class="pregunta">
              ¿Qué es Mandy? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Somos un mercado de productos hechos a mano, artículos vintage y materiales para artesanía. Mnady está hecha de tiendas propiedad de creadores, artistas y coleccionistas de todo el mundo.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta7" class="abrir-pregunta">
            <label for="pregunta7" class="pregunta">
              ¿Cómo realizo una compra? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Cuando encuentres un artículo que quieras comprar, sigue estos pasos:</p>
              <p> Haz clic en Añadir al carro en la página del anuncio del artículo.</p>
              <p> Si el artículo que quieres comprar tiene opciones para elegir (como talla, color o forma), tendrás que seleccionar cada opción antes de poder añadirlo al carro.</p>
              <p>Accede a tu carro en cualquier momento haciendo clic en el icono del carro que verás en la esquina superior derecha del sitio. A partir de ahí, procede a realizar el pago o continúa comprando otros artículos.</p>
            </div>
          </div>

          <div>
            <input type="checkbox" id="pregunta8" class="abrir-pregunta">
            <label for="pregunta8" class="pregunta">
              ¿Cómo informo sobre un problema con mi pedido? <span class="ion-plus"></span><span class="ion-minus"></span>
            </label>
            <div class="respuesta">
              <p>Mandy es un mercado constituido por vendedores individuales que llevan sus propias tiendas. Cada vendedor es responsable de sus propias políticas respecto a envíos, reembolsos y devoluciones, así como de responder preguntas sobre su tienda y sus productos.</p>

              <p>Si quieres devolver un artículo o recibir un reembolso, o si tienes problemas en general con un pedido, lo primero que te recomendamos es que te pongas directamente en contacto con el vendedor. Si no consigues ponerte en contacto con el vendedor o resolver directamente el problema con él, sigue estos pasos para abrir un caso.</p>
            </div>
          </div>
      </article>

    </div>
    <?php require_once('includes/footer.php'); ?>
  </body>
</html>
