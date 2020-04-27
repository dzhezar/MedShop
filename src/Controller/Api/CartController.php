<?php


namespace App\Controller\Api;


use App\Service\CartService;
use App\Service\ValidationService;
use App\Strategy\Validation\AddToCartValidationStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CartController extends AbstractController
{
    /**
     * @var ValidationService
     */
    private $validationService;
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * CartController constructor.
     * @param ValidationService $validationService
     * @param CartService $cartService
     */
    public function __construct(ValidationService $validationService, CartService $cartService)
    {
        $this->validationService = $validationService;
        $this->cartService = $cartService;
    }

    public function add(Request $request)
    {
        if(!$this->validationService->validate($request->request->all(), AddToCartValidationStrategy::TYPE_NAME)) {
            return new BadRequestHttpException();
        }

        $this->cartService->add($request->request->get('id'));

        return new Response();
    }
}