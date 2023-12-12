<?php

    require_once './config.php';

    class DBConnect{
        private $pdo;

        public function getPDO(){
            if (!$this->pdo){
                try{
                    $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                } catch(PDOException $e) {
                    die('Erreur de connexion à la base de données : ' . $e->getMessage());
                }
            }

            return $this->pdo;
        }
    }
    