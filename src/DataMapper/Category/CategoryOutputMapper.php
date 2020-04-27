<?php


namespace App\DataMapper\Category;


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
            ->setId($entity->getCategory()->getId());
    }
}