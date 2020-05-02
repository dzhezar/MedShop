<?php


namespace App\DataMapper\Product;


use App\DataMapper\Category\CategoryOutputMapper;
use App\Entity\Language;
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
     * @param CategoryOutputMapper $categoryOutputMapper
     */
    public function __construct(SessionCartService $sessionCartService)
    {
        $this->sessionCartService = $sessionCartService;
    }

    /**
     * @param ProductTranslation $entity
     * @param bool $with_session
     * @param bool $categories
     * @param bool $related
     * @return ProductModel
     */
    public function entityToModel(
        ProductTranslation $entity,
        $with_session = false,
        $categories = false,
        $related = false
    ): ProductModel {
        $inCart = false;
        $amount = 0;
        if ($with_session) {
            $inCart = $this->sessionCartService->ifProductAddedToCart($entity->getProduct()->getId());
            $amount = $this->sessionCartService->getProductAmount($entity->getProduct()->getId());
        }

        $category = null;
        $subCategory = null;
        if ($categories) {
            $category = CategoryOutputMapper::entityToModel(
                $entity->getProduct()->getCategory()->getCategoryTranslations()->first()
            );
            if ($subCategory = $entity->getProduct()->getCategory()->getCategory()) {
                foreach ($subCategory->getCategoryTranslations() as $categoryTranslation) {
                    if($categoryTranslation->getLanguage()->getId() === $entity->getLanguage()->getId()) {
                        $subCategory = CategoryOutputMapper::entityToModel($categoryTranslation);
                    }
                }
            }
        }

        $related_products = [];
        if($related) {
            foreach ($entity->getProduct()->getRelatedProducts() as $relatedProduct) {
                $related_products[] = $this->entityToModel($relatedProduct->getProductTranslations()->first());
            }
        }

        return (new ProductModel())
            ->setIsVisible($entity->getProduct()->getIsVisible())
            ->setPrice($entity->getProduct()->getPrice())
            ->setTitle($entity->getTitle())
            ->setUsage($entity->getUsageDescription())
            ->setDescription($entity->getDescription())
            ->setSeoTitle($entity->getSeoTitle())
            ->setSeoDescription($entity->getSeoDescription())
            ->setImage($entity->getProduct()->getImage())
            ->setInCart($inCart)
            ->setCartAmount($amount)
            ->setCategory($category)
            ->setSubCategory($subCategory)
            ->setRelatedProducts($related_products)
            ->setSlug($entity->getProduct()->getSlug())
            ->setId($entity->getProduct()->getId());
    }
}