<?php


namespace App\Service;


use App\DataMapper\Order\OrderMapper;
use App\Entity\Orders;
use App\Model\FormModel\CheckoutModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CheckoutService
{
    /**
     * @var SessionCartService
     */
    private $sessionCartService;
    /**
     * @var CartService
     */
    private $cartService;
    /**
     * @var OrderMapper
     */
    private $orderMapper;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PayService
     */
    private $payService;

    /**
     * CheckoutService constructor.
     * @param SessionCartService $sessionCartService
     * @param CartService $cartService
     * @param OrderMapper $orderMapper
     * @param EntityManagerInterface $entityManager
     * @param PayService $payService
     */
    public function __construct(
        SessionCartService $sessionCartService,
        CartService $cartService,
        OrderMapper $orderMapper,
        EntityManagerInterface $entityManager,
        PayService $payService
    ) {
        $this->sessionCartService = $sessionCartService;
        $this->cartService = $cartService;
        $this->orderMapper = $orderMapper;
        $this->entityManager = $entityManager;
        $this->payService = $payService;
    }

    public function create(CheckoutModel $checkoutModel)
    {
        $order = $this->orderMapper->modelToEntity($checkoutModel);
        $order->setPayStatus(Orders::STATUS_CREATED);
        $order->setOrderData($this->cartService->getAll($checkoutModel->getLanguage(), true, true));

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->payService->pay($order);
    }
}