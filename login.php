<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <img src="./assets/logo.png" alt="Logo.png">
        <h2>Login</h2>
        <form method="post">
        <?php
        
        include './classes/user.php';
        
        $fields = [
            ["name" => "username", "formatted" => "Gebruikersnaam", "label" => "Voer in uw gebruikersnaam", "type" => "text"], 
            ["name" => "password", "formatted" => "Wachtwoord", "label" => "Voer in uw wachtwoord", "type" => "password"],
        ];
        
        $user = new User($fields);

        $user->redirectLoggedIn();
        $user->createForm();

        ?>
        </form>
</div>
</body>
<?php

include './classes/helpers.php';

$helper = new Helpers();

$helper->userIsLoggedIn("dashboard.php");


if ($_POST) {
    $user->validateLoginFields($_POST);
}

?>
</html>