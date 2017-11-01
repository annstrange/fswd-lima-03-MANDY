<?php
	require_once('fcs_mandy.php');
	require_once('includes/head.php');
	require_once('includes/header.php');
	require_once('db/conexion.php');

	$idInsert = 0;
	$usuarioTest = [
		"name" => 'ann2',
		"surname" => 'surname2',
		"username" => 'username',
		"email" => 'email@email.com',
		"question" => 'question',
		"answer" => 'answer',
		"password" => 'password',
	];
	echo "<br><br><br><br><br> Hi";
	//$idInsert = insertUsuarioDB($usuarioTest);
	//echo "<br><br><br><br><br> idInsert: $idInsert";

//	$exists1 = comprobarUsuario('username');
//  echo "username test 1 $exists1";
//	$exists2 = comprobarUsuario('email22');
//  echo "username test 2 $exists2";

?>

	<!-- CONTAINER -->

	<div class="main-container">

		<!-- INTRO -->
		<section class="intro">
			<div class="intro-layover">
				<div class="intro-center">
					<h2>Talento local<br><span>independiente</span></h2>
					<form class="main-searchbar" action="" method="get">
						<input type="text" name="main-searchbar" placeholder="Descúbrelo">
						<input type="submit" name="suscribir" value="Buscar">
					</form>
				</div>
			</div>
		</section>


		<!-- CATEGORÍAS -->

		<section class="about">
			<p>Bienvenido a la plataforma donde <span>artistas locales</span> pueden mostrar y ofrecer a lo que le dedican tanto esfuerzo</p>
			<center>
				<a class="ver-mas">
					Conoce más
				</a>
			</center>
		</section>


		<section class="seccion fondo-gris">
			<div class="section-title">
				<h3>Categorías</h3>
				<img src="images/separator.png" alt="Separator">
				<p>Podrás encontrar desde artes plásticas hasta ropa:</p>
			</div>

			<div class="categorias">

				<article class="categoria">
					<span class="imagen-categoria"></span>
					<a href="#">
						<h4>Pintura</h4>
					</a>
				</article>

				<article class="categoria">
					<a href="#">
						<h4>Ilustración</h4>
					</a>
					<span class="imagen-categoria"></span>
				</article>

				<article class="categoria">
					<span class="imagen-categoria"></span>
					<a href="#">
						<h4>Escultura</h4>
					</a>
				</article>


				<article class="categoria">
					<a href="#">
						<h4>Fotografía</h4>
					</a>
					<span class="imagen-categoria"></span>
				</article>

				<article class="categoria">
					<span class="imagen-categoria"></span>
					<a href="#">
						<h4>Joyería</h4>
					</a>
				</article>

			</div>

			<center>
				<a class="ver-mas">
					Ver más categorías
				</a>
			</center>

		</section>


		<section class="seccion">

			<div class="section-title">
				<h3>Artistas destacados</h3>
				<img src="images/separator.png" alt="Separator">
				<p>Explora el perfil de los artistas destacados del mes; conoce sus productos y servicios:</p>
			</div>

			<div class="artistas-destacados">

				<article class="artista">
						<img class="imagen-artista" src="images/artista1.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Matias Sánchez</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> Palermo, Buenos Aires</h6>
						<p>Ilustrador</p>
						<a href="#">Conocer</a>
				</article>

				<article class="artista">
						<img class="imagen-artista" src="images/artista3.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Eduardo Gómez</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> San Telmo, Buenos Aires</h6>
						<p>Diseñador gráfico</p>
						<a href="#">Conocer</a>
				</article>

				<article class="artista">
						<img class="imagen-artista" src="images/artista2.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Martha Pérez</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> Recoleta, Buenos Aires</h6>
						<p>Pintora</p>
						<a href="#">Conocer</a>
				</article>

				<article class="artista">
						<img class="imagen-artista" src="images/artista4.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Jimena Sánchez</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> Palermo, Buenos Aires</h6>
						<p>Escultora</p>
						<a href="#">Conocer</a>
				</article>

				<article class="artista">
						<img class="imagen-artista" src="images/artista5.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Jorge Quispe</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> Recoleta, Buenos Aires</h6>
						<p>Fotógrafo</p>
						<a href="#">Conocer</a>
				</article>
				<article class="artista">
						<img class="imagen-artista" src="images/artista6.png" alt="pdto 01">
						<h5 class="artista-etiqueta">Sofía Pérez</h5>
						<h6 class="artista-contenido"><span class="ion-location"></span> San Telmo, Buenos Aires</h6>
						<p>Confeccionista</p>
						<a href="#">Conocer</a>
				</article>


			</div>

			<center>
				<a class="ver-mas">
					Ver más artistas
				</a>
			</center>
		</section>

		<!-- <section class="seccion">
			<div class="section-title">
				<h3>Productos recientes</h3>
				<img src="images/separator.png" alt="Separator">
				<p>Conoce a los artistas destacados del mes:</p>
			</div>
			<center>
				<a class="ver-mas">
					Ver más categorías
				</a>
			</center>
		</section> -->


	</div>
	<?php require_once('includes/footer.php'); ?>
	</body>
</html>
