<?php

require_once 'form.php';
require_once 'helpers.php';

class User {
    public $fields;
    public $conn;
    public $helpers;

    // Include de form trait voor de createform functie
    use FormTrait;

    function __construct($fields = []) {
        $this->fields = $fields;
        $this->helpers = new Helpers();

        // Initialize de database
        include 'db.php';

        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Helper function om errors te laten zien onder de juiste labels
    public function displayError($name, $message) {
        echo "<script>document.getElementById('{$name}Error').style.display = 'block'</script>";
        echo "<script>document.getElementById('{$name}Error').innerText = '$message'</script>";
    }

    // Check of diegene een admin is
    public function checkAdmin($redirect) {
        if (!isset($_SESSION["role"]) || empty($_SESSION["role"] || $_SESSION["role"] !== "directie")) {
            header("Location: " . $redirect);
        }
    }

    // Redirect indien iemand logged in is
    public function redirectLoggedIn() {
        if (!empty($_SESSION["role"])) {
            $this->redirectRolePage($_SESSION["role"]);
        }
    }

    // Een switch om naar de correcte pagina te sturen
    public function redirectRolePage($role) {
        $roles = $this->helpers->getPageRoles();
        if (array_key_exists($role, $roles)) {
            header('Location: ' . $roles[$role]);
        } else {
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

    // "Delete" een customer zijn account, zet active naar false
    public function deleteCustomer($userID) {
        // Zet het als inactive
        $dataSql = $this->conn->prepare("UPDATE klant SET active = ? WHERE id = ?");
        $dataSql->execute([false, $userID]);

        $this->helpers->redirect("./klantenPagina.php");
    }

    // Delete het account van een werker
    public function deleteWorker($userID) {
        // Zet het als inactive
        $dataSql = $this->conn->prepare("DELETE FROM accounts WHERE ID = ?");
        $dataSql->execute([$userID]);

        $this->helpers->redirect("./personeelPagina.php");
    }

    // Update de password van de user op basis van het restore id
    public function updateUserPassword($newPass, $restoreID) {
        $updateSql = $this->conn->prepare("UPDATE accounts SET Wachtwoord = ?, restore_id = ? WHERE restore_id = ?  ");
        $updateSql->execute([$newPass, "", $restoreID]);
    }

    public function getBlocked($userID) {
        $dataSql = $this->conn->prepare("SELECT blocked FROM accounts WHERE id = ?");
        $dataSql->execute([$userID]);
        return $dataSql->fetch();
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
        $loginSql = $this->conn->prepare("SELECT id, Wachtwoord, Rol, blocked FROM accounts WHERE Gebruikersnaam = ?");
        $loginSql->execute([$_POST["username"]]);
        $newPassword = $loginSql->fetch();

        if (intval($newPassword["blocked"]) === 1) {
            $this->displayError("username", "Je bent geblokkeerd");
            return;
        }

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
            $loginSql = $this->conn->prepare("UPDATE accounts SET Gebruikersnaam = ?, Rol = ?, blocked = ? WHERE ID = ?");
            $loginSql->execute([$username, $rol, $_POST["blocked"], intval($updateID)]);
        } else {
            if (!empty($usernameCheck)) {
                $this->displayError("username", "There is already an account with this username. Please choose a different name");
            }

            // Insert nieuw personeel
            $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
            $loginSql = $this->conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (?, ?, ?, ?)");
            $loginSql->execute([$username, $password, $rol, 1]);
        }

        $this->helpers->redirect("./personeelPagina.php");
    }

    public function registerNewCustomer($postData, $updateID = -1) {
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

        $this->helpers->redirect("./klantenPagina.php");
    }
}