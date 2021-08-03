<?php

namespace App;

class OrderItem
{
    public function __construct(
        private string $description,
        private int $price,
        private int $quantity
    ) {
    }

    public function getTotal(): int
    {
        return $this->price * $this->quantity;
    }
}
