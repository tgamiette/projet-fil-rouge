<?php

namespace App\Services;

use App\Entity\OrderSeller;
use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\ProductsOrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class ProductsOrderHelper {

    public function __construct(private readonly ProductsOrderRepository $productsOrderRepository, private EntityManagerInterface $em) {
    }


    public function ValidatePurchaseOrder(Purchase $data): void {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
    }

    public function RefusePurchaseOrder(Purchase $data): void {
        $data->setStatus(Purchase::STATUS_ERROR);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PENDING);
        }
    }

    public function PickUpProductOrder($data): void {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function checkObjective(ProductsOrder $productsOrder): void {
        //recuperer la somme des produits en cours et verifier si l'objectif de celui ci est atteint
        $listProductsOrder = $this->productsOrderRepository->findProductsOrderPendingByProduct($productsOrder);
        $quantityTotal = $this->productsOrderRepository->sumProductOrderByOrderPaid($productsOrder);
        $quantityTotal >= $productsOrder->getProduct()->getObjective() ? $this->createOrderSeller($listProductsOrder) : null;
    }

    private function createOrderSeller($productsOrder): void {
        $orderSeller = new OrderSeller();
        $total = 0.0;
        $quantity = 0;

        foreach ($productsOrder as $productOrder) {
            $total += $productOrder->getTotal();
            $quantity += $productOrder->getQuantity();

            $productOrder->setStatus(ProductsOrder::STATUT_VALIDE);
            $orderSeller->addProductsOrder($productOrder);
            $orderSeller->setSeller($productOrder->getProduct()->getSeller());
            $orderSeller->setProduct($productsOrder->getProduct());
        }
        $orderSeller->setTotal($total);
        $orderSeller->setQuantity($quantity);

        $this->em->persist($orderSeller);
        $this->em->flush();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function validateObjective(ProductsOrder $productsOrder): void {
        $productsOrder->setStatus(ProductsOrder::STATUT_VALIDE);
        self::checkObjective($productsOrder);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function validateProductOrderList(Collection $productsOrderList): void {
        foreach ($productsOrderList as $productsOrder) {
            $productsOrder = new ProductsOrder();
            $productsOrder->setStatus(ProductsOrder::STATUT_PAID);
            self::checkObjective($productsOrder);

            $this->em->flush();
        }
    }
}
