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
}
