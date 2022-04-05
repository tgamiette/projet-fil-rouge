<?php

namespace App\Repository;

use App\Entity\UserPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPayment[]    findAll()
 * @method UserPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPayment::class);
    }

    // /**
    //  * @return UserPayment[] Returns an array of UserPayment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPayment
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
