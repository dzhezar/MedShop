<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var SessionCartService
     */
    private $sessionCartService;

    /**
     * CartService constructor.
     * @param SessionCartService $sessionCartService
     * @param ProductService $productService
     */
    public function __construct(SessionCartService $sessionCartService, ProductService $productService)
    {
        $this->sessionCartService = $sessionCartService;
        $this->productService = $productService;
    }

    public function add(int $id)
    {
        if($product = $this->productService->findOneBy(['id' => $id, 'is_visible' => true])) {
            $this->sessionCartService->plus($id);
        }
    }
}