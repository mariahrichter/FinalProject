<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of learning_db
 *
 * @author Owner
 */
class LearningDB{
    //put your code here
    
        public static function getAllAlphabetQuestions() {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetquestion
                       ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $questions = array();
        foreach ($statement as $row) {
            $question = new AlphabetQuestion($row['id'],
                                     $row['description'],
                                     $row['letter'],
                                     $row['image'],
                                     $row['active']);
            $questions[] = $question;
        }
        return $questions;
    }
    
         public static function getAllAlphabetAnswers() {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetanswer
                       ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $answers = array();
        foreach ($statement as $row) {
            $answer = new AlphabetAnswer($row['id'],
                                     $row['questionId'],
                                     $row['description'],
                                     $row['image'],
                                     $row['active']);
            $answers[] = $answer;
        }
        return $answers;
    }
    //gets the current alphabet question
    public static function getAlphabetQuestionById($questionId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetquestion 
              WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $questionId);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row['id'] > 0) {
            $question = new AlphabetQuestion($row['id'], $row['description'], $row['letter'], $row['image'], $row['active']);
        } else {
            $question = new AlphabetQuestion(-1, "", "", "", 1);
        }

        return $question;
    }
    
    //gets the current alphabet answer
    public static function getAlphabetAnswerById($answerId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetanswer
              WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $answerId);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row['id'] > 0) {
            $answer = new AlphabetAnswer($row['id'], $row['questionId'], $row['description'], $row['image'], $row['active']);
        } else {
            $answer = new AlphabetAnswer(-1, "", "", "", 1);
        }

        return $answer;
    }
    
}
