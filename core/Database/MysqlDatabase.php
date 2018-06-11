<?php

    namespace Core\Database;
    use \PDO;

    class MysqlDatabase extends Database{


        private $db_name;
        private $db_user;
        private $db_pass;
        private $db_host;
        private $pdo;

        public function __construct($db_name , $db_user = 'nico' , $db_pass = 'nico' , $db_host = 'localhost'){

            $this->db_name = $db_name;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_host = $db_host;

        }

        private function getPDO(){
            if(empty($pdo)){
                $pdo = new PDO('mysql:dbname=blog;host=localhost','nico','nico');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
            }
            return $pdo;
        }

        public function query($statement , $class_name = null , $one = false){
            $req = $this->getPDO()->query($statement);
            if(
                strrpos($statement, 'UPDATE') === 0 ||
                strrpos($statement, 'INSERT') === 0 ||
                strrpos($statement, 'DELETE') === 0
              ){
                return $req;
              }
            if($class_name === null){
                $req->setFetchMode(PDO::FETCH_OBJ);
            }
            else{
                $req->setFetchMode(PDO::FETCH_CLASS , $class_name);
            }
            if($one){
                $donnees = $req->fetch();
            }
            else{
                $donnees = $req->fetchAll();
            }
            return $donnees;
        }

        public function prepare($statement , $attributes , $class_name = null, $one = false){
            $req = $this->getPDO()->prepare($statement);
            $res = $req->execute($attributes);
            if(
                strrpos($statement, 'UPDATE') === 0 ||
                strrpos($statement, 'INSERT') === 0 ||
                strrpos($statement, 'DELETE') === 0
              ){
                return $res;
              }
            if($class_name === null){
                $req->setFetchMode(PDO::FETCH_OBJ);
            }
            else{
                $req->setFetchMode(PDO::FETCH_CLASS , $class_name);
            }
            if($one){
                $donnees = $req->fetch();
            }
            else{
                $donnees = $req->fetchAll();
            }
            return $donnees;

        }

        public function lastInsertId(){
            return $this->getPDO()->lastInsertId();
        }
    }
?>
