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
        <?php if (empty($_GET["id"])) { echo "<h2>Nieuw account</h2>";} else { echo "<h2>Edit klant ID " . $_GET["id"] . "</h2>";}?>
        <form method="post">
        <?php
        
        include './classes/user.php';

        $user = new User();

        if (empty($_SESSION["role"])) {
            header("Location: index.php");
        }


        $fields = [
            ["name" => "name", "formatted" => "Naam", "label" => "Voer in de naam", "type" => "text"],
            ["name" => "address", "formatted" => "Adres", "label" => "Voer in het adres", "type" => "text"],
            ["name" => "place", "formatted" => "Plaats", "label" => "Voer in de plaats", "type" => "text"],
            ["name" => "telephone", "formatted" => "Telefoonnummer", "label" => "Voer in het telefoonnummer", "type" => "text"],
            ["name" => "email", "formatted" => "Email", "label" => "Voer in de email", "type" => "text"],
        ];

        if ($_GET["action"] == "edit") {
            $userData = $user->getEditData("naam, adres, plaats, telefoon, email", "klant", "id = ?", [htmlspecialchars($_GET["id"])]);
            if (!empty($userData)) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }

            for ($i = 0; $i < count($fields); $i++) {
                $fields[$i]["value"] = $userData[$i];
            }
        } else if (isset($_GET["action"]) && $_GET["action"] == "delete") {
            $user->deleteAccount("klant", "id = ?", [htmlspecialchars($_GET["id"])]);
            header("Location: " . "register-worker.php");
        }

        $user->fields = $fields;

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