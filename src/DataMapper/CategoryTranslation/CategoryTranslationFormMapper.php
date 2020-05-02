<?php


namespace App\DataMapper\CategoryTranslation;


use App\DataMapper\FormMapperInterface;
use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Model\FormModel\CategoryModel;
use App\Service\LanguageService;

class CategoryTranslationFormMapper implements FormMapperInterface
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

    public function modelToEntity(CategoryModel $categoryModel, Category $category, $locale, CategoryTranslation $categoryTranslation = null)
    {
        if(!$categoryTranslation) {
            $categoryTranslation = new CategoryTranslation();
        }

        $language = strtoupper($locale);
        return $categoryTranslation
            ->setTitle($categoryModel->{'getTitle' . $language}())
            ->setDescription($categoryModel->{'getDescription' . $language}())
            ->setSeoTitle($categoryModel->{'getSeoTitle' . $language}())
            ->setSeoDescription($categoryModel->{'getSeoDescription' . $language}())
            ->setLanguage($this->languageService->getLanguage($locale))
            ->setCategory($category);
    }
}