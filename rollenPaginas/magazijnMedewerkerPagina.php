<?php
session_start();

require '../classes/db.php';
require '../models/Magazijn.php';

$database = new Database();
$db = $database->getConnection();
$magazijn = new Magazijn($db);

// Verboden artikelen array
$verboden_artikelen = ['wapens', 'motorvoertuigen', 'industriele zonnebanken', 'klein gevaarlijk afval', 'verf', 'asbesthoudende producten', 'ink', 'autobanden', 'etenswaren', 'dranken over datum'];

// Toevoegen artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_artikel'])) {
    $naam = $_POST['naam'];
    $categorie_id = $_POST['categorie_id'];
    $prijs_ex_btw = $_POST['prijs_ex_btw'];
    $aantal = $_POST['aantal'];
    $locatie = $_POST['locatie'];
    $directVerkoopbaar = $_POST['directVerkoopbaar'];
    $isKapot = $_POST['isKapot'];

    // Roep de createArtikel functie aan
    if ($magazijn->createArtikel($naam, $categorie_id, $prijs_ex_btw, $aantal, $locatie, $directVerkoopbaar, $isKapot)) {
        $_SESSION['success_message'] = "Artikel succesvol toegevoegd.";
    } else {
        $_SESSION['error_message'] = "Er is een fout opgetreden bij het toevoegen van het artikel.";
    }
}

// Bijwerken artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_artikel'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $categorie_id = $_POST['categorie_id'];
    $prijs_ex_btw = $_POST['prijs_ex_btw'];
    $aantal = $_POST['aantal'];
    $locatie = $_POST['locatie'];
    $status_id = $_POST['status_id'];

    // Roep de updateArtikel functie aan
    $magazijn->updateArtikel($id, $categorie_id, $naam, $prijs_ex_btw, $aantal, $locatie, $status_id, $directVerkoopbaar, $isKapot);
}


// Verwijder artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_artikel'])) {
    $id = $_POST['id'];
    $magazijn->deleteArtikel($id);
}

// Toevoegen categorie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_categorie'])) {
    $naam = $_POST['naam'];
    $magazijn->createCategorie($naam);
}

// Bijwerken categorie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_categorie'])) {
    $id = $_POST['id'];
    $naam = $_POST['naam'];
    $magazijn->updateCategorie($id, $naam);
}

// Verwijder categorie
if (isset($_POST['delete_categorie'])) {
    $id = $_POST['id'];
    $magazijn->deleteCategorie($id);
}

// Artikelen ophalen
$artikelen = $magazijn->getArtikelen();
$categories = $magazijn->getCategories();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet" type="text/css">
    <title>Artikelen Beheren</title>
    
</head>

<body>

    <?php include '../includes/nav.php'; ?>
    <!-- <nav> -->
        <!-- <img src="../assets/logo.png" alt="logo"> -->
        <!-- <div class="roleTag_loguitBtn">
            <span>Magazijn</span>
            <a href="../logout.php">Uitloggen</a>
        </div> -->
    <!-- </nav> -->

    <div class="magazijnVoorraad">

        <a href="directiePagina.php">&lt; Ga terug</a>

        <h1>Artikelen</h1>
        <input type="text" class="search_field" placeholder="Zoek naar..." onkeyup="searchTable()">
        
        <table border="1" class="artikelTabel">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Artikel naam</th>
                    <th>Categorie</th>
                    <th>Prijs (ex BTW)</th>
                    <th>Aantal</th>
                    <th>Locatie</th>
                    <th>Direct Verkoopbaar</th>
                    <th>Is Kapot</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artikelen as $artikel) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($artikel['id']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['naam']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['categorie_naam']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['prijs_ex_btw']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['aantal']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['locatie']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['directVerkoopbaar']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['isKapot']); ?></td>
                        <td><?php echo htmlspecialchars($artikel['status']); ?></td>
                        <td>
                            <!-- Artikel bewerken -->
                            <form method="GET" action="bewerkPaginas/bewerkArtikel.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($artikel['id']); ?>">
                                <button type="submit">Bewerken</button>
                            </form>
                            <!-- Artikel verwijderen -->
                            <form method="POST" style="display:inline-block;" onsubmit="return confirm('Weet je zeker dat je dit artikel wilt verwijderen?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($artikel['id']); ?>">
                                <button type="submit" name="delete_artikel">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Artikel toevoegen -->
        <h2>Artikel toevoegen</h2>
        <form action="" method="post">
            <input type="text" name="naam" placeholder="Naam" required>
            <select name="categorie_id" required>
                <option value="">Selecteer Categorie</option>
                <?php
                foreach ($categories as $categorie) {
                    echo '<option value="' . htmlspecialchars($categorie['id']) . '">' . htmlspecialchars($categorie['naam']) . '</option>';
                }
                ?>
            </select>
            <input type="number" step="0.01" name="prijs_ex_btw" placeholder="Prijs (ex BTW)" required>
            <input type="number" name="aantal" placeholder="Aantal" required>
            <select name="locatie" required>
                <option value="">Selecteer Locatie</option>
                <option value="Locatie A">Locatie A</option>
                <option value="Locatie B">Locatie B</option>
                <option value="Locatie C">Locatie C</option>
                <option value="Locatie D">Locatie D</option>
                <option value="Locatie E">Locatie E</option>
                <option value="Locatie F">Locatie F</option>
                <option value="Locatie G">Locatie G</option>
                <option value="Locatie H">Locatie H</option>
                <option value="Locatie I">Locatie I</option>
            </select>
            <select name="directVerkoopbaar" required>
                <option value="">Direct Verkoopbaar</option>
                <option value="ja">Ja</option>
                <option value="nee">Nee</option>
            </select>
            <select name="isKapot" required>
                <option value="">Is Kapot</option>
                <option value="ja">Ja</option>
                <option value="nee">Nee</option>
            </select>
            <button type="submit" name="create_artikel" class="addBtn">Voeg Artikel Toe</button>
        </form>

        <!-- Categorieën beheren -->
        <h2 id="categorymanage">Categorieën Beheren</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($categorie['id']); ?></td>
                        <td><?php echo htmlspecialchars($categorie['naam']); ?></td>
                        <td>
                            <!-- Categorie bewerken -->
                            <form method="GET" action="bewerkPaginas/bewerkCategorie.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($categorie['id']); ?>">
                                <button type="submit">Bewerken</button>
                            </form>
                            <!-- Categorie verwijderen -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($categorie['id']); ?>">
                                <button type="submit" name="delete_categorie">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Categorie toevoegen formulier -->
        <h2>Categorie toevoegen</h2>
        <form action="" method="post">
            <input type="text" name="naam" placeholder="Naam" required>
            <button type="submit" name="create_categorie" class="addBtn">Voeg Categorie Toe</button>
        </form>
    </div>

    <footer>
        <p>© centrumDuurzaam</p>
    </footer>

    <script src="../script.js"></script>
</body>

</html>