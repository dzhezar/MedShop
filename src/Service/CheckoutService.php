<?php


namespace App\Service;


use App\DataMapper\Order\OrderMapper;
use App\Entity\Orders;
use App\Model\FormModel\CheckoutModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @var MailService
     */
    private $mailService;

    /**
     * CheckoutService constructor.
     * @param SessionCartService $sessionCartService
     * @param CartService $cartService
     * @param OrderMapper $orderMapper
     * @param EntityManagerInterface $entityManager
     * @param MailService $mailService
     */
    public function __construct(
        SessionCartService $sessionCartService,
        CartService $cartService,
        OrderMapper $orderMapper,
        EntityManagerInterface $entityManager,
        MailService $mailService
    ) {
        $this->sessionCartService = $sessionCartService;
        $this->cartService = $cartService;
        $this->orderMapper = $orderMapper;
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
    }

    public function create(CheckoutModel $checkoutModel, Request $request)
    {
        $order = $this->orderMapper->modelToEntity($checkoutModel);
        $order->setPayStatus(Orders::STATUS_CREATED);
        $order->setOrderData($this->cartService->getAll($checkoutModel->getLanguage(), true, true));
        $order->setHash($this->hashOrder());
        $order->setDateCreated(new \DateTime());
        $order->setDateUpdated(new \DateTime());

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        try {
            $this->mailService->sendNewOrderMail($order);
        } catch (\Exception $exception) {}


        $orders = \json_decode($request->cookies->get('orders', '{}'), true);
        array_unshift($orders, $order->getHash());

        $cookie = new Cookie('orders', \json_encode($orders));

        $response = new JsonResponse(['hash' => $order->getHash()]);

        $response->headers->setCookie($cookie);


        return $response;
    }

    private function hashOrder()
    {
        return md5(uniqid((new \DateTime())->format('Y-m-d H:i:s')));
    }
}