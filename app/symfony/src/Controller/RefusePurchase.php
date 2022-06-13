<?php

namespace App\Controller;

use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\ProductsOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RefusePurchase extends AbstractController {
    private ProductsOrderRepository $productsOrderRepository;

    public function __construct( ProductsOrderRepository $producOrderRepository) {
        $this->productsOrderRepository = $producOrderRepository;
    }

    public function __invoke(Purchase $data): Purchase {
        $data->setStatus(Purchase::STATUS_PAID);
        $productOrders = $this->productsOrderRepository->findBy(['order' => $data->getOrderUser()]);
        foreach ($productOrders as $order) {
            $order->setStatus(ProductsOrder::STATUT_REFUSE);
        }
        return $data;
    }

}
