<?php

require('../model/database.php');
require('../model/parent_db.php');
require('../model/parent_class.php');
require('../model/child_class.php');
require('../model/admin_db.php');
require('../model/learning_db.php');
require('../model/alphabet_question.php');
require('../model/alphabet_answer.php');
session_start();
require('../model/Utility.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = '';
    }

}
if($controllerChoice == 'display_learning_options'){
    
    include('learning_options.php');
}
else if($controllerChoice == 'display_learn_alphabet'){
    $message = "";
    $questionId = rand(1,26);
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $answers = LearningDB::getAllAlphabetAnswers();
    
    include('learn_alphabet.php');
}else if ($controllerChoice == 'next_question'){
    $questionId = rand(1,26);
    $question = LearningDB::getAlphabetQuestionById($questionId);
    $answers = LearningDB::getAllAlphabetAnswers();
    $message = "";
    
    include('learn_alphabet.php');
    
}else if($controllerChoice == "answer_alphabet_question"){
    $questionId = filter_input(INPUT_POST, 'question_id');
    $answerId = filter_input(INPUT_POST, 'answer_id');
    $win = 0;
    $lose = 0;
    
    $answer = LearningDB::getAlphabetAnswerById($answerId);
    $answerQuestionId = $answer->getQuestionId();
    
    if($questionId == $answerQuestionId){
        $message = "CORRECT";
        $win++;
    }
    else{
        $message = "TRY AGAIN";
        $lose++;
    }
    
    $randQuestionId = rand(1,26);
    $question = LearningDB::getAlphabetQuestionById($randQuestionId);
    $answers = LearningDB::getAllAlphabetAnswers();
    include('learn_alphabet.php');
}


?>