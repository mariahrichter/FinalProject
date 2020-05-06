<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_db
 *
 * @author Owner
 */
class AdminDB {

    //put your code here

    public static function getAllParents() {
        $db = Database::getDB();
        $query = 'SELECT * FROM parent
                       ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $parents = array();
        foreach ($statement as $row) {
            $parent = new ParentClass($row['id'], $row['roleId'], $row['firstName'], $row['lastName'], $row['phone'], $row['email'], $row['password'], $row['zip'], $row['active']);
            $parents[] = $parent;
        }
        return $parents;
    }

    public static function addAlphabetQuestion($question) {
        $db = Database::getDB();
        $query = 'INSERT INTO alphabetquestion
                 (description, letter, image)
              VALUES
                 (:description, :letter, :image)';
        $statement = $db->prepare($query);
        $statement->bindValue(':description', $question->getDescription());
        $statement->bindValue(':letter', $question->getLetter());
        $statement->bindValue(':image', $question->getImage());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function addAlphabetAnswer($answer) {
        $db = Database::getDB();
        $query = 'INSERT INTO alphabetanswer
                 (questionId, description, image)
              VALUES
                 (:questionId, :description, :image)';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionId', $answer->getQuestionId());
        $statement->bindValue(':description', $answer->getDescription());
        $statement->bindValue(':image', $answer->getImage());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function updateAlphabetQuestion($question) {
        $db = Database::getDB();
        $query = 'UPDATE alphabetquestion
                SET description = :description,
                    letter = :letter,
                    image = :image,
                    active = :active
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $question->getId());
        $statement->bindValue(':description', $question->getDescription());
        $statement->bindValue(':letter', $question->getLetter());
        $statement->bindValue(':image', $question->getImage());
        $statement->bindValue(':active', $question->getIsActive());
        $statement->execute();
        $statement->closeCursor();
    }

    public static function updateAlphabetAnswer($answer) {
        $db = Database::getDB();
        $query = 'UPDATE alphabetanswer
                SET questionId = :questionId,
                    description = :description,
                    image = :image,
                    active = :active
                WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $answer->getId());
        $statement->bindValue(':questionId', $answer->getQuestionId());
        $statement->bindValue(':description', $answer->getDescription());
        $statement->bindValue(':image', $answer->getImage());
        $statement->bindValue(':active', $answer->getIsActive());
        $statement->execute();
        $statement->closeCursor();
    }

}

?>