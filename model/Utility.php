<?php

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

    //fisher-yates shuffle algorithm for shuffling through an array without repeating a value
    public static function randomize($arr, $n) {
        // Start from the last element  
        // and swap one by one. We  
        // don't need to run for the 
        // first element that's why i > 0 
        for ($i = $n - 1; $i >= 0; $i--) {
            // Pick a random index 
            // from 0 to i 
            $j = rand(0, $i + 1);

            // Swap arr[i] with the  
            // element at random index 
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
        for ($i = 0; $i < $n; $i++) {
            $array = $arr[$i];
            
            echo $array." ";
            
        }
        
        return $array;
    }

}
