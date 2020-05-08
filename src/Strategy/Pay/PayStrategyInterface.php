<?php


namespace App\Strategy\Pay;


use App\Entity\Orders as Order;

interface PayStrategyInterface
{
    public function supports(string $type);

    public function pay(Order $order);
}