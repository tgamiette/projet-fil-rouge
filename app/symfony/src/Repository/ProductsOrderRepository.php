<?php

namespace App\Repository;

use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductsOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsOrder[]    findAll()
 * @method ProductsOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsOrderRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ProductsOrder::class);
    }

    public function add(ProductsOrder $entity, bool $flush = true): void {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(ProductsOrder $entity, bool $flush = true): void {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param ProductsOrder $productsOrder
     * @return ProductsOrder[] Returns an array of ProductsOrder objects
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function sumProductOrderByOrderPaid(ProductsOrder $productsOrder) {

        $result = $this->createQueryBuilder('p')
            ->andWhere('p.product = :product_id')
            ->andWhere('p.status = :status')
            ->setParameters([
                'product_id' => $productsOrder->getProduct()->getId(),
                'status' => ProductsOrder::STATUT_PAID
            ])
            ->orderBy('p.createdAt', 'ASC')
            ->select('SUM(p.quantity) as quantity_total')
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
    }

    /**
     * @param ProductsOrder $productsOrder
     * @return float|int|mixed|string
     */
    public function findProductsOrderPendingByProduct(ProductsOrder $productsOrder) {
// récuperer la quantité du produit commandé
        return $this->createQueryBuilder('p')
            ->andWhere('p.product = :product_id')
            ->andWhere('p.status = :status')
            ->setParameters([
                'product_id' => $productsOrder->getProduct()->getId(),
                'status' => ProductsOrder::STATUT_PAID
            ])
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return ProductsOrder[] Returns an array of ProductsOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductsOrder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
