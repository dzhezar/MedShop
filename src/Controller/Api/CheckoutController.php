<?php


namespace App\Controller\Api;


use App\Factory\PayPalClientFactory;
use App\Form\CheckoutForm;
use App\Model\FormModel\CheckoutModel;
use App\Service\CheckoutService;
use App\Service\ValidationService;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    /**
     * @var ValidationService
     */
    private $validationService;
    /**
     * @var CheckoutService
     */
    private $checkoutService;
    /**
     * @var PayPalClientFactory
     */
    private $clientFactory;

    /**
     * CheckoutController constructor.
     * @param ValidationService $validationService
     * @param CheckoutService $checkoutService
     * @param PayPalClientFactory $clientFactory
     */
    public function __construct(
        ValidationService $validationService,
        CheckoutService $checkoutService,
        PayPalClientFactory $clientFactory
    ) {
        $this->validationService = $validationService;
        $this->checkoutService = $checkoutService;
        $this->clientFactory = $clientFactory;
    }

    public function checkout(Request $request)
    {
        $data = $this->validationService->validate($request->request->all(), CheckoutForm::class);
        if (!$data instanceof CheckoutModel) {
            return new JsonResponse($data, 422);
        }

        return $this->json($this->checkoutService->create($data));
    }

    public function handlePayPalCallback($orderId)
    {
//        $data = \json_decode($request->getContent(), true);
        $this->captureOrder($orderId);
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        // 3. Call PayPal to capture an authorization
        $client = $this->clientFactory->create();
        $response = $client->execute($request);

        dd($response);

        return $response;
    }
}