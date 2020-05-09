<?php


namespace App\Controller\Api;


use App\Entity\Orders;
use App\Service\Pay\PayPalService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayController extends AbstractController
{
    /**
     * @var PayPalService
     */
    private $payPalService;

    /**
     * PayController constructor.
     * @param PayPalService $payPalService
     */
    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function handlePayPalCallback($orderId, $paypalId)
    {
        return $this->json($this->payPalService->handle($paypalId, $orderId));
    }
}