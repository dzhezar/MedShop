<?php


namespace App\Service;


use App\DataMapper\Category\CategoryFormMapper;
use App\DataMapper\Category\CategoryOutputMapper as CategoryOutputMapper;
use App\DataMapper\CategoryTranslation\CategoryTranslationFormMapper;
use App\Entity\Category;
use App\Entity\Language;
use App\Model\FormModel\CategoryModel;
use App\Repository\CategoryTranslationRepository;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    const TOOLTIPS_ARRAY = [
        'category_form_category' => 'Внимание. Вы не увидите категорий, у которых уже установлена вложеность'
    ];

    const UPLOAD_FOLDER = 'category';
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
     * @var FileManagerInterface
     */
    private $fileManager;
    /**
     * @var CategoryFormMapper
     */
    private $categoryFormMapper;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CategoryTranslationFormMapper
     */
    private $categoryTranslationFormMapper;
    /**
     * @var string
     */
    private $relative_path;

    /**
     * CategoryService constructor.
     * @param string $relative_path
     * @param CategoryTranslationRepository $categoryTranslationRepository
     * @param LanguageService $languageService
     * @param CategoryOutputMapper $outputMapper
     * @param FileManagerInterface $fileManager
     * @param CategoryFormMapper $categoryFormMapper
     * @param EntityManagerInterface $entityManager
     * @param CategoryTranslationFormMapper $categoryTranslationFormMapper
     */
    public function __construct(
        string $relative_path,
        CategoryTranslationRepository $categoryTranslationRepository,
        LanguageService $languageService,
        CategoryOutputMapper $outputMapper,
        FileManagerInterface $fileManager,
        CategoryFormMapper $categoryFormMapper,
        EntityManagerInterface $entityManager,
        CategoryTranslationFormMapper $categoryTranslationFormMapper
    ) {
        $this->categoryTranslationRepository = $categoryTranslationRepository;
        $this->languageService = $languageService;
        $this->outputMapper = $outputMapper;
        $this->fileManager = $fileManager;
        $this->categoryFormMapper = $categoryFormMapper;
        $this->entityManager = $entityManager;
        $this->categoryTranslationFormMapper = $categoryTranslationFormMapper;
        $this->relative_path = $relative_path;
    }

    /**
     * @param string $language
     * @return CategoryModel[]
     */
    public function getAll(string $language): array
    {
        $language = $this->languageService->getLanguage($language);
        $categories = $this->categoryTranslationRepository->findBy(['language' => $language], ['id' => 'DESC']);
        $result = [];
        foreach ($categories as $category) {
            $result[] = $this->outputMapper::entityToModel($category);
        }

        return $result;
    }

    public function create(CategoryModel $categoryModel)
    {
        $image = $this->fileManager->uploadFile($categoryModel->getImage(), self::UPLOAD_FOLDER, true);
        $category = $this->categoryFormMapper->modelToEntity(
            $categoryModel,
            $this->relative_path . self::UPLOAD_FOLDER . '/' . $image
        );
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $ruCategoryTranslation = $this->categoryTranslationFormMapper->modelToEntity(
            $categoryModel,
            $category,
            Language::RU_LANGUAGE_NAME
        );

        $enCategoryTranslation = $this->categoryTranslationFormMapper->modelToEntity(
            $categoryModel,
            $category,
            Language::EN_LANGUAGE_NAME
        );

        $this->entityManager->persist($ruCategoryTranslation);
        $this->entityManager->persist($enCategoryTranslation);

        $category->addCategoryTranslation($ruCategoryTranslation);
        $category->addCategoryTranslation($enCategoryTranslation);

        $this->entityManager->flush();
    }

    public function update(CategoryModel $categoryModel, Category $entity)
    {
        if ($categoryModel->getImage()) {
            $image = $this->fileManager->uploadFile($categoryModel->getImage(), self::UPLOAD_FOLDER, true);
            $image = $this->relative_path . self::UPLOAD_FOLDER . '/' . $image;
        } else {
            $image = $entity->getImage();
        }

        $category = $this->categoryFormMapper->modelToEntity(
            $categoryModel,
            $image,
            $entity
        );

        $this->entityManager->flush();

        foreach ($entity->getCategoryTranslations() as $categoryTranslation) {
            $this->categoryTranslationFormMapper->modelToEntity(
                $categoryModel,
                $category,
                $categoryTranslation->getLanguage()->getShortName(),
                $categoryTranslation
            );
        }


        $this->entityManager->flush();
    }

    public function remove(Category $id)
    {
        $this->fileManager->deleteFile($id->getImage());
        $this->entityManager->remove($id);
        $this->entityManager->flush();
    }

    /**
     * @param Category[] $newCategories
     * @param Category[] $oldCategories
     */
    public function updateMainPageCategories(array $newCategories, array $oldCategories)
    {
        foreach ($oldCategories as $oldCategory) {
            $oldCategory->setIsOnMain(false);
        }

        foreach ($newCategories as $newCategory) {
            $newCategory->setIsOnMain(true);
        }

        $this->entityManager->flush();
    }
}