<?php
session_start();
require '../includes/dbconnect.php';

// Initialiseer de databaseklasse en haal de connectie op
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

    try {
        // Bereid de query voor met de opgehaalde verbinding
        $stmt = $conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (:gebruikersnaam, :wachtwoord, :rol, :geverifieerd)");
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
        $stmt->bindParam(':wachtwoord', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':geverifieerd', $geverifieerd, PDO::PARAM_INT);

        // Voer de query uit
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Registratie voltooid! Je kunt nu inloggen.';
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['error'] = 'Er is iets misgegaan, probeer het opnieuw';
            header('Location: ../index.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Databasefout, probeer later opnieuw';
        header('Location: ../index.php');
        exit;
    }
}

// Sluit de databaseverbinding
$db->disconnect();
?>
