<?php

namespace App\Repository;

use App\Entity\Forecast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\City;

/**
 * @method Forecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forecast[]    findAll()
 * @method Forecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forecast::class);
    }

    public function findByCity(City $city)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.city = :city')
            ->setParameter('city', $city)
            ->andWhere('f.date > :now')
            ->setParameter('now',date('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Forecast[] Returns an array of Forecast objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Forecast
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
