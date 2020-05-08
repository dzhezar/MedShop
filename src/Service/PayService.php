<?php


namespace App\Service;


use App\Entity\Orders as Order;
use App\Strategy\Pay\PayStrategyInterface;

class PayService
{
    /** @var PayStrategyInterface[] $strategies */
    private $strategies;

    /**
     * PayService constructor.
     * @param $strategies
     */
    public function __construct($strategies)
    {
        $this->strategies = $strategies;
    }

    public function pay(Order $order)
    {
        foreach ($this->strategies as $strategy) {
            if($strategy->supports($order->getPayment())) {
                $strategy->pay($order);
            }
        }
    }
}