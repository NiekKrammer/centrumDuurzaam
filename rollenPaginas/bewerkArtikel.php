<?php
require '../config/dbconnect.php';
require '../models/Magazijn.php';

$database = new Database();
$db = $database->getConnection();
$magazijn = new Magazijn($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_artikel'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $categorie_id = $_POST['categorie_id'];
    $prijs_ex_btw = $_POST['prijs_ex_btw'];
    $aantal = $_POST['aantal'];
    $locatie = $_POST['locatie'];

    // Debugging statements
    error_log("ID: $id");
    error_log("Naam: $naam");
    error_log("Categorie ID: $categorie_id");
    error_log("Prijs ex BTW: $prijs_ex_btw");
    error_log("Aantal: $aantal");
    error_log("Locatie: $locatie");

    if ($magazijn->categoryExists($categorie_id)) {
        if ($magazijn->updateArtikel($id, $categorie_id, $naam, $prijs_ex_btw, $aantal, $locatie)) {
            error_log("Artikel succesvol bijgewerkt.");
            header("Location: magazijnMedewerkerPagina.php");
            exit();
        } else {
            error_log("Fout bij het bijwerken van het artikel.");
            echo "Fout bij het bijwerken van het artikel.";
        }
    } else {
        error_log("Ongeldige categorie.");
        echo "Ongeldige categorie.";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $artikel = $magazijn->getArtikelById($id);
    if (!$artikel) {
        echo "Artikel niet gevonden.";
        exit();
    }
    $categories = $magazijn->getCategories();
} else {
    header("Location: magazijnMedewerkerPagina.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet" type="text/css">
    <title>Artikel Bewerken</title>
</head>
<body>

    <nav>
        <img src="../assets/logo.png" alt="logo">
        <div class="roleTag_loguitBtn">
            <span>Magazijn</span>
            <a href="../process/logout.php">Uitloggen</a>
        </div>
    </nav>

    <div class="magazijnVoorraad">
        <a href="magazijnMedewerkerPagina.php">&lt; Terug</a>
        
        <h1>Artikel Bewerken</h1>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($artikel['id'] ?? ''); ?>">
            <input type="text" name="naam" value="<?php echo htmlspecialchars($artikel['naam'] ?? ''); ?>" placeholder="Naam" required>
            <select name="categorie_id" required>
                <option value="">Selecteer Categorie</option>
                <?php
                foreach ($categories as $categorie) {
                    $selected = ($categorie['id'] == ($artikel['categorie_id'] ?? '')) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($categorie['id']) . '" ' . $selected . '>' . htmlspecialchars($categorie['naam']) . '</option>';
                }
                ?>
            </select>
            <input type="number" step="0.01" name="prijs_ex_btw" value="<?php echo htmlspecialchars($artikel['prijs_ex_btw'] ?? ''); ?>" placeholder="Prijs (ex BTW)" required>
            <input type="number" step="1" name="aantal" value="<?php echo htmlspecialchars($artikel['aantal'] ?? ''); ?>" placeholder="Aantal" required>
            <input type="text" name="locatie" value="<?php echo htmlspecialchars($artikel['locatie'] ?? ''); ?>" placeholder="Locatie" required>
            <button type="submit" name="update_artikel">Update Artikel</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Centrum Duurzaam. Alle rechten voorbehouden.</p>
    </footer>

</body>
</html>
