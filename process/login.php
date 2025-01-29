<?php
session_start();
require '../config/dbconnect.php';

// Initialiseer de databaseklasse en haal de connectie op
$db = new Database();
$conn = $db->getConnection();

if (isset($_POST['username'], $_POST['password'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['error'] = 'Vul zowel het gebruikersnaam- als wachtwoordveld in';
        header('Location: ../index.php');
        exit;
    }

    try {
        // Bereid de query voor met de opgehaalde verbinding
        $stmt = $conn->prepare('SELECT id, Wachtwoord, Rol FROM accounts WHERE Gebruikersnaam = :username');
        $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $stmt->execute();

        // Controleer of er een resultaat is
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $user['id'];
            $password = $user['Wachtwoord'];
            $role = $user['Rol'];

            // Vergelijk het wachtwoord
            if (password_verify($_POST['password'], $password)) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                $_SESSION['role'] = $role;

                // Stuur de gebruiker naar de juiste pagina op basis van de rol
                switch ($role) {
                    case 'directie':
                        header('Location: ../rollenPaginas/directiePagina.php');
                        exit;
                    case 'magazijn':
                        header('Location: ../rollenPaginas/magazijnMedewerkerPagina.php');
                        exit;
                    case 'winkelpersoneel':
                        header('Location: ../rollenPaginas/winkelpersoonPagina.php');
                        exit;
                    case 'chaffeur':
                        header('Location: ../rollenPaginas/chauffeurPagina.php');
                        exit;
                    default:
                        $_SESSION['error'] = "Onbekende rol: $role";
                        header('Location: ../index.php');
                        exit;
                }
            } else {
                $_SESSION['error'] = 'Ongeldig wachtwoord';
                header('Location: ../index.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Gebruiker niet gevonden';
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
