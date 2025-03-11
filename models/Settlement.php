<?php

class Settlement {
    private int $id;
    private int $group_id;
    private int $payer_id;
    private int $receiver_id;
    private float $amount;
    private string $status;
    private string $settled_at;

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

    public function getReceiverId(): int {
        return $this->receiver_id;
    }

    public function setReceiverId(int $receiver_id): self {
        $this->receiver_id = $receiver_id;
        return $this;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): self {
        $this->amount = $amount;
        return $this;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;
        return $this;
    }

    public function getSettledAt(): string {
        return $this->settled_at;
    }

    public function setSettledAt(string $settled_at): self {
        $this->settled_at = $settled_at;
        return $this;
    }
}