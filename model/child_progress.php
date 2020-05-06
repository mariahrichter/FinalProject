<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of child_progress
 *
 * @author Owner
 */
class ChildProgress {
    //put your code here
    private $id;
    private $childId;
    private $win;
    private $lose;
    private $totalRounds;
    private $isActive;
    
    function __construct($id, $childId, $win, $lose, $totalRounds, $isActive) {
        $this->id = $id;
        $this->childId = $childId;
        $this->win = $win;
        $this->lose = $lose;
        $this->totalRounds = $totalRounds;
        $this->isActive = $isActive;
    }

    function getId() {
        return $this->id;
    }

    function getChildId() {
        return $this->childId;
    }

    function getWin() {
        return $this->win;
    }

    function getLose() {
        return $this->lose;
    }

    function getTotalRounds() {
        return $this->totalRounds;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setChildId($childId) {
        $this->childId = $childId;
    }

    function setWin($win) {
        $this->win = $win;
    }

    function setLose($lose) {
        $this->lose = $lose;
    }

    function setTotalRounds($totalRounds) {
        $this->totalRounds = $totalRounds;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }


}
