<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Answer
 *
 * @author Owner
 */
class AlphabetAnswer {
    private $id;
    private $questionId;
    private $description;
    private $image;
    private $isActive;
    
    function __construct($id, $questionId, $description, $image, $isActive) {
        $this->id = $id;
        $this->questionId = $questionId;
        $this->description = $description;
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

    function getQuestionId() {
        return $this->questionId;
    }

    function getDescription() {
        return $this->description;
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

    function setQuestionId($questionId) {
        $this->questionId = $questionId;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }



}
