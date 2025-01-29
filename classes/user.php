<?php

require_once 'form.php';

class User {
    public $fields;
    public $conn;

    use FormTrait;

    function __construct($fields = []) {
        $this->fields = $fields;

        include './classes/db.php';

        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function displayError($name, $message) {
        echo "<script>document.getElementById('{$name}Error').style.display = 'block'</script>";
        echo "<script>document.getElementById('{$name}Error').innerText = '$message'</script>";
    }

    public function redirectLoggedIn() {
        if (!empty($_SESSION["role"])) {
            $this->redirectRolePage($_SESSION["role"]);
        }
    }

    public function redirectRolePage($role) {
        switch ($role) {
            case 'directie':
                header('Location: /rollenPaginas/directiePagina.php');
                exit;
            case 'magazijn':
                header('Location: /rollenPaginas/magazijnMedewerkerPagina.php');
                exit;
            case 'winkelpersoneel':
                header('Location: /rollenPaginas/winkelpersoonPagina.php');
                exit;
            case 'chaffeur':
                header('Location: /rollenPaginas/chauffeurPagina.php');
                exit;
            default:
                $_SESSION['error'] = "Onbekende rol: $role";
                header('Location: ../index.php');
                exit;
        }
    }

    public function getEditData($fields, $table, $where, $params) {
        $dataSql = $this->conn->prepare("SELECT " . $fields . " FROM " . $table . " WHERE " . $where);
        $dataSql->execute($params);
        return $dataSql->fetch();
    }


    public function validateLoginFields($postData) {
        $isEmpty = false;
    
        foreach ($this->fields as $field) {
            if (!isset($_POST[$field["name"]]) || empty($_POST[$field["name"]])) {
                $isEmpty = true;
                $this->displayError($field["name"], $field["formatted"] . " is leeg.");
            }
        }
    
        if ($isEmpty) {
            return;
        }

        $loginSql = $this->conn->prepare("SELECT id, Wachtwoord, Rol FROM accounts WHERE Gebruikersnaam = ?");
        $loginSql->execute([$_POST["username"]]);
        $newPassword = $loginSql->fetch();

        if (empty($newPassword)) {
            $this->displayError("username", "No account with this username.");
            return;
        }

        if (!password_verify($_POST["password"], $newPassword["Wachtwoord"])) {
            $this->displayError("password", "Password does not match.");
            return;
        }

        $_SESSION["userID"] = $newPassword["id"];
        $_SESSION["role"] = $newPassword["Rol"];

        $this->redirectRolePage($newPassword["Rol"]);
    }

    public function validateWorkerFields($postData, $updateID = -1) {
        $isEmpty = false;
        
        foreach ($this->fields as $field) {
            if (!isset($_POST[$field["name"]]) || empty($_POST[$field["name"]])) {
                $isEmpty = true;
                $this->displayError($field["name"], $field["formatted"] . " is leeg.");
            }
        }

        if ($isEmpty) {
            return;
        }
        
        $username = htmlspecialchars($_POST["username"]);
        $rol = htmlspecialchars($_POST["role"]);
        
        $registerSql = $this->conn->prepare("SELECT Gebruikersnaam FROM accounts WHERE Gebruikersnaam = ?");
        $registerSql->execute([$_POST["username"]]);
        $usernameCheck = $registerSql->fetch();
        
        if ($updateID !== -1) {
            $loginSql = $this->conn->prepare("UPDATE accounts SET Gebruikersnaam = ?, Rol = ? WHERE ID = ?");
            $loginSql->execute([$username, $rol, intval($updateID)]);
        } else {
            if (!empty($usernameCheck)) {
                $this->displayError("username", "There is already an account with this username. Please choose a different name");
            }

            $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
            $loginSql = $this->conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (?, ?, ?, ?)");
            $loginSql->execute([$username, $password, $rol, 1]);
        }

    }

    public function validateCustomerFields($postData, $setSession = true) {
        $isEmpty = false;
        
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

        $registerSql = $this->conn->prepare("SELECT email FROM klant WHERE email = ?");
        $registerSql->execute([$email]);
        $emailCheck = $registerSql->fetch();

        
        if ($updateID !== -1) {
            $loginSql = $this->conn->prepare("UPDATE klant SET naam = ?, adres = ?, plaats = ?, telefoon = ?, email = ? WHERE ID = ?");
            $loginSql->execute([$_POST["name"], $_POST["address"], $_POST["place"], $_POST["telephone"], $email, intval($updateID)]);
        } else {
            if (!empty($emailCheck)) {
                $this->displayError("email", "There is already an account with this email. Please choose a different email");
            }

            $loginSql = $this->conn->prepare("INSERT INTO klant (naam, adres, plaats, telefoon, email) VALUES (?, ?, ?, ?, ?)");
            $loginSql->execute([$_POST["name"], $_POST["address"], $_POST["place"], $_POST["telephone"], $email]);
        }
    }
}