<?php

class Expense {
    private $id;
    private $amount;
    private $description;
    private $date;
    private $groupId;

    public function __construct($amount, $description, $groupId) {
        $this->amount = $amount;
        $this->description = $description;
        $this->date = date('Y-m-d H:i:s');
        $this->groupId = $groupId;
    }

    // Getters and setters for each property
    public function getId() {
        return $this->id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDate() {
        return $this->date;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }
}
?>