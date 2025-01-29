<?php

class Database {
    private $db = "localhost";
    private $dbname = "hollow_peaks";
    private $user = "root";
    private $pass = "";
    public $conn;

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

    public function getConn() {
        return $this->conn;
    }

    // public function get() {
    //     $this->conn
    // }
}