<?php

namespace App;

use App\Cpf;

class Order
{
    private Cpf $cpf;
    private array $items;
    private Coupon $coupon;

    public function __construct(string $cpf)
    {
        $this->cpf = new Cpf($cpf);
        $this->items = [];
    }

    public function addItem(string $description, int $price, int $quantity): void
    {
        $this->items[] = new OrderItem($description, $price, $quantity);
    }

    public function addCoupon(Coupon $coupon): void
    {
        $this->coupon = $coupon;
    }

    public function getTotal(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        if (isset($this->coupon)) {
            $total -= ($total * $this->coupon->getPercentage()) / 100;
        }
        return $total;
    }
}
