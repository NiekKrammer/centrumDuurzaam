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
        <h2>Nieuw account</h2>
        <form method="post">
        <?php
        
        include './classes/user.php';
        
        $fields = [
            ["name" => "name", "formatted" => "Naam", "label" => "Voer in de naam", "type" => "text"],
            ["name" => "address", "formatted" => "Adres", "label" => "Voer in het adres", "type" => "text"],
            ["name" => "place", "formatted" => "Plaats", "label" => "Voer in de plaats", "type" => "text"],
            ["name" => "telephone", "formatted" => "Telefoonnummer", "label" => "Voer in het telefoonnummer", "type" => "text"],
            ["name" => "email", "formatted" => "Email", "label" => "Voer in de email", "type" => "text"],
        ];
        
        $user = new User($fields);

        $user->createForm();

        ?>
        <form>
    </div>
</body>

<?php

include './classes/helpers.php';

$helper = new Helpers();

if ($_POST) {
    $user->validateCustomerFields($_POST);
}

?>
</html>