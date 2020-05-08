<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * CheckoutController constructor.
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $data = $this->cartService->getAll($request->getLocale(), true);
        if($data['total'] <= 0) {
            return $this->redirectToRoute('index');
        }

        return $this->render('checkout/index.html.twig', $data);
    }
}
