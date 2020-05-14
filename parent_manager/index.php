<?php

require('../model/database.php');
require('../model/parent_db.php');
require('../model/parent_class.php');
require('../model/child_class.php');
require('../model/child_progress.php');
require('../model/admin_db.php');
require('../model/learning_db.php');
session_start();
require('../model/Utility.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = '';
    }
}
//goes to the login page
if ($controllerChoice == 'login_parent_form') {
    $error_message = "";

    require_once("parent_login.php");

//processes the login information    
} else if ($controllerChoice == 'parent_process_login') {
    $error_message = "";
    //get email and password
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    //validate inputs
    if ($email == null || $password == null) {
        $error_message = "Please enter a valid email and password";
        include('parent_login.php');
    } else {

        //if inputs are valid 
        //get the user by email
        $parent = ParentDB::getParentByEmail($email);
        //get their id
        $ID = $parent->getId();
        //make sure they are an active profile i.e. not deleted
        $active = $parent->getIsActive();
        //get the hashed password saved in the database to match to the input password
        //for login
        $hashed_password = $parent->getPassword();

        //user must exists and input password must match hashed database password
        if ($ID > 0 && password_verify($password, $hashed_password) && $active == 1) {

            //for testing purposes to see whos logged in
            $parentName = $parent->getFirstName() . ' ' . $parent->getLastName();
            //set the session parent id to the one of the active logged in parent
            $_SESSION['ParentID'] = $ID;
            //sets the whole parent object into session
            $_SESSION['Parent'] = $parent;
            $login_message = "Login Succesful";

            //for displaying profile
            $parentId = $_SESSION["ParentID"];
            $parent = ParentDB::getParentById($parentId);
            $children = ParentDB::getAllActiveChildrenByParentId($parentId);
            include('parent_profile.php');
        } else {
            $error_message = "Incorrect email or password";
            include('parent_login.php');
        }
    }

    //displays the register parent page
} else if ($controllerChoice == 'register_parent_form') {
    $error_message = "";
    require_once "parent_register.php";

//processes the register parent data
} else if ($controllerChoice == 'add_parent') {
    //gets the input data
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    //hashes password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $zip = filter_input(INPUT_POST, 'zip');
    $validForm = true;
    $error_message = "";

    //validation for registering
    if ($firstName == NULL || $lastName == FALSE || $zip == NULL ||
            $phone == NULL || $email == NULL || $password == NULL) {

        $validForm = false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validForm = false;
    }

//validating phone number
    //eliminate every char except 0-9
    $justNums = preg_replace("/[^0-9]/", '', $phone);
    //eliminate leading 1 if its there
    if (strlen($justNums) == 11) {
        $justNums = preg_replace("/^1/", '', $justNums);
    }
    //if we don't have 10 digits left, it's probably not valid.
    if (strlen($justNums) != 10) {
        $validForm = false;
    }

    if ($zip == 00000) {
        $validForm = false;
    }

    if ($validForm) {
        $phone = $justNums;
        //new parent object
        $parent = new ParentClass(-1, 1, $firstName, $lastName, $phone, $email, $hashed_password, $zip, 1);
        //adds parent to database
        $parentId = ParentDB::addParent($parent);
        $_SESSION["ParentID"] = $parentId;
        require_once "add_child.php";
    } else {

        $error_message = "Invalid parent data. Make sure all Fields are filled out.";
        include('../errors/error.php');
    }

    //goes to add child page
//processes child information
} else if ($controllerChoice == 'add_child') {
    //gets data
    $parentId = $_SESSION["ParentID"];
    $childUsername = filter_input(INPUT_POST, 'username');
    $birthday = filter_input(INPUT_POST, 'birthday');
    $today = date('Y-m-d H:i:s',time());
    $validForm = true;
    
    if($birthday > $today){
        $validForm = false;
    }
    //vali

    //can add a child to the parent logged in
    if ($parentId > 0) {
        //validation
        if ($parentId == NULL || $childUsername == NULL || $birthday == NULL) {
            $validForm = false;
            
        } 
        
        if($validForm) {
            //new child object
            $child = new ChildClass(-1, $parentId, $childUsername, $birthday, 1);
            //adds the child to the parent
            ParentDB::addChildToParent($child);

            //for displaying the login page again
            if (!isset($_SESSION['Parent'])) {
                $error_message = "";

                include('parent_login.php');
            } else {
                $parentId = $_SESSION["ParentID"];
                //get parent by id for the page
                $parent = ParentDB::getParentById($parentId);
                //gets children for the page
                $children = ParentDB::getAllActiveChildrenByParentId($parentId);

                include('parent_profile.php');
            }
        }else {
            $error_message = "Invalid child data. Check all fields and try again.";
            include('../errors/error.php');
        }
    } else {
        $error_message = "No parent found";
        include('../errors/error.php');
    }

//displays the parents profile 
} else if ($controllerChoice == "display_parent_profile") {

    $parentId = $_SESSION["ParentID"];
    //get parent by id for the page
    $parent = ParentDB::getParentById($parentId);
    //gets children for the page
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);

    include('parent_profile.php');

