<?php

namespace App\Repository;

use App\Entity\SpecificationTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecificationTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecificationTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecificationTranslation[]    findAll()
 * @method SpecificationTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecificationTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecificationTranslation::class);
    }

    public function getNameAndParentId($language_id)
    {
        return $this->createQueryBuilder('specification_translation')
            ->select('specification_translation.name', 'specification.id')
            ->leftJoin('specification_translation.specification', 'specification')
            ->where('specification_translation.languge = :id')
            ->setParameter('id', $language_id)
            ->getQuery()->getResult();
    }

    /** @return SpecificationTranslation[] */
    public function getNameAndParentIdByProductId($product_id, $language_id)
    {
        return $this->createQueryBuilder('specification_translation')
            ->select('specification_translation', 'specification_values', 'specification', 'specification_value_translations')
            ->leftJoin('specification_translation.specification', 'specification')
            ->leftJoin('specification.specificationValues', 'specification_values')
            ->leftJoin('specification_values.specificationValueTranslations', 'specification_value_translations')
            ->leftJoin('specification_values.product', 'product')
            ->where('specification_translation.languge = :id')
            ->andWhere('product.id = :product_id')
            ->setParameter('id', $language_id)
            ->setParameter('product_id', $product_id)
            ->getQuery()->getResult();
    }

    // /**
    //  * @return SpecificationTranslation[] Returns an array of SpecificationTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SpecificationTranslation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
