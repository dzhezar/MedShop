<?php

namespace App\Repository;

use App\Entity\SpecificationValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecificationValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecificationValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecificationValue[]    findAll()
 * @method SpecificationValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecificationValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecificationValue::class);
    }

    /**
     * @param $product_id
     * @param $language_id
     * @return SpecificationValue[]
     */
    public function getNameAndParentIdByProductId($product_id, $language_id)
    {
        return $this->createQueryBuilder('specification_value')
            ->select('specification_value', 'specification', 'specification_translations', 'specification_value_translations')
            ->leftJoin('specification_value.product', 'product')
            ->leftJoin('specification_value.specificationValueTranslations', 'specification_value_translations')
            ->leftJoin('specification_value.specification', 'specification')
            ->leftJoin('specification.specificationTranslations', 'specification_translations')
            ->leftJoin('specification_translations.languge', 'languge')
            ->where('product.id = :product_id')
            ->andWhere('languge.id = :id')
            ->setParameter('id', $language_id)
            ->setParameter('product_id', $product_id)
            ->getQuery()->getResult();
    }

    // /**
    //  * @return SpecificationValue[] Returns an array of SpecificationValue objects
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
    public function findOneBySomeField($value): ?SpecificationValue
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
