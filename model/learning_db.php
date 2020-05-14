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
class LearningDB {

    //put your code here

    public static function getAllAlphabetQuestions() {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetquestion
                       ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $questions = array();
        foreach ($statement as $row) {
            $question = new AlphabetQuestion($row['id'], $row['description'], $row['letter'], $row['image'], $row['active']);
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
            $answer = new AlphabetAnswer($row['id'], $row['questionId'], $row['description'], $row['image'], $row['active']);
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

    public static function getAlphabetAnswerByQuestionId($questionId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM alphabetanswer
              WHERE questionId = :questionId';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionId', $questionId);
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
    
    public static function getProgressRecordByChildId($childId) {
        $db = Database::getDB();
        $query = 'SELECT * FROM childprogress
              WHERE childId = :childId';
        $statement = $db->prepare($query);
        $statement->bindValue(':childId', $childId);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        if ($row['childId'] > 0) {
            $progress = new ChildProgress($row['id'], $row['childId'], $row['win'], $row['lose'], $row['totalRounds'], $row['active']);
        } else {
            $progress = new ChildProgress(-1, 0, 0, 0, 0, 1);
        }

        return $progress;
    }

    public static function addProgressRecord($progress) {
        $db = Database::getDB();
        $query = 'INSERT INTO childprogress
                 (childId, win, lose, totalRounds)
              VALUES
                 (:childId, :win, :lose, :totalRounds)';
        $statement = $db->prepare($query);
        $statement->bindValue(':childId', $progress->getChildId());
        $statement->bindValue(':win', $progress->getWin());
        $statement->bindValue(':lose', $progress->getLose());
        $statement->bindValue(':totalRounds', $progress->getTotalRounds());
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function updateProgressRecord($progress) {
        $db = Database::getDB();
        $query = 'UPDATE childprogress
                SET win = :win,
                    lose = :lose,
                    totalRounds = :totalRounds,
                    dateMod = now()
                WHERE childId = :childId';

        $statement = $db->prepare($query);
        $statement->bindValue(':childId', $progress->getChildId());
        $statement->bindValue(':win', $progress->getWin());
        $statement->bindValue(':lose', $progress->getLose());
        $statement->bindValue(':totalRounds', $progress->getTotalRounds());
        $statement->execute();
        $statement->closeCursor();
    }
    
    

}
