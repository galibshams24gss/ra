<?php
    class db{
        private $dbhost = 'localhost';
        private $dbuser = 'root';
        private $dbpass = '';
        private $dbname = 'slimapp';

        //connect to db
        public function connect() {
            try{
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $pdo = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
            } catch(PDOException $e){
            exit('DB Error!');
            }
        }
    }
?>