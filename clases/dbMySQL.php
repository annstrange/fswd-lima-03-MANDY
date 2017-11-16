<?php
require_once("soporte.php");
require_once("db.php");

class dbMySQL extends db {
  private $conexion;

  const DB_USER = 'root';
  const DB_PASS = '';

    public function __construct() {
        // Se usa cuando ya tienes un schema
        $dsn = 'mysql:host=127.0.0.1;dbname=mandy_db;charset=utf8mb4;port:3306;';
        $db_user = dbMySQL::DB_USER;
        $db_pass = dbMySQL::DB_PASS;
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
          $this->conexion = new PDO($dsn, $db_user, $db_pass, $options);
        } catch(PDOException $exception) {
            echo "<br>" . $exception->getMessage() . "<br>";
            //$this->conexion= null;
        }
        //return $this->conexion;
      }


  public function insertUsuarioBD(user $user){
    // expect $usuario to be an associative array
      $rowid = 0;
      //$this->conexion = $this->conectarBD();
      $sqlQuery = "INSERT INTO usuario(name,surname,username,email,question, answer,password) VALUES(:name,:surname,:username,:email, :question,:answer,:password)";

      $statement = $this->conexion->prepare($sqlQuery);

        $statement->bindParam(":name", $user->getName(), PDO::PARAM_STR);
          $statement->bindParam(":surname", $user->getSurname(), PDO::PARAM_STR);
          $statement->bindParam(":username", $user->getUsername(), PDO::PARAM_STR);
          $statement->bindParam(":email", $user->getEmail(), PDO::PARAM_STR);
          $statement->bindParam(":question", $user->getQuestion(), PDO::PARAM_STR);
          $statement->bindParam(":answer", $user->getAnswer(), PDO::PARAM_STR);
          $statement->bindParam(":password", $user->getPassword(),PDO::PARAM_STR);

      		//$id = $this->conn->lastInsertId();
        $statement->execute();

        // $result = $statement->fetch(PDO::FETCH_ASSOC);
        // $rowid = $db.lastInsertId();  // this function wasn't found.

        // Trae Id
        $queryId = $this->conexion->prepare("SELECT id
            FROM usuario
            WHERE username = :username
                ORDER BY id desc
            LIMIT 1
            ");
        $queryId->bindParam(":username", $user->getUsername(), PDO::PARAM_STR);
        $queryId->execute();

          $results = $queryId->fetchAll(PDO::FETCH_ASSOC);

          //return new User($results['id']); ???
          return $results[0]['id'];

      }

      public function comprobarEmailBD($email) {
        // devuelva true si hay usuario con este email

        //$db=$this->conectarBD();
        $query = $this->conexion->prepare("SELECT id, name, surname, username, email, password, question, answer
            FROM usuario
            WHERE email = '$email'
            ORDER BY id asc
            LIMIT 1
          ");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        // Para hacer:  try catch, y confirma tengo una linea
        if (count($results) > 0){
          return new User ($results[0]['name'],$results[0]['surname'],$results[0]['username'],$results[0]['email'],$results[0]['question'],$results[0]['answer'],$results[0]['password'],$results[0]['id']);
        }
        else {
          return false;
        }

      }

      public function traerPreguntaBD($id) {
          $usuario = $this->getUserByIdBD($id);
          $q1 = $usuario->getQuestion();

          if ($usuario != null && $q1 != null) {
            return $q1;
          }
          else {
            return false;
          }
        }

      public function traerRespuestaBD(user $user, $answer) {

            $usuario = $this->getUserByIdBD($user->getId());
              $usuarioExistente = [];
              if ($user->getAnswer() == $answer && $usuario->getId() == $user->getId()) {
                  $usuarioExistente = $usuario;
                }
              if (!empty($usuarioExistente)) {
                return $usuarioExistente;
              }
                return false;

            }

      public function getUserByIdBD($userId) {
              // Usa el BD
              //$this->conexion = $this->conectarBD();

              $query = $this->conexion->prepare("SELECT id, name, surname, username, email, question, answer, password
                  FROM usuario
                  WHERE id = '$userId'
                  LIMIT 1
                  ");
              try {
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                //$this->conexion = null;
              }
              catch (PDOException $ex) {
                echo "Failure in getUserByIdBD():" . $ex->getMessage();
              }

              return new User ($results[0]['name'],$results[0]['surname'],$results[0]['username'],$results[0]['email'],$results[0]['question'],$results[0]['answer'],$results[0]['password'],$results[0]['id']);
            }

      public function updateUsuarioBD(user $user, $post) {
              $usuarioAGuardar = [
                  "id" => $user->getId(),
                  "name" => $post['name'],
                  "surname" => $post['surname'],
                  "email" => $post['email']
                ];

                //$this->conexion = $this->conectarBD();
                $sqlQuery = "UPDATE usuario SET name = :name,
                      surname = :surname,
                      email=:email
                    WHERE id = :id; ";

                $statement = $this->conexion->prepare($sqlQuery);
                $statement->bindParam(":id", $user->getId(), PDO::PARAM_INT);
                $statement->bindParam(":name", $post['name'], PDO::PARAM_STR);
                $statement->bindParam(":surname", $post['surname'], PDO::PARAM_STR);
                $statement->bindParam(":email", $post['email'], PDO::PARAM_STR);

                try {
                  $statement->execute();
                  //$this->conexion = null;
                }
                catch (PDOException $ex) {
                  echo "Failure in updateUsuarioBD()".$ex->getMessage();
                }

                return true;
            }


      public function todosLosUsuariosDB() {
              // Devuelva array de usuarios de base de datos (BD)
              // En realidad, no necesitamos traer todos usuarios con BD.
            //$this->conexion = $this->conectarBD();
              $query = $this->conexion->prepare("SELECT id, name, surname, username, email, password, question, answer
                  FROM usuario
                  ");
                $query->execute();

                $results = $query->fetchAll(PDO::FETCH_ASSOC);
               return new User ($results[0]['name'],$results[0]['surname'],$results[0]['username'],$results[0]['email'],$results[0]['question'],$results[0]['answer'],$results[0]['password'],$results[0]['id']);
            }

      public function comprobarUsuarioBD($username) {
              // devuelva User object si hay usuario con este username, else false
              // $usuarios = todosLosUsuariosBD();
              //$usuarioExistente = [];

              //$this->conexion = conectarBD();
              $query = $this->conexion->prepare("SELECT name, surname, username, email, question, answer, password, id
                  FROM usuario
                  WHERE username = '$username'
                  ");
              $query->execute();

              $results = $query->fetchAll(PDO::FETCH_ASSOC);

              // $this->conexion = null;

              if (count($results) > 0){
                return new User ($results[0]['name'],$results[0]['surname'],$results[0]['username'],$results[0]['email'],$results[0]['question'],$results[0]['answer'],$results[0]['password'],$results[0]['id']);
              }
              else {
                return false;
              }
            }

            public function createSchema() {
              $this->conexion = $this->__construct();
              if ($this->conexion) {
                try {
                  $ddl = "CREATE SCHEMA IF NOT EXISTS mandy_db DEFAULT CHARACTER SET utf8;";
                  $this->conexion->exec($ddl);
                } catch (PDOException $exception) {
                  echo "Failure in createSchema(): " . $exception->getMessage() . "<br>";
                  return false;
                }
             } else {
               echo "No database connection";
             }
              //$this->conexion = null;
              return true;
            }

            public function createTablaUsuario () {
              $this->conexion = $this->__construct();
              $ddl = "CREATE TABLE IF NOT EXISTS mandy_db.usuario (
                  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                  name VARCHAR(45) NOT NULL,
                  surname VARCHAR(100) NOT NULL,
                  username VARCHAR(45) UNIQUE NOT NULL,
                  email VARCHAR(100) UNIQUE NOT NULL,
                  password VARCHAR(120) NULL,
                  question VARCHAR(200) NULL,
                  answer VARCHAR(80) NULL
                );";

              try {
                $result=$this->conexion->exec($ddl);
                //$this->conexion = null;
                return true;
              }
              catch (PDOException $exception) {
                echo "Failure in createTablaUsuario(): " . $exception->getMessage() . "<br>";
                return false;
              }
            }
            public function dbExists() {
              //$this->conexion =$this-> conectarBD();
              $primerUsuarioBD = null;
              try {
                $query = $this->conexion->prepare("SELECT * FROM mandy_db.usuario");
                $query->execute();
                $primerUsuarioBD = $query->fetch(PDO::FETCH_ASSOC);
              } catch (PDOException $exception) {
                echo $exception->getMessage() . "<br>";
              }

              if ($primerUsuarioBD) {
                return true;
              } else {
                return false;
              }
            }


            public function bdDisponible() {
              // Boolean sobre la disponibilidad de la base
              //$this->conexion= $this->__construct();
                //$this->conexion= $conectarBD();

                if ($this == null) {
                  return false;
                }
                else {
                  return true;
                }
            }

            public function existeTabla($nombre) {
              // Boolean sobre la existencia de la tabla usuario

              //$this->conexion= $this->__construct();
            //$this->conexion = conectarBD();
              try {
                $ddl = "SELECT count(*) FROM mandy_db." . $nombre . ";";
                $stmt = $this->conexion->prepare($ddl);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(isset($result['count(*)'])) {
                  return true;
                }
              }
              catch (PDOException $exception) {
                return false;
                echo "<br>" . $exception->getMessage() . "<br>";
              }

}
}


 ?>
