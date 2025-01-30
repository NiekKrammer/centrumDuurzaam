<?php
require_once "../classes/db.php";

class Planning
{
    private $conn;
    private $table_name = "planning";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllAppointments()
    {
        $sql = "SELECT 
                    p.id, 
                    k.naam AS klant_naam, 
                    k.adres, 
                    a.naam AS artikel_naam, 
                    p.afspraak_op, 
                    p.kenteken,
                    p.ophalen_of_bezorgen  -- Voeg dit veld toe aan de selectie
                FROM planning p
                JOIN klant k ON p.klant_id = k.id  -- Verbindt de klant via klant_id
                JOIN artikel a ON p.artikel_id = a.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAppointment($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function getAfspraakById($id)
    {
        $query = "SELECT 
                        p.id, 
                        k.naam AS klantnaam, 
                        k.adres, 
                        a.naam AS artikel_naam, 
                        p.afspraak_op, 
                        p.kenteken,
                        p.ophalen_of_bezorgen,
                        p.klant_id,
                        p.artikel_id
                  FROM " . $this->table_name . " p
                  JOIN klant k ON p.klant_id = k.id
                  JOIN artikel a ON p.artikel_id = a.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAfspraak($id, $ophalen_of_bezorgen, $klant_id, $artikel_id, $afspraak_op, $kenteken)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET ophalen_of_bezorgen = :ophalen_of_bezorgen, 
                      klant_id = :klant_id,
                      artikel_id = :artikel_id,
                      afspraak_op = :afspraak_op,
                      kenteken = :kenteken
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":ophalen_of_bezorgen", $ophalen_of_bezorgen);
        $stmt->bindParam(":klant_id", $klant_id);
        $stmt->bindParam(":artikel_id", $artikel_id);
        $stmt->bindParam(":afspraak_op", $afspraak_op);
        $stmt->bindParam(":kenteken", $kenteken);

        return $stmt->execute();
    }


    public function addAppointment($artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op)
    {
        $query = "INSERT INTO " . $this->table_name . " (artikel_id, klant_id, kenteken, ophalen_of_bezorgen, afspraak_op) 
              VALUES (:artikel_id, :klant_id, :kenteken, :ophalen_of_bezorgen, :afspraak_op)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":artikel_id", $artikel_id);
        $stmt->bindParam(":klant_id", $klant_id);
        $stmt->bindParam(":kenteken", $kenteken);
        $stmt->bindParam(":ophalen_of_bezorgen", $ophalen_of_bezorgen);
        $stmt->bindParam(":afspraak_op", $afspraak_op);

        return $stmt->execute();
    }
}
