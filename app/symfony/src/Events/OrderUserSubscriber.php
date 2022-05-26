<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Entity\Purchase;
use App\Repository\OrderSellerRepository;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsOrderRepository;
use App\Repository\ProductsRepository;

use App\Repository\PurchaseRepository;
use App\Services\StripeHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class OrderUserSubscriber implements EventSubscriberInterface {

    private Security $security;
    private OrderUserRepository $orderUserRepository;
    private OrderSellerRepository $orderSellerRepository;
    private ProductsOrderRepository $productsOrderRepository;
    private ProductsRepository $productsRepository;

    public function __construct(Security $security, OrderUserRepository $orderUserRepository, OrderSellerRepository $orderSellerRepository, ProductsRepository $productsRepository, ProductsOrderRepository $productsOrderRepository, PurchaseRepository $purchaseRepository) {

        $this->security = $security;
        $this->productsRepository = $productsRepository;
        $this->productsOrderRepository = $productsOrderRepository;
        $this->orderUserRepository = $orderUserRepository;
        $this->orderSellerRepository = $orderSellerRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => [
                ['setOrder', EventPriorities::POST_VALIDATE],
                ['addProductOrder', EventPriorities::POST_WRITE],
                ['addPurchase', EventPriorities::POST_WRITE],
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
            $date = new \DateTime();
            $total = 0;
            $products = $order->getProducts();
            $order->setCustomer($this->security->getUser());
            foreach ($products as $productId => $qty) {
                $product = $this->productsRepository->find((int)$productId);
                $total += $product->getPrice() * $qty;
            }
            $order->setTotal((float)$total);
            $order->setCreatedAt($date);
            $order->setUpdatedAt($date);
        }
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Stripe\Exception\ApiErrorException
     * @throws \Doctrine\ORM\ORMException
     */
    public function addPurchase(ViewEvent $event) {
        $order = $event->getControllerResult();
        if ($event->getRequest()->isMethod("POST") && $order instanceof OrderUser) {
            $purchase = $this->purchaseRepository->findOneBy(['orderUser' => $order->getId()]);
            if (!$purchase) {
                $purchase = (new Purchase())
                    ->setStatus(Purchase::STATUS_PENDING)
                    ->setOrderUser($order);
            }
            $purchase->setStripeToken((new StripeHelper())->PaymentIntent($order));
            $this->purchaseRepository->add($purchase);

        }
    }
}
