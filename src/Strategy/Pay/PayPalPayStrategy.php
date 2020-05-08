<?php


namespace App\Strategy\Pay;


use App\Entity\Orders as Order;

class PayPalPayStrategy implements PayStrategyInterface
{

    public function supports(string $type)
    {
        return $type === Order::PAY_TYPE_PAYPAL;
    }

    public function pay(Order $order)
    {
        $data = $order->getOrderData();
        $data['products'] = \json_decode($data['products'], true);
    }
}