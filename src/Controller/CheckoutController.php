<?php

namespace App\Controller;

use App\Repository\StateRepository;
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
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * CheckoutController constructor.
     * @param CartService $cartService
     * @param StateRepository $stateRepository
     */
    public function __construct(CartService $cartService, StateRepository $stateRepository)
    {
        $this->cartService = $cartService;
        $this->stateRepository = $stateRepository;
    }

    public function history(Request $request)
    {
        return $this->render('checkout/history.html.twig');
    }

    public function index(Request $request)
    {
        $data = $this->cartService->getAll($request->getLocale(), true);
        if($data['total'] <= 0) {
            return $this->redirectToRoute('index');
        }

        $data['states'] = $this->stateRepository->findAll();

        return $this->render('checkout/index.html.twig', $data);
    }
}
