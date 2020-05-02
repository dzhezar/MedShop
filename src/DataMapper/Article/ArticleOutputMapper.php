<?php


namespace App\DataMapper\Article;


use App\Entity\ArticleTranslation;
use App\Model\OutputModel\ArticleModel;

class ArticleOutputMapper
{
    public static function entityToModel(ArticleTranslation $product)
    {
        return (new ArticleModel())
            ->setId($product->getArticle()->getId())
            ->setImage($product->getArticle()->getImage())
            ->setTitle($product->getTitle())
            ->setShortDescription($product->getShortDescription())
            ->setDescription($product->getDescription())
            ->setSeoTitle($product->getSeoTitle())
            ->setSeoDescription($product->getSeoDescription());
    }
}