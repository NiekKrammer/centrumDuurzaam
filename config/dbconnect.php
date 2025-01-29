<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'duurzaam';
    private $connection;

    // Constructor maakt de verbinding direct met PDO
    public function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            // Zet de PDO-foutmodus op exceptions
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Failed to connect to MySQL: ' . $e->getMessage());
        }
    }

    // Haal de actieve verbinding op
    public function getConnection() {
        return $this->connection;
    }

    // Sluit de verbinding
    public function disconnect() {
        $this->connection = null;
    }
}

?>
