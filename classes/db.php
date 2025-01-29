<?php

class Database {
    private $db = "localhost";
    private $dbname = "duurzaam";
    private $user = "root";
    private $pass = "";
    public $conn;

    // Maak een connectie met de database
    function __construct() {
        @session_start();

        try {
            $conn = new PDO("mysql:host=$this->db;dbname=$this->dbname", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Krijg de connectie variable terug
    public function getConnection() {
        return $this->conn;
    }

    // Sluit de verbinding
    public function disconnect() {
        $this->connection = null;
    }
}