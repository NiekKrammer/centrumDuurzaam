<?php

@session_start();

class Helpers {
    // Helper functie om te redirecten
    public function redirect($location) {
        header("location: " . $location);
    }

    // Check access op basis van rollen
    public function checkRoleAccess($role, $location) {
        if ($role !== $_SESSION["role"]) {
            header("location: " . $location);
        }
    }

    // Check of diegene logged in is
    public function userIsLoggedIn($redirectUrl) {
        if (!empty($_SESSION["userID"])) {
            return true;
            if ($redirectUrl) {
                header("location: " . $redirectUrl);
            }
        }

        return false;
    }

    public function checkAccess($roles, $redirect) {
        if (isset($_SESSION["role"]) && !empty($_SESSION["role"])) {
            if (!in_array($_SESSION["role"], $roles)) {
                $this->redirect($redirect);
            }
        } else {
            $this->redirect($redirect);
        }
    }

    // Pak de page roles en paginas
    public function getPageRoles() {
        return [
        "directie" => "./rollenPaginas/directiePagina.php", 
        "magazijn" => "./rollenPaginas/magazijnMedewerkerPagina.php", 
        "winkelpersoneel" => "./rollenPaginas/winkelpersoonPagina.php",
        "chauffeur" => "./rollenPaginas/chauffeurPagina.php"
        ];
    }
}