<?php
require_once "../classes/db.php";
require_once '../classes/planning.php';

$database = new Database();
$db = $database->getConnection();
$planning = new Planning($db);

// Controleren of een ID is meegegeven
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Geen afspraak ID opgegeven.");
}

$id = $_GET['id'];
$afspraak = $planning->getAfspraakById($id);

if (!$afspraak) {
    die("Afspraak niet gevonden.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ophalen_of_bezorgen = $_POST['ophalen_of_bezorgen'];
    $klant_id = $_POST['klant_id'];  // Correcte variabele gebruiken
    $artikel_id = $_POST['artikel_id'];  // Correcte variabele gebruiken
    $afspraak_op = $_POST['afspraak_op'];
    $kenteken = $_POST['kenteken'];

    $planning->updateAfspraak($id, $ophalen_of_bezorgen, $klant_id, $artikel_id, $afspraak_op, $kenteken);
    header("Location: chauffeurPagina.php");
    exit;
}

include '../classes/helpers.php';

$helpers = new Helpers();
    
$helpers->checkAccess(["directie", "chauffeur", "winkelpersoneel"], "../login.php");

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <title>Afspraak Wijzigen</title>
</head>

<body>

    <?php include '../includes/nav.php'; ?>
    <div class="afspraakWijzigenPagina">
        <h2 style="text-align: left;">Afspraak Wijzigen</h2>
        <form method="post">
            <label>Ophalen of Bezorgen:</label>
            <input type="text" name="ophalen_of_bezorgen" value="<?php echo htmlspecialchars($afspraak['ophalen_of_bezorgen']); ?>" required>
            <br>
            <label>Klantnaam:</label>
            <input type="text" value="<?= htmlspecialchars($afspraak['klantnaam']); ?>" readonly>
            <input type="hidden" name="klant_id" value="<?= htmlspecialchars($afspraak['klant_id']); ?>">
            <br>

            <label>Adres:</label>
            <input type="text" value="<?= htmlspecialchars($afspraak['adres']); ?>" readonly>
            <br>


            <label>Artikel:</label>
            <select name="artikel_id" required>
                <?php
                $artikelen = $db->query("SELECT id, naam FROM artikel")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($artikelen as $artikel):
                ?>
                    <option value="<?= $artikel['id'] ?>" <?= ($artikel['id'] == $afspraak['artikel_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artikel['naam']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <label>Afspraak op:</label>
            <input type="datetime-local" name="afspraak_op" value="<?php echo htmlspecialchars($afspraak['afspraak_op']); ?>" required>
            <br>


            <label for="kenteken">Kenteken:</label>
            <select name="kenteken" id="kenteken" required>
                <?php
                $kentekens = ["AB-123-CD", "EF-456-GH", "AB-123-CDS"]; // De drie vaste opties
                foreach ($kentekens as $kenteken):
                ?>
                    <option value="<?= htmlspecialchars($kenteken) ?>"
                        <?= ($kenteken == $afspraak['kenteken']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kenteken) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
            <button type="submit">Opslaan</button>
        </form>
        <a href="chauffeurPagina.php">Terug</a>
    </div>

    <footer>
        <p>© 2025 Centrum Duurzaam. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>