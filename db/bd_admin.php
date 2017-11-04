<?php
// métodos para crear base de datos, y convertir de json archivo.

// importar .json file a base de datos
$db = null;
require_once('conexion.php');

/* function dropSchema() {
// Cuidate con este!
  $db = connectarBD();
  try {
    $ddl = "DROP SCHEMA `mandy_db`;";
    $result=$db->exec($ddl);
    var_dump($result);
  }
  catch (PDOException $e) {
    echo "Failure: ". $e->getMessage()." <br>";
  }

  $db = null;

}  */

function dropTablaUsuario () {
  $db = connectarBD();

  $ddl = "DROP TABLE mandy_db.usuario; ";

  try {
    $result=$db->exec($ddl);
    $db = null;
  }
  catch (PDOException $e) {
    echo "Failure in dropTablaUsuario(): ". $e->getMessage()." <br>";
  }
}

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Admin</title>
   </head>
   <body>
     <h1>Administración - Convertir JSON to Base de Datos</h1>

     <p>mandy_db exista? <?= esBDDisponible(); ?></p>
     <p>tabla usuario exista? Rowcount: <?= esTablaDefinido("usuario"); ?></p>
     <ul>
       <li><a href="crearSchema.php">Crear BD</a></li>
       <li><a href="crearTabla.php">Crear Tabla(s)</a></li>
       <li><a href="importJSON.php">Importar Datos</a></li>
     </ul>

   </body>
 </html>
