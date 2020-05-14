<?php

require('../model/database.php');
require('../model/parent_db.php');
require('../model/parent_class.php');
require('../model/child_class.php');
require('../model/admin_db.php');
require('../model/learning_db.php');
require('../model/alphabet_question.php');
require('../model/alphabet_answer.php');
require('../model/child_progress.php');
session_start();
require('../model/Utility.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = '';
    }
}

//displays the learning options to choose a player.
if ($controllerChoice == 'display_learning_options') {
    //gets the parent id from session for displaying parents active children
    $parentId = $_SESSION['ParentID'];
    //gets all of the parents active children
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);
    
    $error_message = "";
    
    
    if ($children == null){
        $error_message = "Please add a child to access game.";
    }
    include('learning_options.php');

    //allows user to select their profile then displays the alphabet game page
} else if ($controllerChoice == "select_child") {
    //gets the childs id
    $childId = filter_input(INPUT_POST, 'child_id');
    //sets that id into session
    $_SESSION['ChildID'] = $childId;

    //displays the learn alphabet game
    $correctMessage = "";
    $incorrectMessage = "";
    //gets a random number between 1 and 26 to use as the question id
    $questionId = rand(1, 26);
    //sets the random number as the question id to get a random question
    $question = LearningDB::getAlphabetQuestionById($questionId);
    //gets all the possible answers
    $answers = LearningDB::getAllAlphabetAnswers();


    include('learn_alphabet.php');
}else if ($controllerChoice == 'display_learn_alphabet') {
    $correctMessage = "";
    $incorrectMessage = "";

    //gets a random number between 1 and 26 to use as the question id
    $questionId = rand(1, 26);
    //sets the random number as the question id to get a random question
    $question = LearningDB::getAlphabetQuestionById($questionId);
    //gets all the possible answers
    $answers = LearningDB::getAllAlphabetAnswers();

    include('learn_alphabet.php');
    //runs everytime a user selects and answer (each run is considered a "round")
} else if ($controllerChoice == "answer_alphabet_question") {
    //gets the question id of the question for that round
    $questionId = filter_input(INPUT_POST, 'question_id');
    //gets the selected answer from that round
    $answerId = filter_input(INPUT_POST, 'answer_id');
    //gets the child's id from the session
    $childId = $_SESSION['ChildID'];
    $correctMessage = "";
    $incorrectMessage = "";

    //gets the progress record for the child in session for updating progress
    //for each round
    $progress = LearningDB::getProgressRecordByChildId($childId);
    
    //if the child has never played before than the child id will be 0
    if ($progress->getChildId() == 0) {
        //create new progress record for new player and set all values to 0
        $win = 0;
        $lose = 0;
        $total = 0;
        //creates the new progress record
        $progress = new ChildProgress(-1, $childId, $win, $lose, $total, 1);
        //inserts the new progress record into the database
        LearningDB::addProgressRecord($progress);
        
        //if the child id for the progress record does not equal 0 then
        //get the values of that record
    } else {
        $win = $progress->getWin();
        $lose = $progress->getLose();
        $total = $progress->getTotalRounds();

    }
    
        //get the selected answer by its id
        $answer = LearningDB::getAlphabetAnswerById($answerId);
        //get that answers question id
        $answerQuestionId = $answer->getQuestionId();

        //if the question id of the current round matches the question id of the current
        //selected question than the answer is correct
        if ($questionId == $answerQuestionId) {
            $correctMessage = "CORRECT";
            //add 1 to the total rounds of the game played
            $addTotal = $total + 1;
            //add 1 to the total wins
            $addWin = $win + 1;
            //add a win progress report by creating a new progress record with updated information
            $addWinProgress = new ChildProgress(-1, $childId, $addWin, $lose, $addTotal, 1);
            //add the updated record to the database
            LearningDB::updateProgressRecord($addWinProgress);
        } else {
            //else if the question id DOES NOT match the selected answer's question id
            //the answer selected was incorrect
            $incorrectMessage = "INCORRECT";
            //add 1 to total rounds played
            $addTotal = $total + 1;
            //add 1 to total losses
            $addLose = $lose + 1;
            //create a lose progress report by creating a new progress record with updated information
            $addLoseProgress = new ChildProgress(-1, $childId, $win, $addLose, $addTotal, 1);
            //add the updated record to the database
            LearningDB::updateProgressRecord($addLoseProgress);
        }
        
        //displays the learn alphabet game again
        $randQuestionId = rand(1, 26);
        $question = LearningDB::getAlphabetQuestionById($randQuestionId);
        $answers = LearningDB::getAllAlphabetAnswers();
        include('learn_alphabet.php');
        
     
} 
