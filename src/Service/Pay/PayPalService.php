<?php


namespace App\Service\Pay;


use App\Entity\Orders as Order;
use App\Factory\PayPalClientFactory;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpResponse;

class PayPalService
{
    /**
     * @var PayPalClientFactory
     */
    private $clientFactory;
    /**
     * @var OrdersRepository
     */
    private $ordersRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PayPalService constructor.
     * @param PayPalClientFactory $clientFactory
     * @param OrdersRepository $ordersRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        PayPalClientFactory $clientFactory,
        OrdersRepository $ordersRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->clientFactory = $clientFactory;
        $this->ordersRepository = $ordersRepository;
        $this->entityManager = $entityManager;
    }

    public function handle($payPalId, $orderId)
    {
        if ($order = $this->ordersRepository->findOneBy(['hash' => $orderId])) {
            try {
                $payPalData = $this->captureOrder($payPalId);
                $order->setPayPalData($payPalData);
                $capture = $payPalData['purchase_units'][0]['payments']['captures'][0];
                if ($capture['custom_id'] !== $order->getHash() || $capture['status'] !== 'COMPLETED') {
                    $this->setOrderFailed($order);
                } elseif ($order->getOrderData()['total_with_tax'] !== (float)$capture['amount']['value']
                    || $capture['amount']['currency_code'] !== 'USD'
                ) {
                    $this->setOrderFailed($order);
                } else {
                    $this->setOrderPaid($order);
                }
            } catch (\Exception $exception) {
                $this->setOrderFailed($order);
            }
        }

        $order->setDateUpdated(new \DateTime());
        $this->entityManager->flush();

        return ['status' => $order->getPayStatus()];
    }

    private function setOrderPaid(Order $order)
    {
        $order->setPayStatus(Order::STATUS_SUCCESS_PAYMENT);
    }

    private function setOrderFailed(Order $order)
    {
        $order->setPayStatus(Order::STATUS_FAILED_PAYMENT);
    }

    private function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        $client = $this->clientFactory->create();
        /** @var HttpResponse $response */
        try {
            $response = $client->execute($request);
        } catch (\Exception $exception) {

        }

        $result =  json_encode($response->result);
//        $result = '{"id":"7C4343383J398844K","purchase_units":[{"reference_id":"default","payments":{"captures":[{"id":"4P679552EP6843920","status":"COMPLETED","amount":{"currency_code":"USD","value":"178.800000"},"final_capture":true,"seller_protection":{"status":"NOT_ELIGIBLE"},"seller_receivable_breakdown":{"gross_amount":{"currency_code":"USD","value":"178.80"},"paypal_fee":{"currency_code":"USD","value":"5.49"},"net_amount":{"currency_code":"USD","value":"173.31"}},"custom_id":"0499f943f5deb22058970a4692bf1659","links":[{"href":"https:\/\/api.sandbox.paypal.com\/v2\/payments\/captures\/4P679552EP6843920","rel":"self","method":"GET"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/payments\/captures\/4P679552EP6843920\/refund","rel":"refund","method":"POST"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/7C4343383J398844K","rel":"up","method":"GET"}],"create_time":"2020-05-09T12:51:29Z","update_time":"2020-05-09T12:51:29Z"}]}}],"payer":{"name":{"given_name":"Eugene","surname":"Popov"},"email_address":"zhenya1995q@gmail.com","payer_id":"UXBTXXDXWQH58","address":{"country_code":"US"}},"links":[{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/7C4343383J398844K","rel":"self","method":"GET"}],"status":"COMPLETED"}';
        $result = json_decode($result, true);
        return $result;
    }
}