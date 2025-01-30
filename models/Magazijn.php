<?php

class Magazijn
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Functie om de volledige voorraad op te halen (uit de drie tabellen)
    public function getVoorraad()
    {
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
    public function getVoorraadByArtikelId($artikel_id)
    {
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
    public function getArtikelById($id)
    {
        $query = "SELECT * FROM artikel WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CRUD voor voorraad
    public function createVoorraad($artikel_id, $locatie, $aantal, $status_id)
    {
        $sql = "INSERT INTO voorraad (artikel_id, locatie, aantal, status_id, ingeboekt_op) VALUES (:artikel_id, :locatie, :aantal, :status_id, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':artikel_id', $artikel_id);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':aantal', $aantal);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    public function updateVoorraad($id, $artikel_id, $locatie, $aantal, $status_id)
    {
        $sql = "UPDATE voorraad SET artikel_id = :artikel_id, locatie = :locatie, aantal = :aantal, status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':artikel_id', $artikel_id);
        $stmt->bindParam(':locatie', $locatie);
        $stmt->bindParam(':aantal', $aantal);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    public function deleteVoorraad($id)
    {
        $sql = "DELETE FROM voorraad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Functie om de status van een voorraad item bij te werken
    public function updateVoorraadStatus($id, $status_id)
    {
        $sql = "UPDATE voorraad SET status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status_id', $status_id);
        return $stmt->execute();
    }

    // CRUD voor artikel
    public function createArtikel($naam, $categorie_id, $prijs_ex_btw, $aantal, $locatie, $directVerkoopbaar, $isKapot)
    {
        try {
            // Begin een transactie
            $this->db->beginTransaction();
    
            // Voeg eerst het artikel toe
            $sqlArtikel = "INSERT INTO artikel (categorie_id, naam, prijs_ex_btw, directVerkoopbaar, isKapot) 
                           VALUES (:categorie_id, :naam, :prijs_ex_btw, :directVerkoopbaar, :isKapot)";
            $stmtArtikel = $this->db->prepare($sqlArtikel);
            $stmtArtikel->bindParam(':categorie_id', $categorie_id);
            $stmtArtikel->bindParam(':naam', $naam);
            $stmtArtikel->bindParam(':prijs_ex_btw', $prijs_ex_btw);
            $stmtArtikel->bindParam(':directVerkoopbaar', $directVerkoopbaar);
            $stmtArtikel->bindParam(':isKapot', $isKapot);
            $stmtArtikel->execute();
    
            // Verkrijg het artikel_id van het zojuist ingevoegde artikel
            $artikel_id = $this->db->lastInsertId();
    
            // Voeg de voorraad toe voor het nieuwe artikel
            $sqlVoorraad = "INSERT INTO voorraad (artikel_id, locatie, aantal, status_id) 
                            VALUES (:artikel_id, :locatie, :aantal, 1)";
            $stmtVoorraad = $this->db->prepare($sqlVoorraad);
            $stmtVoorraad->bindParam(':artikel_id', $artikel_id);
            $stmtVoorraad->bindParam(':locatie', $locatie);
            $stmtVoorraad->bindParam(':aantal', $aantal);
            $stmtVoorraad->execute();
    
            // Commit de transactie
            $this->db->commit();
    
            return true;
        } catch (Exception $e) {
            // Rollback de transactie bij een fout
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function getArtikelen()
    {
        $sql = "SELECT a.id, a.naam, a.prijs_ex_btw, c.categorie AS categorie_naam, v.aantal, v.locatie, s.status, a.directVerkoopbaar, a.isKapot 
                FROM artikel a
                JOIN categorie c ON a.categorie_id = c.id
                LEFT JOIN voorraad v ON a.id = v.artikel_id
                LEFT JOIN status s ON v.status_id = s.id
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateArtikel($id, $categorie_id, $naam, $prijs_ex_btw, $aantal, $locatie, $status, $directVerkoopbaar, $isKapot)
    {
        try {
            // Begin de transactie
            $this->db->beginTransaction();

            // Update de artikel tabel
            $query1 = "UPDATE artikel 
                   SET naam = :naam, categorie_id = :categorie_id, prijs_ex_btw = :prijs_ex_btw, directVerkoopbaar = :directVerkoopbaar, isKapot = :isKapot
                   WHERE id = :id";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bindParam(':naam', $naam);
            $stmt1->bindParam(':categorie_id', $categorie_id);
            $stmt1->bindParam(':prijs_ex_btw', $prijs_ex_btw);
            $stmt1->bindParam(':directVerkoopbaar', $directVerkoopbaar);
            $stmt1->bindParam(':isKapot', $isKapot);
            $stmt1->bindParam(':id', $id);
            $stmt1->execute();

            // Update de voorraad tabel (aantal en locatie)
            $query2 = "UPDATE voorraad
                   SET aantal = :aantal, locatie = :locatie
                   WHERE artikel_id = :id";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(':aantal', $aantal);
            $stmt2->bindParam(':locatie', $locatie);
            $stmt2->bindParam(':id', $id);
            $stmt2->execute();

            // Verkrijg de juiste status_id op basis van de status
            $status_id = $this->getStatusIdByStatus($status);

            // Update de status tabel (status_id)
            $query3 = "UPDATE voorraad
                   SET status_id = :status_id
                   WHERE artikel_id = :id";
            $stmt3 = $this->db->prepare($query3);
            $stmt3->bindParam(':status_id', $status_id);
            $stmt3->bindParam(':id', $id);
            $stmt3->execute();

            // Commit de transactie als alles goed is gegaan
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            // Rollback als er iets fout gaat
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    // Methode om status_id op te halen op basis van de status
    public function getStatusIdByStatus($status)
    {
        $query = "SELECT id FROM status WHERE status = :status";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null; // Zorg ervoor dat je de juiste status_id krijgt
    }

    public function deleteArtikel($id)
    {
        try {
            // Begin de transactie
            $this->db->beginTransaction();

            // Verwijder de gerelateerde voorraad records
            $sqlVoorraad = "DELETE FROM voorraad WHERE artikel_id = :id";
            $stmtVoorraad = $this->db->prepare($sqlVoorraad);
            $stmtVoorraad->bindParam(':id', $id);
            $stmtVoorraad->execute();

            // Verwijder het artikel
            $sqlArtikel = "DELETE FROM artikel WHERE id = :id";
            $stmtArtikel = $this->db->prepare($sqlArtikel);
            $stmtArtikel->bindParam(':id', $id);
            $stmtArtikel->execute();

            // Commit de transactie als alles goed is gegaan
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            // Rollback als er iets fout gaat
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    // Haal categorieën op
    public function getCategories()
    {
        $sql = "SELECT id, categorie AS naam FROM categorie ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CRUD voor categorie
    public function createCategorie($categorie)
    {
        $sql = "INSERT INTO categorie (categorie) VALUES (:categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':categorie', $categorie);
        return $stmt->execute();
    }

    public function updateCategorie($id, $categorie)
    {
        $sql = "UPDATE categorie SET categorie = :categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categorie', $categorie);
        return $stmt->execute();
    }

    public function deleteCategorie($id)
    {
        $sql = "DELETE FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Check of de categorie bestaat
    public function categoryExists($categorie_id)
    {
        $sql = "SELECT COUNT(*) FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $categorie_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
