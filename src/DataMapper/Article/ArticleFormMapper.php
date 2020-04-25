<?php


namespace App\DataMapper\Article;


use App\Entity\Article;
use App\Entity\Language;
use App\Model\FormModel\ArticleModel;
use App\Service\SlugService;

class ArticleFormMapper
{
    /**
     * @var SlugService
     */
    private $slugService;

    /**
     * ArticleFormMapper constructor.
     * @param SlugService $slugService
     */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    /**
     * @param ArticleModel $articleModel
     * @param string $image
     * @param Article|null $article
     * @return Article
     */
    public function modelToEntity(ArticleModel $articleModel, string $image, Article $article = null): Article
    {
        if (!$article) {
            $article = new Article();
            $slug = $this->slugService->slugify($articleModel->getTitleEN(), Article::class, 'slug');
        } else {
            foreach ($article->getArticleTranslations() as $articleTranslation) {
                if (
                    $articleTranslation->getLanguage()->getShortName() === Language::EN_LANGUAGE_NAME
                    && $articleTranslation->getTitle() === $articleModel->getTitleEN()
                ) {
                    $slug = $article->getSlug();
                } else {
                    $slug = $this->slugService->slugify($articleModel->getTitleEN(), Article::class, 'slug');
                }
            }
        }

        return $article
            ->setIsVisible($articleModel->isIsVisible())
            ->setDateCreated(new \DateTime())
            ->setSlug($slug)
            ->setImage($image);
    }

    public function entityToModel(Article $article)
    {
        $model = new ArticleModel();
        $model
            ->setIsVisible($article->getIsVisible())
            ->setSlug($article->getSlug());

        $translations = $article->getArticleTranslations();
        foreach ($translations as $translation) {
            $language = strtoupper($translation->getLanguage()->getShortName());
            $model
                ->{'setShortDescription' . $language}(
                    $translation->getShortDescription()
                )
                ->{'setDescription' . $language}(
                    $translation->getDescription()
                )
                ->{'setTitle' . $language}(
                    $translation->getTitle()
                )
                ->{'setSeoDescription' . $language}(
                    $translation->getSeoDescription()
                )
                ->{'setSeoTitle' . $language}(
                    $translation->getSeoTitle()
                );
        }

        return $model;
    }
}