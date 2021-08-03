<?php

namespace Tests\App\Service;

use App\Coupon;
use PHPUnit\Framework\TestCase;
use App\Order;
use UnexpectedValueException;

class OrderTest extends TestCase
{
    private Order $order;

    public function setUp(): void
    {
    }

    /**
     * @dataProvider generateInValidCPFProvider
     */
    public function testShouldNotMakeOrderWithAnInvalidCPF(string $cpf): void
    {
        self::expectException(UnexpectedValueException::class);
        (new Order($cpf));
    }

    public function generateInValidCPFProvider(): array
    {
        return [
            [
                "0098798999990",
                "00000000000",
                "12312312312",
                "86446422799",
                "a1720489726",
                "B1720489726",
                "B17204897261111",
            ]
        ];
    }

    /**
     * @dataProvider generateValidCPFProvider
     */
    public function testShouldMakeOrderWithThreeItems(string $cpf): void
    {
        $order = new Order($cpf);
        $order->addItem("Guitarra", 1000, 2);
        $order->addItem("Amplificador", 5000, 1);
        $order->addItem("Guitarra", 30, 3);
        $total = $order->getTotal();
        self::assertSame($total, 7090);
    }

    /**
     * @dataProvider generateValidCPFProvider
     */
    public function testShouldMakeOrderWithDiscountCoupon(string $cpf): void
    {
        $order = new Order($cpf);
        $order->addItem("Guitarra", 1000, 2);
        $order->addItem("Amplificador", 5000, 1);
        $order->addItem("Guitarra", 30, 3);

        $cupom = new Coupon("VALE20", 20);
        $order->addCoupon($cupom);

        $total = $order->getTotal();
        self::assertSame($total, 5672);
    }

    public function generateValidCPFProvider(): array
    {
        return [
            [
                "490.633.560-80",
                "153.404.350-08",
                "49063356080",
            ]
        ];
    }
}
