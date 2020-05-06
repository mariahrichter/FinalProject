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
if ($controllerChoice == 'display_learning_options') {
    $parentId = $_SESSION['ParentID'];
    $children = ParentDB::getAllActiveChildrenByParentId($parentId);

    include('learning_options.php');
} else if ($controllerChoice == 'display_learn_alphabet') {
    $message = "";

    $questionId = rand(1, 26);
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $answers = LearningDB::getAllAlphabetAnswers();

    include('learn_alphabet.php');
} else if ($controllerChoice == "answer_alphabet_question") {
    $questionId = filter_input(INPUT_POST, 'question_id');
    $answerId = filter_input(INPUT_POST, 'answer_id');
    $childId = $_SESSION['ChildID'];


    $progress = LearningDB::getProgressRecordByChildId($childId);
    
    if ($progress->getChildId() == 0) {
        $win = 0;
        $lose = 0;
        $total = 0;
        $progress = new ChildProgress(-1, $childId, $win, $lose, $total, 1);
        LearningDB::addProgressRecord($progress);
    } else {
        $win = $progress->getWin();
        $lose = $progress->getLose();
        $total = $progress->getTotalRounds();

    }
    
        $answer = LearningDB::getAlphabetAnswerById($answerId);
        $answerQuestionId = $answer->getQuestionId();

        if ($questionId == $answerQuestionId) {
            $message = "CORRECT";
            $addTotal = $total + 1;
            $addWin = $win + 1;
            $addWinProgress = new ChildProgress(-1, $childId, $addWin, $lose, $addTotal, 1);
            LearningDB::updateProgressRecord($addWinProgress);
        } else {
            $message = "INCORRECT";
            $addTotal = $total + 1;
            $addLose = $lose + 1;
            $addLoseProgress = new ChildProgress(-1, $childId, $win, $addLose, $addTotal, 1);
            LearningDB::updateProgressRecord($addLoseProgress);
        }
        
        $randQuestionId = rand(1, 26);
        $question = LearningDB::getAlphabetQuestionById($randQuestionId);
        $answers = LearningDB::getAllAlphabetAnswers();
        include('learn_alphabet.php');
} else if ($controllerChoice == "select_child") {
    $childId = filter_input(INPUT_POST, 'child_id');
    $_SESSION['ChildID'] = $childId;

    $message = "";
    $questionId = rand(1, 26);
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $answers = LearningDB::getAllAlphabetAnswers();


    include('learn_alphabet.php');
}
?>