<?php

    if (!class_exists('Database')) {
        class Database{

            private $host = "mysql";
            private $database = "culinary_hub";
            private $user = "root";
            private $password = "root";
            public $conn;
            
            public function getConnection(){

                $this->conn = null;

                try{
                    $this->conn = new PDO("mysql:host=". $this->host.";dbname=". $this->database, $this->user, $this->password);
                    $this->conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "Erro ao conectar". $e->getMessage();
                }

                return $this->conn;
            }
                
        }
    }