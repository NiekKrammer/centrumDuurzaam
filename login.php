<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
        <?php

        include './classes/user.php';
        
        $fields = [
            ["name" => "username", "formatted" => "Gebruikersnaam", "label" => "Voer in uw gebruikersnaam", "type" => "text"], 
            ["name" => "password", "formatted" => "Wachtwoord", "label" => "Voer in uw wachtwoord", "type" => "password"],
        ];
        
        $user = new User($fields);

        // Redirect als de user ingelogd is en maak een form zo niet
        $user->redirectLoggedIn();
        $user->createForm();

        ?>
        <button type="submit" name="request" value="true">Wachtwoord vergeten?</button>
        </form>
</div>
</body>
<?php

if ($_POST) {
    // Check of het een restore request is
    if (!empty($_POST["username"]) && isset($_POST["request"])) {
        // Check of het account bestaat
        $dataSql = $user->conn->prepare("SELECT ID FROM accounts WHERE Gebruikersnaam = ?");
        $dataSql->execute([$_POST["username"]]);
        $gottenID = $dataSql->fetch();

        // Maak een speciale link
        if (!empty($gottenID)) {
            echo "<a href='" . $user->createSpecialLink($gottenID["ID"]) . "'>Restore password link</a>";
        }
    
    }

    $user->loginWorker($_POST);
}

?>
</html>