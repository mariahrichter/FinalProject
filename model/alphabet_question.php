<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of question
 *
 * @author Owner
 */
class AlphabetQuestion {
    //put your code here
    private $id;
    private $description;
    private $letter;
    private $image;
    private $isActive;
    
    
    function __construct($id, $description, $letter, $image, $isActive) {
        $this->id = $id;
        $this->description = $description;
        $this->letter = $letter;
        $this->image = $image;
        $this->isActive = $isActive;
    }

    function getStatusDescription() {

        if ($this->isActive == 1) {
            $status = "Active";
        } else {
            $status = "Deleted";
        }

        return $status;
    }

    function getNotStatusDescription() {

        if ($this->isActive == 1) {
            $status = "Deleted";
        } else {
            $status = "Active";
        }

        return $status;
    }

    function getNotIsActive() {
        $notIsActive = 2;

        if ($this->isActive == 1) {
            $notIsActive = 2;
        }

        if ($this->isActive == 2) {
            $notIsActive = 1;
        }

        return $notIsActive;
    }

    
    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getLetter() {
        return $this->letter;
    }

    function getImage() {
        return $this->image;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setLetter($letter) {
        $this->letter = $letter;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }


}
