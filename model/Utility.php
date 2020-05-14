<?php

/**
 * Description of Utility
 *
 * @author Andy Banagsberg
 * Used for the WishList Project
 */
class Utility {

    public static function getUserRoleIdFromSession() {
        $roleID = 0;
        // Look at the session and see if we are
        // 0: Not Logged in
        // 1: End User
        // 2: Administrator
        // See if we have a session
        if (isset($_SESSION['Parent'])) {
            $roleID = $_SESSION['Parent']->getRoleId();
            // 1: End User, 2: Administroat
        }
        return $roleID;
    }

    public static function getUserIdFromSession() {
        $userID = 0;
        // Look at the session and see if we are
        // 0: Not Logged in
        // 1: End User
        // 2: Administrator
        // See if we have a session
        if (isset($_SESSION['Parent'])) {
            $userID = $_SESSION['Parent']->getId();
            // 1: End User, 2: Administroat
        }
        return $userID;
    }
}
