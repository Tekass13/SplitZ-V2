<?php

class Group {
    private $id;
    private $name;
    private $description;
    private $created_at;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
        $this->created_at = date('Y-m-d H:i:s');
    }

    // Getters and setters for each property
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
?>