<?php

class Helpers {
    public function redirect($location) {
        header("location: " + $location);
    }

    public function checkRoleAccess($role, $location) {
        if ($role !== $_SESSION["role"]) {
            header("location: " + $location);
        }
    }

    public function userIsLoggedIn($redirectUrl) {
        if (!empty($_SESSION["userID"])) {
            return true;
            if ($redirectUrl) {
                header("location: " . $redirectUrl);
            }
        }

        return false;
    }
}