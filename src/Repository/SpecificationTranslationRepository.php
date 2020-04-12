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
