<?php
require_once "../classes/planning.php";
require_once "../classes/db.php";

$planning = new Planning();
$db = new Database();
$conn = $db->getConnection();

// Ophalen van klanten en artikelen voor het formulier
$klanten = $conn->query("SELECT id, naam FROM klant")->fetchAll(PDO::FETCH_ASSOC);
$artikelen = $conn->query("SELECT id, naam FROM artikel")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $artikel_id = $_POST['artikel_id'];
    $klant_id = $_POST['klant_id'];
    $kenteken = $_POST['kenteken'];
    $ophalen_of_bezorgen = $_POST['ophalen_of_bezorgen'];
    $afspraak_op = $_POST['afspraak_op'];

    if ($planning->addAppointment($artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op)) {
        header("Location: chauffeurPagina.php");
        exit;
    } else {
        $error = "Er is iets misgegaan bij het maken van de afspraak.";
    }
}
$db->disconnect();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afspraak maken</title>
    <link href="../../styles.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="container">
    <h1>Nieuwe afspraak maken</h1>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST">
        <label for="klant_id">Klant:</label>
        <select name="klant_id" required>
            <option value="">Selecteer een klant</option>
            <?php foreach ($klanten as $klant): ?>
                <option value="<?= $klant['id'] ?>"><?= htmlspecialchars($klant['naam']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="artikel_id">Artikel:</label>
        <select name="artikel_id" required>
            <option value="">Selecteer een artikel</option>
            <?php foreach ($artikelen as $artikel): ?>
                <option value="<?= $artikel['id'] ?>"><?= htmlspecialchars($artikel['naam']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="kenteken">kenteken</label>

<select name="kenteken" id="kenteken">
  <option value="AB-123-CD">AB-123-CD</option>
  <option value="EF-456-GH">EF-456-GH</option>
  <option value="AB-123-CDS">AB-123-CDS</option>
</select>
        <label for="ophalen_of_bezorgen">Ophalen of bezorgen:</label>
        <select name="ophalen_of_bezorgen" required>
            <option value="ophalen">Ophalen</option>
            <option value="bezorgen">Bezorgen</option>
        </select>
        
        <label for="afspraak_op">Afspraakdatum:</label>
        <input type="datetime-local" name="afspraak_op" required>
        
        <button type="submit">Afspraak maken</button>
    </form>
    <a href="chauffeurPagina.php" class="btn">Terug naar overzicht</a>
</div>

</body>
</html>