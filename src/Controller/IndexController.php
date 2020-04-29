<?php

namespace App\Controller;

use App\Model\OutputModel\ProductModel;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * IndexController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        /** @var ProductModel[] $products */
        $products = $this->productService->getPopularProducts($request->getLocale());
        return $this->render(
            'index.html.twig',
            [
                'products' => $products
            ]
        );
    }

    public function index_default()
    {
        return $this->redirectToRoute('index');
    }
}
