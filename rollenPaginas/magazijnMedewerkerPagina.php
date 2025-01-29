<?php
session_start();
require '../includes/dbconnect.php';
require '../models/Magazijn.php';

$db = new Database();
$conn = $db->getConnection();

$magazijnModel = new MagazijnModel($conn);
$voorraad = $magazijnModel->getVoorraad();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet" type="text/css">
    <title>Magazijn medewerker</title>
</head>

<body>

    <nav>
        <img src="../assets/logo.png" alt="logo">
        <div class="roleTag_loguitBtn">
            <span>Magazijn</span>
            <a href="../process/logout.php">Uitloggen</a>
        </div>
    </nav>

    <div class="container">
        <h1>Voorraad Overzicht</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Artikel</th>
                    <th>Aantal</th>
                    <th>Locatie</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraad as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['artikel']); ?></td>
                        <td><?php echo $item['aantal']; ?></td>
                        <td><?php echo htmlspecialchars($item['locatie']); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    
</body>

</html>
