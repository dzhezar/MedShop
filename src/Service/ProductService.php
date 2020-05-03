<?php


namespace App\Service;


use App\DataMapper\Product\ProductFormMapper;
use App\DataMapper\Product\ProductOutputMapper;
use App\DataMapper\ProductTranslation\ProductTranslationFormMapper;
use App\Entity\CategoryTranslation;
use App\Entity\Language;
use App\Entity\Product;
use App\Entity\ProductTranslation;
use App\Entity\Specification;
use App\Entity\SpecificationValue;
use App\Entity\SpecificationValueTranslation;
use App\Model\FormModel\CategoryModel;
use App\Model\FormModel\ProductModel;
use App\Repository\ProductRepository;
use App\Repository\ProductTranslationRepository;
use App\Service\FileManager\FileManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

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
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;

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
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(
        string $relative_path,
        ProductTranslationRepository $productTranslationRepository,
        LanguageService $languageService,
        ProductOutputMapper $outputMapper,
        FileManagerInterface $fileManager,
        ProductFormMapper $productFormMapper,
        EntityManagerInterface $entityManager,
        ProductTranslationFormMapper $productTranslationFormMapper,
        ProductRepository $productRepository,
        PaginatorInterface $paginator
    ) {
        $this->relative_path = $relative_path;
        $this->productTranslationRepository = $productTranslationRepository;
        $this->languageService = $languageService;
        $this->outputMapper = $outputMapper;
        $this->fileManager = $fileManager;
        $this->productFormMapper = $productFormMapper;
        $this->entityManager = $entityManager;
        $this->productTranslationFormMapper = $productTranslationFormMapper;
        $this->productRepository = $productRepository;
        $this->paginator = $paginator;
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
            $result[] = $this->outputMapper->entityToModel($product, true);
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
            Language::RU_LANGUAGE_NAME
        );


        $enProductTranslation = $this->productTranslationFormMapper->modelToEntity(
            $productModel,
            Language::EN_LANGUAGE_NAME
        );

        $this->entityManager->persist($ruProductTranslation);
        $this->entityManager->persist($enProductTranslation);

        $product->addProductTranslation($ruProductTranslation);
        $product->addProductTranslation($enProductTranslation);

        $this->createSpecifications($productModel, $product);
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

        foreach ($product->getSpecificationValues() as $specificationValue) {
            $product->removeSpecificationValue($specificationValue);
            $this->entityManager->remove($specificationValue);
        }

        $this->entityManager->flush();

        $this->createSpecifications($productModel, $product);

        foreach ($entity->getProductTranslations() as $categoryTranslation) {
            $this->productTranslationFormMapper->modelToEntity(
                $productModel,
                $categoryTranslation->getLanguage()->getShortName(),
                $categoryTranslation
            );
        }


        $this->entityManager->flush();
    }

    public function remove(Product $id)
    {
        $this->fileManager->deleteFile($id->getImage());
        $this->entityManager->remove($id);
        $this->entityManager->flush();
    }

    private function createSpecifications(ProductModel $productModel, Product $product)
    {
        $specificationRepo = $this->entityManager->getRepository(Specification::class);

        $specifications = json_decode($productModel->getSpecifications(), true);
        foreach ($specifications as $specification) {
            if (isset($specification['specif']) && isset($specification['en']) && isset($specification['ru'])) {
                /** @var Specification|null $specificationEntity */
                if ($specificationEntity = $specificationRepo->findOneBy(['id' => $specification['specif']])) {
                    $specificationValue = new SpecificationValue();
                    $specificationValue->setSpecification($specificationEntity);
                    $specificationValue->setProduct($product);

                    $this->entityManager->persist($specificationValue);
                    $this->entityManager->flush();

                    $enSpecificationValue = new SpecificationValueTranslation();
                    $enSpecificationValue->setSpecificationValue($specificationValue);
                    $enSpecificationValue->setName($specification['en']);
                    $enSpecificationValue->setLanguage($this->languageService->getLanguage(Language::EN_LANGUAGE_NAME));

                    $ruSpecificationValue = new SpecificationValueTranslation();
                    $ruSpecificationValue->setSpecificationValue($specificationValue);
                    $ruSpecificationValue->setName($specification['ru']);
                    $ruSpecificationValue->setLanguage($this->languageService->getLanguage(Language::RU_LANGUAGE_NAME));

                    $this->entityManager->persist($enSpecificationValue);
                    $this->entityManager->persist($ruSpecificationValue);
                }
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param Product[] $newProducts
     * @param Product[] $oldProducts
     */
    public function updateMainPageCategories(array $newProducts, array $oldProducts)
    {
        foreach ($oldProducts as $oldProduct) {
            $oldProduct->setIsOnMain(false);
        }

        foreach ($newProducts as $newProduct) {
            $newProduct->setIsOnMain(true);
        }

        $this->entityManager->flush();
    }

    public function switchVisibility(int $id, bool $checked): bool
    {
        /** @var Product|null $product */
        if ($product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id])) {
            $product->setIsVisible($checked);
            $this->entityManager->flush();
            return true;
        }

        return false;
    }

    public function getPopularProducts(string $language)
    {
        $productTranslations = $this->productTranslationRepository->getPopularProductsByLanguage(
            $this->languageService->getLanguage($language)->getId()
        );

        $result = [];

        foreach ($productTranslations as $productTranslation) {
            $result[] = $this->outputMapper->entityToModel($productTranslation, true);
        }

        return $result;
    }

    public function findOneBy(array $criteria)
    {
        return $this->productRepository->findOneBy($criteria);
    }

    public function findVisibleProductByIdAndLanguage(int $id, string $language)
    {
        return $this->productTranslationRepository->findProductByIdAndLanguage(
            $id,
            $this->languageService->getLanguage(
                $language
            )->getId()
        );
    }

    public function getBySessionIds(array $ids, string $language)
    {
        $language = $this->languageService->getLanguage($language);
        $products = $this->productTranslationRepository->findByProductIds($language->getId(), $ids);
        $result = [];
        foreach ($products as $product) {
            $result[] = $this->outputMapper->entityToModel($product, true);
        }

        return $result;
    }

    public function getProductBySlugAndLanguage(string $slug, string $language)
    {
        $language = $this->languageService->getLanguage($language)->getId();
        /** @var ProductTranslation $product */
        if ($product = $this->productTranslationRepository->findProductBySlugAndLanguage(
            $slug,
            $language
        )) {
            $rel_product = $this->productRepository->findRelatedProductsByLanguageAndId($product->getId(), $language);
            if ($rel_product) {
                foreach ($rel_product->getRelatedProducts() as $item) {
                    $product->getProduct()->addRelatedProduct($item);
                }
            }

            return $this->outputMapper->entityToModel($product, true, true, true, true);
        }

        return false;
    }

    public function getProductByCategory(CategoryTranslation $categoryTranslation, $page = 0)
    {
        /** @var ProductTranslation[] $products */
        $products = $this->productTranslationRepository->getProductsByCategoryIdAndLanguage(
            $categoryTranslation->getCategory()->getId(),
            $categoryTranslation->getLanguage()->getId()
        );

        $pagination = $this->paginator->paginate(
            $products,
            $page,
            1 //TODO Changed to 20
        );


        $products = [];
        foreach ($pagination->getItems() as $item) {
            $products[] = $this->outputMapper->entityToModel($item, true);
        }

        $pagination->setItems($products);


        return $pagination;
    }
}