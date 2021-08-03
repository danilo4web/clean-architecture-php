<?php

namespace Tests\App;

use App\PlaceOrder;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testShouldMakeAnOrder()
    {
        $input = [
            'cpf' => "778.278.412-36",
            'items' => [
                ['description' => 'Guitarra', 'price' => 1000, 'quantity' => 2],
                ['description' => 'Amplificador', 'price' => 5000, 'quantity' => 1],
                ['description' => 'Cabo', 'price' => 30, 'quantity' => 3],
            ],
            'coupon' => "VALE20"
        ];
        $placeOrder = new PlaceOrder();
        $output = $placeOrder->execute($input);
        self::assertEquals($output['total'], 5672);
    }
}
