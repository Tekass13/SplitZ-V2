<?php

class Settlement {
    private $id;
    private $amount;
    private $date;
    private $payerId;
    private $payeeId;

    public function __construct($amount, $payerId, $payeeId) {
        $this->amount = $amount;
        $this->date = date('Y-m-d H:i:s');
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
    }

    // Getters and setters for each property
    public function getId() {
        return $this->id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPayerId() {
        return $this->payerId;
    }

    public function getPayeeId() {
        return $this->payeeId;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setPayerId($payerId) {
        $this->payerId = $payerId;
    }

    public function setPayeeId($payeeId) {
        $this->payeeId = $payeeId;
    }
}
?>