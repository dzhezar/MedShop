<?php


namespace App\Service;


use App\DataMapper\Article\ArticleFormMapper;
use App\DataMapper\Article\ArticleOutputMapper;
use App\DataMapper\ArticleTranslation\ArticleTranslationFormMapper;
use App\DataMapper\MainPageSlider\MainPageSliderOutputMapper;
use App\Entity\Article;
use App\Entity\Language;
use App\Entity\MainPageSlider;
use App\Entity\MainPageSliderTranslation;
use App\Model\FormModel\ArticleModel;
use App\Model\FormModel\MainPageSliderModel;
use App\Repository\ArticleTranslationRepository;
use App\Repository\MainPageSliderTranslationRepository;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class MainPageSliderService
{
    const UPLOAD_FOLDER = 'slider';

    public $tooltipsArray = [];
    /**
     * @var string
     */
    private $relative_path;
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
     * @var MainPageSliderTranslationRepository
     */
    private $mainPageSliderTranslationRepository;
    /**
     * @var MainPageSliderOutputMapper
     */
    private $mainPageSliderOutputMapper;

    public function __construct(
        string $relative_path,
        MainPageSliderTranslationRepository $mainPageSliderTranslationRepository,
        LanguageService $languageService,
        MainPageSliderOutputMapper $mainPageSliderOutputMapper,
        FileManagerInterface $fileManager,
        ArticleFormMapper $articleFormMapper,
        EntityManagerInterface $entityManager,
        ArticleTranslationFormMapper $articleTranslationFormMapper
    ) {
        $this->relative_path = $relative_path;
        $this->languageService = $languageService;
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
        $this->mainPageSliderTranslationRepository = $mainPageSliderTranslationRepository;
        $this->mainPageSliderOutputMapper = $mainPageSliderOutputMapper;
    }

    public function getAll(string $language)
    {
        $language = $this->languageService->getLanguage($language);
        $slides = $this->mainPageSliderTranslationRepository->findBy(['language' => $language], ['id' => 'DESC']);
        $result = [];
        foreach ($slides as $slide) {
            $result[] = $this->mainPageSliderOutputMapper::entityToModel($slide);
        }

        return $result;
    }

    public function create(MainPageSliderModel $mainPageSliderModel)
    {
        $image = $this->fileManager->uploadFile($mainPageSliderModel->getImage(), self::UPLOAD_FOLDER, true);
        $slider = (new MainPageSlider())->setImage($this->relative_path . self::UPLOAD_FOLDER . '/' . $image);

        $this->entityManager->persist($slider);
        $this->entityManager->flush();

        $ruSliderTranslation = (new MainPageSliderTranslation())
            ->setMainPageSlider($slider)
            ->setLanguage($this->languageService->getLanguage(Language::RU_LANGUAGE_NAME))
            ->setText($mainPageSliderModel->getTextRU());

        $enSliderTranslation = (new MainPageSliderTranslation())
            ->setMainPageSlider($slider)
            ->setLanguage($this->languageService->getLanguage(Language::EN_LANGUAGE_NAME))
            ->setText($mainPageSliderModel->getTextEN());

        $this->entityManager->persist($ruSliderTranslation);
        $this->entityManager->persist($enSliderTranslation);

        $this->entityManager->flush();
    }

    public function update(MainPageSliderModel $mainPageSliderModel, MainPageSlider $mainPageSlider)
    {
        if ($mainPageSliderModel->getImage()) {
            $image = $this->fileManager->uploadFile($mainPageSliderModel->getImage(), self::UPLOAD_FOLDER, true);
            $image = $this->relative_path . self::UPLOAD_FOLDER . '/' . $image;
        } else {
            $image = $mainPageSlider->getImage();
        }

        $mainPageSlider->setImage($image);

        $this->entityManager->flush();

        foreach ($mainPageSlider->getMainPageSliderTranslations() as $mainPageSliderTranslation) {
            $language = strtoupper($mainPageSliderTranslation->getLanguage()->getShortName());
            $mainPageSliderTranslation->setText($mainPageSliderModel->{'getText' . $language}());
        }


        $this->entityManager->flush();
    }

    public function remove(MainPageSlider $mainPageSlider)
    {
        $this->fileManager->deleteFile($mainPageSlider->getImage());
        $this->entityManager->remove($mainPageSlider);
        $this->entityManager->flush();
    }
}