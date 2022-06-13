<?php

namespace App\Services;

use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\ProductsOrderRepository;
use App\Repository\ProductsRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ProductsOrderHelper {

    private ProductsOrderRepository $productsOrderRepository;
//    private static ManagerRegistry $managerRegistry;

    public function __construct(ProductsOrderRepository $productsOrderRepository) {
        $this->productsOrderRepository = $productsOrderRepository;
//        self::$managerRegistry = $managerRegistry;
    }


    public function ValidatePurchaseOrder(Purchase $data): void {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
    }

    public function ReffusePurchaseOrder(Purchase $data): void {
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

    //P
    public function pickUppProductOrder($data): void {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
    }

    public function checkObjective(ProductsOrder $productsOrder): void {
        //recuperer la somme des produits en cours  et verifier si l'objectif de celui ci est atteint
//        self::$managerRegistry->getRepository(ProductsOrder::class);
        $product = $productsOrder->getProduct();
        $listProductsOrder = $this->productsOrderRepository->findProductsOrderPending($productsOrder);
//        $listProductsOrder->
        $quantityTotal = $this->productsOrderRepository->findProductsOrderPending($productsOrder);
        $quantityTotal >= $product->getObjective() ?" " :"" ;
//        $managerRegistry->getRepository(Pro);
        $product = $productsOrder->getProduct();

    }

    public function succesPayment(?ProductsOrder $productsOrder) {
        $productsOrder->setStatus(ProductsOrder::STATUT_PAID);
        self::checkObjective($productsOrder);
    }
}
