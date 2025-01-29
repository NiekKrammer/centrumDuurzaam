<?php

require_once 'form.php';

class User {
    public $fields;
    public $conn;

    use FormTrait;

    function __construct($fields) {
        $this->fields = $fields;

        include './classes/db.php';

        $db = new Database();
        $this->conn = $db->getConn();
    }

    public function displayError($name, $message) {
        echo "<script>document.getElementById('{$name}Error').style.display = 'block'</script>";
        echo "<script>document.getElementById('{$name}Error').innerText = '$message'</script>";
    }

    public function redirectLoggedIn() {
        if (!empty($_SESSION["userID"])) {
            header("location: dashboard.php");
        }
    }

    public function redirectRolePage($role) {
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

        if (!password_verify($_POST["password"], $newPassword["wachtwoord"])) {
            $this->displayError("password", "Password does not match.");
            return;
        }

        $_SESSION["userID"] = $newPassword["personeel_id"];
        $_SESSION["role"] = $newPassword["rol"];

        redirectRolePage($newPassword["rol"]);
    }

    public function validateRegisterFields($postData) {
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
        $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $rol = htmlspecialchars($_POST["role"]);

        $registerSql = $this->conn->prepare("SELECT gebruikersnaam FROM personeel WHERE gebruikersnaam = ?");
        $registerSql->execute([$_POST["username"]]);
        $usernameCheck = $registerSql->fetch();

        if (!empty($usernameCheck)) {
            $this->displayError("There is already an account with this username. Please choose a different name");
        }    

        $loginSql = $conn->prepare("INSERT INTO accounts (Gebruikersnaam, Wachtwoord, Rol, Is_geverifieerd) VALUES (?, ?, ?, ?)");
        $loginSql->execute([$username, $password, $rol, 1]);
        $insertedID = $conn->lastInsertId();

        $_SESSION["userID"] = $insertedID;
        $_SESSION["role"] = 1;

        redirectRolePage($newPassword["rol"]);
    }
}