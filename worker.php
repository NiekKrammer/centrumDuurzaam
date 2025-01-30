<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Login</title>
</head>
<body>
    <img id="logo" src="./assets/logo.png" alt="Logo.png">
    <div class="login-container">
        <!-- Laat text zien op basis van welke actie het is -->
        <?php if (empty($_GET["id"])) { echo "<h2>Nieuw account</h2>";} else { echo "<h2>Edit worker ID " . $_GET["id"] . "</h2>";}?>
        <form method="post">
        <?php

        include './classes/user.php';

        $user = new User();

        // Check of de user toegang heeft
        $user->checkAdmin("index.php");
        
        // Define wat custom fields
        $fields = [
            ["name" => "username", "formatted" => "Username", "label" => "Voer in uw username", "type" => "text"],
            ["name" => "password", "formatted" => "Wachtwoord", "label" => "Voer in uw wachtwoord", "type" => "text"],
            ["name" => "role", "formatted" => "Rol", "label" => "Voer in een rol", "html" => "
            <label>Selecteer een rol</label><label class='errorMessage' id='roleError'></label><br>
            <select name='role' id='role-select'>
            <option value='directie'>Directie</option>
            <option value='magazijn'>Magazijn</option>
            <option value='winkelpersoneel'>winkelpersoneel</option>
            <option value='chaffeur'>Chauffeur</option>
            </select>"],
        ];

        
        $user->fields = $fields;
        
        // Check of de actie edit is
        if (isset($_GET["action"]) && $_GET["action"] == "edit") {
            // Pak de gebruikersnaam
            $userData = $user->getEditData("Gebruikersnaam", "accounts", "ID = ?", [htmlspecialchars($_GET["id"])]);
            if (empty($userData)) {
                header("Location: worker.php");
            }
            
            // Verander de preset value van het username field
            $fields[0]["value"] = $userData["Gebruikersnaam"];
            // Wachtwoord is een andere pagina
            unset($fields[1]);
            // Update fields
            $user->fields = $fields;
            
            // Doe een delete indien de actie delete is
        } else if (isset($_GET["action"]) && $_GET["action"] == "delete") {
            $user->deleteAccount(htmlspecialchars($_GET["id"]));
            header("Location: rollenPaginas/klantenPagina.php");
        }
        
        $user->createForm();

        ?>
        </form>
        <?php if (isset($_GET["id"]) && !empty($_GET["id"])) { echo "<a href='restore.php?id=" . $_GET["id"] . "'>Verander wachtwoord</a>"; } ?>
    </div>
</body>

<?php

$helper = new Helpers();

// Check of er is gepost
if ($_POST) {

    // Doe of een edit of een create
    if (!empty($_GET["id"])) {
        $user->registerNewWorker($_POST, $_GET["id"]);
    } else {
        $user->registerNewWorker($_POST);
    }
}

?>
</html>