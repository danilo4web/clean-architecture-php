<?php

namespace App;

class PlaceOrder
{
    private array $coupons;
    private array $orders;

    public function __construct()
    {
        $this->coupons = ['VALE20' => new Coupon('VALE20', 20)];
        $this->orders = [];
    }

    public function execute(array $input): array
    {
        $order = new Order($input['cpf']);

        foreach ($input['items'] as $item) {
            $order->addItem($item['description'], $item['price'], $item['quantity']);
        }

        if (isset($input['coupon'])) {
            if (isset($this->coupons[$input['coupon']])) {
                $order->addCoupon($this->coupons[$input['coupon']]);
            }
        }

        $total = $order->getTotal();
        $this->orders[] = $order;

        return ['total' => $total];
    }
}
