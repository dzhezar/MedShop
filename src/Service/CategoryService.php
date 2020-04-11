<?php


namespace App\Service;



use App\DataMapper\Category\OutputMapper as CategoryOutputMapper;
use App\Model\CategoryModel;
use App\Repository\CategoryTranslationRepository;

class CategoryService
{
    /**
     * @var CategoryTranslationRepository
     */
    private $categoryTranslationRepository;
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var CategoryOutputMapper
     */
    private $outputMapper;

    /**
     * CategoryService constructor.
     * @param CategoryTranslationRepository $categoryTranslationRepository
     * @param LanguageService $languageService
     * @param CategoryOutputMapper $outputMapper
     */
    public function __construct(CategoryTranslationRepository $categoryTranslationRepository, LanguageService $languageService, CategoryOutputMapper $outputMapper)
    {
        $this->categoryTranslationRepository = $categoryTranslationRepository;
        $this->languageService = $languageService;
        $this->outputMapper = $outputMapper;
    }

    /**
     * @param string $language
     * @return CategoryModel[]
     */
    public function getAll(string $language): array
    {
        $language = $this->languageService->getLanguage($language);
        $categories = $this->categoryTranslationRepository->findBy(['language' => $language]);
        $result = [];
        foreach ($categories as $category) {
            $result[] = $this->outputMapper::entityToModel($category);
        }

        return $result;
    }
}