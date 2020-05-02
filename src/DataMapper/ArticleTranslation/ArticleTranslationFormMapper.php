<?php


namespace App\DataMapper\ArticleTranslation;


use App\Entity\Article;
use App\Entity\ArticleTranslation;
use App\Model\FormModel\ArticleModel;
use App\Service\LanguageService;

class ArticleTranslationFormMapper
{
    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * ArticleTranslationFormMapper constructor.
     * @param LanguageService $languageService
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function modelToEntity(
        ArticleModel $articleModel,
        Article $article,
        string $locale,
        ArticleTranslation $articleTranslation = null
    ): ArticleTranslation {
        if (!$articleTranslation) {
            $articleTranslation = new ArticleTranslation();
        }

        $language = strtoupper($locale);
        return $articleTranslation
            ->setTitle($articleModel->{'getTitle' . $language}())
            ->setArticle($article)
            ->setShortDescription($articleModel->{'getShortDescription' . $language}())
            ->setDescription($articleModel->{'getDescription' . $language}())
            ->setSeoTitle($articleModel->{'getSeoTitle' . $language}())
            ->setSeoDescription($articleModel->{'getSeoDescription' . $language}())
            ->setLanguage($this->languageService->getLanguage($locale));
    }
}