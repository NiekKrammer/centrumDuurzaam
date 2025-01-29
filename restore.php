<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Restore account</title>
</head>
<body>
    <h2>Restore your account</h2>
    <form method="post">
        <label>New password</label>
        <input type="password" name="password" />
    </form>
</body>
</html>

<?php

if ($_POST) {
    // Update the password by using the restore ID
    include './classes/user.php';

    $user = new User();

    $user->updateUserPassword(password_hash($_POST["password"],PASSWORD_DEFAULT), $_GET["id"]);

    echo "Your password has been changed!<a href='login.php'>Go to login</a>";
}