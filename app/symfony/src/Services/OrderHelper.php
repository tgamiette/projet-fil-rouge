<?php

namespace App\Services;

use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\ProductsOrderRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;

class OrderHelper {

    private ProductsOrderRepository $productsOrderRepository;

    public function __construct(ProductsOrderRepository $productsOrderRepository) {
        $this->productsOrderRepository = $productsOrderRepository;
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
    public function PickUppProductOrder($data): void {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);

        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
    }
}
