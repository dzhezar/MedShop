<?php


namespace App\DataMapper\Category;


use App\DataMapper\FormMapperInterface;
use App\Entity\Category;
use App\Entity\Language;
use App\Model\FormModel\CategoryModel;
use App\Service\SlugService;

class CategoryFormMapper implements FormMapperInterface
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
        CategoryModel $categoryModel,
        ?string $image = null,
        Category $category = null
    ): Category {
        if (!$category) {
            $category = new Category();
            $slug = $this->slugService->slugify($categoryModel->getTitleEN(), Category::class, 'slug');
        } else {
            //Remove already set subcategories if more than 2 nesting
            if($categoryModel->getCategory()) {
                foreach ($category->getCategories() as $subCategory) {
                    $category->removeCategory($subCategory);
                }
            }


            foreach ($category->getCategoryTranslations() as $categoryTranslation) {
                if (
                    $categoryTranslation->getLanguage()->getShortName() === Language::EN_LANGUAGE_NAME
                    && $categoryTranslation->getTitle() === $categoryModel->getTitleEN()
                ) {
                    $slug = $category->getSlug();
                } else {
                    $slug = $this->slugService->slugify($categoryModel->getTitleEN(), Category::class, 'slug');

                }
            }
        }

        return $category
            ->setSlug($slug)
            ->setCategory($categoryModel->getCategory())
            ->setImage($image);
    }

    public function entityToModel(Category $category): CategoryModel
    {
        $model = new CategoryModel();
        $model
            ->setCategory($category->getCategory())
            ->setSlug($category->getSlug());

        $translations = $category->getCategoryTranslations();
        foreach ($translations as $translation) {
            $language = strtoupper($translation->getLanguage()->getShortName());
            $model
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