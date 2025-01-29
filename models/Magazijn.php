<?php

class Magazijn {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Functie om de volledige voorraad op te halen (uit de drie tabellen)
    public function getVoorraad() {
        $query = "
            SELECT
                v.id AS voorraad_id,
                a.id AS artikel_id,
                a.naam AS artikel_naam,
                a.prijs_ex_btw,
                c.categorie AS categorie_naam,
                v.locatie,
                v.aantal,
                s.status AS voorraad_status,
                v.ingeboekt_op
            FROM
                voorraad v
            JOIN artikel a ON v.artikel_id = a.id
            JOIN categorie c ON a.categorie_id = c.id
            JOIN status s ON v.status_id = s.id
            ORDER BY v.locatie;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Functie om voorraad op te halen op basis van artikel_id
    public function getVoorraadByArtikelId($artikel_id) {
        $query = "
            SELECT
                v.id AS voorraad_id,
                a.id AS artikel_id,
                a.naam AS artikel_naam,
                a.prijs_ex_btw,
                c.categorie AS categorie_naam,
                v.locatie,
                v.aantal,
                s.status AS voorraad_status,
                v.ingeboekt_op
            FROM
                voorraad v
            JOIN artikel a ON v.artikel_id = a.id
            JOIN categorie c ON a.categorie_id = c.id
            JOIN status s ON v.status_id = s.id
            WHERE v.artikel_id = :artikel_id
            ORDER BY v.locatie;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':artikel_id', $artikel_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Functie om een specifiek artikel op te halen
    public function getArtikelById($id) {
        $query = "SELECT * FROM artikel WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CRUD voor voorraad
    public function createVoorraad($artikel_id, $locatie, $aantal, $status_id) {
        $sql = "INSERT INTO voorraad (artikel_id, locatie, aantal, status_id, ingeboekt_op) VALUES (:artikel_id, :locatie, :aantal, :status_id, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':artikel_id', $artikel_id);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':aantal', $aantal);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    public function updateVoorraad($id, $artikel_id, $locatie, $aantal, $status_id) {
        $sql = "UPDATE voorraad SET artikel_id = :artikel_id, locatie = :locatie, aantal = :aantal, status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':artikel_id', $artikel_id);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':aantal', $aantal);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    public function deleteVoorraad($id) {
        $sql = "DELETE FROM voorraad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Functie om de status van een voorraad item bij te werken
    public function updateVoorraadStatus($id, $status_id) {
        $sql = "UPDATE voorraad SET status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    // CRUD voor artikel
    public function createArtikel($naam, $categorie_id, $prijs_ex_btw) {
        $sql = "INSERT INTO artikel (categorie_id, naam, prijs_ex_btw) VALUES (:categorie_id, :naam, :prijs_ex_btw)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':prijs_ex_btw', $prijs_ex_btw);
        return $stmt->execute();
    }

    public function getArtikelen() {
        $sql = "SELECT a.id, a.naam, a.prijs_ex_btw, c.categorie AS categorie_naam, v.aantal, v.locatie, s.status 
                FROM artikel a
                JOIN categorie c ON a.categorie_id = c.id
                LEFT JOIN voorraad v ON a.id = v.artikel_id
                LEFT JOIN status s ON v.status_id = s.id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function updateArtikel($id, $categorie_id, $naam, $prijs_ex_btw) {
        $sql = "UPDATE artikel SET categorie_id = :categorie_id, naam = :naam, prijs_ex_btw = :prijs_ex_btw WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':prijs_ex_btw', $prijs_ex_btw);
        return $stmt->execute();    
    }

    public function deleteArtikel($id) {
        $sql = "DELETE FROM artikel WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Method to get categories
    public function getCategories() {
        $sql = "SELECT id, categorie AS naam FROM categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CRUD voor categorie
    public function createCategorie($categorie) {
        $sql = "INSERT INTO categorie (categorie) VALUES (:categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categorie', $categorie);
        return $stmt->execute();
    }

    public function getCategorieen() {
        $sql = "SELECT * FROM categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCategorie($id, $categorie) {
        $sql = "UPDATE categorie SET categorie = :categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categorie', $categorie);
        return $stmt->execute();
    }

    public function deleteCategorie($id) {
        $sql = "DELETE FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Method to check if a category exists
    public function categoryExists($categorie_id) {
        $sql = "SELECT COUNT(*) FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $categorie_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>