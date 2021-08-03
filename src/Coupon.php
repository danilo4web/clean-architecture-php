<?php

namespace App;

class Coupon
{
    public function __construct(
        private string $code,
        private int $percentage
    ) {
    }

    public function getPercentage(): int
    {
        return $this->percentage;
    }
}
