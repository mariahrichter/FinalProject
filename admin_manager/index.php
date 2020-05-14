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

//displays the parent list page
if ($controllerChoice == 'display_all_parents') {
    $error_message = "";
    //gets all the parents for the list of all parents
    $parents = AdminDB::getAllParents();

    require_once("parent_list.php");

    //displays the edit parent page
} else if ($controllerChoice == "edit_parent") {
    //gets the parents id
    $parentId = filter_input(INPUT_POST, 'parent_id');
    //gets the parent for the page
    $parent = ParentDB::getParentById($parentId);
    //gets the children for the page
    $children = ParentDB::getAllChildrenByParentId($parentId);
    $error_message = "";

    include('edit_parent.php');

    //updates the parent in the database
} else if ($controllerChoice == 'update_parent') {
    //get input data
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $roleId = filter_input(INPUT_POST, 'roleId');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    //gets the parent by id
    $parent = ParentDB::getParentById($parentId);
    //gets the parents password to put into the parent object because 
    //we are not updated the password at this point
    $password = $parent->getPassword();
    $validForm = true;
    //get input data
    $zip = filter_input(INPUT_POST, 'zip');
    $isActive = filter_input(INPUT_POST, 'isActive');

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


    if($validForm) {
        $phone = $justNums;
        //if valid create new parent object without updating password and inserting current password
        $parent = new ParentClass($parentId, $roleId, $firstName, $lastName, $phone, $email, $password, $zip, $isActive);
        //update the parent
        ParentDB::updateParent($parent);

        //displays the parent list page after udating
        $error_message = "";
        $parents = AdminDB::getAllParents();

        require_once("parent_list.php");
    }else {

        $error_message = "Invalid parent data. Make sure all Fields are filled out.";
        include('../errors/error.php');
    }


//allows admin to update parent password and processes it
} else if ($controllerChoice == 'update_parent_password') {
    //get parent is
    $parentId = filter_input(INPUT_POST, 'parent_id');
    //get the current parent
    $parent = ParentDB::getParentById($parentId);
    //we aren't updating anything but the password so we get all previous data from the 
    //parent object
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

    //lets admin update child
} else if ($controllerChoice == 'update_child') {
    //get the parent id
    $parentId = filter_input(INPUT_POST, 'parent_id');
    //get the child id
    $childId = filter_input(INPUT_POST, 'child_id');
    //get input data
    $childUsername = filter_input(INPUT_POST, 'childUsername');
    $childBirthday = filter_input(INPUT_POST, 'childBirthday');
    $isActive = filter_input(INPUT_POST, 'isActive');
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
        $child = new ChildClass($childId, $parentId, $childUsername, $childBirthday, $isActive);
        //update the child
        ParentDB::updateChild($child);

        //display the parent list page
        $error_message = "";
        $parents = AdminDB::getAllParents();

        require_once("parent_list.php");
    }else{
        $error_message = "Invalid child data. Check all fields and try again.";
        include('../errors/error.php');
    }

