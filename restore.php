<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Restore account</title>
</head>
<body>
    <h2>Restore account ID <?php echo $_GET["id"] ?></h2>
    <a href="rollenPaginas/klantenPagina.php">Ga terug naar worker overzicht</a>
    <form method="post">
        <label>New password</label><br>
        <input type="password" name="password" /><br>
        <input type="password" name="password_check" /><br>
        <button type="submit">Verander wachtwoord</button>
    </form>
</body>
</html>

<?php

if ($_POST) {
    // Update the password by using the restore ID
    include './classes/user.php';

    $user = new User();

    $user->checkAdmin("login.php");

    if ($_POST["password"] !== $_POST["password_check"]) {
        echo "Wachtwoorden komen niet overeen";
    } else {
        $user->updateUserPassword(password_hash($_POST["password"],PASSWORD_DEFAULT), $_GET["id"]);
    
        echo "Your password has been changed!<a href='login.php'>Go to login</a>";
    }
}