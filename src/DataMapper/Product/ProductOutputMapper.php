<?php


namespace App\DataMapper\Product;


use App\Entity\ProductTranslation;
use App\Model\OutputModel\ProductModel;

class ProductOutputMapper
{

    /**
     * @param ProductTranslation $entity
     * @return ProductModel
     */
    public static function entityToModel(ProductTranslation $entity): ProductModel
    {
        return (new ProductModel())
            ->setPrice($entity->getProduct()->getPrice())
            ->setTitle($entity->getTitle())
            ->setDescription($entity->getDescription())
            ->setSeoTitle($entity->getSeoTitle())
            ->setSeoDescription($entity->getSeoDescription())
            ->setImage($entity->getProduct()->getImage())
            ->setId($entity->getProduct()->getId());
    }
}