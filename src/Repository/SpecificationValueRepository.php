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
