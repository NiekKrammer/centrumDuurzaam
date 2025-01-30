<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./styles.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h2>Klanten</h2>
    <a href="../customer.php">Maak nieuwe klant</a>

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
    echo "<th>Edit</th>";
    echo "<th>Delete</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $editLink = "../customer.php?action=edit&id=" . $id;
        $deleteLink = "../customer.php?action=delete&id=" . $id;

        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$naam}</td>";
        echo "<td>{$adres}</td>";
        echo "<td>{$plaats}</td>";
        echo "<td>{$telefoon}</td>";
        echo "<td>{$email}</td>";
        echo "<th><a href='$editLink'>EDIT</a></th>";
        echo "<th><a href='$deleteLink'>DELETE</a></th>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Geen klanten gevonden.</p>";
}
?>
   
</body>
</html>