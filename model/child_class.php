<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of child_class
 *
 * @author Owner
 */
class ChildClass {

    private $id;
    private $parentId;
    private $childUsername;
    private $birthday;
    private $isActive;

    function __construct($id, $parentId, $childUsername, $birthday, $isActive) {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->childUsername = $childUsername;
        $this->birthday = $birthday;
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

    function getParentId() {
        return $this->parentId;
    }

    function getChildUsername() {
        return $this->childUsername;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setParentId($parentId) {
        $this->parent1d = $parentId;
    }

    function setChildUsername($childUsername) {
        $this->childUsername = $childUsername;
    }

    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
