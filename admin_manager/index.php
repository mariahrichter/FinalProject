<?php

require('../model/database.php');
require('../model/parent_db.php');
require('../model/parent_class.php');
require('../model/child_class.php');
require('../model/admin_db.php');
require('../model/alphabet_question.php');
require('../model/alphabet_answer.php');
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
if ($controllerChoice == 'display_all_parents') {
    $error_message = "";
    $parents = AdminDB::getAllParents();

    require_once("parent_list.php");
} else if ($controllerChoice == "edit_parent") {

    $parentId = filter_input(INPUT_POST, 'parent_id');
    //gets the parent for the page
    $parent = ParentDB::getParentById($parentId);
    //gets the children for the page
    $children = ParentDB::getAllChildrenByParentId($parentId);
    $error_message = "";

    include('edit_parent.php');
} else if ($controllerChoice == 'update_parent') {
    //get input data
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $roleId = filter_input(INPUT_POST, 'roleId');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');

    $parent = ParentDB::getParentById($parentId);
    $password = $parent->getPassword();

    $zip = filter_input(INPUT_POST, 'zip');
    $isActive = filter_input(INPUT_POST, 'isActive');

    //validate input
    if ($firstName == NULL || $lastName == FALSE || $phone == NULL ||
            $email == NULL || $zip == NULL) {
        $error = "Invalid parent data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //if valid create new parent object
        $parent = new ParentClass($parentId, $roleId, $firstName, $lastName, $phone, $email, $password, $zip, $isActive);
        //update the parent
        ParentDB::updateParent($parent);

        $error_message = "";
        $parents = AdminDB::getAllParents();

        require_once("parent_list.php");
    }
//allows user to update their password and processes it
} else if ($controllerChoice == 'update_parent_password') {

    $parentId = filter_input(INPUT_POST, 'parent_id');
    $parent = ParentDB::getParentById($parentId);
    $roleId = $parent->getRoleId();
    $firstName = $parent->getFirstName();
    $lastName = $parent->getLastName();
    $phone = $parent->getPhone();
    $email = $parent->getEmail();
    $zip = $parent->getZip();
    $isActive = $parent->getIsActive();
    //get input new password from form
    $password = filter_input(INPUT_POST, 'password');
    //get input new confirm password from form
    $password2 = filter_input(INPUT_POST, 'password2');

    //make sure there is a password.
    if ($password == NULL || $password2 == NULL) {
        $error = "Invalid password data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //make sure the passwords match
        if ($password == $password2) {
            //hash the new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //create new parent object
            $parent = new ParentClass($parentId, $roleId, $firstName, $lastName, $phone, $email, $hashed_password, $zip, $isActive);
            //update the parent
            ParentDB::updateParent($parent);
            $error_message = "";
            $parents = AdminDB::getAllParents();
            include('parent_list.php');
        }
        //if passwords do not match
        else {
            //display edit profile
            $parent = ParentDB::getParentById($parentId);
            $children = ParentDB::getAllChildrenByParentId($parentId);
            $error_message = "Passwords do not match. Try Again.";
            require_once "edit_parent.php";
        }
    }
} else if ($controllerChoice == 'update_child') {
    //get input data
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $childId = filter_input(INPUT_POST, 'child_id');
    $childUsername = filter_input(INPUT_POST, 'childUsername');
    $childBirthday = filter_input(INPUT_POST, 'childBirthday');
    $isActive = filter_input(INPUT_POST, 'isActive');

    //validate
    if ($childUsername == NULL || $childBirthday == NULL) {
        $error_message = "Invalid child data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //set child birthday to database form.
        $childBirthday = date("Y-m-d", strtotime(str_replace('/', '-', $childBirthday)));
        //create new child object
        $child = new ChildClass($childId, $parentId, $childUsername, $childBirthday, $isActive);
        //update the child
        ParentDB::updateChild($child);

        $error_message = "";
        $parents = AdminDB::getAllParents();

        require_once("parent_list.php");
    }
//displays the verify delete page
} else if ($controllerChoice == 'display_add_parent') {
    $error_message = "";
    require_once "add_parent.php";
} else if ($controllerChoice == 'add_parent') {
    //gets the input data
    $roleId = filter_input(INPUT_POST, 'roleId');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $password2 = filter_input(INPUT_POST, 'password2');
    $zip = filter_input(INPUT_POST, 'zip');
    $error_message = "";

    //validation for registering
    if ($firstName == NULL || $lastName == FALSE ||
            $zip == NULL || $phone == NULL ||
            $email == NULL || $password == NULL || $password2 == NULL) {
        $error_message = "Invalid parent data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        if ($password == $password2) {

            //hashes password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //new parent object
            $parent = new ParentClass(-1, $roleId, $firstName, $lastName, $phone, $email, $hashed_password, $zip, 1);

            //adds parent to database
            ParentDB::addParent($parent);
        } else {
            $error_message = "Passwords do not match.";
        }
    }

    $parents = AdminDB::getAllParents();

    //goes to parent list
    require_once "parent_list.php";
} else if ($controllerChoice == "add_child_form") {
    $error_message = "";
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $parent = ParentDB::getParentById($parentId);

    include('add_child.php');
} else if ($controllerChoice == 'add_child') {
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $childUsername = filter_input(INPUT_POST, 'username');
    $birthday = filter_input(INPUT_POST, 'birthday');


    //validation
    if ($parentId == NULL || $childUsername == NULL || $birthday == NULL) {
        $error_message = "Invalid child data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //new child object
        $child = new ChildClass(-1, $parentId, $childUsername, $birthday, 1);
        //adds the child to the parent
        ParentDB::addChildToParent($child);

        $error_message = "";
        $parents = AdminDB::getAllParents();
        include('parent_list.php');
    }
} else if ($controllerChoice == "display_add_alphabet_question") {
    $error_message = "";

    include('add_alphabet_question.php');
} else if ($controllerChoice == "add_alphabet_question") {
    $description = filter_input(INPUT_POST, 'description');
    $letter = filter_input(INPUT_POST, 'letter');
    $image = filter_input(INPUT_POST, 'image');

    if ($description == NULL || $letter == FALSE || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {

        $question = new AlphabetQuestion(-1, $description, $letter, $image, 1);

        //adds parent to database
        AdminDB::addAlphabetQuestion($question);
    }
} else if ($controllerChoice == "display_alphabet_question_list") {

    $questions = LearningDB::getAllAlphabetQuestions();


    include('alphabet_question_list.php');
} else if ($controllerChoice == "add_answer_form") {
    $questionId = filter_input(INPUT_POST, 'question_id');
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $error_message = "";

    include('add_alphabet_answer.php');
} else if ($controllerChoice == "add_alphabet_answer") {
    $questionId = filter_input(INPUT_POST, 'question_id');
    $description = filter_input(INPUT_POST, 'description');
    $image = filter_input(INPUT_POST, 'image');

    if ($description == NULL || $questionId == FALSE || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {

        $answer = new AlphabetAnswer(-1, $questionId, $description, $image, 1);

        //adds parent to database
        AdminDB::addAlphabetAnswer($answer);

        $questions = LearningDB::getAllAlphabetQuestions();
        
        include('alphabet_question_list.php');
    }
}
?>