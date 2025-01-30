<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <title>Document</title>
</head>

<body>
    <?php include '../includes/nav.php'; ?>
    
    <a href="directiePagina.php" style="margin: 8px;">&lt; Ga terug</a>
    <div class="klantenPagina">

        <h1>Personeel</h1>
        <a class="nieuw" href="../rollenPaginas/worker.php">Voeg personeel toe</a>

        <?php
        include_once '../classes/db.php';
        include_once '../models/Personeel.php';

        // Instantiate database and klant object
        $database = new Database();
        $db = $database->getConnection();

        $klant = new Personeel($db);

        // Query klanten
        $stmt = $klant->getAllPersoneel();
        $num = $stmt->rowCount();

        if ($num > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Gebruikersnaam</th>";
            echo "<th>Rol</th>";
            echo "<th>Is geverifieerd</th>";
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $editLink = "./worker.php?action=edit&id=" . $ID;
                $deleteLink = "./worker.php?action=delete&id=" . $ID;
                $isVerified = $Is_geverifieerd ? "Geverifieerd" : "Niet geverifieerd";

                echo "<tr>";
                echo "<td>{$ID}</td>";
                echo "<td>{$Gebruikersnaam}</td>";
                echo "<td>{$Rol}</td>";
                echo "<td>{$isVerified}</td>";
                echo "<th><a href='$editLink'>EDIT</a></th>";
                echo "<th><a href='$deleteLink'>DELETE</a></th>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Geen personeel gevonden.</p>";
        }
        ?>
    </div>

    <footer>
        <p>© centrumDuurzaam</p>
    </footer>

</body>

</html>