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
                } elseif ((string) $order->getOrderData()['total_with_tax'] !== (string)$capture['amount']['value']
                    || $capture['amount']['currency_code'] !== 'USD'
                ) {
                    $this->setOrderFailed($order);
                } else {
                    $this->setOrderPaid($order);
                }
            } catch (\Exception $exception) {
                $this->setOrderFailed($order);
            }
            $order->setDateUpdated(new \DateTime());
            $this->entityManager->flush();
            return ['status' => $order->getPayStatus()];
        }

        return ['status' => 'failed'];
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
//        $result = '{"id": "88L43506PN424225N", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v2/checkout/orders/88L43506PN424225N", "method": "GET"}], "payer": {"name": {"surname": "Popov", "given_name": "Eugene"}, "address": {"country_code": "US"}, "payer_id": "6ES3MC4J36VDN", "email_address": "qq@gmail.com"}, "status": "COMPLETED", "purchase_units": [{"payments": {"captures": [{"id": "4HH42190BB331053Y", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v2/payments/captures/4HH42190BB331053Y", "method": "GET"}, {"rel": "refund", "href": "https://api.sandbox.paypal.com/v2/payments/captures/4HH42190BB331053Y/refund", "method": "POST"}, {"rel": "up", "href": "https://api.sandbox.paypal.com/v2/checkout/orders/88L43506PN424225N", "method": "GET"}], "amount": {"value": "178.80", "currency_code": "USD"}, "status": "COMPLETED", "custom_id": "07d74ad18981224f4235e33bb1bb6252", "create_time": "2020-05-09T13:44:39Z", "update_time": "2020-05-09T13:44:39Z", "final_capture": true, "seller_protection": {"status": "NOT_ELIGIBLE"}, "seller_receivable_breakdown": {"net_amount": {"value": "173.31", "currency_code": "USD"}, "paypal_fee": {"value": "5.49", "currency_code": "USD"}, "gross_amount": {"value": "178.80", "currency_code": "USD"}}}]}, "reference_id": "default"}]}';
//        $result = '{"id":"7C4343383J398844K","purchase_units":[{"reference_id":"default","payments":{"captures":[{"id":"4P679552EP6843920","status":"COMPLETED","amount":{"currency_code":"USD","value":"178.800000"},"final_capture":true,"seller_protection":{"status":"NOT_ELIGIBLE"},"seller_receivable_breakdown":{"gross_amount":{"currency_code":"USD","value":"178.80"},"paypal_fee":{"currency_code":"USD","value":"5.49"},"net_amount":{"currency_code":"USD","value":"173.31"}},"custom_id":"0499f943f5deb22058970a4692bf1659","links":[{"href":"https:\/\/api.sandbox.paypal.com\/v2\/payments\/captures\/4P679552EP6843920","rel":"self","method":"GET"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/payments\/captures\/4P679552EP6843920\/refund","rel":"refund","method":"POST"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/7C4343383J398844K","rel":"up","method":"GET"}],"create_time":"2020-05-09T12:51:29Z","update_time":"2020-05-09T12:51:29Z"}]}}],"payer":{"name":{"given_name":"Eugene","surname":"Popov"},"email_address":"zhenya1995q@gmail.com","payer_id":"UXBTXXDXWQH58","address":{"country_code":"US"}},"links":[{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/7C4343383J398844K","rel":"self","method":"GET"}],"status":"COMPLETED"}';
//        $result = '{"id": "55798590FR6618506", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v2/checkout/orders/55798590FR6618506", "method": "GET"}], "payer": {"name": {"surname": "Doe", "given_name": "John"}, "address": {"country_code": "US"}, "payer_id": "JMEZ6YD7XS2EE", "email_address": "sb-lidwd1709764@personal.example.com"}, "status": "COMPLETED", "purchase_units": [{"payments": {"captures": [{"id": "6HM71473YP833133J", "links": [{"rel": "self", "href": "https://api.sandbox.paypal.com/v2/payments/captures/6HM71473YP833133J", "method": "GET"}, {"rel": "refund", "href": "https://api.sandbox.paypal.com/v2/payments/captures/6HM71473YP833133J/refund", "method": "POST"}, {"rel": "up", "href": "https://api.sandbox.paypal.com/v2/checkout/orders/55798590FR6618506", "method": "GET"}], "amount": {"value": "44.88", "currency_code": "USD"}, "status": "COMPLETED", "custom_id": "4b87d42da785171a4de061e7d2b01759", "create_time": "2020-05-09T14:53:35Z", "update_time": "2020-05-09T14:53:35Z", "final_capture": true, "seller_protection": {"status": "NOT_ELIGIBLE"}, "seller_receivable_breakdown": {"net_amount": {"value": "43.28", "currency_code": "USD"}, "paypal_fee": {"value": "1.60", "currency_code": "USD"}, "gross_amount": {"value": "44.88", "currency_code": "USD"}}}]}, "reference_id": "default"}]}';
        $result = json_decode($result, true);
        return $result;
    }
}