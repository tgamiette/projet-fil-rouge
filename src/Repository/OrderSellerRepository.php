<?php

namespace App\Repository;

use App\Entity\OrderSeller;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderSeller|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSeller|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderSeller[]    findAll()
 * @method OrderSeller[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSellerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSeller::class);
    }

    // /**
    //  * @return OrderSeller[] Returns an array of OrderSeller objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderSeller
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
