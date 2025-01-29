
<?php
include_once '../classes/db.php';
include_once '../models/Klant.php';

// Instantiate database and klant object
$database = new Database();
$db = $database->getConnection();

$klant = new Klant($db);

// Query klanten
$stmt = $klant->getAllKlanten();
$num = $stmt->rowCount();

if($num > 0) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Naam</th>";
    echo "<th>Adres</th>";
    echo "<th>Plaats</th>";
    echo "<th>Telefoon</th>";
    echo "<th>Email</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$naam}</td>";
        echo "<td>{$adres}</td>";
        echo "<td>{$plaats}</td>";
        echo "<td>{$telefoon}</td>";
        echo "<td>{$email}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Geen klanten gevonden.</p>";
}
?>