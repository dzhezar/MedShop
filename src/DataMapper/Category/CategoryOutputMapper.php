<?php


namespace App\DataMapper\Category;


use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Model\OutputModel\CategoryModel;

class CategoryOutputMapper
{

    /**
     * @param CategoryTranslation $entity
     * @return CategoryModel
     */
    public static function entityToModel(CategoryTranslation $entity): CategoryModel
    {
        return (new CategoryModel())
            ->setTitle($entity->getTitle())
            ->setDescription($entity->getDescription())
            ->setSeoTitle($entity->getSeoTitle())
            ->setSeoDescription($entity->getSeoDescription())
            ->setImage($entity->getCategory()->getImage())
            ->setLink(
                CategoryOutputMapper::generateLink($entity->getCategory(), $entity->getLanguage()->getShortName())
            )
            ->setSubCategoryLink(
                CategoryOutputMapper::generateLink(
                    $entity->getCategory()->getCategory(),
                    $entity->getLanguage()->getShortName()
                )
            )
            ->setId($entity->getCategory()->getId());
    }

    public static function generateLink(?Category $category, $language): string
    {
        $link = '';
        if($category) {
            $link .= '/' . $language . '/category';
            if ($category->getCategory()) {
                $link .= '/' . $category->getCategory()->getSlug();
            }
            $link .= '/'.$category->getSlug();
        }

        return $link;
    }
}