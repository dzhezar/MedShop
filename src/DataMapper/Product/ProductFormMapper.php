<?php


namespace App\DataMapper\Product;


use App\DataMapper\FormMapperInterface;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Product;
use App\Model\FormModel\ProductModel;
use App\Service\SlugService;

class ProductFormMapper implements FormMapperInterface
{
    /**
     * @var SlugService
     */
    private $slugService;

    /**
     * FormMapper constructor.
     * @param SlugService $slugService
     */
    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function modelToEntity(
        ProductModel $productModel,
        ?string $image = null,
        Product $category = null
    ): Product
    {
        if (!$category) {
            $category = new Product();
            $slug = $this->slugService->slugify($productModel->getTitleEN(), Category::class, 'slug');
        } else {
            //TODO Fix slug duplicate
            foreach ($category->getProductTranslations() as $productTranslation) {
                if (
                    $productTranslation->getLanguage()->getShortName() === Language::EN_LANGUAGE_NAME
                    && $productTranslation->getTitle() === $productModel->getTitleEN()
                ) {
                    $slug = $category->getSlug();
                } else {
                    $slug = $this->slugService->slugify($productModel->getTitleEN(), Category::class, 'slug');

                }
            }
        }

        foreach ($productModel->getRelatedProducts() as $relatedProduct) {
            $category->addRelatedProduct($relatedProduct);
        }

        return $category
            ->setSlug($slug)
            ->setPrice($productModel->getPrice())
            ->setCategory($productModel->getCategory())
            ->setImage($image);
    }

    public function entityToModel(Product $product): ProductModel
    {
        $model = new ProductModel();
        $model
            ->setPrice($product->getPrice())
            ->setRelatedProducts($product->getRelatedProducts())
            ->setCategory($product->getCategory())
            ->setSlug($product->getSlug());

        $translations = $product->getProductTranslations();
        foreach ($translations as $translation) {
            $language = strtoupper($translation->getLanguage()->getShortName());
            $model
                ->{'setUsageDescription' . $language}(
                    $translation->getUsageDescription()
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