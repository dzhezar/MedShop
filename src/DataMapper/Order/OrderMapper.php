<?php


namespace App\DataMapper\Order;


use App\Entity\Orders as Order;
use App\Model\FormModel\CheckoutModel;
use App\Model\OutputModel\OrderModel;
use App\Service\LanguageService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderMapper
{
    const ARRAY_STATUSES = [
        'ru' => [
            Order::STATUS_CREATED => 'Ожидает оплаты',
            Order::STATUS_FAILED_PAYMENT => 'Неуспешная оплата',
            Order::STATUS_SUCCESS_PAYMENT => 'Успешная оплата'
        ],
        'en' => [
            Order::STATUS_CREATED => 'Waiting for pay',
            Order::STATUS_FAILED_PAYMENT => 'Failed payment',
            Order::STATUS_SUCCESS_PAYMENT => 'Success payment'
        ]
    ];
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * OrderMapper constructor.
     * @param LanguageService $languageService
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(LanguageService $languageService, UrlGeneratorInterface $urlGenerator)
    {
        $this->languageService = $languageService;
        $this->urlGenerator = $urlGenerator;
    }

    public function modelToEntity(CheckoutModel $checkoutModel)
    {
        return (new Order())
            ->setLanguage($this->languageService->getLanguage($checkoutModel->getLanguage()))
            ->setAddress($checkoutModel->getAddress())
            ->setCity($checkoutModel->getCity())
            ->setEmail($checkoutModel->getEmail())
            ->setFullName($checkoutModel->getFullName())
            ->setPhone($checkoutModel->getPhone())
            ->setState($checkoutModel->getState())
            ->setZip($checkoutModel->getZip());
    }

    public function entityToModel(Order $order, string $language)
    {
        $orderData = $order->getOrderData();
        $orderData['products'] = \json_decode($orderData['products'], true);
        return (new OrderModel())
            ->setId($order->getId())
            ->setDateUpdated($order->getDateUpdated())
            ->setDateCreated($order->getDateCreated())
            ->setPaymentLink($this->generatePaymentLink($order))
            ->setStatus($order->getPayStatus())
            ->setStatusText(self::ARRAY_STATUSES[$language][$order->getPayStatus()])
            ->setFullName($order->getFullName())
            ->setEmail($order->getEmail())
            ->setStreet($order->getAddress())
            ->setCity($order->getCity())
            ->setState($order->getState()->getName())
            ->setZip($order->getZip())
            ->setPhone($order->getPhone())
            ->setOrderData($orderData);
    }

    private function generatePaymentLink(Order $order)
    {
        $link = null;
        if ($order->getPayStatus() !== Order::STATUS_SUCCESS_PAYMENT) {
            $link = $this->urlGenerator->generate('paypal_pay', ['orderHash' => $order->getHash()]);
        }

        return $link;
    }
}
