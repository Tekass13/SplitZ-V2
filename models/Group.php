<?php

class Group {
    private int $id;
    private string $name;
    private int $created_by;
    private string $created_at;
    private array $members = [];

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getCreatedBy(): int {
        return $this->created_by;
    }

    public function setCreatedBy(int $created_by): self {
        $this->created_by = $created_by;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self {
        $this->created_at = $created_at;
        return $this;
    }

    public function getMembers(): array {
        return $this->members;
    }

    public function setMembers(array $members): self {
        $this->members = $members;
        return $this;
    }

    public function addMember(User $member): self {
        $this->members[] = $member;
        return $this;
    }
}