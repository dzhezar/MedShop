<?php


namespace App\Controller\Api;


use App\Form\CheckoutForm;
use App\Model\FormModel\CheckoutModel;
use App\Service\CheckoutService;
use App\Service\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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
     * CheckoutController constructor.
     * @param ValidationService $validationService
     * @param CheckoutService $checkoutService
     */
    public function __construct(ValidationService $validationService, CheckoutService $checkoutService)
    {
        $this->validationService = $validationService;
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request)
    {
        $data = $this->validationService->validate($request->request->all(), CheckoutForm::class);
        if(!$data instanceof CheckoutModel) {
            return new JsonResponse($data, 422);
        }

        $this->checkoutService->create($data);


        dd($data);
    }
}