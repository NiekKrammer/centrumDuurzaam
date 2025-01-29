<?php

class MagazijnModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    

    public function getVoorraad() {
        $sql = "SELECT artikel.naam AS artikel, voorraad.aantal, voorraad.locatie, status.status
                FROM voorraad
                INNER JOIN artikel ON voorraad.artikel_id = artikel.id
                INNER JOIN status ON voorraad.status_id = status.id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
