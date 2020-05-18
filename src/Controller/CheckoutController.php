<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\OrdersRepository;
use App\Repository\StateRepository;
use App\Service\CartService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    /**
     * @var CartService
     */
    private $cartService;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * CheckoutController constructor.
     * @param CartService $cartService
     * @param StateRepository $stateRepository
     * @param OrderService $orderService
     */
    public function __construct(
        CartService $cartService,
        StateRepository $stateRepository,
        OrderService $orderService
    ) {
        $this->cartService = $cartService;
        $this->stateRepository = $stateRepository;
        $this->orderService = $orderService;
    }

    public function cart(Request $request)
    {
        return $this->render('checkout/cart.html.twig', $this->cartService->getAll($request->getLocale()));
    }

    public function history(Request $request)
    {
        return $this->render(
            'checkout/history.html.twig',
            ['orders' => $this->orderService->getAllByCookies($request)]
        );
    }

    public function index(Request $request)
    {
        $data = $this->cartService->getAll($request->getLocale(), true);
        if ($data['total'] <= 0) {
            return $this->redirectToRoute('index');
        }

        $data['states'] = $this->stateRepository->findAll();

        return $this->render('checkout/index.html.twig', $data);
    }
}
