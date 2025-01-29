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
        <h2>Nieuw account</h2>
        <form method="post">
        <?php

        @session_start();

        var_dump($_SESSION);

        if (empty($_SESSION["role"] && $_SESSION["role"] != "directie")) {
            header("Location: index.php");
        }
        
        include './classes/user.php';
        
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
        
        $user = new User($fields);

        // $user->redirectLoggedIn();
        $user->createForm();

        ?>
        <form>
    </div>
</body>

<?php

include './classes/helpers.php';

$helper = new Helpers();

if ($_POST) {
    $user->validateWorkerFields($_POST);
}

?>
</html>