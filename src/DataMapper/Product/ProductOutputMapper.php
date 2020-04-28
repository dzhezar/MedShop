<?php


namespace App\DataMapper\Product;


use App\Entity\ProductTranslation;
use App\Model\OutputModel\ProductModel;
use App\Service\SessionCartService;

class ProductOutputMapper
{
    /**
     * @var SessionCartService
     */
    private $sessionCartService;

    /**
     * ProductOutputMapper constructor.
     * @param SessionCartService $sessionCartService
     */
    public function __construct(SessionCartService $sessionCartService)
    {
        $this->sessionCartService = $sessionCartService;
    }

    /**
     * @param ProductTranslation $entity
     * @param bool $with_session
     * @return ProductModel
     */
    public function entityToModel(ProductTranslation $entity, $with_session = false): ProductModel
    {
        $inCart = false;
        $amount = 0;
        if($with_session) {
            $inCart = $this->sessionCartService->ifProductAddedToCart($entity->getProduct()->getId());
            $amount = $this->sessionCartService->getProductAmount($entity->getProduct()->getId());
        }

        return (new ProductModel())
            ->setIsVisible($entity->getProduct()->getIsVisible())
            ->setPrice($entity->getProduct()->getPrice())
            ->setTitle($entity->getTitle())
            ->setDescription($entity->getDescription())
            ->setSeoTitle($entity->getSeoTitle())
            ->setSeoDescription($entity->getSeoDescription())
            ->setImage($entity->getProduct()->getImage())
            ->setInCart($inCart)
            ->setCartAmount($amount)
            ->setId($entity->getProduct()->getId());
    }
}