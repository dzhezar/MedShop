<?php


namespace App\Controller;


use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayController extends AbstractController
{
    /**
     * @var OrdersRepository
     */
    private $ordersRepository;

    /**
     * PayController constructor.
     * @param OrdersRepository $ordersRepository
     */
    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function paypalPay($orderHash)
    {
        if($order = $this->ordersRepository->findOneBy(['hash' => $orderHash])) {
            return $this->render('pay/paypal.html.twig', ['order'=> $order]);
        }

        throw $this->createNotFoundException();
    }
}