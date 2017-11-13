<?php
require_once('soporte.php');

testConnection();
function testConnection() {
  global $db;
  global $auth;
  global $validator;

   var_dump($db);
   var_dump($auth);
   var_dump($validator);

   // que puedo hacer con nuestra objectos?
   $user1 = $db->getUserByIdBD(3);
   echo "<br>";
   var_dump($user1);
}

 ?>
