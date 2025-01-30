<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet" type="text/css">
    <title>Chauffeur</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { margin-top: 50px; }
        .btn { display: inline-block; padding: 10px 15px; margin: 10px; text-decoration: none; color: white; background-color: #007BFF; border-radius: 5px; }
        .btn:hover { background-color: #0056b3; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>

<?php 
include '../includes/nav.php'; 

$helpers = new Helpers();
    
$helpers->checkAccess(["directie"], "../login.php");

?>

 <h2>Overzicht wagens</h2>


    <div class="container-overzicht">
        <table>
        <tr>
    <th>id</th>
    <th>kenteken</th>
    <th>actie</th>
    </tr> 
    <tr>
        <td></td>
        <td></td>
    <td>
            <a href='afspraakwijzigen.php?id=<?= $appointment["id"] ?>' class='btn'>Wijzigen</a>
            <a href='index.php?delete_id=<?= $appointment["id"] ?>' class='btn btn-danger' onclick="return confirm('Weet je zeker dat je deze afspraak wilt verwijderen?');">Verwijderen</a>
        </td>
</tr>

<footer>
        <p>© 2025 Centrum Duurzaam. Alle rechten voorbehouden.</p>
    </footer>

</body>