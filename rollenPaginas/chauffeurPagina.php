<?php
require_once "../classes/planning.php";

$planning = new Planning();

if (isset($_GET['delete_id'])) {
    $planning->deleteAppointment($_GET['delete_id']);
    header("Location: chauffeurPagina.php");
}

$appointments = $planning->getAllAppointments();

include '../classes/helpers.php';

$helpers = new Helpers();
    
$helpers->checkAccess(["directie", "chauffeur"], "../login.php");
?>

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

<?php include '../includes/nav.php'; ?>

<div class="container">
    <h1>Welkom Chauffeur</h1>
    <h2>Overzicht bestaande afspraken</h2>
    <a href="afspraakmaken.php" class="btn">Afspraak maken</a>

    <div class="container-overzicht">
        <table>
        <tr>
    <th>Klant Naam</th>
    <th>Adres</th>
    <th>Naam artikel</th>
    <th>Afspraakdatum</th>
    <th>Ophalen of bezorgen</th>
    <th>Kenteken</th>
    <th>Actie</th>
</tr>
<?php foreach ($appointments as $appointment): ?>
    <tr>
        <td><?= htmlspecialchars($appointment['klant_naam']) ?></td>
        <td><?= htmlspecialchars($appointment['adres']) ?></td>
        <td><?= htmlspecialchars($appointment['artikel_naam']) ?></td>
        <td><?= htmlspecialchars($appointment['afspraak_op']) ?></td>
        <td><?= htmlspecialchars($appointment['ophalen_of_bezorgen']) ?></td>
        <td><?= htmlspecialchars($appointment['kenteken']) ?></td>
        <td>
            <a href='afspraakwijzigen.php?id=<?= $appointment["id"] ?>' class='btn'>Wijzigen</a>
            <a href='chauffeurPagina.php?delete_id=<?= $appointment["id"] ?>' class='btn btn-danger' onclick="return confirm('Weet je zeker dat je deze afspraak wilt verwijderen?');">Verwijderen</a>
        </td>
    </tr>
<?php endforeach; ?>

        </table>
    </div>
    <div class="beheerwagens">
        <a href="beheerwagens.php" class="btn">Beheer wagens</a>
    </div>
</div>

<footer>
    <p>© 2025 Centrum Duurzaam. Alle rechten voorbehouden.</p>
</footer>

</body>
</html>