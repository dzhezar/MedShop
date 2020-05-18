<?php


namespace App\Service;


use App\Model\OutputModel\ProductModel;
use Symfony\Component\Serializer\SerializerInterface;

class CartService
{
    const DELIVERY_PRICE = 15;
    const TAX_COEFFICIENT = 0.2;
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
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * CartService constructor.
     * @param SessionCartService $sessionCartService
     * @param ProductService $productService
     * @param LanguageService $languageService
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SessionCartService $sessionCartService,
        ProductService $productService,
        LanguageService $languageService,
        SerializerInterface $serializer
    ) {
        $this->sessionCartService = $sessionCartService;
        $this->productService = $productService;
        $this->languageService = $languageService;
        $this->serializer = $serializer;
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
            return $this->sessionCartService->minus($id);
        }

        return [];
    }

    public function remove(int $id)
    {
        if ($product = $this->productService->findOneBy(['id' => $id])) {
            $this->sessionCartService->remove($id);
        }
    }

    public function getAll(string $language, $with_tax = false, $to_array = false)
    {
        $ids = array_keys($this->sessionCartService->all());
        /** @var ProductModel[] $products */
        $products = $this->productService->getBySessionIds($ids, $language);
        $total = 0;
        $amount = 0;
        foreach ($products as $product) {
            $amount += $product->getCartAmount();
            $total += $product->getCartAmount()*$product->getPrice();
        }

        if($to_array) {
            $products = $this->serializer->serialize($products, 'json');
        }

        $result = [
            'amount' => $amount,
            'products' => $products,
            'total' => $total
        ];

        if($with_tax) {
            $result['shipping_price'] = self::DELIVERY_PRICE;
            $totalBeforeTax = $result['total'] + $result['shipping_price'];
            $result['total_before_tax'] = $totalBeforeTax;
            $result['tax'] = self::TAX_COEFFICIENT * $totalBeforeTax;
            $result['total_with_tax'] = round($result['total_before_tax'] + $result['tax'], 2);
        }

        return $result;
    }

    public function clear()
    {
        $this->sessionCartService->clear();
    }

    public function setRandomCartId()
    {
        return $this->sessionCartService->setRandomCardIdToSession();
    }
}