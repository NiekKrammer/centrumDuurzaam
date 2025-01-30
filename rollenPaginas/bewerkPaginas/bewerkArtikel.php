<?php
// Include database connection
require '../../classes/db.php';
require '../../models/Magazijn.php';

// Maak verbinding met de database via de Database class
$database = new Database();
$conn = $database->getConnection();
$magazijn = new Magazijn($conn);

// Check if form is submitted
if (isset($_POST['update_artikel'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $categorie_id = $_POST['categorie_id'];
    $prijs_ex_btw = $_POST['prijs_ex_btw'];
    $aantal = $_POST['aantal'];
    $locatie = $_POST['locatie'];
    $status = $_POST['status'];
    $directVerkoopbaar = $_POST['directVerkoopbaar'];
    $isKapot = $_POST['isKapot'];

    // Update artikel in the database
    $magazijn->updateArtikel($id, $categorie_id, $naam, $prijs_ex_btw, $aantal, $locatie, $status, $directVerkoopbaar, $isKapot);
    header("Location: ../magazijnMedewerkerPagina.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT a.id, a.naam, a.categorie_id, a.prijs_ex_btw, v.aantal, v.locatie, v.status_id, a.directVerkoopbaar, a.isKapot 
              FROM artikel a
              JOIN voorraad v ON a.id = v.artikel_id
              WHERE a.id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $artikel = $stmt->fetch(PDO::FETCH_ASSOC);

    // Haal de categorieën op
    $categories = $magazijn->getCategories();
} else {
    echo "Geen artikel ID opgegeven.";
    exit;
}

include '../../classes/helpers.php';

$helpers = new Helpers();
    
$helpers->checkAccess(["directie", "magazijn"], "../../login.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../styles.css" rel="stylesheet" type="text/css">
    <title>Artikel Bewerken</title>
</head>
<body>
    <nav>
        <img src="../../assets/logo.png" alt="logo">
        <div class="roleTag_loguitBtn">
            <span>Magazijn</span>
            <a href="../../logout.php">Uitloggen</a>
        </div>
    </nav>

    <div class="magazijnVoorraad">
        <a href="../magazijnMedewerkerPagina.php">&lt; Ga terug</a>

        
        <form action="" method="post" class="artikelBewerkForm">
            <h1>Artikel Bewerken</h1>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($artikel['id'] ?? ''); ?>">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($artikel['naam'] ?? ''); ?>" placeholder="Naam" required>
            
            <label for="categorie_id">Categorie:</label>
            <select id="categorie_id" name="categorie_id" required>
            <option value="">Selecteer Categorie</option>
            <?php
            foreach ($categories as $categorie) {
                $selected = ($categorie['id'] == ($artikel['categorie_id'] ?? '')) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($categorie['id']) . '" ' . $selected . '>' . htmlspecialchars($categorie['naam']) . '</option>';
            }
            ?>
            </select>
            
            <label for="prijs_ex_btw">Prijs (ex BTW):</label>
            <input type="number" id="prijs_ex_btw" step="0.01" name="prijs_ex_btw" value="<?php echo htmlspecialchars($artikel['prijs_ex_btw'] ?? ''); ?>" placeholder="Prijs (ex BTW)" required>
            
            <label for="aantal">Aantal:</label>
            <input type="number" id="aantal" step="1" name="aantal" value="<?php echo htmlspecialchars($artikel['aantal'] ?? ''); ?>" placeholder="Aantal" required>
            
            <label for="locatie">Locatie:</label>
            <select id="locatie" name="locatie" required>
            <option value="">Selecteer Locatie</option>
            <option value="Locatie A" <?php echo ($artikel['locatie'] == 'Locatie A') ? 'selected' : ''; ?>>Locatie A</option>
            <option value="Locatie B" <?php echo ($artikel['locatie'] == 'Locatie B') ? 'selected' : ''; ?>>Locatie B</option>
            <option value="Locatie C" <?php echo ($artikel['locatie'] == 'Locatie C') ? 'selected' : ''; ?>>Locatie C</option>
            <option value="Locatie D" <?php echo ($artikel['locatie'] == 'Locatie D') ? 'selected' : ''; ?>>Locatie D</option>
            <option value="Locatie E" <?php echo ($artikel['locatie'] == 'Locatie E') ? 'selected' : ''; ?>>Locatie E</option>
            <option value="Locatie F" <?php echo ($artikel['locatie'] == 'Locatie F') ? 'selected' : ''; ?>>Locatie F</option>
            <option value="Locatie G" <?php echo ($artikel['locatie'] == 'Locatie G') ? 'selected' : ''; ?>>Locatie G</option>
            <option value="Locatie H" <?php echo ($artikel['locatie'] == 'Locatie H') ? 'selected' : ''; ?>>Locatie H</option>
            <option value="Locatie I" <?php echo ($artikel['locatie'] == 'Locatie I') ? 'selected' : ''; ?>>Locatie I</option>
            </select>
            
            <label for="status">Status:</label>
            <select id="status" name="status" required>
            <option value="">Selecteer Status</option>
            <option value="in voorraad" <?php echo ($artikel['status_id'] == 1) ? 'selected' : ''; ?>>In voorraad</option>
            <option value="uit voorraad" <?php echo ($artikel['status_id'] == 2) ? 'selected' : ''; ?>>Uit voorraad</option>
            </select>
            
            <label for="directVerkoopbaar">Direct Verkoopbaar:</label>
            <select id="directVerkoopbaar" name="directVerkoopbaar" required>
            <option value="">Direct Verkoopbaar</option>
            <option value="ja" <?php echo ($artikel['directVerkoopbaar'] == 'ja') ? 'selected' : ''; ?>>Ja</option>
            <option value="nee" <?php echo ($artikel['directVerkoopbaar'] == 'nee') ? 'selected' : ''; ?>>Nee</option>
            </select>
            
            <label for="isKapot">Is Kapot:</label>
            <select id="isKapot" name="isKapot" required>
            <option value="">Is Kapot</option>
            <option value="ja" <?php echo ($artikel['isKapot'] == 'ja') ? 'selected' : ''; ?>>Ja</option>
            <option value="nee" <?php echo ($artikel['isKapot'] == 'nee') ? 'selected' : ''; ?>>Nee</option>
            </select>
            
            <button type="submit" name="update_artikel" class="addBtn" style="margin-top: 8px;">Update Artikel</button>
        </form>
    </div>
    <footer>
        <p>© centrumDuurzaam</p>
    </footer>
</body>
</html>