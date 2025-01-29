<?php

require_once 'form.php';

class User {
    public $fields;
    public $conn;

    // Include de form trait voor de createform functie
    use FormTrait;

    function __construct($fields = []) {
        $this->fields = $fields;

        // Initialize de database
        include './classes/db.php';

        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Helper function om errors te laten zien onder de juiste labels
    public function displayError($name, $message) {
        echo "<script>document.getElementById('{$name}Error').style.display = 'block'</script>";
        echo "<script>document.getElementById('{$name}Error').innerText = '$message'</script>";
    }

    // Redirect indien iemand logged in is
    public function redirectLoggedIn() {
        if (!empty($_SESSION["role"])) {
            $this->redirectRolePage($_SESSION["role"]);
        }
    }

    // Een switch om naar de correcte pagina te sturen
    public function redirectRolePage($role) {
        switch ($role) {
            case 'directie':
                header('Location: ./rollenPaginas/directiePagina.php');
                exit;
            case 'magazijn':
                header('Location: ./rollenPaginas/magazijnMedewerkerPagina.php');
                exit;
            case 'winkelpersoneel':
                header('Location: ./rollenPaginas/winkelpersoonPagina.php');
                exit;
            case 'chaffeur':
                header('Location: ./rollenPaginas/chauffeurPagina.php');
                exit;
            default:
                $_SESSION['error'] = "Onbekende rol: $role";
                header('Location: ../index.php');
                exit;
        }
    }

    // Krijg de data om een edit uit te voeren
    public function getEditData($fields, $table, $where, $params) {
        $dataSql = $this->conn->prepare("SELECT " . $fields . " FROM " . $table . " WHERE " . $where);
        $dataSql->execute($params);
        return $dataSql->fetch();
    }

    // Delete een account
    public function deleteAccount($table, $where, $params) {
        $dataSql = $this->conn->prepare("DELETE FROM " . $table . " WHERE " . $where);
        $dataSql->execute($params);
        return $dataSql->fetch();
    }

    // Maak een speciale link en zet die in de database
    public function createSpecialLink($userID) {
        $uniqueID = uniqid();
        $specialLink = $_SERVER["SERVER_NAME"] . "/" . explode("/", $_SERVER["REQUEST_URI"])[1] . "/restore.php?id=" . $uniqueID;

        $updateSql = $this->conn->prepare("UPDATE accounts SET restore_id = ? WHERE ID = ?");
        $updateSql->execute([$uniqueID, $userID]);

        return $specialLink;
    }

    // Update de password van de user op basis van het restore id
    public function updateUserPassword($newPass, $restoreID) {
        $updateSql = $this->conn->prepare("UPDATE accounts SET Wachtwoord = ?, restore_id = ? WHERE restore_id = ?  ");
        $updateSql->execute([$newPass, "", $restoreID]);

        return true;
    }

    // Validate login velden voor login.php
    public function loginWorker($postData) {
        $isEmpty = false;
    
        // Loop door alle fields heen en check of ze leeg zijn
        foreach ($this->fields as $field) {
            if (!isset($_POST[$field["name"]]) || empty($_POST[$field["name"]])) {
                $isEmpty = true;
                $this->displayError($field["name"], $field["formatted"] . " is leeg.");
            }
        }
    
        if ($isEmpty) {
            return;
        }

        // Pak alle data uit database
        $loginSql = $this->conn->prepare("SELECT id, Wachtwoord, Rol FROM accounts WHERE Gebruikersnaam = ?");
        $loginSql->execute([$_POST["username"]]);
        $newPassword = $loginSql->fetch();

        // Check of er uberhaupt een account is
        if (empty($newPassword)) {
            $this->displayError("username", "No account with this username.");
            return;
        }

        // Verify de password met welke in de database zit
        if (!password_verify($_POST["password"], $newPassword["Wachtwoord"])) {
            $this->displayError("password", "Password does not match.");
            return;
        }

        // Update session
        $_SESSION["userID"] = $newPassword["id"];
        $_SESSION["role"] = $newPassword["Rol"];

        $this->redirectRolePage($newPassword["Rol"]);
    }


    public function registerNewWorker($postData, $updateID = -1) {
        $isEmpty = false;
        
        // Loop door alle fields heen en check of ze leeg zijn
        foreach ($this->fields as $field) {
            if (!isset($_POST[$field["name"]]) || empty($_POST[$field["name"]])) {
                $isEmpty = true;
                $this->displayError($field["name"], $field["formatted"] . " is leeg.");
            }
        }

        if ($isEmpty) {
            return;
        }
        
        // Pak de variables uit de post en gebruik htmlspecialchars tegen xxs
        $username = htmlspecialchars($_POST["username"]);
        $rol = htmlspecialchars($_POST["role"]);
        
        // Check of personeel een account heeft
        $registerSql = $this->conn->prepare("SELECT Gebruikersnaam FROM accounts WHERE Gebruikersnaam = ?");
        $registerSql->execute([$_POST["username"]]);
        $usernameCheck = $registerSql->fetch();
        
        // Als updateid niet -1 is dan is dit een update actie 
        if ($updateID !== -1) {
            // Update database
            $loginSql = $this->conn->prepare("UPDATE accounts SET Gebruikersnaam = ?, Rol = ? WHERE ID = ?");
            $loginSql->execute([$username, $rol, intval($updateID)]);
        } else {
            if (!empty($usernameCheck)) {
                $this->displayError("username", "There is already an account with this username. Please choose a different name");
            }

            // Insert nieuw personeel
            $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
            $loginSql = $this->conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (?, ?, ?, ?)");
            $loginSql->execute([$username, $password, $rol, 1]);
        }

    }

    public function registerNewCustomer($postData, $setSession = true) {
        $isEmpty = false;
        
        // Loop door alle fields heen en check of ze leeg zijn
        foreach ($this->fields as $field) {
            if (!isset($_POST[$field["name"]]) || empty($_POST[$field["name"]])) {
                $isEmpty = true;
                $this->displayError($field["name"], $field["formatted"] . " is leeg.");
            }
        }

        if ($isEmpty) {
            return;
        }
        
        $email = htmlspecialchars($_POST["email"]);

        // Check of er een account is
        $registerSql = $this->conn->prepare("SELECT email FROM klant WHERE email = ?");
        $registerSql->execute([$email]);
        $emailCheck = $registerSql->fetch();

        // Als updateid niet -1 is dan is dit een update actie 
        if ($updateID !== -1) {
            // Update database
            $loginSql = $this->conn->prepare("UPDATE klant SET naam = ?, adres = ?, plaats = ?, telefoon = ?, email = ? WHERE ID = ?");
            $loginSql->execute([$_POST["name"], $_POST["address"], $_POST["place"], $_POST["telephone"], $email, intval($updateID)]);
        } else {
            if (!empty($emailCheck)) {
                $this->displayError("email", "There is already an account with this email. Please choose a different email");
            }

            // Insert een nieuwe klant
            $loginSql = $this->conn->prepare("INSERT INTO klant (naam, adres, plaats, telefoon, email) VALUES (?, ?, ?, ?, ?)");
            $loginSql->execute([$_POST["name"], $_POST["address"], $_POST["place"], $_POST["telephone"], $email]);
        }
    }
}