<?php


namespace App\DataMapper\ProductTranslation;


use App\DataMapper\FormMapperInterface;
use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\Product;
use App\Entity\ProductTranslation;
use App\Model\FormModel\CategoryModel;
use App\Model\FormModel\ProductModel;
use App\Service\LanguageService;

class ProductTranslationFormMapper implements FormMapperInterface
{
    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * CategoryTranslationFormMapper constructor.
     * @param LanguageService $languageService
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function modelToEntity(ProductModel $productModel, $locale, ProductTranslation $productTranslation = null)
    {
        if(!$productTranslation) {
            $productTranslation = new ProductTranslation();
        }

        $language = strtoupper($locale);
        return $productTranslation
            ->setTitle($productModel->{'getTitle' . $language}())
            ->setDescription($productModel->{'getDescription' . $language}())
            ->setSeoTitle($productModel->{'getSeoTitle' . $language}())
            ->setSeoDescription($productModel->{'getSeoDescription' . $language}())
            ->setLanguage($this->languageService->getLanguage($locale))
            ->setUsageDescription($productModel->{'getUsageDescription' . $language}());
    }
}