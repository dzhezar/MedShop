<?php


namespace App\Service;


use App\DataMapper\Article\ArticleFormMapper;
use App\DataMapper\Article\ArticleOutputMapper;
use App\DataMapper\ArticleTranslation\ArticleTranslationFormMapper;
use App\Entity\Article;
use App\Entity\Language;
use App\Model\FormModel\ArticleModel;
use App\Repository\ArticleTranslationRepository;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ArticleService
{
    const UPLOAD_FOLDER = 'article';

    public $tooltipsArray = [];
    /**
     * @var string
     */
    private $relative_path;
    /**
     * @var ArticleTranslationRepository
     */
    private $articleTranslationRepository;
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var ArticleOutputMapper
     */
    private $outputMapper;
    /**
     * @var FileManagerInterface
     */
    private $fileManager;
    /**
     * @var ArticleFormMapper
     */
    private $articleFormMapper;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ArticleTranslationFormMapper
     */
    private $articleTranslationFormMapper;
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(
        string $relative_path,
        ArticleTranslationRepository $articleTranslationRepository,
        LanguageService $languageService,
        ArticleOutputMapper $outputMapper,
        FileManagerInterface $fileManager,
        ArticleFormMapper $articleFormMapper,
        EntityManagerInterface $entityManager,
        ArticleTranslationFormMapper $articleTranslationFormMapper,
        PaginatorInterface $paginator
    ) {
        $this->relative_path = $relative_path;
        $this->articleTranslationRepository = $articleTranslationRepository;
        $this->languageService = $languageService;
        $this->outputMapper = $outputMapper;
        $this->fileManager = $fileManager;
        $this->articleFormMapper = $articleFormMapper;
        $this->entityManager = $entityManager;
        $this->articleTranslationFormMapper = $articleTranslationFormMapper;
        $this->tooltipsArray['article_form_shortDescriptionRU'] = TooltipService::createImageElement(
            '/admin/img/tooltips/short_description.png'
        );
        $this->tooltipsArray['article_form_shortDescriptionEN'] = TooltipService::createImageElement(
            '/admin/img/tooltips/short_description.png'
        );
        $this->paginator = $paginator;
    }

    public function getAll(string $language)
    {
        $language = $this->languageService->getLanguage($language);
        $products = $this->articleTranslationRepository->findBy(['language' => $language], ['id' => 'DESC']);
        $result = [];
        foreach ($products as $product) {
            $result[] = $this->outputMapper::entityToModel($product);
        }

        return $result;
    }

    public function getAllForMainPage(string $language)
    {
        $language = $this->languageService->getLanguage($language);
        $products = $this->articleTranslationRepository->getVisibleArticlesByLanguage($language->getId());
        $result = [];

        foreach ($products as $product) {
            $result[] = $this->outputMapper::entityToModel($product);
        }

        return $result;
    }

    public function getAllWithPagination(string $language, int $page = 1)
    {
        $language = $this->languageService->getLanguage($language);
        $products = $this->articleTranslationRepository->getVisibleArticlesByLanguageQuery($language->getId());
        $result = [];

        $pagination = $this->paginator->paginate(
            $products,
            $page,
            1 //TODO Change to 20
        );

        foreach ($pagination as $product) {
            $result[] = $this->outputMapper::entityToModel($product);
        }

        $pagination->setItems($result);

        return $pagination;
    }

    public function create(ArticleModel $articleModel)
    {
        $image = $this->fileManager->uploadFile($articleModel->getImage(), self::UPLOAD_FOLDER, true);
        $article = $this->articleFormMapper->modelToEntity(
            $articleModel,
            $this->relative_path . self::UPLOAD_FOLDER . '/' . $image
        );


        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $ruArticleTranslation = $this->articleTranslationFormMapper->modelToEntity(
            $articleModel,
            $article,
            Language::RU_LANGUAGE_NAME
        );

        $enArticleTranslation = $this->articleTranslationFormMapper->modelToEntity(
            $articleModel,
            $article,
            Language::EN_LANGUAGE_NAME
        );

        $this->entityManager->persist($ruArticleTranslation);
        $this->entityManager->persist($enArticleTranslation);

        $article->addArticleTranslation($ruArticleTranslation);
        $article->addArticleTranslation($enArticleTranslation);

        $this->entityManager->flush();
    }

    public function update(ArticleModel $articleModel, Article $article)
    {
        if ($articleModel->getImage()) {
            $image = $this->fileManager->uploadFile($articleModel->getImage(), self::UPLOAD_FOLDER, true);
            $image = $this->relative_path . self::UPLOAD_FOLDER . '/' . $image;
        } else {
            $image = $article->getImage();
        }

        $article = $this->articleFormMapper->modelToEntity(
            $articleModel,
            $image,
            $article
        );

        $this->entityManager->flush();

        foreach ($article->getArticleTranslations() as $articleTranslation) {
            $this->articleTranslationFormMapper->modelToEntity(
                $articleModel,
                $article,
                $articleTranslation->getLanguage()->getShortName(),
                $articleTranslation
            );
        }


        $this->entityManager->flush();
    }

    public function remove(Article $article)
    {
        $this->fileManager->deleteFile($article->getImage());
        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    public function findOneBySlugAndLanguage(string $slug, string $language)
    {
        if($article = $this->articleTranslationRepository->findBySlugAndLanguage($slug, $this->languageService->getLanguage($language)->getId())) {
            return $this->outputMapper->entityToModel($article);
        }

        return false;
    }
}