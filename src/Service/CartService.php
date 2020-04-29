<?php


namespace App\Service;


use App\Model\OutputModel\ProductModel;

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
     * @var LanguageService
     */
    private $languageService;

    /**
     * CartService constructor.
     * @param SessionCartService $sessionCartService
     * @param ProductService $productService
     * @param LanguageService $languageService
     */
    public function __construct(
        SessionCartService $sessionCartService,
        ProductService $productService,
        LanguageService $languageService
    ) {
        $this->sessionCartService = $sessionCartService;
        $this->productService = $productService;
        $this->languageService = $languageService;
    }

    public function add(int $id)
    {
        if ($product = $this->productService->findOneBy(['id' => $id, 'is_visible' => true])) {
            $this->sessionCartService->plus($id);
        }
    }

    public function minus(int $id)
    {
        if ($product = $this->productService->findOneBy(['id' => $id, 'is_visible' => true])) {
            $this->sessionCartService->minus($id);
        }
    }

    public function remove(int $id)
    {
        if ($product = $this->productService->findOneBy(['id' => $id])) {
            $this->sessionCartService->remove($id);
        }
    }

    public function getAll(string $language)
    {
        $ids = array_keys($this->sessionCartService->all());
        /** @var ProductModel[] $products */
        $products = $this->productService->getBySessionIds($ids, $language);
        $total = 0;
        foreach ($products as $product) {
            $total += $product->getCartAmount()*$product->getPrice();
        }
        return [
            'products' => $products,
            'total' => $total
        ];
    }
}