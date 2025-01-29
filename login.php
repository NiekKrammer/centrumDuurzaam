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
        </form>
</div>
</body>
<?php

if ($_POST) {
    $user->loginWorker($_POST);
}

?>
</html>