//displays the verify delete page
} else if ($controllerChoice == 'display_add_parent') {
    $error_message = "";
    require_once "add_parent.php";

//lets admin add a new parent
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
    $validForm = true;

    //validation for registering
    if ($firstName == NULL || $lastName == FALSE ||
            $zip == NULL || $phone == NULL ||
            $email == NULL || $password == NULL || $password2 == NULL) {
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
//validation for zip
    if ($zip == 00000) {
        $validForm = false;
    }


    if ($validForm) {
        if ($password == $password2) {
            $phone = $justNums;
            //hashes password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //new parent object
            $parent = new ParentClass(-1, $roleId, $firstName, $lastName, $phone, $email, $hashed_password, $zip, 1);

            //adds parent to database
            ParentDB::addParent($parent);
        } else {
            $error_message = "Passwords do not match.";
        }
    }else {

        $error_message = "Invalid parent data. Make sure all Fields are filled out.";
        include('../errors/error.php');
    }

    $parents = AdminDB::getAllParents();

    //goes to parent list
    require_once "parent_list.php";

    //displays the add child page
} else if ($controllerChoice == "add_child_form") {
    $error_message = "";
    $parentId = filter_input(INPUT_POST, 'parent_id');
    $parent = ParentDB::getParentById($parentId);

    include('add_child.php');
    //allows admin to add a child to the parent
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

    //displays the add alphabet question page
} else if ($controllerChoice == "display_add_alphabet_question") {
    $error_message = "";

    include('add_alphabet_question.php');
    //allows admin to add a alphabet question
} else if ($controllerChoice == "add_alphabet_question") {
    //gets data
    $description = filter_input(INPUT_POST, 'description');
    $letter = filter_input(INPUT_POST, 'letter');
    $image = filter_input(INPUT_POST, 'image');

    //validates input
    if ($description == NULL || $letter == FALSE || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //creates new question with input data
        $question = new AlphabetQuestion(-1, $description, $letter, $image, 1);

        //adds question to database
        AdminDB::addAlphabetQuestion($question);
    }

    //displays the question list page
} else if ($controllerChoice == "display_alphabet_question_list") {
    //gets all questions from DB to display
    $questions = LearningDB::getAllAlphabetQuestions();

    include('alphabet_question_list.php');
    //displays the add answer to question page
} else if ($controllerChoice == "add_answer_form") {
    //gets the question id
    $questionId = filter_input(INPUT_POST, 'question_id');
    //gets the question by its id
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $error_message = "";

    include('add_alphabet_answer.php');
    //allows admin to add a answer the a question
} else if ($controllerChoice == "add_alphabet_answer") {
    //get question id
    $questionId = filter_input(INPUT_POST, 'question_id');
    //get input data
    $description = filter_input(INPUT_POST, 'description');
    $image = filter_input(INPUT_POST, 'image');

    //validates
    if ($description == NULL || $questionId == FALSE || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        //creates new question for the database with input data
        $answer = new AlphabetAnswer(-1, $questionId, $description, $image, 1);
        //adds parent to database
        AdminDB::addAlphabetAnswer($answer);

        //display question list page
        $questions = LearningDB::getAllAlphabetQuestions();

        include('alphabet_question_list.php');
    }

    //displays the answer to the corresponding question
} else if ($controllerChoice == "display_alphabet_answer") {
    //gets the question id
    $questionId = filter_input(INPUT_POST, 'question_id');
    //gets the answer to the question
    $answer = LearningDB::getAlphabetAnswerByQuestionId($questionId);
    //gets the question that matches the id
    $question = LearningDB::getAlphabetQuestionById($questionId);

    include('alphabet_answer.php');

    //displays the edit question page
} else if ($controllerChoice == "display_edit_question") {
    //gets the question id
    $questionId = filter_input(INPUT_POST, 'question_id');
    //gets the question with the same id
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $error_message = "";

    include('edit_alphabet_question.php');

    //displays the edit answer page 
} else if ($controllerChoice == "display_edit_answer") {
    //gets question id 
    $questionId = filter_input(INPUT_POST, 'question_id');
    //uses question id to get corresponding answer
    $answer = LearningDB::getAlphabetAnswerByQuestionId($questionId);
    //gets the question for matching id
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $error_message = "";

    include('edit_alphabet_answer.php');

    //allows admin to update questions
} else if ($controllerChoice == "update_question") {
    //gets question id for updating
    $questionId = filter_input(INPUT_POST, 'question_id');
    //get input data
    $description = filter_input(INPUT_POST, 'description');
    $letter = filter_input(INPUT_POST, 'letter');
    $image = filter_input(INPUT_POST, 'imagePath');
    $active = filter_input(INPUT_POST, 'isActive');

    //validates
    if ($description == NULL || $letter == FALSE || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {

        //creates updated question for inserting into database
        $question = new AlphabetQuestion($questionId, $description, $letter, $image, $active);

        //adds updated question to database
        AdminDB::updateAlphabetQuestion($question);
    }

    //displays question list
    $questions = LearningDB::getAllAlphabetQuestions();

    include('alphabet_question_list.php');

    //allows admin to update answers to questions
} else if ($controllerChoice == "update_answer") {
    //get the answer id for updating
    $answerId = filter_input(INPUT_POST, 'answer_id');
    //get input data
    $description = filter_input(INPUT_POST, 'description');
    $questionId = filter_input(INPUT_POST, 'question_id');
    $image = filter_input(INPUT_POST, 'imagePath');
    $active = filter_input(INPUT_POST, 'isActive');

    //validate
    if ($description == NULL || $image == NULL) {
        $error_message = "Invalid question data. Check all fields and try again.";
        include('../errors/error.php');
    } else {

        //creates a new answer object with updated data to insert into database
        $updatedAnswer = new AlphabetAnswer($answerId, $questionId, $description, $image, $active);

        //adds updated answer to database
        AdminDB::updateAlphabetAnswer($updatedAnswer);

        //displays the answer page
        $answer = LearningDB::getAlphabetAnswerByQuestionId($questionId);
        $question = LearningDB::getAlphabetQuestionById($questionId);

        include('alphabet_answer.php');
    }
}
