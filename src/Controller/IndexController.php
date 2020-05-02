<?php

namespace App\Controller;

use App\Model\OutputModel\ProductModel;
use App\Service\MainPageSliderService;
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
     * @var MainPageSliderService
     */
    private $mainPageSliderService;

    /**
     * IndexController constructor.
     * @param ProductService $productService
     * @param MainPageSliderService $mainPageSliderService
     */
    public function __construct(ProductService $productService, MainPageSliderService $mainPageSliderService)
    {
        $this->productService = $productService;
        $this->mainPageSliderService = $mainPageSliderService;
    }

    public function index(Request $request)
    {
        $slides = $this->mainPageSliderService->getAll($request->getLocale());
        /** @var ProductModel[] $products */
        $products = $this->productService->getPopularProducts($request->getLocale());
        return $this->render(
            'index.html.twig',
            [
                'slides' => $slides,
                'products' => $products
            ]
        );
    }

    public function index_default()
    {
        return $this->redirectToRoute('index');
    }
}
