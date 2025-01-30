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

    public function getLocationsHtml($compare = "") {
        $start = "<select id='locatie' name='locatie' required>";
        $locations = ["Selecteer Locatie", "Locatie A", "Locatie B", "Locatie C", "Locatie D", "Locatie E", "Locatie F", "Locatie G", "Locatie H", "Locatie I", "Locatie J", "Magazijn A", "Magazijn B", "Magazijn C"];

        for ($i = 0; $i < count($locations); $i++) {
            $location = $locations[$i];
            if ($compare === $location) {
                $start .= "<option value='$location' selected>$location</option>";
            } else {
                if ($i !== 0) {
                    $start .= "<option value='$location'>$location</option>";
                } else {
                    $start .= "<option value=''>$location</option>";
                }
            }
        }
        $start .= "</select>";

        return $start;
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