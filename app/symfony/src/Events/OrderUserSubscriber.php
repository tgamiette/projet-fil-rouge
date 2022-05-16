<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsOrderRepository;
use App\Repository\ProductsRepository;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;
    private ProductsOrderRepository $productsOrderRepository;
    private ProductsRepository $productsRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository, ProductsRepository $productsRepository, ProductsOrderRepository $productsOrderRepository) {

        $this->security = $security;
        $this->productsRepository = $productsRepository;
        $this->productsOrderRepository = $productsOrderRepository;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => [
                ['addProductOrder', EventPriorities::POST_WRITE],
                ['setOrder', EventPriorities::POST_VALIDATE],
            ]
        ];
    }

    public function addProductOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            $products = $order->getProducts();
            $date = new \DateTime();
            foreach ($products as $productId => $qty) {
                $product = $this->productsRepository->find((int)$productId);
                $productOrder = (new ProductsOrder())
                    ->setProduct($product)
                    ->setQuantity($qty)
                    ->setUpdatedAt($date)
                    ->setStatus(ProductsOrder::STATUT_PENDING)
                    ->setTotal($product->getPrice() * $qty)
                    ->setPrixU($product->getPrice())->setUnit(2);
                $order->addProductsOrder($productOrder);
                $this->productsOrderRepository->add($productOrder);

            }
        }
    }

    public function setOrder(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            $products = $order->getProducts();
            $date = new \DateTime();
            $order->setCreatedAt($date)
                ->setCustomer($this->security->getUser())
                ->setUpdatedAt($date);
        }
    }
}
