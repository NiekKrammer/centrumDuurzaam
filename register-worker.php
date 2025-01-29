<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/register.css"> -->
    <link rel="stylesheet" href="./styles.css">
    <title>Login</title>
</head>
<body>
    <img id="logo" src="./assets/logo.png" alt="Logo.png">
    <div class="login-container">
        <?php if (empty($_GET["id"])) { echo "<h2>Nieuw account</h2>";} else { echo "<h2>Edit worker ID " . $_GET["id"] . "</h2>";}?>
        <form method="post">
        <?php

        include './classes/user.php';

        $user = new User();

        if (empty($_SESSION["role"] || $_SESSION["role"] != "directie")) {
            header("Location: index.php");
        }
        
        
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
        
        if (isset($_GET["action"]) && $_GET["action"] == "edit") {
            $userData = $user->getEditData("Gebruikersnaam", "accounts", "ID = ?", [htmlspecialchars($_GET["id"])]);
            if (empty($userData)) {
                header("Location: " . "register-worker.php");
            }

            $fields[0]["value"] = $userData["Gebruikersnaam"];
            unset($fields[1]);
            $user->fields = $fields;
        } else if (isset($_GET["action"]) && $_GET["action"] == "delete") {
            $user->deleteAccount("accounts", "ID = ?", [htmlspecialchars($_GET["id"])]);
            header("Location: " . "register-worker.php");
        }
        
        $user->createForm();

        ?>
        <form>
    </div>
</body>

<?php

include './classes/helpers.php';

$helper = new Helpers();

if ($_POST) {
    if (!empty($_GET["id"])) {
        $user->validateWorkerFields($_POST, $_GET["id"]);
    } else {
        $user->validateWorkerFields($_POST);
    }
}

?>
</html>