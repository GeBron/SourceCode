<?php
class UserValidator {
    function validateFullUser($user) {
        if ($this->nameUnchanged($user) ||
                $this->nameNotInDB()) return TRUE;
        return FALSE;
    }

    private function nameUnchanged($user) {
        return $_POST['username'] == $user->getUsername();
    }

    private function nameNotInDB() {
        // Query the database, return TRUE if there is no user
        // with a name corresponding to $_POST['username'])
    }
}
