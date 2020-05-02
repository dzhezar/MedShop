<?php


namespace App\Controller;


use App\Model\OutputModel\ProductModel;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function single(Request $request, $slug)
    {
        /** @var ProductModel|null $product */
        $product = $this->productService->getProductBySlugAndLanguage($slug, $request->getLocale());

        if(!$product) {
            return $this->createNotFoundException();
        }

        return $this->render('product/single.html.twig', ['product' => $product]);
    }
}
