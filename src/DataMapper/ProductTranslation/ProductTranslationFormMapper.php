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

    public function modelToEntity(ProductModel $categoryModel, Product $category, $locale, ProductTranslation $categoryTranslation = null)
    {
        if(!$categoryTranslation) {
            $categoryTranslation = new ProductTranslation();
        }

        $language = strtoupper($locale);
        return $categoryTranslation
            ->setTitle($categoryModel->{'getTitle' . $language}())
            ->setDescription($categoryModel->{'getDescription' . $language}())
            ->setSeoTitle($categoryModel->{'getSeoTitle' . $language}())
            ->setSeoDescription($categoryModel->{'getSeoDescription' . $language}())
            ->setLanguage($this->languageService->getLanguage($locale))
            ->setUsageDescription($categoryModel->{'getUsageDescription' . $language}());
    }
}