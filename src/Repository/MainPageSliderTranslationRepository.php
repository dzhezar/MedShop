<?php

namespace App\Repository;

use App\Entity\MainPageSliderTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainPageSliderTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainPageSliderTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainPageSliderTranslation[]    findAll()
 * @method MainPageSliderTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainPageSliderTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainPageSliderTranslation::class);
    }

    // /**
    //  * @return MainPageSliderTranslation[] Returns an array of MainPageSliderTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainPageSliderTranslation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
