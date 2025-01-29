<?php
session_start();
require '../includes/dbconnect.php';

$db = new Database();
$conn = $db->getConnection();

if (isset($_POST['gebruikersnaam'], $_POST['wachtwoord'], $_POST['rol'], $_POST['geverifieerd'])) {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = $_POST['wachtwoord'];
    $rol = $_POST['rol'];
    $geverifieerd = $_POST['geverifieerd'] ? 1 : 0; // 1 als aangevinkt, anders 0

    // Controleer of velden zijn ingevuld
    if (empty($gebruikersnaam) || empty($wachtwoord) || empty($rol)) {
        $_SESSION['error'] = 'Vul alle velden in';
        header('Location: ../index.php'); 
        exit;
    }

    // Wachtwoord hash genereren
    $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

    // Databasequery om gebruiker te registreren, inclusief de geverifieerd kolom
    $stmt = $conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssi', $gebruikersnaam, $hashedPassword, $rol, $geverifieerd);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Registratie voltooid! Je kunt nu inloggen.';
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Er is iets misgegaan, probeer het opnieuw';
        header('Location: ../index.php'); 
        exit;
    }

    $stmt->close();
}
?>
