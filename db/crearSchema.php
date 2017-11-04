<?php
$db = null;
require_once('conexion.php');

$result = createSchema();
echo "Result of createSchema(): ". $result." <br>";

function createSchema() {
  $db = connectarSinBD();
  if ($db) {
    try {
      $ddl = "CREATE SCHEMA IF NOT EXISTS `mandy_db` DEFAULT CHARACTER SET utf8 ;";
      $result=$db->exec($ddl);
      var_dump($result);
    }
    catch (PDOException $ex) {
      echo "Failure: ". $ex->getMessage()." <br>";
      return false;
    }
 }
 else {
   echo "No database connection <br> ";
 }
  $db = null;
  return true;
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Crear Schema</title>
  </head>
  <body>
    <p></p>
    <a type="button" href="bd_admin.php">Atrás</a>
  </body>
</html>
