<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findRelatedProductsByLanguageAndId(int $id, int $languageId)
    {
        return $this->createQueryBuilder('product')
            ->addSelect('related_products', 'related_products_translations')
            ->leftJoin('product.related_products', 'related_products')
            ->leftJoin('related_products.productTranslations', 'related_products_translations')
            ->where('product.id = :id')
            ->andWhere('related_products_translations.language = :lang_id')
            ->setParameter('id', $id)
            ->setParameter('lang_id', $languageId)
            ->getQuery()->getOneOrNullResult();
    }
}
