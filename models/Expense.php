<?php

class Expense {
    private int $id;
    private int $group_id;
    private int $payer_id;
    private float $amount;
    private string $receipt_url;
    private string $date;
    private array $participants = [];

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getGroupId(): int {
        return $this->group_id;
    }

    public function setGroupId(int $group_id): self {
        $this->group_id = $group_id;
        return $this;
    }

    public function getPayerId(): int {
        return $this->payer_id;
    }

    public function setPayerId(int $payer_id): self {
        $this->payer_id = $payer_id;
        return $this;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): self {
        $this->amount = $amount;
        return $this;
    }

    public function getReceiptUrl(): string {
        return $this->receipt_url;
    }

    public function setReceiptUrl(string $receipt_url): self {
        $this->receipt_url = $receipt_url;
        return $this;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): self {
        $this->date = $date;
        return $this;
    }

    public function getParticipants(): array {
        return $this->participants;
    }

    public function setParticipants(array $participants): self {
        $this->participants = $participants;
        return $this;
    }

    public function addParticipant(array $participant): self {
        $this->participants[] = $participant;
        return $this;
    }
}