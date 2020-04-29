<?php

namespace App\Repository;

use App\Entity\ProductTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTranslation[]    findAll()
 * @method ProductTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTranslation::class);
    }

    public function getPopularProductsByLanguage(int $languageId)
    {
        return $this->createQueryBuilder('product_translation')
            ->addSelect('product')
            ->leftJoin('product_translation.product', 'product')
            ->leftJoin('product_translation.language', 'language')
            ->where('product.is_on_main = true')
            ->andWhere('product.is_visible = true')
            ->andWhere('language.id = :lang_id')
            ->setParameter('lang_id', $languageId)
            ->getQuery()->getResult();
    }

    public function findProductByIdAndLanguage(int $id, int $languageId)
    {
        return $this->createQueryBuilder('product_translation')
            ->addSelect('product')
            ->leftJoin('product_translation.product', 'product')
            ->leftJoin('product_translation.language', 'language')
            ->where('product.id = :id')
            ->andWhere('language.id = :lang_id')
            ->setParameter('id', $id)
            ->setParameter('lang_id', $languageId)
            ->getQuery()->getResult();
    }

    public function findProductBySlugAndLanguage(string $slug, int $languageId)
    {
        return $this->createQueryBuilder('product_translation')
            ->addSelect(
                'product',
                'category',
                'category_translations',
                'subcategory',
                'subcategory_translations',
            )
            ->leftJoin('product_translation.product', 'product')
            ->leftJoin('product.category', 'category')
            ->leftJoin('category.categoryTranslations', 'category_translations')
            ->leftJoin('category.category', 'subcategory')
            ->leftJoin('subcategory.categoryTranslations', 'subcategory_translations')
            ->leftJoin('product_translation.language', 'language')
            ->where('product.slug = :slug')
            ->andWhere('language.id = :lang_id')
            ->andWhere('category_translations.language = :lang_id')
            ->andWhere('subcategory_translations.language = :lang_id')
            ->setParameter('slug', $slug)
            ->setParameter('lang_id', $languageId)
            ->getQuery()->getOneOrNullResult();
    }

    public function findByProductIds(int $languageId, array $ids)
    {
        return $this->createQueryBuilder('product_translation')
            ->addSelect('product')
            ->leftJoin('product_translation.product', 'product')
            ->leftJoin('product_translation.language', 'language')
            ->where('product.id IN (:ids)')
            ->andWhere('product.is_visible = true')
            ->andWhere('language.id = :lang_id')
            ->setParameter('ids', $ids)
            ->setParameter('lang_id', $languageId)
            ->getQuery()->getResult();
    }
}
