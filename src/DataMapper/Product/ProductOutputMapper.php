<?php


namespace App\DataMapper\Product;


use App\DataMapper\Category\CategoryOutputMapper;
use App\Entity\ProductTranslation;
use App\Model\OutputModel\ProductModel;
use App\Service\BreadcrumbsService;
use App\Service\SessionCartService;
use App\Strategy\Breadcurmbs\ProductBreadcrumbsStrategy;

class ProductOutputMapper
{
    /**
     * @var SessionCartService
     */
    private $sessionCartService;
    /**
     * @var BreadcrumbsService
     */
    private $breadcrumbsService;

    /**
     * ProductOutputMapper constructor.
     * @param SessionCartService $sessionCartService
     * @param BreadcrumbsService $breadcrumbsService
     */
    public function __construct(SessionCartService $sessionCartService, BreadcrumbsService $breadcrumbsService)
    {
        $this->sessionCartService = $sessionCartService;
        $this->breadcrumbsService = $breadcrumbsService;
    }

    /**
     * @param ProductTranslation $entity
     * @param bool $with_session
     * @param bool $categories
     * @param bool $related
     * @param bool $with_breadcrumbs
     * @return array
     */
    public function entityToModel(
        ProductTranslation $entity,
        $with_session = false,
        $categories = false,
        $related = false,
        $with_breadcrumbs = false
    ) {
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
                    if ($categoryTranslation->getLanguage()->getId() === $entity->getLanguage()->getId()) {
                        $subCategory = CategoryOutputMapper::entityToModel($categoryTranslation);
                    }
                }
            }
        }

        $related_products = [];
        if ($related) {
            foreach ($entity->getProduct()->getRelatedProducts() as $relatedProduct) {
                $related_products[] = $this->entityToModel($relatedProduct->getProductTranslations()->first());
            }
        }

        $product = (new ProductModel())
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

        if ($with_breadcrumbs) {
            $breadCrumbs = $this->breadcrumbsService->generateBreadcrumbs(
                $entity,
                ProductBreadcrumbsStrategy::TYPE_NAME
            );
            return [
                'product' => $product,
                'breadcrumbs' => $breadCrumbs
            ];
        }

        return $product;
    }
}