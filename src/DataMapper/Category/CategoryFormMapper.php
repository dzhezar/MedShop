<?php


namespace App\DataMapper\Category;


use App\DataMapper\FormMapperInterface;
use App\Entity\Category;
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

    public function modelToEntity(CategoryModel $categoryModel, ?string $image = null): Category
    {
        return (new Category())
            ->setSlug($categoryModel->getTitleEN())
            ->setCategory($categoryModel->getCategory())
            ->setImage($image);
    }
}