//displays the edit profile page
} else if ($controllerChoice == "display_child_progress") {
    $parentId = $_SESSION["ParentID"];
    //gets children for the page
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);



    include('child_progress.php');
} else if ($controllerChoice == "edit_profile") {

    $parentId = filter_input(INPUT_POST, 'parent_id');
    //gets the parent for the page
    $parent = ParentDB::getParentById($parentId);
    //gets the children for the page
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);
    $error_message = "";

    include('edit_profile.php');

//displays the add child page for adding multiple children
} else if ($controllerChoice == 'add_another_child') {
    $error_message = "";
    include('add_child.php');

    //processes the information on the edit profile page
} else if ($controllerChoice == 'update_profile') {
    //get input data
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');

    $parent = ParentDB::getParentById($parentId);
    $password = $parent->getPassword();

    $zip = filter_input(INPUT_POST, 'zip');
    $validForm = true;

    //validate input
    if ($firstName == NULL || $lastName == FALSE || $phone == NULL ||
            $email == NULL || $zip == NULL) {
        $validForm = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validForm = false;
    }

//validating phone number
    //eliminate every char except 0-9
    $justNums = preg_replace("/[^0-9]/", '', $phone);
    //eliminate leading 1 if its there
    if (strlen($justNums) == 11) {
        $justNums = preg_replace("/^1/", '', $justNums);
    }
    //if we don't have 10 digits left, it's probably not valid.
    if (strlen($justNums) != 10) {
        $validForm = false;
    }

    if ($zip == 00000) {
        $validForm = false;
    }


    if ($validForm) {
        $phone = $justNums;
        //if valid create new parent object
        $parent = new ParentClass($parentId, 1, $firstName, $lastName, $phone, $email, $password, $zip, 1);
        //update the parent
        ParentDB::updateParent($parent);

        //get the child information for the parent profile
        $children = ParentDB::getAllActiveChildrenByParentId($parentId);
        require_once "parent_profile.php";
    } else {

        $error_message = "Invalid parent data. Make sure all Fields are filled out.";
        include('../errors/error.php');
    }



//allows user to update their password and processes it
} else if ($controllerChoice == 'update_password') {

    $parentId = filter_input(INPUT_POST, 'parent_id');
    $parent = ParentDB::getParentById($parentId);
    $firstName = $parent->getFirstName();
    $lastName = $parent->getLastName();
    $phone = $parent->getPhone();
    $email = $parent->getEmail();
    $zip = $parent->getZip();
    //get input new password from form
    $password = filter_input(INPUT_POST, 'password');
    //get input new confirm password from form
    $password2 = filter_input(INPUT_POST, 'password2');

    //make sure there is a password.
    if ($password == NULL || $password2 == NULL) {
        $error_message = "Invalid password data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //make sure the passwords match
        if ($password == $password2) {
            //hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //create new parent object
            $parent = new ParentClass($parentId, 1, $firstName, $lastName, $phone, $email, $hashed_password, $zip, 1);
            //update the parent
            ParentDB::updateParent($parent);

            $children = ParentDB::getAllActiveChildrenByParentId($parentId);
            require_once "parent_profile.php";
        }
        //if passwords do not match
        else {
            //display edit profile
            $parent = ParentDB::getParentById($parentId);
            $children = ParentDB::getAllActiveChildrenByParentId($parentId);
            $error_message = "Passwords do not match. Try Again.";
            require_once "edit_profile.php";
        }
    }
} else if ($controllerChoice == 'delete_child') {
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $childId = filter_input(INPUT_POST, 'child_id');
    ParentDB::deleteChildById($childId);

    //for displaying the profile
    $parent = ParentDB::getParentById($parentId);
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);
    require_once "parent_profile.php";


//processes the information for updating child
} else if ($controllerChoice == 'update_child') {
    //get input data
    $parentId = $_SESSION["ParentID"];
    $childId = filter_input(INPUT_POST, 'child_id');
    $childUsername = filter_input(INPUT_POST, 'childUsername');
    $childBirthday = filter_input(INPUT_POST, 'childBirthday');
    $today = date('Y-m-d H:i:s',time());
    $validForm = true;
    
    if($childBirthday > $today){
        $validForm = false;
    }
    //validate
    if ($childUsername == NULL || $childBirthday == NULL) {
        $validForm = false;
    } 
    
    if($validForm) {
        //set child birthday to database form.
        $childBirthday = date("Y-m-d", strtotime(str_replace('/', '-', $childBirthday)));
        //create new child object
        $child = new ChildClass($childId, $parentId, $childUsername, $childBirthday, 1);
        //update the child
        ParentDB::updateChild($child);

        //for displaying the profile
        $parent = ParentDB::getParentById($parentId);
        $children = ParentDB::getAllActiveChildrenByParentId($parentId);
        require_once "parent_profile.php";
    }else{
        $error_message = "Invalid child data. Check all fields and try again.";
        include('../errors/error.php');
    }
//displays the verify delete page
} else if ($controllerChoice == "verify_delete_profile") {

    require_once "delete_profile.php";

//processes delete profile   
} else if ($controllerChoice == "delete_profile") {
    $parentId = $_SESSION["ParentID"];
    //sets all of parent's children to inactive
    ParentDB::deleteChildByParentId($parentId);
    //sets the parent to inactive
    ParentDB::deleteParentById($parentId);
    //kill the session and display the home page
    session_destroy();
    require_once "../index.php";
}//logs parent out of page   
else if ($controllerChoice == "logOut") {
    session_destroy();
    require_once "../index.php";
}
?>