<?php


namespace App\Service;


use App\DataMapper\Category\CategoryFormMapper;
use App\DataMapper\Category\CategoryOutputMapper as CategoryOutputMapper;
use App\DataMapper\CategoryTranslation\CategoryTranslationFormMapper;
use App\DataMapper\Product\ProductFormMapper;
use App\DataMapper\Product\ProductOutputMapper;
use App\DataMapper\ProductTranslation\ProductTranslationFormMapper;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Product;
use App\Model\FormModel\CategoryModel;
use App\Model\FormModel\ProductModel;
use App\Repository\CategoryTranslationRepository;
use App\Repository\ProductTranslationRepository;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    const UPLOAD_FOLDER = 'product';
    /**
     * @var string
     */
    private $relative_path;
    /**
     * @var ProductTranslationRepository
     */
    private $productTranslationRepository;
    /**
     * @var LanguageService
     */
    private $languageService;
    /**
     * @var ProductOutputMapper
     */
    private $outputMapper;
    /**
     * @var FileManagerInterface
     */
    private $fileManager;
    /**
     * @var ProductFormMapper
     */
    private $productFormMapper;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ProductTranslationFormMapper
     */
    private $productTranslationFormMapper;

    /**
     * CategoryService constructor.
     * @param string $relative_path
     * @param ProductTranslationRepository $productTranslationRepository
     * @param LanguageService $languageService
     * @param ProductOutputMapper $outputMapper
     * @param FileManagerInterface $fileManager
     * @param ProductFormMapper $productFormMapper
     * @param EntityManagerInterface $entityManager
     * @param ProductTranslationFormMapper $productTranslationFormMapper
     */
    public function __construct(
        string $relative_path,
        ProductTranslationRepository $productTranslationRepository,
        LanguageService $languageService,
        ProductOutputMapper $outputMapper,
        FileManagerInterface $fileManager,
        ProductFormMapper $productFormMapper,
        EntityManagerInterface $entityManager,
        ProductTranslationFormMapper $productTranslationFormMapper
    ) {
        $this->relative_path = $relative_path;
        $this->productTranslationRepository = $productTranslationRepository;
        $this->languageService = $languageService;
        $this->outputMapper = $outputMapper;
        $this->fileManager = $fileManager;
        $this->productFormMapper = $productFormMapper;
        $this->entityManager = $entityManager;
        $this->productTranslationFormMapper = $productTranslationFormMapper;
    }

    /**
     * @param string $language
     * @return CategoryModel[]
     */
    public function getAll(string $language): array
    {
        $language = $this->languageService->getLanguage($language);
        $products = $this->productTranslationRepository->findBy(['language' => $language], ['id' => 'DESC']);
        $result = [];
        foreach ($products as $product) {
            $result[] = $this->outputMapper::entityToModel($product);
        }

        return $result;
    }

    public function create(ProductModel $productModel)
    {
        $image = $this->fileManager->uploadFile($productModel->getImage(), self::UPLOAD_FOLDER, true);
        $product = $this->productFormMapper->modelToEntity(
            $productModel,
            $this->relative_path . self::UPLOAD_FOLDER . '/' . $image
        );

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $ruProductTranslation = $this->productTranslationFormMapper->modelToEntity(
            $productModel,
            $product,
            Language::RU_LANGUAGE_NAME
        );


        $enProductTranslation = $this->productTranslationFormMapper->modelToEntity(
            $productModel,
            $product,
            Language::EN_LANGUAGE_NAME
        );

        $this->entityManager->persist($ruProductTranslation);
        $this->entityManager->persist($enProductTranslation);

        $product->addProductTranslation($ruProductTranslation);
        $product->addProductTranslation($enProductTranslation);

        $this->entityManager->flush();
    }

    public function update(ProductModel $productModel, Product $entity)
    {
        if ($productModel->getImage()) {
            $image = $this->fileManager->uploadFile($productModel->getImage(), self::UPLOAD_FOLDER, true);
            $image = $this->relative_path . self::UPLOAD_FOLDER . '/' . $image;
        } else {
            $image = $entity->getImage();
        }

        $product = $this->productFormMapper->modelToEntity(
            $productModel,
            $image,
            $entity
        );

        $this->entityManager->flush();

        foreach ($entity->getProductTranslations() as $categoryTranslation) {
            $this->productTranslationFormMapper->modelToEntity(
                $productModel,
                $product,
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
}