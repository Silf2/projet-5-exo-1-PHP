<?php

    require_once './config.php';

    class DBConnect{
        static private $pdo;

        static public function getPDO(){
            if (!static::$pdo){
                try{
                    static::$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                } catch(PDOException $e) {
                    die('Erreur de connexion à la base de données : ' . $e->getMessage());
                }
            }

            return static::$pdo;
        }
    }
    