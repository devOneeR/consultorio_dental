<?php

class Database {
    private $host = 'localhost';
    private $port = '3308';
    private $db_name = 'consultorio_dental';
    private $username = 'root';
    private $password = '';
    private $conn;
    private static $isntance = null;

        private function __construct() {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->conn->exec("SET NAMES 'utf8'");
            
            } catch(PDOException $e) {
                echo "Error de conexion: " . $e->getMessage();
            }
        }

    public static function getInstance() {
        if (self::$isntance === null) {
            self::$isntance = new self();
        }
        return self::$isntance;
    }

    public function getConnection() {
        return $this->conn;
    }
}



