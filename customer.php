<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Login</title>
</head>

<body>
    <nav>
        <img src="assets/logo.png" alt="logo">
        <div class="roleTag_loguitBtn">
            <span>Directie</span>
            <a href="logout.php">Uitloggen</a>
        </div>
    </nav>

    <a href="rollenPaginas/klantenPagina.php" style="margin: 8px;">&lt; Ga terug</a>

    <div class="login-container">
        <!-- Laat text zien op basis van welke actie het is -->
        <?php if (empty($_GET["id"])) {
            echo "<h2>Nieuw account</h2>";
        } else {
            echo "<h2>Edit klant ID " . $_GET["id"] . "</h2>";
        } ?>
        <a href="rollenPaginas/klantenPagina.php">Ga terug naar klanten overzicht</a>
        <form method="post">
            <?php

            include './classes/user.php';

            $user = new User();

            // Check of de gebruiker toegang heeft
            if (!isset($_SESSION["role"]) || empty($_SESSION["role"])) {
                header("Location: index.php");
            }

            // Define wat fields
            $fields = [
                ["name" => "name", "formatted" => "Naam", "label" => "Voer in de naam", "type" => "text"],
                ["name" => "address", "formatted" => "Adres", "label" => "Voer in het adres", "type" => "text"],
                ["name" => "place", "formatted" => "Plaats", "label" => "Voer in de plaats", "type" => "text"],
                ["name" => "telephone", "formatted" => "Telefoonnummer", "label" => "Voer in het telefoonnummer", "type" => "text"],
                ["name" => "email", "formatted" => "Email", "label" => "Voer in de email", "type" => "text"],
            ];

            // Als de actie edit is update de data
            if (isset($_GET["action"]) && $_GET["action"] == "edit") {
                // Check of er een account is
                $userData = $user->getEditData("naam, adres, plaats, telefoon, email", "klant", "id = ?", [htmlspecialchars($_GET["id"])]);
                if (empty($userData)) {
                    header("Location: customer.php");
                }

                // Loop door de fields en automatisch vul in de velden
                for ($i = 0; $i < count($fields); $i++) {
                    $fields[$i]["value"] = $userData[$i];
                }

                // Delete het account indien dat de actie is
            } else if (isset($_GET["action"]) && $_GET["action"] == "delete") {
                $user->deleteAccount("klant", "id", htmlspecialchars($_GET["id"]));
                header("Location: customer.php");
            }

            $user->fields = $fields;

            $user->createForm();

            ?>
        </form>
    </div>
</body>

<?php

include './classes/helpers.php';

$helper = new Helpers();

// Doe een edit of create
if ($_POST) {
    if (!empty($_GET["id"])) {
        $user->registerNewCustomer($_POST, $_GET["id"]);
    } else {
        $user->registerNewCustomer($_POST);
    }
}

?>

</html>