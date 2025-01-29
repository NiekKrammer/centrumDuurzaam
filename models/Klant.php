<?php
class Klant {
    private $conn;
    private $table_name = "klanten";

    public $id;
    public $naam;
    public $email;
    public $telefoon;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllKlanten() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>