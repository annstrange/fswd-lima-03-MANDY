<?php

require_once("clases/validator.php");
require_once("clases/auth.php");
// require_once("clases/dbJSON.php");
require_once("clases/dbMySQL.php");

$db = new dbMySQL();
$auth = new Auth();
$validator = new Validator();

 ?>
