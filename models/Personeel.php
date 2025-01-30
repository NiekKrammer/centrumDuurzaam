<?php
class Personeel {
    private $conn;
    private $table_name = "accounts";

    public $ID;
    public $Gebruikersnaam;
    public $Rol;
    public $Is_geverifieerd;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPersoneel() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>