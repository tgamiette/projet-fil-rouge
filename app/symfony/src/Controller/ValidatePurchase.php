<?php

namespace App\Controller;

use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\ProductsOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidatePurchase extends AbstractController {
    private Purchase $purchase;
    private ProductsOrderRepository $productsOrderRepository;

    public function __construct(ProductsOrderRepository $productsOrderRepository) {
        $this->productsOrderRepository = $productsOrderRepository;
    }

//TODO commande validé
    public function __invoke(Purchase $data): Purchase {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['orderId' => $data->getOrderUser()]);
        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_PAID);
        }
        return $data;
    }
}
